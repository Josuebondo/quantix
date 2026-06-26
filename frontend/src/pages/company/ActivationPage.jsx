import { zodResolver } from "@hookform/resolvers/zod";
import { useEffect, useState } from "react";
import { useForm } from "react-hook-form";
import { z } from "zod";
import api from "../../services/api";

const activationSchema = z.object({
  email: z.string().email("Veuillez entrer un email valide"),
});

export default function ActivationPage() {
  const [stage, setStage] = useState("initial");
  const [requestLoading, setRequestLoading] = useState(false);
  const [submitLoading, setSubmitLoading] = useState(false);
  const [errorMessage, setErrorMessage] = useState("");

  const {
    register,
    handleSubmit,
    setFocus,
    formState: { errors, isValid },
  } = useForm({
    resolver: zodResolver(activationSchema),
    mode: "onChange",
    defaultValues: {
      email: "",
    },
  });

  useEffect(() => {
    if (stage === "form") {
      setFocus("email");
    }
  }, [setFocus, stage]);

  const startRequest = async () => {
    setRequestLoading(true);
    await new Promise((resolve) => setTimeout(resolve, 1000));
    setRequestLoading(false);
    setStage("form");
  };

  const onSubmit = async (values) => {
    setSubmitLoading(true);
    setErrorMessage("");

    try {
      await api.post("/company/send-activation", {
        email: values.email,
      });
      setStage("success");
    } catch (error) {
      setErrorMessage(
        error?.message || "Erreur lors de l'envoi du lien d'activation",
      );
    } finally {
      setSubmitLoading(false);
    }
  };

  return (
    <div className="bg-background text-on-background font-body-md min-h-screen flex flex-col items-center justify-between selection:bg-primary/30">
      <div className="fixed inset-0 pointer-events-none z-0 grid-bg"></div>
      <div className="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/5 blur-[120px] rounded-full pointer-events-none"></div>

      <header className="w-full z-10 py-12 px-margin-desktop max-w-container-max-width mx-auto flex justify-center">
        <div className="flex items-center gap-2 group cursor-pointer transition-transform duration-300 hover:scale-105">
          <img
            src="/images/quantix_logo.jpeg"
            alt="Quantix Logo"
            className="w-10 h-10 rounded-full object-cover border-2 border-primary group-hover:border-primary/80 transition-colors duration-300"
          />
          <span className="font-headline-md text-headline-md font-bold text-primary tracking-tight">
            Quatinx
          </span>
        </div>
      </header>

      <main className="relative z-10 flex-1 flex flex-col items-center justify-center w-full px-margin-mobile">
        <div className="max-w-[560px] w-full auth-card p-8 md:p-12 text-center emerald-glow">
          {stage !== "success" ? (
            <div className="fade-transition" id="error-state">
              <div className="mb-8 relative inline-block">
                <div className="absolute inset-0 bg-primary/20 blur-2xl rounded-full scale-150 animate-pulse"></div>
                <div className="relative w-20 h-20 bg-surface-container-high rounded-full flex items-center justify-center border border-white/10 mx-auto">
                  <span
                    className="material-symbols-outlined text-primary text-4xl"
                    style={{ fontVariationSettings: "'FILL' 0, 'wght' 200" }}
                  >
                    link_off
                  </span>
                </div>
              </div>

              <h1 className="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-6 tracking-tight">
                Lien d'activation expire
              </h1>
              <p className="font-body-lg text-body-lg text-on-surface-variant mb-10 leading-relaxed max-w-md mx-auto">
                Oups ! Il semble que votre lien d'activation n'est plus valide
                ou a deja ete utilise. Pour des raisons de securite, ces liens
                expirent apres 24 heures.
              </p>

              <div className="flex flex-col items-center">
                {stage === "initial" ? (
                  <div className="w-full" id="initial-action-container">
                    <button
                      className="auth-btn-primary w-full px-10 py-4 bg-primary text-on-primary-fixed font-semibold rounded-lg transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] active:scale-95 flex items-center justify-center gap-3"
                      onClick={startRequest}
                      disabled={requestLoading}
                      type="button"
                      aria-busy={requestLoading}
                    >
                      <span className={requestLoading ? "hidden" : ""}>
                        Demander un nouveau lien
                      </span>
                      <span
                        className={`material-symbols-outlined animate-spin-custom ${
                          requestLoading ? "" : "hidden"
                        }`}
                      >
                        progress_activity
                      </span>
                    </button>
                  </div>
                ) : (
                  <form
                    className="w-full space-y-6"
                    id="activation-form"
                    onSubmit={handleSubmit(onSubmit)}
                    noValidate
                  >
                    <div className="w-full text-left">
                      <label
                        className="block font-label-sm text-label-sm text-on-surface-variant mb-2 ml-1"
                        htmlFor="admin-email"
                      >
                        Email de l'administrateur
                      </label>
                      <input
                        id="admin-email"
                        type="email"
                        placeholder="admin@entreprise.com"
                        className="auth-input"
                        aria-invalid={errors.email ? "true" : "false"}
                        aria-describedby={
                          errors.email || errorMessage
                            ? "activation-email-error"
                            : undefined
                        }
                        {...register("email")}
                      />
                      <p
                        id="activation-email-error"
                        className="auth-error-text mt-2 min-h-4"
                        role="alert"
                      >
                        {errors.email?.message || errorMessage}
                      </p>
                    </div>

                    <button
                      className="auth-btn-primary w-full px-10 py-4 bg-primary text-on-primary-fixed font-semibold rounded-lg transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] active:scale-95 flex items-center justify-center gap-3"
                      type="submit"
                      disabled={submitLoading || !isValid}
                      aria-busy={submitLoading}
                    >
                      <span className={submitLoading ? "hidden" : ""}>
                        Envoyer le lien d'activation
                      </span>
                      <span
                        className={`material-symbols-outlined animate-spin-custom ${
                          submitLoading ? "" : "hidden"
                        }`}
                      >
                        progress_activity
                      </span>
                    </button>
                  </form>
                )}

                <div className="flex flex-col md:flex-row items-center gap-6 mt-10">
                  <a
                    className="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors flex items-center gap-2"
                    href="#"
                  >
                    <span className="material-symbols-outlined text-[18px]">
                      support_agent
                    </span>
                    Contacter le support
                  </a>
                  <span className="hidden md:block w-1 h-1 bg-surface-variant rounded-full"></span>
                  <a
                    className="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors flex items-center gap-2"
                    href="/login"
                  >
                    <span className="material-symbols-outlined text-[18px]">
                      arrow_back
                    </span>
                    Retour a la connexion
                  </a>
                </div>
              </div>
            </div>
          ) : (
            <div className="fade-transition" id="success-state">
              <div className="mb-8 relative inline-block">
                <div className="absolute inset-0 bg-primary/20 blur-2xl rounded-full scale-150"></div>
                <div className="relative w-20 h-20 bg-surface-container-high rounded-full flex items-center justify-center border border-white/10 mx-auto">
                  <span
                    className="material-symbols-outlined text-primary text-5xl"
                    style={{ fontVariationSettings: "'FILL' 1, 'wght' 400" }}
                  >
                    check_circle
                  </span>
                </div>
              </div>

              <h1 className="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-6 tracking-tight">
                Lien envoye !
              </h1>
              <p className="font-body-lg text-body-lg text-on-surface-variant mb-10 leading-relaxed max-w-md mx-auto">
                Un nouveau lien d'activation a ete envoye a votre adresse email.
                Pensez a verifier vos courriers indesirables si vous ne le
                recevez pas d'ici quelques minutes.
              </p>

              <div className="w-full">
                <a
                  className="block w-full px-10 py-4 bg-primary text-on-primary-fixed text-center font-semibold rounded-lg transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] active:scale-95"
                  href="/login"
                >
                  Retour a la connexion
                </a>
              </div>
            </div>
          )}
        </div>
        <div className="absolute -bottom-24 -right-24 w-64 h-64 bg-primary/5 blur-[80px] rounded-full pointer-events-none"></div>
      </main>

      <footer className="w-full z-10 py-12 border-t border-white/5 bg-surface-container-lowest/50 backdrop-blur-sm mt-12">
        <div className="max-w-container-max-width mx-auto px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-8">
          <div className="text-on-surface-variant font-body-md text-[14px]">
            © 2024 Quatinx Inc. All rights reserved.
          </div>
          <div className="flex items-center gap-8">
            <a
              className="font-body-md text-[14px] text-on-surface-variant hover:text-primary transition-colors"
              href="#"
            >
              Privacy Policy
            </a>
            <a
              className="font-body-md text-[14px] text-on-surface-variant hover:text-primary transition-colors"
              href="#"
            >
              Terms of Service
            </a>
            <a
              className="font-body-md text-[14px] text-on-surface-variant hover:text-primary transition-colors"
              href="#"
            >
              Security
            </a>
            <a
              className="font-body-md text-[14px] text-on-surface-variant hover:text-primary transition-colors"
              href="#"
            >
              Contact
            </a>
          </div>
        </div>
      </footer>
    </div>
  );
}
