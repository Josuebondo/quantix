/**
 * ═══════════════════════════════════════════════════════════════════════════
 * WIZARD SESSION ARCHITECTURE (SINGLE SOURCE OF TRUTH)
 * ═══════════════════════════════════════════════════════════════════════════
 */

/**
 * 🔵 WIZARD SESSION - Identifiant central unique
 */
const wizardSession = {
  id: generateUUID(), // wizardSessionId UNIQUE
  status: "draft", // draft | in_progress | completed | deployed
  createdAt: new Date().toISOString(),
  lastSavedAt: null,
  deployedAt: null,
  idempotencyKey: null, // Pour deploy idempotent
};

/**
 * 🔵 DRAFT STATE - Single Source of Truth
 * Contient TOUT le formulaire du wizard
 */
let wizardDraftState = {
  // STEP 1: Workspace
  workspaceName: "",
  slug: "", // auto-generated
  currency: "EUR",
  country: "FR",
  timezone: "UTC+1",
  unitSystem: "metric",

  // STEP 2: Site
  siteName: "",
  siteType: "depot",
  siteAddress: "",

  // STEP 3: Categories
  categories: ["Composants", "Périphériques"],

  // STEP 4: Product
  productName: "",
  productSku: "",
  productCategory: "",
  productPrice: 0,
  productStock: 0,
  skuPrefix: "QTX-",
  autoGenerateSku: true,

  // STEP 5: Roles
  roles: ["Admin", "Manager"],
  selectedRole: "Admin",

  // STEP 6: Permissions
  permissions: {}, // será buildado dinámicamente

  // STEP 7: Invitations
  invitations: [],

  // Stock & Validation
  stockAlertEnabled: true,
  negativeStockAllowed: false,

  // Initialize with real backend data if available
  ...(typeof BACKEND_WIZARD_STATE !== "undefined" && BACKEND_WIZARD_STATE
    ? BACKEND_WIZARD_STATE
    : {}),
};

/**
 * 🔵 UI STATE - Pour le UI uniquement
 */
const uiState = {
  currentStep:
    typeof BACKEND_CURRENT_STEP !== "undefined" ? BACKEND_CURRENT_STEP : 1,
  totalSteps: 8,
  isDirty: false, // Dirty check
  isSaving: false,
  saveError: null,
};

/**
 * 🔵 DIRTY TRACKING - Quelle field a changé
 */
const dirtyFields = new Set();

const stepInfo = [
  {
    name: "Workspace",
    icon: "corporate_fare",
  },
  {
    name: "Sites",
    icon: "warehouse",
  },
  {
    name: "Catégories",
    icon: "category",
  },
  {
    name: "Produits",
    icon: "inventory",
  },
  {
    name: "Rôles",
    icon: "badge",
  },
  {
    name: "Permissions",
    icon: "policy",
  },
  {
    name: "Utilisateurs",
    icon: "group_add",
  },
  {
    name: "Finalisation",
    icon: "task_alt",
  },
];

/**
 * ═══════════════════════════════════════════════════════════════════════════
 * UTILITIES & HELPERS
 * ═══════════════════════════════════════════════════════════════════════════
 */

/**
 * Generate UUID v4
 */
function generateUUID() {
  return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function (c) {
    const r = (Math.random() * 16) | 0;
    const v = c === "x" ? r : (r & 0x3) | 0x8;
    return v.toString(16);
  });
}

/**
 * Debounce helper
 */
function debounce(func, delay) {
  let timeoutId;
  return function (...args) {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => func(...args), delay);
  };
}

/**
 * Deep clone
 */
function deepClone(obj) {
  return JSON.parse(JSON.stringify(obj));
}

/**
 * ═══════════════════════════════════════════════════════════════════════════
 * WIZARD CONTROLLER (STATE → API GATEWAY)
 * ═══════════════════════════════════════════════════════════════════════════
 */

