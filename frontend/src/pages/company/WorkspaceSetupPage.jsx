import { useEffect, useMemo, useRef, useState } from "react";
import { useSearchParams } from "react-router-dom";
import { z } from "zod";
import api from "../../services/api";
import { companyService } from "../../services/companyService";

const STEP_INFO = [
  { name: "Workspace", icon: "corporate_fare" },
  { name: "Sites", icon: "warehouse" },
  { name: "Categories", icon: "category" },
  { name: "Produits", icon: "inventory" },
  { name: "Roles", icon: "badge" },
  { name: "Permissions", icon: "policy" },
  { name: "Utilisateurs", icon: "group_add" },
  { name: "Finalisation", icon: "task_alt" },
];

const CRUD_KEYS = ["view", "list", "create", "update", "delete"];

const MODULE_LABELS = {
  products: "Produits",
  stocks: "Stocks",
  sales: "Ventes",
  users: "Utilisateurs",
  roles: "Roles",
  auth: "Authentification",
};

const INITIAL_DRAFT = {
  workspaceName: "",
  currency: "EUR",
  country: "FR",
  timezone: "UTC+1",
  unitSystem: "metric",
  skuPrefix: "QTX-",
  autoGenerateSku: true,
  stockAlertEnabled: true,
  negativeStockAllowed: false,

  siteName: "",
  siteType: "depot",
  siteAddress: "",

  categories: ["Composants", "Peripheriques"],

  productName: "",
  productSku: "",
  productCategory: "",

  roles: ["Admin", "Manager"],
  selectedRole: "Admin",
  permissions: [],
  selectedPermissions: [],

  invitations: [],
};

const STEP_SCHEMAS = {
  1: z.object({
    workspaceName: z.string().min(2, "Le nom du workspace est requis."),
  }),
  2: z.object({
    siteName: z.string().min(2, "Le nom du site est requis."),
  }),
  4: z.object({
    productName: z.string().min(2, "Le nom du produit est requis."),
    productCategory: z.string().min(1, "Choisissez une categorie."),
  }),
};

function moduleLabel(key) {
  return MODULE_LABELS[key] || key;
}

function permissionKey(code) {
  return code?.split(".").pop();
}

function permissionPrefix(moduleKey) {
  if (!moduleKey) return moduleKey;
  const map = {
    products: "product",
    stocks: "stock",
    sales: "sale",
    users: "user",
    roles: "role",
    auth: "auth",
  };
  return map[moduleKey] || moduleKey;
}

function localSku(prefix) {
  const rand = Math.random().toString(36).substring(2, 7).toUpperCase();
  return `${prefix || "SKU-"}${rand}`;
}

