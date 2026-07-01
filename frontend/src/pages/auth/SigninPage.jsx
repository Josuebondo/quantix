import { zodResolver } from "@hookform/resolvers/zod";
import { useEffect, useMemo, useState } from "react";
import { useForm } from "react-hook-form";
import { z } from "zod";
import api from "../../services/api";
import { authService } from "../../services/authService";
import { useAppStore } from "../../store/useAppStore";
import Logo from "../../components/common/Logo";

const stepOneSchema = z.object({
  company_name: z.string().min(1, "Le nom de l'entreprise est requis"),
  company_email: z.union([
    z.literal(""),
    z.string().email("Email entreprise invalide"),
  ]),
  company_phone: z.string().optional(),
});

const stepTwoSchema = z
  .object({
    admin_first_name: z.string().min(1, "Le prenom est requis"),
    admin_last_name: z.string().min(1, "Le nom est requis"),
    admin_email: z.string().email("Email professionnel invalide"),
    admin_password: z.string().min(8, "Minimum 8 caracteres"),
    admin_password_confirm: z.string().min(1, "Confirmez le mot de passe"),
  })
  .refine((data) => data.admin_password === data.admin_password_confirm, {
    message: "Les mots de passe ne correspondent pas",
    path: ["admin_password_confirm"],
  });

const stepperItems = [
  {
    number: "01",
    icon: "business",
    title: "Entreprise",
    description: "Informations de base",
  },
  {
    number: "02",
    icon: "person",
    title: "Administrateur",
    description: "Compte proprietaire",
  },
  {
    number: "03",
    icon: "mark_email_read",
    title: "Activation",
    description: "Verification e-mail",
  },
  {
    number: "04",
    icon: "rocket_launch",
    title: "Configuration",
    description: "Workspace pret",
  },
];

const benefitItems = [
  { icon: "verified", label: "Donnees securisees" },
  { icon: "security", label: "Sauvegarde automatique" },
  { icon: "warehouse", label: "Multi-entrepots" },
  { icon: "groups", label: "Multi-utilisateurs" },
  { icon: "cloud_done", label: "Disponible partout" },
  { icon: "speed", label: "Installation en 2 minutes" },
];

const loadingTimeline = [
  "Creation de votre espace...",
  "Configuration...",
  "Creation du workspace...",
  "Envoi de l'e-mail...",
];

function toSubdomain(value) {
  const clean = String(value || "")
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .replace(/[^a-z0-9\s-]/g, "")
    .trim()
    .replace(/\s+/g, "-")
    .slice(0, 30);
  return clean || "workspace-demo";
}

function passwordChecks(value) {
  return {
    length: value.length >= 8,
    lowerUpper: /[a-z]/.test(value) && /[A-Z]/.test(value),
    number: /\d/.test(value),
    special: /[^A-Za-z0-9]/.test(value),
  };
}

function scorePassword(value) {
  const checks = passwordChecks(value);
  return Object.values(checks).filter(Boolean).length;
}

function fieldClasses(hasError) {
  return `auth-input auth-input-icon pr-3 h-12 ${
    hasError ? "aria-[invalid=true]:border-red-400" : ""
  }`;
}

function InfoInput({
  id,
  label,
  icon,
  type = "text",
  placeholder,
  error,
  register,
  autoFocus = false,
}) {
  return (
    <div className="flex flex-col gap-2">
      <label
        htmlFor={id}
        className="text-[11px] font-bold text-white/55 uppercase tracking-[0.18em]"
      >
        {label}
      </label>
      <div className="relative group">
        <span className="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-[20px] transition-colors group-focus-within:text-primary">
          {icon}
        </span>
        <input
          id={id}
          type={type}
          autoFocus={autoFocus}
          placeholder={placeholder}
          className={fieldClasses(Boolean(error))}
          aria-invalid={error ? "true" : "false"}
          aria-label={label}
          {...register}
        />
      </div>
      <p className="auth-error-text min-h-4" role="alert">
        {error?.message}
      </p>
    </div>
  );
}

