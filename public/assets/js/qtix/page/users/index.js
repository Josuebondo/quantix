import { helpers } from "/assets/js/qtix/qtix.js";
let state = {
  users: [],
  stats: null,
  filtered: [],

  search: "",
  role: "all",

  page: 1,
  perPage: 10,

  sortKey: "name",
  sortDir: "asc",
};

// ✅ FIX: events global store
let events = [];

export async function init() {
  // console.log("Users page loaded");

  await loadUsers();
  await renderIntitation();
  bindEvents();
}

export function destroy() {
  events.forEach(({ element, event, handler }) => {
    element.removeEventListener(event, handler);
  });

  events = [];
}

/**
 * LOAD DATA
 */
async function loadUsers() {
  try {
    const res = await getdata();

    state.users = res.teams || [];
    state.stats = res.stats || {};

    state.filtered = state.users;

    renderStats(state.stats);
    renderTable(state.filtered);
  } catch (e) {
    console.error("loadUsers error:", e);
    Qtix.error("Erreur chargement utilisateurs");
  }
}
async function getdata() {
  try {
    const res = await Qtix.get("/team/data");

    return (
      res?.data ??
      res ?? {
        entrepots: [],
        roles: [],
        teams: [],
        stats: [],
        invitation: [],
      }
    );
  } catch (e) {
    Qtix.error("Erreur chargement donnée");

    return {
      entrepots: [],
      roles: [],
      teams: [],
      stats: [],
      invitation: [],
    };
  }
}
async function loadInviteUsedata() {
  const res = await getdata();
  const entrepots = res.entrepots ?? [];
  const roles = res.roles ?? [];
  const warehouseSelect = document.getElementById("invitation-Entrepôt");
  const roleSelect = document.getElementById("invitation-Role");
  fillSelect(warehouseSelect, entrepots, "Sélectionner un entrepôt");
  fillSelect(roleSelect, roles, "Sélectionner un rôle");
}
function getPaginatedData() {
  let data = [...state.filtered];

  // SORT
  if (state.sortKey) {
    data.sort((a, b) => {
      let valA = a[state.sortKey];
      let valB = b[state.sortKey];

      if (typeof valA === "string") valA = valA.toLowerCase();
      if (typeof valB === "string") valB = valB.toLowerCase();

      if (state.sortDir === "asc") {
        return valA > valB ? 1 : -1;
      } else {
        return valA < valB ? 1 : -1;
      }
    });
  }

  const start = (state.page - 1) * state.perPage;
  const end = start + state.perPage;

  return {
    data: data.slice(start, end),
    total: data.length,
    pages: Math.ceil(data.length / state.perPage),
  };
}

/**
 * PAGINATION
 */
function renderPagination() {
  const container = document.querySelector("#pagination");
  if (!container) return;

  const { pages } = getPaginatedData();

  let buttons = "";

  for (let i = 1; i <= pages; i++) {
    buttons += `
      <button
        class="w-8 h-8 rounded ${
          state.page === i
            ? "bg-primary text-white"
            : "border border-outline-variant"
        }"
        data-page="${i}">
        ${i}
      </button>
    `;
  }

  container.innerHTML = `
    <div class="flex items-center gap-2">
      ${buttons}
    </div>
  `;
}

/**
 * STATS
 */
function renderStats(stats) {
  setText("#stat-active-users", stats.activeUsers);
  setText("#stat-active-trend", stats.activeTrend);

  setText("#stat-pending-invites", stats.pendingInvites);
  setText("#stat-pending-trend", stats.pendingTrend);

  setText("#stat-roles", stats.roles);
  setText("#stat-total-users", stats.totalUsers);
  setText("#stat-total-trend", stats.totalTrend);
}

/**
 * TABLE
 */