export default function WorkspaceSetupPage() {
  const [searchParams] = useSearchParams();
  const [currentStep, setCurrentStep] = useState(1);
  const [draft, setDraft] = useState(INITIAL_DRAFT);
  const [dirty, setDirty] = useState(false);
  const [saving, setSaving] = useState(false);
  const [syncState, setSyncState] = useState("ready");
  const [categoryInput, setCategoryInput] = useState("");
  const [roleInput, setRoleInput] = useState("");
  const [inviteEmail, setInviteEmail] = useState("");
  const [inviteRole, setInviteRole] = useState("Admin");
  const [isDeploying, setIsDeploying] = useState(false);
  const [deployText, setDeployText] = useState("DEPLOIEMENT DU WORKSPACE...");
  const [deploySubtext, setDeploySubtext] = useState(
    "Synchronisation des serveurs regionaux",
  );
  const [stepErrors, setStepErrors] = useState({});

  const sessionIdRef = useRef(null);
  const initializedRef = useRef(false);

  useEffect(() => {
    const session = searchParams.get("session");
    if (session) {
      sessionIdRef.current = session;
    }
  }, [searchParams]);

  useEffect(() => {
    let ignore = false;

    const initialize = async () => {
      if (!sessionIdRef.current) return;

      try {
        const response = await api.get("/api/wizard/resume", {
          params: { session: sessionIdRef.current },
        });

        const payload = response?.data ?? response;
        if (!ignore && payload?.success && payload?.data) {
          setDraft((prev) => ({ ...prev, ...payload.data.state }));
          setCurrentStep(payload.data.step || 1);
        }
      } catch {
        // Keep local defaults when resume endpoint fails.
      } finally {
        initializedRef.current = true;
      }
    };

    initialize();

    return () => {
      ignore = true;
    };
  }, []);

  useEffect(() => {
    if (!initializedRef.current || !dirty || saving || !sessionIdRef.current) {
      return;
    }

    const timer = setTimeout(async () => {
      setSaving(true);
      setSyncState("saving");
      try {
        await companyService.wizardAutosave({
          wizardSessionId: sessionIdRef.current,
          state: draft,
          step: currentStep,
          dirtyFields: ["*"],
        });
        setDirty(false);
        setSyncState("saved");
        setTimeout(() => setSyncState("ready"), 1800);
      } catch {
        setSyncState("error");
        setTimeout(() => setSyncState("ready"), 2800);
      } finally {
        setSaving(false);
      }
    }, 1500);

    return () => clearTimeout(timer);
  }, [currentStep, dirty, draft, saving]);

  useEffect(() => {
    if (currentStep !== 6 || !sessionIdRef.current) return;

    const loadPermissions = async () => {
      try {
        const response = await companyService.wizardPermissions();
        const payload = response?.data ?? response;
        const permissions = payload?.data?.permissions || [];
        setDraft((prev) => ({
          ...prev,
          permissions,
          selectedPermissions: prev.selectedPermissions || [],
        }));
      } catch {
        // Keep empty permissions table on failure.
      }
    };

    loadPermissions();
  }, [currentStep]);

  const setField = (key, value) => {
    setDraft((prev) => ({ ...prev, [key]: value }));
    setDirty(true);
    setStepErrors((prev) => {
      if (!prev[key]) return prev;
      const next = { ...prev };
      delete next[key];
      return next;
    });
  };

  const goNext = async () => {
    const schema = STEP_SCHEMAS[currentStep];
    if (schema) {
      const validation = schema.safeParse(draft);
      if (!validation.success) {
        const mapped = {};
        validation.error.issues.forEach((issue) => {
          const field = issue.path[0];
          if (field && !mapped[field]) {
            mapped[field] = issue.message;
          }
        });
        setStepErrors(mapped);
        return;
      }
    }

    setStepErrors({});
    if (currentStep < 8) {
      const next = currentStep + 1;
      setCurrentStep(next);
      if (next === 8) {
        await deployWizard();
      }
    }
  };

  const goPrev = () => {
    if (currentStep > 1) {
      setCurrentStep((step) => step - 1);
    }
  };

  const addCategory = () => {
    const value = categoryInput.trim();
    if (!value || draft.categories.includes(value)) return;
    setField("categories", [...draft.categories, value]);
    setCategoryInput("");
  };

  const removeCategory = (name) => {
    setField(
      "categories",
      draft.categories.filter((item) => item !== name),
    );
  };

  const addRole = (name) => {
    const value = name.trim();
    if (!value || draft.roles.includes(value)) return;
    setField("roles", [...draft.roles, value]);
    setRoleInput("");
  };

  const removeRole = (name) => {
    const filtered = draft.roles.filter((item) => item !== name);
    setField("roles", filtered);
    if (draft.selectedRole === name) {
      setField("selectedRole", "Admin");
    }
  };

  const addInvitation = () => {
    if (!inviteEmail.trim()) return;
    const invitations = [
      ...draft.invitations,
      { email: inviteEmail, role: inviteRole },
    ];
    setField("invitations", invitations);
    setInviteEmail("");
  };

  const removeInvitation = (index) => {
    setField(
      "invitations",
      draft.invitations.filter((_, i) => i !== index),
    );
  };

  const togglePermission = (code, checked) => {
    const current = new Set(draft.selectedPermissions || []);
    if (checked) {
      current.add(code);
    } else {
      current.delete(code);
    }
    setField("selectedPermissions", [...current]);
  };

  const generateSku = async () => {
    try {
      const response = await companyService.wizardGenerateSku({
        wizardSessionId: sessionIdRef.current,
        productName: draft.productName,
        productCategory: draft.productCategory,
        skuPrefix: draft.skuPrefix,
      });
      const payload = response?.data ?? response;
      const sku = payload?.data?.sku || localSku(draft.skuPrefix);
      setField("productSku", sku);
    } catch {
      setField("productSku", localSku(draft.skuPrefix));
    }
  };

  const deployWizard = async () => {
    if (!sessionIdRef.current) return;

    setIsDeploying(true);
    setDeployText("DEPLOIEMENT DU WORKSPACE...");
    setDeploySubtext("Configuration des bases de donnees");

    try {
      await new Promise((resolve) => setTimeout(resolve, 700));
      setDeployText("CREATION DES ROLES...");
      setDeploySubtext("Mise a jour des acces de securite");
      await new Promise((resolve) => setTimeout(resolve, 700));
      setDeployText("SAUVEGARDE DES DONNEES...");
      setDeploySubtext("Synchronisation des configurations");

      const response = await companyService.wizardDeploy({
        wizardSessionId: sessionIdRef.current,
        state: draft,
      });
      const payload = response?.data ?? response;

      setDeployText("SYSTEME PRET");
      setDeploySubtext("Redirection vers le tableau de bord");
      await new Promise((resolve) => setTimeout(resolve, 1000));

      const redirectUrl = payload?.data?.redirectUrl || "/dashboard";
      window.location.href = redirectUrl;
    } catch (error) {
      setDeployText("ERREUR DEPLOIEMENT");
      setDeploySubtext(error?.message || "Erreur inconnue");
    } finally {
      setIsDeploying(false);
    }
  };

  const groupedPermissions = useMemo(() => {
    const permissions = draft.permissions || [];
    const modules = [...new Set(permissions.map((p) => p.module))];

    return modules.map((moduleKey) => {
      const rows = CRUD_KEYS.map((action) => {
        let permission = permissions.find(
          (entry) =>
            entry.module === moduleKey && permissionKey(entry.code) === action,
        );
        if (!permission) {
          const prefix = permissionPrefix(moduleKey);
          permission = permissions.find(
            (entry) =>
              entry.code === `${prefix}.${action}` ||
              entry.code === `${moduleKey}.${action}`,
          );
        }
        return { action, permission };
      });

      return { moduleKey, rows };
    });
  }, [draft.permissions]);

  return (
    <div className="flex text-white flex-col md:flex-row h-screen overflow-hidden bg-slate-950 font-display min-h-screen bg-pattern">
      <aside className="w-full md:w-80 md:h-screen bg-gradient-to-b from-slate-800/60 via-slate-900/70 to-slate-950/80 border-b md:border-b-0 md:border-r border-white/10 flex flex-row md:flex-col sticky top-0 md:sticky z-40 shadow-2xl backdrop-blur-xl">
        <div className="p-4 md:p-8 border-b border-white/10 shrink-0">
          <div className="flex items-center gap-3 group">
            <div className="w-10 h-10 bg-gradient-to-br from-primary to-primary/60 rounded-xl flex items-center justify-center border border-primary/40 shadow-lg shadow-primary/20 transition-all duration-300 group-hover:shadow-primary/40">
              <span className="material-symbols-outlined text-white text-2xl">
                inventory_2
              </span>
            </div>
            <div>
              <h1 className="text-xl font-bold text-white leading-tight">
                Quatinx
              </h1>
              <p className="text-[10px] text-white/60 tracking-[0.2em] uppercase font-semibold">
                Enterprise Cloud
              </p>
            </div>
          </div>
        </div>

        <nav className="flex-1 overflow-hidden">
          <div className="flex flex-row md:flex-col gap-2 overflow-x-auto md:overflow-y-auto no-scrollbar px-3 py-3 md:px-4 md:py-4">
            {STEP_INFO.map((step, index) => {
              const stepNum = index + 1;
              const isActive = stepNum === currentStep;
              return (
                <div
                  key={step.name}
                  className={`group flex items-center gap-4 p-3 rounded-xl min-w-[90px] md:min-w-0 md:w-full shrink-0 cursor-pointer transition-all duration-300 ${
                    isActive
                      ? "bg-primary/15 border border-primary/20 text-white"
                      : "bg-white/5 text-white/80 hover:bg-white/10"
                  }`}
                >
                  <div
                    className={`w-8 h-8 rounded-lg flex items-center justify-center ${isActive ? "border border-primary/30 bg-primary/20 text-primary" : "border border-white/10 bg-white/10"}`}
                  >
                    <span className="material-symbols-outlined text-[18px]">
                      {step.icon}
                    </span>
                  </div>
                  <div className="hidden md:flex flex-col">
                    <span className="text-[10px] font-bold tracking-widest uppercase opacity-40">
                      {String(stepNum).padStart(2, "0")}
                    </span>
                    <span className="text-sm">{step.name}</span>
                  </div>
                </div>
              );
            })}
          </div>
        </nav>

        <div className="hidden md:block p-6 h-16 border-t border-white/10 bg-white/5 shrink-0">
          <div className="flex items-center gap-3 text-white/70">
            <span className="material-symbols-outlined text-sm">
              {syncState === "saving"
                ? "sync"
                : syncState === "saved"
                  ? "check_circle"
                  : syncState === "error"
                    ? "error"
                    : "cloud_done"}
            </span>
            <span
              className="text-xs font-medium uppercase tracking-widest"
              role="status"
              aria-live="polite"
            >
              {syncState === "saving"
                ? "Sauvegarde..."
                : syncState === "saved"
                  ? "Sauvegarde"
                  : syncState === "error"
                    ? "Erreur"
                    : "Systeme pret"}
            </span>
          </div>
        </div>
      </aside>

      <main className="flex-1 flex flex-col relative overflow-hidden bg-slate-950">
        <div className="absolute top-0 w-full h-32 bg-gradient-to-b from-slate-950/80 to-transparent z-10 pointer-events-none"></div>
        <div className="flex-1 overflow-y-auto scrollbar-custom px-6 md:px-12 py-24 z-0">
          <div className="max-w-4xl mx-auto">
            {currentStep === 1 ? (
              <section>
                <div className="space-y-10 animate-slide-in">
                  <header className="space-y-3">
                    <span className="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">
                      Etape 01
                    </span>
                    <h2 className="text-4xl text-white">
                      Configuration du Workspace
                    </h2>
                    <p className="text-white/50">
                      Definissez l'identite globale et les parametres regionaux.
                    </p>
                  </header>
                  <div className="bg-white/5 border border-white/10 backdrop-blur-xl p-10 rounded-2xl space-y-10">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                      <div className="md:col-span-2 space-y-3">
                        <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                          Nom de l'organisation
                        </label>
                        <input
                          className="auth-input"
                          autoFocus
                          aria-invalid={
                            stepErrors.workspaceName ? "true" : "false"
                          }
                          value={draft.workspaceName}
                          onChange={(e) =>
                            setField("workspaceName", e.target.value)
                          }
                          placeholder="ex: Quatinx Global Ltd"
                          type="text"
                        />
                        {stepErrors.workspaceName ? (
                          <p className="auth-error-text" role="alert">
                            {stepErrors.workspaceName}
                          </p>
                        ) : null}
                      </div>
                      <div className="space-y-3">
                        <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                          Devise par defaut
                        </label>
                        <select
                          className="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white"
                          value={draft.currency}
                          onChange={(e) => setField("currency", e.target.value)}
                        >
                          <option value="EUR">Euro (EUR)</option>
                          <option value="USD">US Dollar (USD)</option>
                          <option value="GBP">British Pound (GBP)</option>
                          <option value="XAF">Franc CFA (XAF)</option>
                        </select>
                      </div>
                      <div className="space-y-3">
                        <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                          Pays
                        </label>
                        <select
                          className="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white"
                          value={draft.country}
                          onChange={(e) => setField("country", e.target.value)}
                        >
                          <option value="FR">France</option>
                          <option value="BE">Belgique</option>
                          <option value="CA">Canada</option>
                          <option value="CH">Suisse</option>
                          <option value="SN">Senegal</option>
                        </select>
                      </div>
                      <div className="space-y-3">
                        <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                          Fuseau Horaire
                        </label>
                        <select
                          className="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white"
                          value={draft.timezone}
                          onChange={(e) => setField("timezone", e.target.value)}
                        >
                          <option value="UTC+1">
                            (UTC+01:00) Paris, Bruxelles, Madrid
                          </option>
                          <option value="UTC+0">
                            (UTC+00:00) Casablanca, Londres
                          </option>
                          <option value="UTC-5">
                            (UTC-05:00) New York, Montreal
                          </option>
                        </select>
                      </div>
                      <div className="space-y-3">
                        <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                          Systeme d'unites
                        </label>
                        <select
                          className="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white"
                          value={draft.unitSystem}
                          onChange={(e) =>
                            setField("unitSystem", e.target.value)
                          }
                        >
                          <option value="metric">Metrique (kg, m, l)</option>
                          <option value="imperial">
                            Imperial (lb, ft, gal)
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            ) : null}

            {currentStep === 2 ? (
              <section>
                <div className="space-y-8 animate-slide-in">
                  <header className="space-y-3">
                    <span className="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">
                      Etape 02
                    </span>
                    <h2 className="text-4xl text-white">
                      Initialisation des Sites
                    </h2>
                    <p className="text-white/50">
                      Configurez vos points logistiques et de distribution.
                    </p>
                  </header>
                  <div className="bg-white/5 border border-white/10 backdrop-blur-xl p-10 rounded-2xl space-y-8">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div className="space-y-3">
                        <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                          Nom du site
                        </label>
                        <input
                          className="auth-input"
                          aria-invalid={stepErrors.siteName ? "true" : "false"}
                          value={draft.siteName}
                          onChange={(e) => setField("siteName", e.target.value)}
                          placeholder="ex: Hub Logistique Paris"
                          type="text"
                        />
                        {stepErrors.siteName ? (
                          <p className="auth-error-text" role="alert">
                            {stepErrors.siteName}
                          </p>
                        ) : null}
                      </div>
                      <div className="space-y-3">
                        <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                          Type de site
                        </label>
                        <select
                          className="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white"
                          value={draft.siteType}
                          onChange={(e) => setField("siteType", e.target.value)}
                        >
                          <option value="depot">Depot (Stockage)</option>
                          <option value="point_de_vente">
                            Point de vente (Retail)
                          </option>
                        </select>
                      </div>
                    </div>
                    <div className="space-y-3">
                      <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                        Adresse physique
                      </label>
                      <textarea
                        className="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white"
                        value={draft.siteAddress}
                        onChange={(e) =>
                          setField("siteAddress", e.target.value)
                        }
                        rows={3}
                      ></textarea>
                    </div>
                  </div>
                </div>
              </section>
            ) : null}

            {currentStep === 3 ? (
              <section>
                <div className="space-y-8 animate-slide-in">
                  <header className="space-y-3">
                    <span className="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">
                      Etape 03
                    </span>
                    <h2 className="text-4xl text-white">
                      Segmentation de l'Inventaire
                    </h2>
                    <p className="text-white/50">
                      Organisez vos produits par familles logiques.
                    </p>
                  </header>
                  <div className="bg-white/5 border border-white/10 backdrop-blur-xl p-10 rounded-2xl space-y-10">
                    <div className="space-y-4">
                      <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                        Ajouter une categorie
                      </label>
                      <div className="flex gap-3">
                        <input
                          className="flex-1 bg-white/5 border border-white/10 rounded-xl p-4 text-white"
                          value={categoryInput}
                          onChange={(e) => setCategoryInput(e.target.value)}
                          placeholder="ex: Hardware, Logiciels..."
                          type="text"
                          onKeyDown={(e) => {
                            if (e.key === "Enter") {
                              e.preventDefault();
                              addCategory();
                            }
                          }}
                        />
                        <button
                          className="bg-primary text-midnight font-bold px-3 py-2 md:px-8 md:py-4 rounded-xl"
                          type="button"
                          onClick={addCategory}
                        >
                          Ajouter
                        </button>
                      </div>
                    </div>
                    <div className="flex flex-wrap gap-3 min-h-[50px] p-6 bg-white/5 rounded-2xl border border-dashed border-white/10">
                      {draft.categories.map((cat) => (
                        <span
                          key={cat}
                          className="px-4 py-2 bg-primary/10 border border-primary/20 rounded-xl text-primary text-sm flex items-center gap-2"
                        >
                          {cat}
                          <button
                            type="button"
                            onClick={() => removeCategory(cat)}
                          >
                            <span className="material-symbols-outlined text-xs">
                              close
                            </span>
                          </button>
                        </span>
                      ))}
                    </div>
                  </div>
                </div>
              </section>
            ) : null}

            {currentStep === 4 ? (
              <section>
                <div className="space-y-8 animate-slide-in">
                  <header className="space-y-3">
                    <span className="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">
                      Etape 04
                    </span>
                    <h2 className="text-4xl text-white">
                      Referencement Produit
                    </h2>
                    <p className="text-white/50">
                      Commencez par enregistrer votre premier article pilote.
                    </p>
                  </header>
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white/5 border border-white/10 backdrop-blur-xl p-10 rounded-2xl">
                    <div className="md:col-span-2 space-y-3">
                      <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                        Nom du produit
                      </label>
                      <input
                        className="auth-input"
                        aria-invalid={stepErrors.productName ? "true" : "false"}
                        value={draft.productName}
                        onChange={(e) =>
                          setField("productName", e.target.value)
                        }
                        type="text"
                      />
                      {stepErrors.productName ? (
                        <p className="auth-error-text" role="alert">
                          {stepErrors.productName}
                        </p>
                      ) : null}
                    </div>
                    <div className="space-y-3">
                      <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                        SKU Unique
                      </label>
                      <div className="relative flex items-center">
                        <input
                          className="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-primary font-mono text-sm outline-none"
                          value={draft.productSku}
                          readOnly
                          type="text"
                        />
                        <button
                          className="absolute right-2 px-3 py-2 bg-primary/10 text-primary rounded-lg text-xs font-bold"
                          onClick={generateSku}
                          type="button"
                        >
                          Generer
                        </button>
                      </div>
                    </div>
                    <div className="space-y-3">
                      <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                        Categorie
                      </label>
                      <select
                        className="auth-input"
                        aria-invalid={
                          stepErrors.productCategory ? "true" : "false"
                        }
                        value={draft.productCategory}
                        onChange={(e) =>
                          setField("productCategory", e.target.value)
                        }
                      >
                        <option value="">Choisir...</option>
                        {draft.categories.map((cat) => (
                          <option key={cat} value={cat}>
                            {cat}
                          </option>
                        ))}
                      </select>
                      {stepErrors.productCategory ? (
                        <p className="auth-error-text" role="alert">
                          {stepErrors.productCategory}
                        </p>
                      ) : null}
                    </div>
                  </div>
                </div>
              </section>
            ) : null}

            {currentStep === 5 ? (
              <section>
                <div className="space-y-10 animate-slide-in">
                  <header className="space-y-3">
                    <span className="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">
                      Etape 05
                    </span>
                    <h2 className="text-4xl text-white">Gestion des Roles</h2>
                    <p className="text-white/50">
                      Creez et personnalisez les profils d'acces pour votre
                      equipe.
                    </p>
                  </header>
                  <div className="bg-white/5 border border-white/10 backdrop-blur-xl p-10 rounded-2xl space-y-8">
                    <div className="space-y-4">
                      <div className="flex gap-3">
                        <input
                          className="flex-1 bg-white/5 border border-white/10 rounded-xl p-4 text-white"
                          value={roleInput}
                          onChange={(e) => setRoleInput(e.target.value)}
                          placeholder="Taper le nom du role..."
                          type="text"
                          onKeyDown={(e) => {
                            if (e.key === "Enter") {
                              e.preventDefault();
                              addRole(roleInput);
                            }
                          }}
                        />
                        <button
                          className="bg-primary text-midnight font-bold px-3 py-2 md:px-8 md:py-4 rounded-xl"
                          onClick={() => addRole(roleInput)}
                          type="button"
                        >
                          Creer
                        </button>
                      </div>
                    </div>

                    <div className="flex flex-wrap gap-3">
                      {draft.roles.map((role) => (
                        <button
                          key={role}
                          className={`px-6 py-4 rounded-xl border-2 transition-all flex items-center gap-3 ${draft.selectedRole === role ? "border-primary bg-primary/5 text-white" : "border-white/10 text-white/50 hover:border-white/20"}`}
                          type="button"
                          onClick={() => setField("selectedRole", role)}
                        >
                          <span className="material-symbols-outlined text-sm">
                            {draft.selectedRole === role
                              ? "check_circle"
                              : "circle"}
                          </span>
                          <span className="font-bold">{role}</span>
                          {role !== "Admin" ? (
                            <span
                              className="material-symbols-outlined text-xs opacity-50"
                              onClick={(event) => {
                                event.stopPropagation();
                                removeRole(role);
                              }}
                            >
                              delete
                            </span>
                          ) : null}
                        </button>
                      ))}
                    </div>
                  </div>
                </div>
              </section>
            ) : null}

            {currentStep === 6 ? (
              <section>
                <div className="space-y-8 animate-slide-in">
                  <header className="space-y-3">
                    <span className="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">
                      Etape 06
                    </span>
                    <h2 className="text-4xl text-white">Matrice de Securite</h2>
                    <p className="text-white/50">
                      Configurez les acces pour{" "}
                      <span className="text-primary font-bold">
                        {draft.selectedRole}
                      </span>
                    </p>
                  </header>

                  <div className="bg-white/5 border border-white/10 backdrop-blur-xl rounded-2xl overflow-hidden shadow-lg shadow-black/10">
                    <div className="overflow-x-auto">
                      <table className="min-w-[720px] w-full text-left text-white/90">
                        <thead className="bg-white/10 text-white/70">
                          <tr>
                            <th className="p-5 text-white/50 uppercase tracking-wider text-[10px] font-bold">
                              Module
                            </th>
                            {CRUD_KEYS.map((key) => (
                              <th
                                key={key}
                                className="p-5 text-white/50 uppercase tracking-wider text-[10px] font-bold text-center"
                              >
                                {key}
                              </th>
                            ))}
                          </tr>
                        </thead>
                        <tbody className="divide-y divide-white/10 bg-white/5/10">
                          {groupedPermissions.length === 0 ? (
                            <tr>
                              <td
                                className="p-5 text-center text-white/50"
                                colSpan={6}
                              >
                                Aucune permission trouvee.
                              </td>
                            </tr>
                          ) : (
                            groupedPermissions.map(({ moduleKey, rows }) => (
                              <tr
                                key={moduleKey}
                                className="odd:bg-white/5 even:bg-transparent"
                              >
                                <td className="p-5 font-medium text-sm text-white">
                                  {moduleLabel(moduleKey)}
                                </td>
                                {rows.map(({ action, permission }) => {
                                  if (!permission) {
                                    return (
                                      <td
                                        key={action}
                                        className="p-5 text-center text-white/30"
                                      >
                                        -
                                      </td>
                                    );
                                  }

                                  const checked =
                                    draft.selectedRole === "Admin" ||
                                    draft.selectedPermissions.includes(
                                      permission.code,
                                    );

                                  return (
                                    <td
                                      key={action}
                                      className="p-5 text-center"
                                    >
                                      <input
                                        type="checkbox"
                                        className="perm-checkbox w-4 h-4 rounded bg-white/5 border border-white/10 text-primary focus:ring-primary"
                                        checked={checked}
                                        onChange={(e) =>
                                          togglePermission(
                                            permission.code,
                                            e.target.checked,
                                          )
                                        }
                                      />
                                    </td>
                                  );
                                })}
                              </tr>
                            ))
                          )}
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
            ) : null}

            {currentStep === 7 ? (
              <section>
                <div className="space-y-8 animate-slide-in">
                  <header className="space-y-3">
                    <span className="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">
                      Etape 07
                    </span>
                    <h2 className="text-4xl text-white">Collaborateurs</h2>
                    <p className="text-white/50">
                      Invitez votre equipe a rejoindre votre nouvel espace.
                    </p>
                  </header>
                  <div className="space-y-6">
                    <div className="grid grid-cols-1 md:grid-cols-5 gap-6 bg-white/5 border border-white/10 backdrop-blur-xl p-8 rounded-2xl items-end">
                      <div className="md:col-span-2 space-y-3">
                        <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                          Email du collaborateur
                        </label>
                        <input
                          className="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white"
                          value={inviteEmail}
                          onChange={(e) => setInviteEmail(e.target.value)}
                          type="email"
                        />
                      </div>
                      <div className="md:col-span-2 space-y-3">
                        <label className="text-white/50 uppercase tracking-wider text-[11px] font-bold">
                          Role assigne
                        </label>
                        <select
                          className="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white"
                          value={inviteRole}
                          onChange={(e) => setInviteRole(e.target.value)}
                        >
                          {draft.roles.map((role) => (
                            <option key={role} value={role}>
                              {role}
                            </option>
                          ))}
                        </select>
                      </div>
                      <button
                        className="bg-primary text-midnight h-[56px] font-bold rounded-xl"
                        onClick={addInvitation}
                        type="button"
                      >
                        <span className="material-symbols-outlined">
                          person_add
                        </span>
                      </button>
                    </div>

                    <div className="space-y-3">
                      {draft.invitations.map((invitation, index) => (
                        <div
                          key={`${invitation.email}-${index}`}
                          className="flex items-center justify-between p-5 bg-white/5 border border-white/10 rounded-xl animate-slide-in"
                        >
                          <div className="flex items-center gap-4">
                            <div className="w-10 h-10 bg-primary/10 text-primary rounded-full flex items-center justify-center font-bold text-xs">
                              {invitation.email.charAt(0).toUpperCase()}
                            </div>
                            <div>
                              <p className="text-sm font-bold">
                                {invitation.email}
                              </p>
                              <p className="text-[10px] text-white/50 font-medium uppercase tracking-widest">
                                {invitation.role}
                              </p>
                            </div>
                          </div>
                          <button
                            onClick={() => removeInvitation(index)}
                            type="button"
                            className="text-white/50 hover:text-error"
                          >
                            <span className="material-symbols-outlined">
                              delete
                            </span>
                          </button>
                        </div>
                      ))}
                    </div>
                  </div>
                </div>
              </section>
            ) : null}

            {currentStep === 8 ? (
              <section>
                <div className="flex flex-col items-center justify-center min-h-[500px] text-center space-y-12 animate-slide-in">
                  <div className="relative rounded-full">
                    <div className="w-40 h-40 border-4 border-primary/10 border-t-primary rounded-full animate-spin"></div>
                    <div className="absolute inset-0 flex items-center justify-center">
                      <span className="material-symbols-outlined text-5xl text-primary animate-pulse">
                        cloud_upload
                      </span>
                    </div>
                  </div>
                  <div className="space-y-2">
                    <p className="text-primary tracking-[0.3em] font-bold uppercase">
                      {deployText}
                    </p>
                    <p className="text-xs text-white/50 opacity-50">
                      {deploySubtext}
                    </p>
                    {isDeploying ? null : (
                      <button
                        className="mt-8 bg-secondary text-on-secondary font-bold px-12 py-5 rounded-2xl"
                        type="button"
                        onClick={deployWizard}
                      >
                        Relancer le deploiement
                      </button>
                    )}
                  </div>
                </div>
              </section>
            ) : null}
          </div>
        </div>

        <footer className="h-16 px-12 bg-white/5 backdrop-blur-md border-t border-white/10 flex items-center justify-between z-20">
          <button
            className={`flex items-center gap-3 font-bold text-white/50 hover:text-white transition-all group ${currentStep === 1 || currentStep === 8 ? "hidden" : ""}`}
            onClick={goPrev}
            type="button"
          >
            <span className="material-symbols-outlined group-hover:-translate-x-1 transition-transform">
              arrow_back
            </span>
            <span className="hidden sd:inline">Retour</span>
          </button>
          <div className="flex-1"></div>
          <div className="flex items-center gap-6">
            <div className="text-xs font-bold tracking-widest text-white/50 hidden md:block">
              ETAPE <span className="text-white">{currentStep}</span> / 8
            </div>
            {currentStep < 8 ? (
              <button
                className="bg-primary text-midnight font-bold px-3 py-2 md:px-12 md:py-4 rounded-xl hover:bg-primary/90 active:scale-95 transition-all flex items-center gap-3 shadow-xl shadow-primary/10"
                onClick={goNext}
                type="button"
                disabled={isDeploying || saving}
              >
                <span className="material-symbols-outlined">arrow_forward</span>
                <span className="hidden md:inline">Continuer</span>
              </button>
            ) : null}
          </div>
        </footer>
      </main>
    </div>
  );
}