function ConfigInput({ id, label, icon, value, onChange, placeholder }) {
  return (
    <div className="flex flex-col gap-2">
      <label
        htmlFor={id}
        className="text-[11px] font-bold text-white/55 uppercase tracking-[0.18em]"
      >
        {label}
      </label>
      <div className="relative group">
        <span className="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-[20px] transition-colors group-focus-within:text-primary">
          {icon}
        </span>
        <input
          id={id}
          type="text"
          value={value}
          onChange={onChange}
          placeholder={placeholder}
          className="auth-input auth-input-icon pr-3 h-12"
          aria-label={label}
        />
      </div>
    </div>
  );
}

function PreviewCard({ preview }) {
  const items = [
    { icon: "business", label: "Nom entreprise", value: preview.companyName },
    { icon: "language", label: "Sous-domaine", value: preview.subdomain },
    { icon: "payments", label: "Plan", value: preview.plan },
    { icon: "public", label: "Pays", value: preview.country },
    { icon: "attach_money", label: "Devise", value: preview.currency },
    { icon: "schedule", label: "Fuseau horaire", value: preview.timezone },
  ];

  return (
    <aside className="auth-card p-6 lg:p-7 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_28px_90px_rgba(2,6,23,0.58)]">
      <div className="flex items-center justify-between mb-5">
        <div>
          <p className="text-[11px] font-bold tracking-[0.2em] uppercase text-primary/80">
            Apercu en temps reel
          </p>
          <h3 className="text-white text-xl font-semibold mt-2">
            Votre workspace
          </h3>
        </div>
        <span className="material-symbols-outlined text-primary text-2xl animate-pulse">
          rocket_launch
        </span>
      </div>

      <div className="space-y-3">
        {items.map((item) => (
          <div
            key={item.label}
            className="rounded-xl border border-white/8 bg-white/[0.02] px-3 py-2.5 transition-colors duration-300 hover:bg-white/[0.045]"
          >
            <p className="text-[11px] uppercase tracking-[0.16em] text-white/50 mb-1 flex items-center gap-1.5">
              <span className="material-symbols-outlined text-[16px] text-primary/80">
                {item.icon}
              </span>
              {item.label}
            </p>
            <p className="text-sm font-semibold text-white break-all">
              {item.value}
            </p>
          </div>
        ))}
      </div>
    </aside>
  );
}