async function renderTable() {
  const tbody = document.querySelector("#usersTable");
  if (!tbody) return;

  const { data } = getPaginatedData();

  tbody.innerHTML = data
    .map(
      (user) => `
    <tr class="hover:bg-surface-container-low dark:hover:bg-surface-variant/20">

      <td class="py-4 px-6">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">
            ${getInitials(user.name)}
          </div>

          <div>
            <div class="font-bold">${user.name}</div>
            <div class="text-sm text-gray-500">${user.email}</div>
          </div>
        </div>
      </td>

      <td class="px-6">${user.role}</td>
      <td class="px-6">${user.warehouse || "-"}</td>

      <td class="px-6">
        <span class="px-2 py-1 rounded text-xs ${
          user.status === "Actif"
            ? "bg-green-100 text-green-600"
            : "bg-red-100 text-red-600"
        }">
          ${user.status}
        </span>
      </td>

      <td class="px-6">${user.last_login_at}</td>
      <td class="px-6">${user.created_at}</td>

     <td class="px-6">
    <div class="flex justify-end items-center gap-2">

        <!-- Modifier -->
        <button
            class="btn-edit group relative flex items-center justify-center w-9 h-9 rounded-xl bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all duration-200 hover:scale-105"
            data-id="${user.id}"
            title="Modifier">
            <span class="material-symbols-outlined text-[18px]">
                edit_square
            </span>
        </button>

        <!-- Activer / Désactiver -->
        <button
            class="btn-toggle group relative flex items-center justify-center w-9 h-9 rounded-xl ${
              user.status === "Actif"
                ? "bg-orange-100 text-orange-600 hover:bg-orange-600 hover:text-white"
                : "bg-green-100 text-green-600 hover:bg-green-600 hover:text-white"
            } transition-all duration-200 hover:scale-105"
            data-id="${user.id}"
            title="${user.status === "Actif" ? "Désactiver" : "Activer"}">

            <span class="material-symbols-outlined text-[18px]">
                ${user.status === "Actif" ? "toggle_off" : "toggle_on"}
            </span>
        </button>

        <!-- Supprimer -->
        <button
            class="btn-delete group relative flex items-center justify-center w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-200 hover:scale-105"
            data-id="${user.id}"
            title="Supprimer">
            <span class="material-symbols-outlined text-[18px]">
                delete
            </span>
        </button>

    </div>
</td>
    </tr>
  `,
    )
    .join("");
  const res = await getdata();
  const roles = res.roles ?? [];
  const roleSelect = document.getElementById("roleFilter");
  fillSelect(roleSelect, roles, "Tous les rôles", "all", true);
  renderPagination();
}
/**
 * TABLE Invitations
 */
async function renderIntitation() {
  const res = await getdata();
  const data = res.invitations;
  const tbody = helpers.el("invitationTable");
  data.forEach((d) => {
    const tr = document.createElement("tr");
    tr.className =
      "hover:bg-surface-container-low dark:hover:bg-surface-variant/20 transition-colors group";
    tr.innerHTML = `   
                        <td class="py-4 px-6 text-on-surface dark:text-inverse-on-surface font-medium">${d.email}</td>
                        <td class="py-4 px-6"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-surface-variant dark:bg-outline text-on-surface-variant dark:text-surface-variant">${d.name}</span></td>
                        <td class="py-4 px-6"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-[#FEF9C3] dark:bg-[#713F12] text-[#A16207] dark:text-[#FEF08A]"><span class="w-1.5 h-1.5 rounded-full bg-[#A16207] dark:bg-[#FEF08A]"></span> En attente</span></td>
                        <td class="py-4 px-6 text-on-surface-variant dark:text-surface-variant">${d.created_at}</td>
                        <td class="py-4 px-6 text-on-surface-variant dark:text-surface-variant">${d.expires_at}</td>
                        <td class="py-4 px-6 text-right">
                            <button class="text-primary dark:text-primary-fixed hover:text-primary-container dark:hover:text-primary-fixed-dim text-sm font-medium mr-3">Renvoyer</button>
                            <button class="text-error hover:text-danger dark:hover:text-red-300 text-sm font-medium">Annuler</button>
                        </td>
               `;
    tbody.appendChild(tr);
    // console.log(d.email);
  });
  // const { data } = getPaginatedData();
}

/**
 * EVENTS
 */

function bindEvents() {
  const btn = document.querySelector("#btnInviteUser");

  if (btn) {
    const handler = () => openInviteModal();
    btn.addEventListener("click", handler);
    events.push({ element: btn, event: "click", handler });
  }

  // search
  const search = document.querySelector("#searchUsers");

  if (search) {
    search.addEventListener(
      "input",
      debounce((e) => {
        state.search = e.target.value;
        applyFilters();
      }, 300),
    );
  }

  // role filter
  const role = document.querySelector("#roleFilter");

  if (role) {
    role.addEventListener("change", (e) => {
      state.role = e.target.value;
      console.log(state.role);
      applyFilters();
    });
    const handler = (e) => {
      state.role = e.target.value;
      applyFilters();
    };

    role.addEventListener("change", handler);
    events.push({ element: role, event: "change", handler });
  }

  // table actions
  const table = document.querySelector("#usersTable");

  if (table) {
    const handler = (e) => {
      const id = e.target.closest("button")?.dataset.id;
      if (!id) return;

      if (e.target.closest(".btn-edit")) editUser(id);
      if (e.target.closest(".btn-delete")) deleteUser(id);
      if (e.target.closest(".btn-toggle")) toggleUser(id);
    };

    table.addEventListener("click", handler);
    events.push({ element: table, event: "click", handler });
  }

  // pagination
  document.addEventListener("click", (e) => {
    const btn = e.target.closest("[data-page]");
    if (!btn) return;

    state.page = Number(btn.dataset.page);
    renderTable();
  });

  // sort
  document.addEventListener("click", (e) => {
    const th = e.target.closest("[data-sort]");
    if (!th) return;

    const key = th.dataset.sort;

    if (state.sortKey === key) {
      state.sortDir = state.sortDir === "asc" ? "desc" : "asc";
    } else {
      state.sortKey = key;
      state.sortDir = "asc";
    }

    renderTable();
  });
}