const WizardController = {
  /**
   * INITIALIZE WIZARD ON PAGE LOAD
   */
  async initialize() {
    const urlParams = new URLSearchParams(window.location.search);
    const sessionId = urlParams.get("session");

    if (!sessionId) {
      console.error("[WIZARD] No session ID in URL");
      return;
    }

    wizardSession.id = sessionId;

    // Load existing state
    const resumeResult = await this.resumeSession();
    if (resumeResult.success) {
      wizardDraftState = { ...wizardDraftState, ...resumeResult.state };
      uiState.currentStep = resumeResult.step;
    }
  },

  /**
   * RESUME WIZARD FROM BACKEND
   */
  async resumeSession() {
    try {
      const response = await fetch(
        `/api/wizard/resume?session=${wizardSession.id}`,
        {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
          },
        },
      );

      if (!response.ok) {
        throw new Error(`Resume failed: ${response.statusText}`);
      }

      const result = await response.json();

      if (!result.success) {
        return { success: false };
      }

      return {
        success: true,
        state: result.data.state,
        step: result.data.step,
        status: result.data.status,
      };
    } catch (error) {
      console.error("[RESUME ERROR]", error);
      return { success: false };
    }
  },

  /**
   * UPDATE STATE + MARK DIRTY
   */
  updateField(fieldPath, value) {
    const keys = fieldPath.split(".");
    let current = wizardDraftState;

    for (let i = 0; i < keys.length - 1; i++) {
      current = current[keys[i]];
    }

    const lastKey = keys[keys.length - 1];
    current[lastKey] = value;

    // Mark dirty
    dirtyFields.add(fieldPath);
    uiState.isDirty = true;

    // Trigger debounced autosave
    this.autosaveDebounced();
  },

  /**
   * AUTO-SAVE (DEBOUNCED + DIRTY CHECK)
   */
  autosaveDebounced: debounce(async function () {
    if (!uiState.isDirty || uiState.isSaving) return;

    await WizardController.autosave();
  }, 1500), // 1.5 second debounce

  /**
   * AUTOSAVE ACTUAL
   */
  async autosave() {
    const indicator = document.getElementById("autosave-indicator");
    const icon = document.getElementById("sync-icon");
    const text = document.getElementById("sync-text");

    uiState.isSaving = true;

    try {
      // Show saving state with smooth transition
      if (indicator) {
        indicator.style.transition = "opacity 0.3s ease";
        indicator.style.opacity = "1";
        indicator.style.color = "#d4e4fa";
      }

      if (icon) {
        icon.innerText = "sync";
        icon.style.animation = "spin 1s linear infinite";
      }

      if (text) {
        text.innerText = "Sauvegarde...";
      }

      let token = document.querySelector('meta[name="csrf-token"]')?.content;

      // API CALL
      const response = await fetch("/api/wizard/autosave", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-Token": token,
        },
        body: JSON.stringify({
          wizardSessionId: wizardSession.id,
          state: wizardDraftState,
          step: uiState.currentStep,
          dirtyFields: Array.from(dirtyFields),
        }),
      });

      if (!response.ok) {
        throw new Error(
          `Autosave failed: ${response.status} ${response.statusText}`,
        );
      }

      const data = await response.json();

      if (!data.success) {
        throw new Error(data.message || "Autosave failed");
      }

      // Reset dirty state
      dirtyFields.clear();
      uiState.isDirty = false;
      wizardSession.lastSavedAt = new Date().toISOString();
      uiState.saveError = null;

      // Show success with smooth transition
      if (icon) {
        icon.innerText = "check_circle";
        icon.style.animation = "none";
        icon.style.color = "#4caf50";
      }
      if (text) {
        text.innerText = "Sauvegardé";
      }

      // After 2s, return to idle state
      setTimeout(() => {
        if (icon) {
          icon.innerText = "cloud_done";
          icon.style.color = "";
        }
        if (text) {
          text.innerText = "Prêt";
        }
        if (indicator) {
          indicator.style.transition = "opacity 0.5s ease";
          indicator.style.opacity = "0.5";
        }
      }, 2000);
    } catch (error) {
      console.error("[AUTOSAVE ERROR]", error.message);
      uiState.saveError = error.message;

      // Show error state
      if (icon) {
        icon.innerText = "error";
        icon.style.animation = "none";
        icon.style.color = "#f44336";
      }
      if (text) {
        text.innerText = "Erreur";
      }

      // Reset after 3s
      setTimeout(() => {
        if (icon) {
          icon.innerText = "cloud_done";
          icon.style.color = "";
        }
        if (text) {
          text.innerText = "Prêt";
        }
        if (indicator) {
          indicator.style.transition = "opacity 0.5s ease";
          indicator.style.opacity = "0.5";
        }
      }, 3000);
    } finally {
      uiState.isSaving = false;
    }
  },

  /**
   * GENERATE SKU (CONTROLLED)
   */
  async generateSKU() {
    const skuInput = document.getElementById("prod-sku");
    const genBtn = event?.target?.closest("button");

    if (uiState.isSaving) return;

    try {
      // Show loading
      if (skuInput) skuInput.value = "Génération...";
      if (genBtn) {
        genBtn.disabled = true;
        genBtn.classList.add("opacity-50");
      }

      // API CALL
      const response = await fetch("/api/wizard/generate-sku", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          wizardSessionId: wizardSession.id,
          productName: wizardDraftState.productName,
          productCategory: wizardDraftState.productCategory,
          skuPrefix: wizardDraftState.skuPrefix,
        }),
      });

      const data = await response.json();
      const sku = data?.data?.sku || this.generateLocalSKU();
      this.updateField("productSku", sku);
      if (skuInput) skuInput.value = sku;
    } catch (error) {
      console.error("SKU generation error:", error.message);
      // Fallback local generation
      const sku = this.generateLocalSKU();
      this.updateField("productSku", sku);
      if (skuInput) skuInput.value = sku;
    } finally {
      if (genBtn) {
        genBtn.disabled = false;
        genBtn.classList.remove("opacity-50");
      }
    }
  },

  /**
   * GENERATE SKU LOCAL FALLBACK
   */
  generateLocalSKU() {
    const prefix = wizardDraftState.skuPrefix || "SKU-";
    const rand = Math.random().toString(36).substring(2, 7).toUpperCase();
    return `${prefix}${rand}`;
  },

  /**
   * LOAD PERMISSIONS
   */
  async loadPermissions() {
    const body = document.getElementById("permissions-body");
    const loader = document.getElementById("permissions-loader");
    const table = document.getElementById("permissions-table-container");
    const roleDisplay = document.getElementById("current-role-display");

    if (!body) return;

    try {
      roleDisplay.innerText = wizardDraftState.selectedRole;
      table?.classList.add("opacity-30");
      loader?.classList.remove("hide");

      const response = await fetch("/api/wizard/permissions", {
        method: "GET",
        headers: { "Content-Type": "application/json" },
      });

      if (!response.ok) throw new Error(`HTTP ${response.status}`);

      const response_data = await response.json();
      const modules = Array.isArray(response_data)
        ? response_data
        : response_data.data || [];

      body.innerHTML = "";

      modules.forEach((mod) => {
        const isAdmin = wizardDraftState.selectedRole === "Admin";
        const tr = document.createElement("tr");
        tr.className = "animate-slide-in";
        tr.innerHTML = `
          <td class="p-5 font-medium text-sm">${mod}</td>
          <td class="p-5 text-center"><input type="checkbox" ${isAdmin ? "checked" : ""} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
          <td class="p-5 text-center"><input type="checkbox" ${isAdmin ? "checked" : ""} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
          <td class="p-5 text-center"><input type="checkbox" ${isAdmin ? "checked" : ""} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
          <td class="p-5 text-center"><input type="checkbox" ${isAdmin ? "checked" : ""} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
        `;
        body.appendChild(tr);
      });

      loader?.classList.add("hide");
      table?.classList.remove("opacity-30");
    } catch (error) {
      console.error("Permissions load error:", error.message);
      // Fallback: render static modules
      const modules = ["Stock", "Ventes", "Sites", "Analyses", "Utilisateurs"];
      body.innerHTML = "";

      modules.forEach((mod) => {
        const isAdmin = wizardDraftState.selectedRole === "Admin";
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td class="p-5 font-medium text-sm">${mod}</td>
          <td class="p-5 text-center"><input type="checkbox" ${isAdmin ? "checked" : ""} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
          <td class="p-5 text-center"><input type="checkbox" ${isAdmin ? "checked" : ""} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
          <td class="p-5 text-center"><input type="checkbox" ${isAdmin ? "checked" : ""} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
          <td class="p-5 text-center"><input type="checkbox" ${isAdmin ? "checked" : ""} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
        `;
        body.appendChild(tr);
      });

      loader?.classList.add("hide");
      table?.classList.remove("opacity-30");
    }
  },

  /**
   * DEPLOY FINAL (IDEMPOTENT)
   */
  async deployWizard() {
    if (uiState.isSaving) return;

    const finalLoader = document.getElementById("final-loader");
    const loaderText = document.getElementById("loader-text");
    const loaderSub = document.getElementById("loader-subtext");

    uiState.isSaving = true;

    try {
      const updates = [
        {
          text: "DÉPLOIEMENT DU WORKSPACE...",
          sub: "Configuration des bases de données",
        },
        {
          text: "CRÉATION DES RÔLES...",
          sub: "Mise à jour des accès de sécurité",
        },
        {
          text: "SAUVEGARDE DES DONNÉES...",
          sub: "Synchronisation des configurations",
        },
      ];

      // Generate idempotency key
      if (!wizardSession.idempotencyKey) {
        wizardSession.idempotencyKey = generateUUID();
      }

      for (let i = 0; i < updates.length; i++) {
        loaderText.innerText = updates[i].text;
        loaderSub.innerText = updates[i].sub;

        // FINAL API CALL
        const response = await fetch("/api/wizard/deploy", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-Idempotency-Key": wizardSession.idempotencyKey,
          },
          body: JSON.stringify({
            wizardSessionId: wizardSession.id,
            state: wizardDraftState,
            step: i + 1,
          }),
        });

        if (!response.ok) {
          throw new Error(`Deploy step ${i + 1} failed`);
        }

        await new Promise((resolve) => setTimeout(resolve, 800));
      }

      // Final step
      loaderText.innerText = "SYSTÈME PRÊT";
      loaderSub.innerText = "Redirection vers le tableau de bord";

      wizardSession.status = "deployed";
      wizardSession.deployedAt = new Date().toISOString();

      await new Promise((resolve) => setTimeout(resolve, 1000));

      finalLoader.classList.add("hide");
      document.getElementById("loader-status").classList.add("hide");
      document.getElementById("final-success").classList.remove("hide");
    } catch (error) {
      console.error("[DEPLOY ERROR]", error);
      loaderText.innerText = "ERREUR DÉPLOIEMENT";
      loaderSub.innerText = error.message;
    } finally {
      uiState.isSaving = false;
    }
  },
};

/**
 * ═══════════════════════════════════════════════════════════════════════════
 * BACKEND SIMULATION & API CALLS
 * ═══════════════════════════════════════════════════════════════════════════
 */
async function simulateApiCall(endpoint, data) {
  const delay = 300 + Math.random() * 200;
  return new Promise((resolve) =>
    setTimeout(
      () =>
        resolve({
          status: "success",
          timestamp: Date.now(),
        }),
      delay,
    ),
  );
}

/**
 * UTILS
 */
async function triggerAutoSave() {
  // Delegate to controller
  await WizardController.autosave();
}

/**
 * ═══════════════════════════════════════════════════════════════════════════
 * CORE UI LOGIC
 * ═══════════════════════════════════════════════════════════════════════════
 */

async function init() {
  // Initialize wizard session from URL
  await WizardController.initialize();

  renderSidebar();
  updateUI();

  // Setup input listeners with field tracking
  document.querySelectorAll("[data-state]").forEach((el) => {
    el.addEventListener("input", (e) => {
      const fieldPath = e.target.getAttribute("data-state");
      const value =
        e.target.type === "checkbox" ? e.target.checked : e.target.value;

      // Use controller to update (auto debounce + dirty check)
      WizardController.updateField(fieldPath, value);
    });
  });

  renderCategories();
  renderRoles();
}

function renderSidebar() {
  const container = document.getElementById("sidebar-nav-container");
  container.innerHTML = "";
  stepInfo.forEach((step, index) => {
    const stepNum = index + 1;
    const isCompleted = stepNum < uiState.currentStep;
    const isActive = stepNum === uiState.currentStep;

    const div = document.createElement("div");
    div.className = `group flex items-center gap-4 p-4 rounded-xl transition-all duration-300 ${isActive ? "bg-surface-container-high/50 shadow-sm" : ""}`;

    div.innerHTML = `
                <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center border transition-colors ${isActive ? "bg-primary border-primary text-on-primary" : isCompleted ? "bg-secondary/10 border-secondary text-secondary" : "bg-surface-container/50 border-outline-variant/30 text-on-surface-variant"}">
                    <span class="material-symbols-outlined text-[18px]">${isCompleted ? "check" : step.icon}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold tracking-widest uppercase opacity-40 leading-none mb-1">0${stepNum}</span>
                    <span class="font-label-md text-sm ${isActive ? "text-on-surface font-bold" : "text-on-surface-variant"}">${step.name}</span>
                </div>
            `;
    container.appendChild(div);
  });
}

function updateUI() {
  for (let i = 1; i <= uiState.totalSteps; i++) {
    const section = document.getElementById(`step-${i}`);
    if (i === uiState.currentStep) section.classList.remove("hide");
    else section.classList.add("hide");
  }

  renderSidebar();
  document.getElementById("current-step-num").innerText = uiState.currentStep;

  const btnPrev = document.getElementById("btn-prev");
  const btnNext = document.getElementById("btn-next");
  const stepCounter = document.getElementById("step-counter");

  if (uiState.currentStep === 1) btnPrev.classList.add("hidden");
  else btnPrev.classList.remove("hidden");

  if (uiState.currentStep === uiState.totalSteps) {
    btnNext.classList.add("hidden");
    btnPrev.classList.add("hidden");
    stepCounter.classList.add("hidden");
    // Deploy is triggered manually or on final action
  } else {
    btnNext.classList.remove("hidden");
    stepCounter.classList.remove("hidden");
  }

  if (uiState.currentStep === 4) populateCategorySelect();
  if (uiState.currentStep === 6) WizardController.loadPermissions();
  if (uiState.currentStep === 7) populateRoleInviteSelect();
}

/**
 * STEP 3: CATEGORIES
 */
function renderCategories() {
  const container = document.getElementById("category-list");
  if (!container) return;
  container.innerHTML = "";
  wizardDraftState.categories.forEach((cat) => {
    const tag = document.createElement("span");
    tag.className =
      "px-4 py-2 bg-primary/10 border border-primary/20 rounded-xl text-primary text-sm flex items-center gap-2 animate-slide-in";
    tag.innerHTML = `${cat} <button onclick="removeCategory('${cat}')" class="material-symbols-outlined text-xs hover:text-on-surface">close</button>`;
    container.appendChild(tag);
  });
}

function addCategory(name) {
  if (name && !wizardDraftState.categories.includes(name)) {
    WizardController.updateField("categories", [
      ...wizardDraftState.categories,
      name,
    ]);
    renderCategories();
  }
}

function addCategoryFromInput() {
  const input = document.getElementById("cat-input");
  addCategory(input.value);
  input.value = "";
}

function removeCategory(name) {
  const updated = wizardDraftState.categories.filter((c) => c !== name);
  WizardController.updateField("categories", updated);
}

document.getElementById("cat-input")?.addEventListener("keypress", (e) => {
  if (e.key === "Enter") addCategoryFromInput();
});

/**
 * STEP 5: ROLES
 */
function renderRoles() {
  const container = document.getElementById("role-list-container");
  if (!container) return;
  container.innerHTML = "";
  wizardDraftState.roles.forEach((role) => {
    const isActive = wizardDraftState.selectedRole === role;
    const btn = document.createElement("button");
    btn.className = `px-6 py-4 rounded-xl border-2 transition-all flex items-center gap-3 animate-slide-in ${isActive ? "border-primary bg-primary/5 text-on-surface" : "border-outline-variant/30 text-on-surface-variant hover:border-outline-variant"}`;
    btn.innerHTML = `
                <span class="material-symbols-outlined text-sm">${isActive ? "check_circle" : "circle"}</span>
                <span class="font-bold">${role}</span>
                ${role !== "Admin" ? `<span class="material-symbols-outlined text-xs opacity-50 hover:text-error transition-colors" onclick="event.stopPropagation(); removeRole('${role}')">delete</span>` : ""}
            `;
    btn.onclick = () => selectRole(role);
    container.appendChild(btn);
  });
}

function addRole(name) {
  if (name && !wizardDraftState.roles.includes(name)) {
    WizardController.updateField("roles", [...wizardDraftState.roles, name]);
    renderRoles();
  }
}

function addRoleFromInput() {
  const input = document.getElementById("role-input");
  if (input.value) {
    addRole(input.value);
    input.value = "";
  }
}

function removeRole(name) {
  const updated = wizardDraftState.roles.filter((r) => r !== name);
  if (wizardDraftState.selectedRole === name) {
    WizardController.updateField("selectedRole", "Admin");
  }
  WizardController.updateField("roles", updated);
}

function selectRole(role) {
  WizardController.updateField("selectedRole", role);
  renderRoles();
}

/**
 * STEP 7: USERS
 */
function populateRoleInviteSelect() {
  const select = document.getElementById("invite-role");
  select.innerHTML = "";
  wizardDraftState.roles.forEach((role) => {
    const opt = document.createElement("option");
    opt.value = role;
    opt.textContent = role;
    select.appendChild(opt);
  });
}

function addInvitation() {
  const email = document.getElementById("invite-email").value;
  const role = document.getElementById("invite-role").value;
  if (email) {
    const updated = [...wizardDraftState.invitations, { email, role }];
    WizardController.updateField("invitations", updated);
    renderInvitations();
    document.getElementById("invite-email").value = "";
  }
}

function renderInvitations() {
  const list = document.getElementById("invitation-list");
  list.innerHTML = "";
  wizardDraftState.invitations.forEach((inv, index) => {
    const item = document.createElement("div");
    item.className =
      "flex items-center justify-between p-5 bg-surface-container/30 border border-outline-variant/30 rounded-xl animate-slide-in";
    item.innerHTML = `
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-full flex items-center justify-center font-bold text-xs">${inv.email.charAt(0).toUpperCase()}</div>
                    <div>
                        <p class="text-sm font-bold">${inv.email}</p>
                        <p class="text-[10px] text-on-surface-variant font-medium uppercase tracking-widest">${inv.role}</p>
                    </div>
                </div>
                <button onclick="removeInvite(${index})" class="text-on-surface-variant hover:text-error">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            `;
    list.appendChild(item);
  });
}

function removeInvite(index) {
  const updated = wizardDraftState.invitations.filter((_, i) => i !== index);
  WizardController.updateField("invitations", updated);
}

/**
 * STEP 4: PRODUCT HELPERS
 */
function populateCategorySelect() {
  const select = document.getElementById("prod-category");
  select.innerHTML = '<option value="">Choisir...</option>';
  wizardDraftState.categories.forEach((cat) => {
    const opt = document.createElement("option");
    opt.value = cat;
    opt.textContent = cat;
    select.appendChild(opt);
  });
}

async function generateSKU() {
  await WizardController.generateSKU();
}

/**
 * STEP 8: FINAL
 */
function runFinalSequence() {
  // Trigger deploy
  WizardController.deployWizard();
}

/**
 * ═══════════════════════════════════════════════════════════════════════════
 * NAVIGATION & EVENT LISTENERS
 * ═══════════════════════════════════════════════════════════════════════════
 */

document.getElementById("btn-next").addEventListener("click", () => {
  if (uiState.currentStep < uiState.totalSteps) {
    uiState.currentStep++;
    updateUI();
  } else if (uiState.currentStep === uiState.totalSteps) {
    // Trigger final deploy sequence
    WizardController.deployWizard();
  }
});

document.getElementById("btn-prev").addEventListener("click", () => {
  if (uiState.currentStep > 1) {
    uiState.currentStep--;
    updateUI();
  }
});

/**
 * Log wizard info in console for debugging
 */
function logWizardInfo() {
  // Debug info available on demand via console
  return {
    sessionId: wizardSession.id,
    status: wizardSession.status,
    step: uiState.currentStep,
    isDirty: uiState.isDirty,
    isSaving: uiState.isSaving,
    state: wizardDraftState,
    dirtyFields: Array.from(dirtyFields),
  };
}

// Make available in console
window.wizardInfo = logWizardInfo;
window.wizardSession = wizardSession;
window.wizardDraftState = wizardDraftState;
window.uiState = uiState;

// Start App
init();