export default function SigninPage() {
  const setAuth = useAppStore((state) => state.setAuth);
  const [currentStep, setCurrentStep] = useState(1);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [loadingMessage, setLoadingMessage] = useState(
    "Traitement en cours...",
  );
  const [result, setResult] = useState({ type: "", message: "" });
  const [loadingStepIndex, setLoadingStepIndex] = useState(0);
  const [workspaceConfig, setWorkspaceConfig] = useState({
    country: "Congo (RDC)",
    currency: "USD",
    language: "Francais",
    timezone: "Africa/Kinshasa",
    industry: "Distribution",
    employees: "1-10",
    plan: "Essai Gratuit",
  });

  const stepOneForm = useForm({
    resolver: zodResolver(stepOneSchema),
    mode: "onChange",
    defaultValues: {
      company_name: "",
      company_email: "",
      company_phone: "",
    },
  });

  const stepTwoForm = useForm({
    resolver: zodResolver(stepTwoSchema),
    mode: "onChange",
    defaultValues: {
      admin_first_name: "",
      admin_last_name: "",
      admin_email: "",
      admin_password: "",
      admin_password_confirm: "",
    },
  });

  const submitRegistration = async () => {
    const validStepOne = await stepOneForm.trigger();
    const validStepTwo = await stepTwoForm.trigger();
    if (!validStepOne || !validStepTwo) {
      setCurrentStep(validStepOne ? 2 : 1);
      return;
    }

    setCurrentStep(3);
    setIsSubmitting(true);
    setLoadingMessage("Traitement en cours...");
    setResult({ type: "", message: "" });

    const payload = {
      ...stepOneForm.getValues(),
      ...stepTwoForm.getValues(),
    };

    try {
      const response = await authService.registerCompany(payload);
      const data = response?.data ?? response;

      if (!data?.success) {
        let errorText = data?.message || "Une erreur est survenue";
        if (data?.errors && typeof data.errors === "object") {
          const messages = Object.values(data.errors)
            .flatMap((entry) => (Array.isArray(entry) ? entry : [entry]))
            .filter(Boolean)
            .map(String);
          if (messages.length) {
            errorText = messages.join("\n");
          }
        }

        setResult({ type: "error", message: errorText });
        return;
      }

      const token = data?.data?.tokens?.access_token ?? null;
      const user = data?.data?.user ?? null;
      if (token) {
        setAuth({ token, user });
      }

      try {
        await api.post("/company/send-activation", {
          email: payload.admin_email,
        });
      } catch {
        // Keep success screen even if resend endpoint fails silently.
      }

      setResult({
        type: "success",
        message:
          "Votre inscription a ete un succes ! Un e-mail d'activation a ete envoye.",
      });
    } catch (error) {
      setResult({
        type: "error",
        message: error?.message || "Impossible de contacter le serveur",
      });
    } finally {
      setIsSubmitting(false);
    }
  };

  const resendActivationEmail = async () => {
    const email = stepTwoForm.getValues("admin_email");
    if (!email) return;

    setLoadingMessage("Envoi en cours...");
    try {
      await api.post("/company/send-activation", { email });
      setResult({
        type: "success",
        message: "E-mail de reactivation envoye.",
      });
    } catch {
      setResult({
        type: "error",
        message: "Erreur lors de l'envoi de l'e-mail",
      });
    } finally {
      setLoadingMessage("Traitement en cours...");
    }
  };

  const disableContinueStepOne =
    !stepOneForm.formState.isValid || isSubmitting || currentStep !== 1;
  const disableContinueStepTwo =
    !stepTwoForm.formState.isValid || isSubmitting || currentStep !== 2;
  const canResend = useMemo(() => {
    return !isSubmitting && !!stepTwoForm.getValues("admin_email");
  }, [isSubmitting, stepTwoForm]);

  const companyName = stepOneForm.watch("company_name") || "KABIPANGI-FILS";
  const companyEmail =
    stepOneForm.watch("company_email") || "contact@entreprise.com";
  const companyPhone = stepOneForm.watch("company_phone") || "+243 000 000 000";
  const adminEmail = stepTwoForm.watch("admin_email") || "admin@entreprise.com";
  const adminPassword = stepTwoForm.watch("admin_password") || "";
  const checks = passwordChecks(adminPassword);
  const passwordScore = scorePassword(adminPassword);
  const passwordPercent = (passwordScore / 4) * 100;
  const passwordLevel =
    passwordScore <= 1
      ? "Faible"
      : passwordScore <= 2
        ? "Moyen"
        : passwordScore <= 3
          ? "Bon"
          : "Excellent";

  const visualStep =
    currentStep === 1
      ? 1
      : currentStep === 2
        ? 2
        : isSubmitting
          ? 3
          : result.type
            ? 4
            : 3;
  const stepProgress = `${((visualStep - 1) / (stepperItems.length - 1)) * 100}%`;

  const preview = useMemo(() => {
    const domain = `${toSubdomain(companyName)}.quantix.app`;
    return {
      companyName,
      subdomain: domain,
      plan: workspaceConfig.plan,
      country: workspaceConfig.country,
      currency: workspaceConfig.currency,
      timezone: workspaceConfig.timezone,
      adminEmail,
    };
  }, [adminEmail, companyName, workspaceConfig]);

  useEffect(() => {
    if (!isSubmitting) {
      setLoadingStepIndex(0);
      return;
    }

    setLoadingStepIndex(0);
    setLoadingMessage(loadingTimeline[0]);

    const timer = setInterval(() => {
      setLoadingStepIndex((prev) => {
        const next = Math.min(prev + 1, loadingTimeline.length - 1);
        setLoadingMessage(loadingTimeline[next]);
        return next;
      });
    }, 1200);

    return () => clearInterval(timer);
  }, [isSubmitting]);

  const updateConfig = (field) => (event) => {
    setWorkspaceConfig((prev) => ({
      ...prev,
      [field]: event.target.value,
    }));
  };

  return (
    <div className="auth-shell text-on-background font-body-md min-h-screen selection:bg-primary/30 antialiased overflow-x-hidden">
      <header className="sticky top-0 z-40 border-b border-white/10 bg-slate-950/70 backdrop-blur-xl">
        <div className="mx-auto max-w-[1280px] h-20 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
          <div className="flex items-center gap-3">
            <Logo />
          </div>
          <a
            href="/login"
            className="h-10 px-4 rounded-lg border border-white/15 text-xs font-bold tracking-[0.18em] uppercase text-white/70 hover:text-white hover:border-white/30 transition-colors duration-200 flex items-center gap-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/50"
            aria-label="Acceder a la connexion"
          >
            <span className="material-symbols-outlined text-base">login</span>
            <span className="hidden sm:inline">Connexion</span>
          </a>
        </div>
      </header>

      <main className="relative z-10 px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <section className="mx-auto max-w-[1280px] mb-8 md:mb-10 animate-fade-in">
          <div className="auth-card px-5 py-8 sm:p-8 lg:p-10">
            <p className="text-primary/90 text-xs font-bold tracking-[0.2em] uppercase mb-3">
              Get Started
            </p>
            <h1 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-[1.05]">
              Lancez votre espace Quantix en moins de 2 minutes
            </h1>
            <p className="hidden sm:block text-white/65 mt-4 text-sm sm:text-base max-w-3xl leading-relaxed">
              Onboarding premium, configuration guidee et activation immediate.
              Concentrez-vous sur votre business, Quantix gere le reste.
            </p>

            <div className="mt-6 flex flex-wrap gap-3">
              {[
                "Essai gratuit",
                "Sans carte bancaire",
                "Configuration en moins de 2 minutes",
              ].map((badge, index) => (
                <span
                  key={badge}
                  className={`inline-flex items-center gap-2 rounded-full border border-primary/25 bg-primary/10 px-4 py-2 text-xs font-semibold text-primary transition-transform duration-300 hover:-translate-y-0.5 ${
                    index > 0 ? "hidden sm:inline-flex" : "inline-flex"
                  }`}
                >
                  <span className="material-symbols-outlined text-[16px]">
                    verified
                  </span>
                  {badge}
                </span>
              ))}
            </div>
          </div>
        </section>

        <section className="mx-auto max-w-[1280px] mb-8 md:mb-10 animate-fade-in">
          <div className="auth-card p-5 sm:p-6 lg:p-8">
            <div className="relative">
              <div className="absolute top-6 left-0 right-0 h-[2px] bg-white/10" />
              <div
                className="absolute top-6 left-0 h-[2px] bg-primary transition-all duration-700 ease-out"
                style={{ width: stepProgress }}
                aria-hidden="true"
              />

              <div className="relative grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                {stepperItems.map((item, index) => {
                  const stepIndex = index + 1;
                  const isDone = visualStep > stepIndex;
                  const isCurrent = visualStep === stepIndex;

                  return (
                    <div
                      key={item.title}
                      className="pt-0.5"
                      aria-current={isCurrent ? "step" : undefined}
                    >
                      <div className="flex items-center gap-3">
                        <div
                          className={`w-12 h-12 rounded-xl border flex items-center justify-center transition-all duration-500 ${
                            isDone
                              ? "bg-primary text-slate-900 border-primary"
                              : isCurrent
                                ? "bg-primary/15 text-primary border-primary/50 shadow-[0_0_0_4px_rgba(19,236,128,0.12)]"
                                : "bg-white/[0.02] text-white/50 border-white/15"
                          }`}
                        >
                          <span className="material-symbols-outlined text-[20px]">
                            {isDone ? "check_circle" : item.icon}
                          </span>
                        </div>
                        <div>
                          <p className="hidden sm:block text-[10px] tracking-[0.2em] uppercase font-bold text-white/45">
                            {item.number}
                          </p>
                          <p
                            className={`text-sm font-semibold ${
                              isCurrent || isDone
                                ? "text-white"
                                : "text-white/60"
                            }`}
                          >
                            {item.title}
                          </p>
                          <p className="hidden md:block text-xs text-white/45">
                            {item.description}
                          </p>
                        </div>
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>
          </div>
        </section>

        <section className="mx-auto max-w-[1280px] grid grid-cols-1 xl:grid-cols-[280px_minmax(0,1fr)_320px] gap-6 items-start">
          <aside className="order-3 auth-card p-6 animate-fade-in md:hidden xl:block xl:order-1">
            <div className="mb-5">
              <p className="text-[11px] uppercase tracking-[0.2em] text-primary/80 font-bold">
                Pourquoi Quantix
              </p>
              <h3 className="text-white text-xl font-semibold mt-2">
                Avantages inclus
              </h3>
            </div>
            <ul className="space-y-3">
              {benefitItems.map((benefit) => (
                <li
                  key={benefit.label}
                  className="rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5 flex items-center gap-3 transition-all duration-200 hover:bg-white/[0.05] hover:border-white/20"
                >
                  <span className="material-symbols-outlined text-primary text-[20px]">
                    {benefit.icon}
                  </span>
                  <span className="text-sm text-white/80">{benefit.label}</span>
                </li>
              ))}
            </ul>
          </aside>

          <div className="order-1 xl:order-2 animate-fade-in">
            {currentStep === 1 ? (
              <section className="auth-card p-5 sm:p-8 lg:p-10 transition-all duration-500">
                <div className="mb-8">
                  <h2 className="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    Informations Entreprise
                  </h2>
                  <p className="text-white/60 mt-2">
                    Configurez votre entreprise et vos preferences de workspace.
                  </p>
                </div>

                <div className="hidden md:block xl:hidden mb-6">
                  <PreviewCard preview={preview} />
                </div>

                <form
                  className="space-y-6"
                  onSubmit={stepOneForm.handleSubmit(() => setCurrentStep(2))}
                  aria-label="Formulaire entreprise"
                >
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <InfoInput
                      id="company_name"
                      label="Nom *"
                      icon="business"
                      placeholder="Entreprise SARL"
                      error={stepOneForm.formState.errors.company_name}
                      register={stepOneForm.register("company_name")}
                      autoFocus
                    />

                    <InfoInput
                      id="company_email"
                      label="Email"
                      icon="mail"
                      type="email"
                      placeholder="contact@entreprise.com"
                      error={stepOneForm.formState.errors.company_email}
                      register={stepOneForm.register("company_email")}
                    />

                    <InfoInput
                      id="company_phone"
                      label="Telephone"
                      icon="call"
                      type="tel"
                      placeholder="+33 1 23 45 67 89"
                      error={stepOneForm.formState.errors.company_phone}
                      register={stepOneForm.register("company_phone")}
                    />

                    <ConfigInput
                      id="company_country"
                      label="Pays"
                      icon="public"
                      value={workspaceConfig.country}
                      onChange={updateConfig("country")}
                      placeholder="France"
                    />

                    <ConfigInput
                      id="company_currency"
                      label="Devise"
                      icon="payments"
                      value={workspaceConfig.currency}
                      onChange={updateConfig("currency")}
                      placeholder="EUR"
                    />

                    <ConfigInput
                      id="company_language"
                      label="Langue"
                      icon="language"
                      value={workspaceConfig.language}
                      onChange={updateConfig("language")}
                      placeholder="Francais"
                    />

                    <ConfigInput
                      id="company_timezone"
                      label="Fuseau horaire"
                      icon="schedule"
                      value={workspaceConfig.timezone}
                      onChange={updateConfig("timezone")}
                      placeholder="Africa/Paris"
                    />

                    <ConfigInput
                      id="company_industry"
                      label="Secteur d'activite"
                      icon="business_center"
                      value={workspaceConfig.industry}
                      onChange={updateConfig("industry")}
                      placeholder="Retail"
                    />

                    <ConfigInput
                      id="company_employees"
                      label="Nombre d'employes"
                      icon="groups"
                      value={workspaceConfig.employees}
                      onChange={updateConfig("employees")}
                      placeholder="1-10"
                    />
                  </div>

                  <button
                    className="auth-btn-primary h-12 px-6 w-full sm:w-auto bg-primary text-slate-900 font-bold text-xs tracking-[0.18em] uppercase inline-flex items-center justify-center gap-2 shadow-[0_16px_30px_rgba(19,236,128,0.2)] hover:shadow-[0_20px_36px_rgba(19,236,128,0.28)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/70 disabled:opacity-60"
                    type="submit"
                    disabled={disableContinueStepOne}
                    aria-busy={isSubmitting}
                    aria-label="Continuer vers administrateur"
                  >
                    Continuer
                    <span className="material-symbols-outlined text-lg">
                      arrow_forward
                    </span>
                  </button>
                </form>
              </section>
            ) : null}

            {currentStep === 2 ? (
              <section className="auth-card p-5 sm:p-8 lg:p-10 transition-all duration-500">
                <div className="mb-8">
                  <h2 className="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    Compte Administrateur
                  </h2>
                  <p className="text-white/60 mt-2">
                    Creez le compte principal qui pilotera votre workspace.
                  </p>
                </div>

                <form
                  onSubmit={stepTwoForm.handleSubmit(submitRegistration)}
                  className="space-y-6"
                  aria-label="Formulaire administrateur"
                >
                  <div className="hidden md:block xl:hidden">
                    <PreviewCard preview={preview} />
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <InfoInput
                      id="admin_first_name"
                      label="Prenom *"
                      icon="badge"
                      placeholder="Jean"
                      error={stepTwoForm.formState.errors.admin_first_name}
                      register={stepTwoForm.register("admin_first_name")}
                    />

                    <InfoInput
                      id="admin_last_name"
                      label="Nom *"
                      icon="badge"
                      placeholder="Dupont"
                      error={stepTwoForm.formState.errors.admin_last_name}
                      register={stepTwoForm.register("admin_last_name")}
                    />

                    <div className="sm:col-span-2">
                      <InfoInput
                        id="admin_email"
                        label="Email professionnel *"
                        icon="mail"
                        type="email"
                        placeholder="jean@entreprise.com"
                        error={stepTwoForm.formState.errors.admin_email}
                        register={stepTwoForm.register("admin_email")}
                      />
                    </div>

                    <InfoInput
                      id="admin_password"
                      label="Mot de passe *"
                      icon="lock"
                      type="password"
                      placeholder="********"
                      error={stepTwoForm.formState.errors.admin_password}
                      register={stepTwoForm.register("admin_password")}
                    />

                    <InfoInput
                      id="admin_password_confirm"
                      label="Confirmation *"
                      icon="lock_reset"
                      type="password"
                      placeholder="********"
                      error={
                        stepTwoForm.formState.errors.admin_password_confirm
                      }
                      register={stepTwoForm.register("admin_password_confirm")}
                    />
                  </div>

                  <div
                    className="rounded-2xl border border-white/10 bg-white/[0.02] p-4"
                    aria-live="polite"
                  >
                    <div className="flex items-center justify-between gap-4 mb-3">
                      <p className="text-xs uppercase tracking-[0.18em] text-white/60 font-bold">
                        Force du mot de passe
                      </p>
                      <p className="text-sm font-semibold text-primary">
                        {passwordLevel}
                      </p>
                    </div>
                    <div className="h-2 rounded-full bg-white/10 overflow-hidden mb-4">
                      <div
                        className={`h-full transition-all duration-500 ${
                          passwordScore <= 1
                            ? "bg-red-500"
                            : passwordScore <= 2
                              ? "bg-amber-400"
                              : passwordScore <= 3
                                ? "bg-primary/70"
                                : "bg-primary"
                        }`}
                        style={{ width: `${passwordPercent}%` }}
                      />
                    </div>

                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-2">
                      {[
                        { ok: checks.length, text: "Minimum 8 caracteres" },
                        {
                          ok: checks.lowerUpper,
                          text: "Majuscule et minuscule",
                        },
                        { ok: checks.number, text: "Au moins un chiffre" },
                        {
                          ok: checks.special,
                          text: "Au moins un caractere special",
                        },
                      ].map((rule) => (
                        <p
                          key={rule.text}
                          className={`text-xs flex items-center gap-2 ${
                            rule.ok ? "text-primary" : "text-white/55"
                          }`}
                        >
                          <span className="material-symbols-outlined text-[16px]">
                            {rule.ok ? "check_circle" : "cancel"}
                          </span>
                          {rule.text}
                        </p>
                      ))}
                    </div>
                  </div>

                  <div className="flex flex-col sm:flex-row gap-3 pt-2">
                    <button
                      className="h-12 px-6 rounded-xl border border-white/15 text-white/75 font-bold text-xs tracking-[0.18em] uppercase inline-flex items-center justify-center gap-2 transition-all duration-200 hover:border-white/30 hover:text-white active:scale-[0.99] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/70 disabled:opacity-60"
                      onClick={() => setCurrentStep(1)}
                      type="button"
                      disabled={isSubmitting}
                      aria-label="Revenir aux informations entreprise"
                    >
                      <span className="material-symbols-outlined text-lg">
                        arrow_back
                      </span>
                      Retour
                    </button>

                    <button
                      className="auth-btn-primary h-12 px-6 rounded-xl bg-primary text-slate-900 font-bold text-xs tracking-[0.18em] uppercase inline-flex items-center justify-center gap-2 shadow-[0_16px_30px_rgba(19,236,128,0.2)] hover:shadow-[0_20px_36px_rgba(19,236,128,0.28)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/70 disabled:opacity-60"
                      type="submit"
                      disabled={disableContinueStepTwo}
                      aria-busy={isSubmitting}
                      aria-label="Lancer la creation du workspace"
                    >
                      {isSubmitting ? "Creation..." : "Lancer"}
                      <span className="material-symbols-outlined text-lg">
                        {isSubmitting ? "progress_activity" : "rocket_launch"}
                      </span>
                    </button>
                  </div>
                </form>
              </section>
            ) : null}

            {currentStep === 3 ? (
              <section className="auth-card p-6 sm:p-10 transition-all duration-500">
                {isSubmitting ? (
                  <div
                    className="max-w-2xl mx-auto text-center"
                    role="status"
                    aria-live="polite"
                  >
                    <div className="mx-auto mb-6 w-16 h-16 rounded-2xl bg-primary/10 border border-primary/30 flex items-center justify-center">
                      <span className="material-symbols-outlined text-primary text-4xl animate-spin">
                        progress_activity
                      </span>
                    </div>
                    <h2 className="text-3xl font-bold text-white tracking-tight mb-2">
                      Creation de votre espace...
                    </h2>
                    <p className="text-white/65">{loadingMessage}</p>

                    <div className="mt-8 space-y-2 text-left max-w-lg mx-auto">
                      {loadingTimeline.map((item, index) => {
                        const done = index <= loadingStepIndex;
                        return (
                          <div
                            key={item}
                            className={`rounded-xl border px-4 py-3 flex items-center gap-3 transition-all duration-300 ${
                              done
                                ? "border-primary/40 bg-primary/10 text-primary"
                                : "border-white/10 bg-white/[0.02] text-white/50"
                            }`}
                          >
                            <span className="material-symbols-outlined text-[18px]">
                              {done ? "check_circle" : "schedule"}
                            </span>
                            <span className="text-sm font-medium">{item}</span>
                          </div>
                        );
                      })}
                    </div>
                  </div>
                ) : result.type === "success" ? (
                  <div className="max-w-2xl mx-auto text-center">
                    <div className="mx-auto mb-7 w-20 h-20 rounded-2xl bg-primary/10 border border-primary/30 flex items-center justify-center shadow-[0_0_32px_rgba(19,236,128,0.22)]">
                      <span className="material-symbols-outlined text-primary text-5xl">
                        celebration
                      </span>
                    </div>

                    <h2 className="text-3xl sm:text-4xl font-bold text-white tracking-tight">
                      Bienvenue sur Quantix
                    </h2>
                    <p className="text-white/70 text-base sm:text-lg mt-3">
                      Votre espace est pret.
                    </p>

                    <div className="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-3 text-left">
                      {[
                        ["Entreprise", preview.companyName],
                        ["Sous-domaine", preview.subdomain],
                        ["Plan", preview.plan],
                        ["Email", preview.adminEmail],
                      ].map(([label, value]) => (
                        <div
                          key={label}
                          className="rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3"
                        >
                          <p className="text-[11px] uppercase tracking-[0.16em] text-white/55 font-semibold mb-1">
                            {label}
                          </p>
                          <p className="text-sm font-semibold text-white break-all">
                            {value}
                          </p>
                        </div>
                      ))}
                    </div>

                    <div className="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                      <a
                        href={`mailto:${preview.adminEmail}`}
                        className="h-12 px-5 rounded-xl border border-white/15 text-white/85 font-bold text-xs tracking-[0.18em] uppercase inline-flex items-center justify-center gap-2 hover:border-white/30 hover:bg-white/[0.04] transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/70"
                        aria-label="Ouvrir ma messagerie"
                      >
                        <span className="material-symbols-outlined text-lg">
                          mail
                        </span>
                        Ouvrir ma messagerie
                      </a>

                      <button
                        onClick={resendActivationEmail}
                        className="auth-btn-primary h-12 px-5 rounded-xl bg-primary text-slate-900 font-bold text-xs tracking-[0.18em] uppercase inline-flex items-center justify-center gap-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/70 disabled:opacity-60"
                        type="button"
                        disabled={!canResend}
                        aria-label="Renvoyer l'e-mail d'activation"
                      >
                        <span className="material-symbols-outlined text-lg">
                          refresh
                        </span>
                        Renvoyer l'e-mail
                      </button>

                      <a
                        href="/login"
                        className="h-12 px-5 rounded-xl border border-white/15 text-white/85 font-bold text-xs tracking-[0.18em] uppercase inline-flex items-center justify-center gap-2 hover:border-white/30 hover:bg-white/[0.04] transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/70"
                        aria-label="Acceder a la connexion"
                      >
                        <span className="material-symbols-outlined text-lg">
                          login
                        </span>
                        Acceder a la connexion
                      </a>
                    </div>
                  </div>
                ) : (
                  <div className="max-w-2xl mx-auto text-center">
                    <div className="mx-auto mb-7 w-20 h-20 rounded-2xl bg-red-500/10 border border-red-500/30 flex items-center justify-center">
                      <span className="material-symbols-outlined text-red-400 text-5xl">
                        error
                      </span>
                    </div>
                    <h2 className="text-3xl sm:text-4xl font-bold text-white tracking-tight">
                      Une erreur est survenue
                    </h2>
                    <p className="text-white/70 mt-3 whitespace-pre-line">
                      {result.message || "Une erreur est survenue"}
                    </p>

                    <div className="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                      <button
                        onClick={() => setCurrentStep(1)}
                        className="auth-btn-primary h-12 px-6 rounded-xl bg-primary text-slate-900 font-bold text-xs tracking-[0.18em] uppercase inline-flex items-center justify-center gap-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/70"
                        type="button"
                        aria-label="Reessayer"
                      >
                        <span className="material-symbols-outlined text-lg">
                          refresh
                        </span>
                        Reessayer
                      </button>

                      <a
                        href="mailto:support@quantix.app"
                        className="h-12 px-6 rounded-xl border border-white/15 text-white/85 font-bold text-xs tracking-[0.18em] uppercase inline-flex items-center justify-center gap-2 hover:border-white/30 hover:bg-white/[0.04] transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/70"
                        aria-label="Contacter le support"
                      >
                        <span className="material-symbols-outlined text-lg">
                          support_agent
                        </span>
                        Contacter le support
                      </a>
                    </div>
                  </div>
                )}
              </section>
            ) : null}
          </div>

          <div className="order-2 xl:order-3 hidden xl:block animate-fade-in">
            <PreviewCard preview={preview} />
            <div className="hidden 2xl:block auth-card mt-5 p-5">
              <p className="text-[11px] uppercase tracking-[0.2em] text-white/50 font-bold mb-3">
                Activite
              </p>
              <div className="space-y-2">
                {[
                  `Entreprise: ${companyName}`,
                  `Contact: ${companyEmail}`,
                  `Telephone: ${companyPhone}`,
                  `Admin: ${adminEmail}`,
                ].map((line) => (
                  <p key={line} className="text-sm text-white/70 break-all">
                    {line}
                  </p>
                ))}
              </div>
            </div>
          </div>
        </section>
      </main>

      <div className="fixed inset-0 pointer-events-none -z-10 overflow-hidden bg-slate-950">
        <div className="absolute top-[-12%] right-[-10%] w-[70%] h-[60%] bg-primary/10 blur-[140px] rounded-full" />
        <div className="absolute bottom-[-20%] left-[-15%] w-[70%] h-[70%] bg-cyan-400/10 blur-[140px] rounded-full" />
        <div className="absolute top-[35%] left-[42%] w-[20%] h-[20%] bg-white/5 blur-[120px] rounded-full" />
      </div>
    </div>
  );
}