/**
 * FILTERS
 */
function applyFilters() {
  let result = [...state.users];

  // SEARCH
  if (state.search) {
    const s = state.search.toLowerCase();
    result = result.filter(
      (u) =>
        u.name.toLowerCase().includes(s) || u.email.toLowerCase().includes(s),
    );
  }

  // ROLE FILTER
  if (state.role && state.role !== "all") {
    console.log(state.role);
    result = result.filter((u) => u.role === state.role);
  }

  // SORT 🔥 FIX PRINCIPAL
  if (state.sortKey) {
    result.sort((a, b) => {
      let valA = a[state.sortKey];
      let valB = b[state.sortKey];

      if (typeof valA === "string") valA = valA.toLowerCase();
      if (typeof valB === "string") valB = valB.toLowerCase();

      if (valA < valB) return state.sortDir === "asc" ? -1 : 1;
      if (valA > valB) return state.sortDir === "asc" ? 1 : -1;
      return 0;
    });
  }

  state.filtered = result;
  state.page = 1;

  renderTable();
}

/**
 * ACTIONS
 */
async function toggleUser(id) {
  const user = state.users.find((u) => u.id == id);
  if (!user) return;

  const newStatus = user.status === "active" ? "inactive" : "active";

  await Qtix.patch(`/company/users/${id}`, { status: newStatus });

  Qtix.success("Statut mis à jour");

  await loadUsers();
}

function openInviteModal() {
  loadInviteUsedata();
  Qtix.toggleModal("invite-modal");
}
async function submitInvitation() {
  // Qtix.toggleModal("invite-modal");

  // console.log("submited");
  sendInvitation();
}
window.submitInvitation = submitInvitation;
function fillSelect(
  selectEl,
  data,
  placeholder = "Sélectionner",
  defaul = "",
  v = false,
) {
  if (!selectEl) return;

  // reset options
  selectEl.innerHTML = "";

  // option placeholder
  const defaultOption = document.createElement("option");
  defaultOption.value = defaul;
  defaultOption.textContent = placeholder;
  selectEl.appendChild(defaultOption);
  if (v === false) {
    // options dynamiques
    data.forEach((item) => {
      const option = document.createElement("option");
      option.value = item.id;
      option.textContent = item.name;
      selectEl.appendChild(option);
    });
  } else {
    data.forEach((item) => {
      const option = document.createElement("option");
      option.value = item.name;
      option.textContent = item.name;
      selectEl.appendChild(option);
    });
  }
}

async function sendInvitation() {
  Qtix.startLoading();
  await Qtix.delay(2700);
  const email = helpers.el("invitation-email").value;
  const nom = helpers.el("invitation-nom").value;
  const Entrepôt = helpers.el("invitation-Entrepôt").value;
  const role = helpers.el("invitation-Role").value;
  const data = {
    email,
    nom,
    Entrepôt,
    role,
  };
  const res = await Qtix.post("/team/invite", data);
  console.log(res);
  if (res.success !== true) {
    const errors = res.errors;

    if (errors !== undefined) {
      const champs = Object.keys(errors);
      // console.log(champs);
      let i = 0;
      while (i < champs.length) {
        const champ = champs[i];
        let j = 0;
        while (j < errors[champ].length) {
          helpers.el(champ + "-error").textContent = errors[champ][j];
          // console.log(errors);
          setTimeout(() => {
            helpers.el(champ + "-error").textContent = "";
          }, 5000);
          j++;
        }
        i++;
      }
    }
    Qtix.error(res.message);
    Qtix.stopLoading();
  } else {
    Qtix.success(res.message);

    Qtix.stopLoading();
    Qtix.toggleModal("invite-modal");
  }
  // console.log(req);
}
function editUser(id) {
  Qtix.navigate(`/users/edit/${id}`);
}

async function deleteUser(id) {
  if (!confirm("Supprimer cet utilisateur ?")) return;

  await Qtix.delete(`/company/users/${id}`);
  Qtix.success("Utilisateur supprimé");

  await loadUsers();
}

/**
 * HELPERS
 */
function setText(id, value) {
  const el = document.querySelector(id);
  if (el) el.textContent = value ?? 0;
}

function getInitials(name) {
  return name
    .split(" ")
    .map((n) => n[0])
    .join("")
    .toUpperCase();
}

function debounce(fn, delay = 300) {
  let t;
  return (...args) => {
    clearTimeout(t);
    t = setTimeout(() => fn(...args), delay);
  };
}
