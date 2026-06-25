import { zodResolver } from "@hookform/resolvers/zod";
import { useMemo, useState } from "react";
import { useForm } from "react-hook-form";
import { z } from "zod";
import api from "../../services/api";
import { authService } from "../../services/authService";
import { useAppStore } from "../../store/useAppStore";

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

export default function SigninPage() {
  const setAuth = useAppStore((state) => state.setAuth);
  const [currentStep, setCurrentStep] = useState(1);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [loadingMessage, setLoadingMessage] = useState(
    "Traitement en cours...",
  );
  const [result, setResult] = useState({ type: "", message: "" });

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

  const lineWidth =
    currentStep === 1 ? "0%" : currentStep === 2 ? "50%" : "100%";

  const disableContinueStepOne =
    !stepOneForm.formState.isValid || isSubmitting || currentStep !== 1;
  const disableContinueStepTwo =
    !stepTwoForm.formState.isValid || isSubmitting || currentStep !== 2;
  const canResend = useMemo(() => {
    return !isSubmitting && !!stepTwoForm.getValues("admin_email");
  }, [isSubmitting, stepTwoForm]);

  return (
    <div className="auth-shell text-on-background font-body-md min-h-screen flex flex-col selection:bg-primary/30 antialiased overflow-x-hidden">
      <nav className="bg-background/40 backdrop-blur-xl text-sm border-b border-white/5 flex justify-between items-center px-8 h-20 w-full fixed top-0 z-50">
        <div className="flex items-center gap-3">
          <div className="flex items-center justify-center w-10 h-10 rounded-lg bg-primary/10 border border-primary/30 shadow-[0_0_15px_rgba(19,236,128,0.1)]">
            <span className="material-symbols-outlined text-primary text-2xl">
              deployed_code
            </span>
          </div>
          <div className="flex flex-col">
            <span className="text-xl font-bold text-white tracking-tight leading-none font-headline-md">
              QUATINX
            </span>
            <span className="text-[8px] uppercase tracking-[0.2em] text-white/40 font-semibold">
              Enterprise Solution
            </span>
          </div>
        </div>
        <div className="flex items-center gap-6">
          <span className="text-on-surface-variant text-xs font-semibold tracking-widest uppercase opacity-70">
            Support
          </span>
          <button
            className="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center"
            type="button"
          >
            <span className="material-symbols-outlined text-sm">help</span>
          </button>
        </div>
      </nav>

      <main className="flex-grow flex flex-col items-center justify-start pt-40 pb-32 px-6 w-full relative z-10">
        <div className="w-full max-w-xl mb-24 relative">
          <div className="flex items-center justify-between relative">
            <div className="absolute top-5 left-4 right-4 h-[1px] bg-white/10 -z-0"></div>
            <div
              className="absolute top-5 left-4 h-[1px] bg-primary transition-all duration-500 -z-0"
              style={{ width: `calc(${lineWidth} - 2rem)` }}
            ></div>

            {[1, 2, 3].map((step) => {
              const active = currentStep >= step;
              const current = currentStep === step;
              const icon =
                step === 1 ? "business" : step === 2 ? "person" : "verified";
              const label = step === 1 ? "Infos" : step === 2 ? "Owner" : "Fin";
              return (
                <div
                  key={step}
                  className="relative z-10 flex flex-col items-center gap-4"
                >
                  <div
                    className={`w-10 h-10 rounded-full flex items-center justify-center ring-8 ring-background transition-all duration-500 ${active ? (current ? "bg-primary text-on-primary shadow-[0_0_15px_rgba(19,236,128,0.3)]" : "bg-primary/20 text-primary") : "bg-surface-container-highest text-on-surface-variant/40"}`}
                  >
                    <span className="material-symbols-outlined text-base">
                      {active && !current ? "done" : icon}
                    </span>
                  </div>
                  <span
                    className={`text-[10px] font-bold uppercase tracking-[0.2em] ${active ? "text-primary" : "text-outline opacity-50"}`}
                  >
                    {label}
                  </span>
                </div>
              );
            })}
          </div>
        </div>

        <div className="w-full max-w-5xl mx-auto">
          {currentStep === 1 ? (
            <section className="step-content active">
              <div className="max-w-2xl mx-auto auth-card p-8 md:p-12">
                <div className="mb-10">
                  <h2 className="text-3xl font-bold text-white mb-3 font-headline-md tracking-tight">
                    Creez votre entreprise
                  </h2>
                  <p className="text-white/50 text-sm font-body-md">
                    Commencons par configurer votre profil et votre entreprise.
                  </p>
                </div>
                <form
                  className="space-y-8"
                  onSubmit={stepOneForm.handleSubmit(() => setCurrentStep(2))}
                >
                  <div className="space-y-4">
                    <h3 className="text-sm font-bold text-primary uppercase tracking-[0.2em]">
                      Informations Entreprise
                    </h3>
                    <div className="flex flex-col gap-2.5">
                      <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                        Nom de l'entreprise *
                      </label>
                      <input
                        className="auth-input"
                        type="text"
                        placeholder="Entreprise SARL"
                        autoFocus
                        aria-invalid={
                          stepOneForm.formState.errors.company_name
                            ? "true"
                            : "false"
                        }
                        {...stepOneForm.register("company_name")}
                      />
                      <p className="auth-error-text min-h-4" role="alert">
                        {stepOneForm.formState.errors.company_name?.message}
                      </p>
                    </div>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                      <div className="flex flex-col gap-2.5">
                        <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                          Email entreprise
                        </label>
                        <input
                          className="auth-input"
                          type="email"
                          placeholder="contact@entreprise.com"
                          aria-invalid={
                            stepOneForm.formState.errors.company_email
                              ? "true"
                              : "false"
                          }
                          {...stepOneForm.register("company_email")}
                        />
                        <p className="auth-error-text min-h-4" role="alert">
                          {stepOneForm.formState.errors.company_email?.message}
                        </p>
                      </div>
                      <div className="flex flex-col gap-2.5">
                        <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                          Telephone
                        </label>
                        <input
                          className="auth-input"
                          type="tel"
                          placeholder="+33 1 23 45 67 89"
                          {...stepOneForm.register("company_phone")}
                        />
                      </div>
                    </div>
                  </div>
                  <button
                    className="auth-btn-primary w-full bg-primary text-white font-bold py-5 rounded-xl"
                    type="submit"
                    disabled={disableContinueStepOne}
                    aria-busy={isSubmitting}
                  >
                    CONTINUER{" "}
                    <span className="material-symbols-outlined text-lg align-middle">
                      arrow_forward
                    </span>
                  </button>
                </form>
              </div>
            </section>
          ) : null}

          {currentStep === 2 ? (
            <section className="step-content active">
              <form onSubmit={stepTwoForm.handleSubmit(submitRegistration)}>
                <div className="max-w-2xl mx-auto auth-card p-8 md:p-12">
                  <div className="text-center mb-16">
                    <h2 className="text-4xl font-bold text-white mb-4">
                      Informations de l'Administrateur
                    </h2>
                    <p className="text-white/50">
                      Veuillez fournir les informations de l'administrateur.
                    </p>
                  </div>
                  <div className="pt-6 border-t border-white/5 space-y-4">
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                      <div className="flex flex-col gap-2.5">
                        <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                          Prenom *
                        </label>
                        <input
                          className="auth-input"
                          type="text"
                          placeholder="Jean"
                          aria-invalid={
                            stepTwoForm.formState.errors.admin_first_name
                              ? "true"
                              : "false"
                          }
                          {...stepTwoForm.register("admin_first_name")}
                        />
                        <p className="auth-error-text min-h-4" role="alert">
                          {
                            stepTwoForm.formState.errors.admin_first_name
                              ?.message
                          }
                        </p>
                      </div>
                      <div className="flex flex-col gap-2.5">
                        <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                          Nom *
                        </label>
                        <input
                          className="auth-input"
                          type="text"
                          placeholder="Dupont"
                          aria-invalid={
                            stepTwoForm.formState.errors.admin_last_name
                              ? "true"
                              : "false"
                          }
                          {...stepTwoForm.register("admin_last_name")}
                        />
                        <p className="auth-error-text min-h-4" role="alert">
                          {
                            stepTwoForm.formState.errors.admin_last_name
                              ?.message
                          }
                        </p>
                      </div>
                    </div>
                    <div className="flex flex-col gap-2.5">
                      <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                        Email professionnel *
                      </label>
                      <input
                        className="auth-input"
                        type="email"
                        placeholder="jean@entreprise.com"
                        aria-invalid={
                          stepTwoForm.formState.errors.admin_email
                            ? "true"
                            : "false"
                        }
                        {...stepTwoForm.register("admin_email")}
                      />
                      <p className="auth-error-text min-h-4" role="alert">
                        {stepTwoForm.formState.errors.admin_email?.message}
                      </p>
                    </div>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                      <div className="flex flex-col gap-2.5">
                        <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                          Mot de passe *
                        </label>
                        <input
                          className="auth-input"
                          type="password"
                          placeholder="••••••••"
                          aria-invalid={
                            stepTwoForm.formState.errors.admin_password
                              ? "true"
                              : "false"
                          }
                          {...stepTwoForm.register("admin_password")}
                        />
                        <p className="auth-error-text min-h-4" role="alert">
                          {stepTwoForm.formState.errors.admin_password?.message}
                        </p>
                      </div>
                      <div className="flex flex-col gap-2.5">
                        <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                          Confirmer mot de passe *
                        </label>
                        <input
                          className="auth-input"
                          type="password"
                          placeholder="••••••••"
                          aria-invalid={
                            stepTwoForm.formState.errors.admin_password_confirm
                              ? "true"
                              : "false"
                          }
                          {...stepTwoForm.register("admin_password_confirm")}
                        />
                        <p className="auth-error-text min-h-4" role="alert">
                          {
                            stepTwoForm.formState.errors.admin_password_confirm
                              ?.message
                          }
                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                <div className="flex justify-center mt-20 gap-6">
                  <button
                    className="px-10 py-4 rounded-xl border border-white/10 text-white/50 font-bold text-xs tracking-widest uppercase hover:border-white/20 hover:text-white transition-colors"
                    onClick={() => setCurrentStep(1)}
                    type="button"
                    disabled={isSubmitting}
                  >
                    RETOUR
                  </button>
                  <button
                    className="auth-btn-primary px-14 py-4 rounded-xl bg-primary text-midnight font-bold text-xs tracking-widest flex items-center gap-3 uppercase shadow-lg shadow-primary/20"
                    type="submit"
                    disabled={disableContinueStepTwo}
                    aria-busy={isSubmitting}
                  >
                    {isSubmitting ? "CREATION..." : "SUIVANT"}{" "}
                    <span className="material-symbols-outlined text-lg">
                      {isSubmitting ? "autorenew" : "arrow_forward"}
                    </span>
                  </button>
                </div>
              </form>
            </section>
          ) : null}

          {currentStep === 3 ? (
            <section className="step-content active">
              <div className="flex flex-col items-center text-center py-16 px-8 md:px-12 auth-card rounded-3xl max-w-3xl mx-auto">
                {isSubmitting ? (
                  <div
                    className="w-full max-w-lg space-y-6"
                    role="status"
                    aria-live="polite"
                  >
                    <div className="mx-auto w-14 h-14 rounded-full border-2 border-primary/25 border-t-primary animate-spin"></div>
                    <p className="loader-text text-white font-semibold">
                      {loadingMessage}
                    </p>
                    <div className="space-y-3">
                      <div className="h-3 skeleton-line"></div>
                      <div className="h-3 skeleton-line w-4/5 mx-auto"></div>
                      <div className="h-3 skeleton-line w-3/5 mx-auto"></div>
                    </div>
                  </div>
                ) : result.type === "success" ? (
                  <div className="w-full items-center flex flex-col gap-8">
                    <div className="w-32 h-32 bg-primary/10 rounded-full flex items-center justify-center ring-1 ring-primary/30 relative">
                      <span className="material-symbols-outlined text-6xl text-primary">
                        mail
                      </span>
                    </div>
                    <h2 className="text-4xl font-bold text-white tracking-tight">
                      Votre inscription a ete un succes !
                    </h2>
                    <p className="text-white/70 text-lg leading-relaxed max-w-lg">
                      {result.message}
                    </p>
                    <button
                      onClick={resendActivationEmail}
                      className="auth-btn-primary w-full sm:w-auto bg-primary text-midnight font-bold py-5 px-16 rounded-xl text-sm tracking-widest uppercase"
                      type="button"
                      disabled={!canResend}
                    >
                      Renvoyer l'e-mail
                    </button>
                    <a
                      className="text-white/40 hover:text-primary text-xs font-bold tracking-[0.1em] uppercase"
                      href="/login"
                    >
                      Retour a la connexion
                    </a>
                  </div>
                ) : (
                  <div className="w-full items-center flex flex-col gap-8">
                    <div className="w-32 h-32 bg-red-600/10 rounded-full flex items-center justify-center ring-1 ring-red-600/30 relative">
                      <span className="material-symbols-outlined text-6xl text-red-600">
                        error
                      </span>
                    </div>
                    <h2 className="text-4xl font-bold text-white tracking-tight">
                      Une erreur est survenue
                    </h2>
                    <p className="text-white/70 text-lg leading-relaxed max-w-lg whitespace-pre-line">
                      {result.message || "Une erreur est survenue"}
                    </p>
                    <button
                      onClick={() => setCurrentStep(1)}
                      className="w-full sm:w-auto bg-primary text-midnight font-bold py-5 px-16 rounded-xl text-sm tracking-widest uppercase"
                      type="button"
                    >
                      Reessayer
                    </button>
                    <a
                      className="text-white/40 hover:text-primary text-xs font-bold tracking-[0.1em] uppercase"
                      href="/login"
                    >
                      Retour a la connexion
                    </a>
                  </div>
                )}
              </div>
            </section>
          ) : null}
        </div>
      </main>

      <div className="fixed top-0 left-0 w-full h-full pointer-events-none -z-10 overflow-hidden bg-slate-950">
        <div className="absolute top-[-15%] right-[-10%] w-[70%] h-[70%] bg-primary/5 blur-[180px] rounded-full"></div>
        <div className="absolute bottom-[-20%] left-[-15%] w-[60%] h-[60%] bg-white/2 blur-[160px] rounded-full"></div>
      </div>
    </div>
  );
}
