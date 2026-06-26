import { zodResolver } from "@hookform/resolvers/zod";
import { useEffect, useMemo, useState } from "react";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { useAppStore } from "../../store/useAppStore";
import { authService } from "../../services/authService";

const registerSchema = z
  .object({
    company_name: z.string().min(1, "Le nom de l'entreprise est requis"),
    company_email: z.union([
      z.literal(""),
      z.string().email("L'email entreprise est invalide"),
    ]),
    company_phone: z.string().optional(),
    admin_first_name: z.string().min(1, "Le prénom est requis"),
    admin_last_name: z.string().min(1, "Le nom est requis"),
    admin_email: z.string().email("L'email professionnel est invalide"),
    admin_password: z
      .string()
      .min(8, "Le mot de passe doit contenir au moins 8 caractères"),
    admin_password_confirm: z
      .string()
      .min(1, "Veuillez confirmer le mot de passe"),
  })
  .refine((data) => data.admin_password === data.admin_password_confirm, {
    message: "Les mots de passe ne correspondent pas",
    path: ["admin_password_confirm"],
  });

export default function RegisterCompanyPage() {
  const setAuth = useAppStore((state) => state.setAuth);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [serverErrors, setServerErrors] = useState({});
  const [showSuccess, setShowSuccess] = useState(false);

  const {
    register,
    handleSubmit,
    setError,
    formState: { errors, isValid },
  } = useForm({
    resolver: zodResolver(registerSchema),
    mode: "onChange",
    defaultValues: {
      company_name: "",
      company_email: "",
      company_phone: "",
      admin_first_name: "",
      admin_last_name: "",
      admin_email: "",
      admin_password: "",
      admin_password_confirm: "",
    },
  });

  const readServerFieldError = (field) => {
    const value = serverErrors[field];
    if (!value) return "";
    if (Array.isArray(value)) return value.join(" ");
    return String(value);
  };

  const onSubmit = async (values) => {
    setServerErrors({});
    setShowSuccess(false);
    setIsSubmitting(true);

    const payload = {
      company_name: values.company_name,
      company_email: values.company_email,
      company_phone: values.company_phone,
      admin_first_name: values.admin_first_name,
      admin_last_name: values.admin_last_name,
      admin_email: values.admin_email,
      admin_password: values.admin_password,
    };

    try {
      const response = await authService.registerCompany(payload);
      const data = response?.data ?? response;

      if (!data?.success) {
        const errorsFromApi = data?.errors || {};
        setServerErrors(errorsFromApi);

        Object.entries(errorsFromApi).forEach(([field, value]) => {
          const message = Array.isArray(value)
            ? value.join(" ")
            : String(value);
          setError(field, { type: "server", message });
        });

        if (!Object.keys(errorsFromApi).length && data?.message) {
          setServerErrors({ _global: data.message });
        }
        return;
      }

      const token = data?.data?.tokens?.access_token ?? null;
      const user = data?.data?.user ?? null;
      if (token) {
        setAuth({ token, user });
      }

      setShowSuccess(true);
    } catch (error) {
      setServerErrors({
        _global:
          error?.message ||
          "Une erreur est survenue lors de la creation du compte. Veuillez reessayer.",
      });
    } finally {
      setIsSubmitting(false);
    }
  };

  useEffect(() => {
    if (!showSuccess) return;
    const timer = setTimeout(() => {
      window.location.href = "/dashboard";
    }, 2000);
    return () => clearTimeout(timer);
  }, [showSuccess]);

  const isDisabled = useMemo(
    () => isSubmitting || !isValid,
    [isSubmitting, isValid],
  );

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
              QUANTIX
            </span>
            <span className="text-[8px] uppercase tracking-[0.2em] text-white/40 font-semibold">
              Enterprise Solution
            </span>
          </div>
        </div>
        <div className="flex items-center gap-6">
          <a
            href="/login"
            className="text-on-surface-variant text-xs font-semibold tracking-widest uppercase opacity-70 hover:opacity-100 transition-opacity"
          >
            Se connecter
          </a>
          <button
            className="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 transition-all duration-300 group"
            type="button"
          >
            <span className="material-symbols-outlined text-sm group-hover:scale-110 transition-transform">
              help
            </span>
          </button>
        </div>
      </nav>

      <main className="flex-grow flex flex-col items-center justify-start pt-32 pb-32 px-6 w-full relative z-10">
        <div className="w-full max-w-2xl mx-auto">
          <div className="text-center mb-12">
            <h1 className="text-4xl font-bold text-white mb-4 font-headline-md tracking-tight">
              Creez votre compte entreprise
            </h1>
            <p className="text-white/50 font-body-md max-w-lg mx-auto">
              Inscrivez votre entreprise et commencez a utiliser Quantix des
              aujourd'hui
            </p>
          </div>

          <div className="auth-card p-8 md:p-12">
            {showSuccess ? (
              <div
                className="bg-[rgba(19,236,128,0.1)] border border-[rgba(19,236,128,0.3)] text-[#13ec80] p-4 rounded-xl mb-4 text-sm"
                role="status"
                aria-live="polite"
              >
                <div className="flex items-center gap-3">
                  <span className="material-symbols-outlined text-lg">
                    check_circle
                  </span>
                  <span>Inscription reussie! Redirection en cours...</span>
                </div>
              </div>
            ) : null}

            {serverErrors._global ? (
              <div
                className="mb-4 rounded-xl border border-red-400/25 bg-red-400/10 px-4 py-3 text-sm text-red-200"
                role="alert"
              >
                {serverErrors._global}
              </div>
            ) : null}

            <form
              className="space-y-8"
              onSubmit={handleSubmit(onSubmit)}
              noValidate
            >
              <div>
                <h3 className="text-sm font-bold text-primary uppercase tracking-[0.2em] mb-6">
                  Informations Entreprise
                </h3>

                <div className="space-y-5">
                  <div className="flex flex-col gap-2.5">
                    <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                      Nom de l'entreprise *
                    </label>
                    <input
                      type="text"
                      placeholder="Entreprise SARL"
                      className="auth-input text-sm font-body-md"
                      autoFocus
                      aria-invalid={errors.company_name ? "true" : "false"}
                      {...register("company_name")}
                    />
                    <p className="auth-error-text min-h-5" role="alert">
                      {errors.company_name?.message ||
                        readServerFieldError("company_name")}
                    </p>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div className="flex flex-col gap-2.5">
                      <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                        Email de l'entreprise
                      </label>
                      <input
                        type="email"
                        placeholder="contact@entreprise.com"
                        className="auth-input text-sm font-body-md"
                        aria-invalid={errors.company_email ? "true" : "false"}
                        {...register("company_email")}
                      />
                      <p className="auth-error-text min-h-5" role="alert">
                        {errors.company_email?.message ||
                          readServerFieldError("company_email")}
                      </p>
                    </div>

                    <div className="flex flex-col gap-2.5">
                      <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                        Telephone
                      </label>
                      <input
                        type="tel"
                        placeholder="+33 1 23 45 67 89"
                        className="auth-input text-sm font-body-md"
                        {...register("company_phone")}
                      />
                      <p className="auth-error-text min-h-5" role="alert">
                        {readServerFieldError("company_phone")}
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div className="pt-6 border-t border-white/5">
                <h3 className="text-sm font-bold text-primary uppercase tracking-[0.2em] mb-6">
                  Administrateur
                </h3>

                <div className="space-y-5">
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div className="flex flex-col gap-2.5">
                      <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                        Prenom *
                      </label>
                      <input
                        type="text"
                        placeholder="Jean"
                        className="auth-input text-sm font-body-md"
                        aria-invalid={
                          errors.admin_first_name ? "true" : "false"
                        }
                        {...register("admin_first_name")}
                      />
                      <p className="auth-error-text min-h-5" role="alert">
                        {errors.admin_first_name?.message ||
                          readServerFieldError("admin_first_name")}
                      </p>
                    </div>

                    <div className="flex flex-col gap-2.5">
                      <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                        Nom *
                      </label>
                      <input
                        type="text"
                        placeholder="Dupont"
                        className="auth-input text-sm font-body-md"
                        aria-invalid={errors.admin_last_name ? "true" : "false"}
                        {...register("admin_last_name")}
                      />
                      <p className="auth-error-text min-h-5" role="alert">
                        {errors.admin_last_name?.message ||
                          readServerFieldError("admin_last_name")}
                      </p>
                    </div>
                  </div>

                  <div className="flex flex-col gap-2.5">
                    <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                      Email professionnel *
                    </label>
                    <input
                      type="email"
                      placeholder="jean.dupont@entreprise.com"
                      className="auth-input text-sm font-body-md"
                      aria-invalid={errors.admin_email ? "true" : "false"}
                      {...register("admin_email")}
                    />
                    <p className="auth-error-text min-h-5" role="alert">
                      {errors.admin_email?.message ||
                        readServerFieldError("admin_email")}
                    </p>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div className="flex flex-col gap-2.5">
                      <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                        Mot de passe *
                      </label>
                      <input
                        type="password"
                        placeholder="••••••••"
                        className="auth-input text-sm font-body-md"
                        aria-invalid={errors.admin_password ? "true" : "false"}
                        {...register("admin_password")}
                      />
                      <div className="text-[10px] text-white/40 mt-1">
                        Min. 8 caracteres
                      </div>
                      <p className="auth-error-text min-h-5" role="alert">
                        {errors.admin_password?.message ||
                          readServerFieldError("admin_password")}
                      </p>
                    </div>

                    <div className="flex flex-col gap-2.5">
                      <label className="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">
                        Confirmez le mot de passe *
                      </label>
                      <input
                        type="password"
                        placeholder="••••••••"
                        className="auth-input text-sm font-body-md"
                        aria-invalid={
                          errors.admin_password_confirm ? "true" : "false"
                        }
                        {...register("admin_password_confirm")}
                      />
                      <p className="auth-error-text min-h-5" role="alert">
                        {errors.admin_password_confirm?.message}
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div className="pt-6">
                <button
                  type="submit"
                  disabled={isDisabled}
                  aria-busy={isSubmitting}
                  className="auth-btn-primary w-full bg-primary text-midnight py-5 rounded-xl flex items-center justify-center gap-3 text-sm tracking-widest uppercase shadow-lg shadow-primary/10"
                >
                  <span>
                    {isSubmitting ? "CREATION..." : "CREER MON COMPTE"}
                  </span>
                  <span
                    className={`material-symbols-outlined text-lg ${
                      isSubmitting ? "spin" : "hidden"
                    }`}
                  >
                    autorenew
                  </span>
                </button>
              </div>

              <div className="text-center text-[10px] text-white/40 leading-relaxed">
                <p>
                  En creant un compte, vous acceptez nos{" "}
                  <a href="#" className="text-primary hover:underline">
                    conditions d'utilisation
                  </a>{" "}
                  et notre{" "}
                  <a href="#" className="text-primary hover:underline">
                    politique de confidentialite
                  </a>
                  .
                </p>
              </div>
            </form>

            <div className="mt-10 pt-8 border-t border-white/5 text-center">
              <p className="text-white/60 text-sm">
                Vous avez deja un compte?{" "}
                <a
                  href="/login"
                  className="text-primary font-bold hover:underline"
                >
                  Se connecter
                </a>
              </p>
            </div>
          </div>
        </div>
      </main>

      <div className="fixed top-0 left-0 w-full h-full pointer-events-none -z-10 overflow-hidden bg-slate-950">
        <div className="absolute top-[-15%] right-[-10%] w-[70%] h-[70%] bg-primary/5 blur-[180px] rounded-full"></div>
        <div className="absolute bottom-[-20%] left-[-15%] w-[60%] h-[60%] bg-white/2 blur-[160px] rounded-full"></div>
        <div
          className="absolute inset-0 opacity-[0.03]"
          style={{
            backgroundImage:
              "radial-gradient(circle at 50% 50%, #13ec80 0%, transparent 50%)",
            backgroundSize: "cover",
          }}
        ></div>
      </div>
    </div>
  );
}
