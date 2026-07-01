import { zodResolver } from "@hookform/resolvers/zod";
import { useMemo, useState } from "react";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { useAuth } from "../../hooks/useAuth";
import { useLoading } from "../../hooks/useLoading";

const loginSchema = z.object({
  email: z.string().min(1, "Veuillez remplir tous les champs"),
  password: z.string().min(1, "Veuillez remplir tous les champs"),
});

export default function LoginPage() {
  const { login } = useAuth();
  const { isLoading } = useLoading();
  const [showPassword, setShowPassword] = useState(false);
  const [pendingRedirect, setPendingRedirect] = useState(false);
  const [message, setMessage] = useState({ type: "", text: "" });

  const {
    register,
    handleSubmit,
    setFocus,
    formState: { errors, isValid },
  } = useForm({
    resolver: zodResolver(loginSchema),
    mode: "onChange",
    defaultValues: {
      email: "",
      password: "",
    },
  });

  const isDisabled = useMemo(
    () => isLoading || pendingRedirect || !isValid,
    [isLoading, pendingRedirect, isValid],
  );

  const onSubmit = async (values) => {
    setMessage({ type: "", text: "" });

    try {
      const data = await login({
        email: values.email.trim(),
        password: values.password,
      });
      console.log("Login response:", data);
      if (data?.success) {
        setPendingRedirect(true);
        setMessage({
          type: "success",
          text: "Connexion réussie, redirection...",
        });

        await new Promise((resolve) => setTimeout(resolve, 2700));
        window.location.href = data?.redirectUrl || "/app";
        return;
      }

      setMessage({
        type: "error",
        text: data?.message || "Identifiants incorrects",
      });
    } catch (error) {
      console.error("Login error:", error);
      setMessage({
        type: "error",
        text: error?.message || "Impossible de contacter le serveur",
      });
    }
  };

  return (
    <div className="bg-slate-950 font-display min-h-screen flex items-center justify-center p-4 bg-pattern">
      <div className="w-full max-w-md">
        <div className="flex items-center justify-center gap-3 mb-10">
          <div className="flex items-center gap-2">
            <img
              alt="Quantix Logo"
              className="h-20 w-auto object-contain dark:brightness-200"
              style={{ borderRadius: "100%" }}
              src="/src/assets/images/quantix_logo.jpeg"
            />
          </div>
          <div className="flex flex-col">
            <span className="text-3xl font-bold text-white tracking-tight leading-none">
              QUANTIX
            </span>
            <span className="text-[10px] uppercase tracking-[0.2em] text-white/40 font-semibold mt-1">
              Enterprise Solution
            </span>
          </div>
        </div>

        <div className="auth-card p-6 md:p-8">
          <div className="mb-8">
            <h2 className="text-xl font-semibold text-white">Bienvenue</h2>
            <p className="text-white/50 text-sm mt-1">
              Connectez-vous pour accéder à votre espace
            </p>
          </div>

          <form
            className="space-y-5"
            onSubmit={handleSubmit(onSubmit)}
            noValidate
          >
            <div>
              <label
                className="block text-sm font-medium text-white/70 mb-2"
                htmlFor="email"
              >
                E-mail ou Utilisateur
              </label>
              <div className="relative group">
                <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                  <span className="material-symbols-outlined text-white/30 text-[20px] group-focus-within:text-primary transition-colors">
                    person
                  </span>
                </div>
                <input
                  id="email"
                  type="text"
                  placeholder="nom@entreprise.com"
                  autoComplete="username"
                  autoFocus
                  aria-label="E-mail ou utilisateur"
                  aria-invalid={errors.email ? "true" : "false"}
                  aria-describedby={
                    errors.email ? "login-email-error" : undefined
                  }
                  className="auth-input block w-full auth-input-icon"
                  {...register("email")}
                  onKeyDown={(event) => {
                    if (event.key === "Enter" && !errors.email) {
                      event.preventDefault();
                      setFocus("password");
                    }
                  }}
                />
              </div>
              {errors.email ? (
                <p
                  id="login-email-error"
                  className="auth-error-text mt-2"
                  role="alert"
                >
                  {errors.email.message}
                </p>
              ) : null}
            </div>

            <div>
              <label
                className="block text-sm font-medium text-white/70 mb-2"
                htmlFor="password"
              >
                Mot de passe
              </label>
              <div className="relative group">
                <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                  <span className="material-symbols-outlined text-white/30 text-[20px] group-focus-within:text-primary transition-colors">
                    lock
                  </span>
                </div>
                <input
                  id="password"
                  type={showPassword ? "text" : "password"}
                  autoComplete="current-password"
                  aria-label="Mot de passe"
                  aria-invalid={errors.password ? "true" : "false"}
                  aria-describedby={
                    errors.password ? "login-password-error" : undefined
                  }
                  placeholder="••••••••"
                  className="auth-input block w-full auth-input-icon pr-12"
                  {...register("password")}
                />
                <button
                  type="button"
                  aria-label={
                    showPassword
                      ? "Masquer le mot de passe"
                      : "Afficher le mot de passe"
                  }
                  className={`absolute inset-y-0 right-0 pr-3.5 flex items-center transition-colors duration-200 ${
                    showPassword
                      ? "text-primary"
                      : "text-white/30 hover:text-primary"
                  }`}
                  onClick={() => setShowPassword((prev) => !prev)}
                >
                  <span className="material-symbols-outlined text-[20px]">
                    {showPassword ? "visibility_off" : "visibility"}
                  </span>
                </button>
              </div>
              {errors.password ? (
                <p
                  id="login-password-error"
                  className="auth-error-text mt-2"
                  role="alert"
                >
                  {errors.password.message}
                </p>
              ) : null}
            </div>

            <div className="flex items-center justify-between text-sm">
              <label className="flex items-center cursor-pointer group">
                <input
                  className="rounded-md border-white/10 bg-white/5 text-primary focus:ring-primary/50 h-4 w-4 transition-all"
                  type="checkbox"
                />
                <span className="ml-2 text-white/50 group-hover:text-white/80 transition-colors">
                  Se souvenir de moi
                </span>
              </label>
              <a
                className="text-primary/90 hover:text-primary transition-colors font-medium"
                href="#"
              >
                Mot de passe oublié ?
              </a>
            </div>

            <button
              id="loginBtn"
              type="submit"
              disabled={isDisabled}
              aria-busy={isLoading || pendingRedirect}
              className="auth-btn-primary w-full py-3.5 h-14 bg-primary text-black shadow-lg shadow-primary/10 flex items-center justify-center gap-2 group"
            >
              <span>
                {isLoading || pendingRedirect ? "Connexion..." : "Se connecter"}
              </span>
              <span
                className={`material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform ${
                  isLoading || pendingRedirect ? "spin" : ""
                }`}
              >
                {isLoading || pendingRedirect ? "autorenew" : "login"}
              </span>
            </button>

            <p
              className={`auth-live ${
                message.type === "success" ? "text-green-500" : "text-red-500"
              }`}
              role="status"
              aria-live="polite"
            >
              {message.text}
            </p>
          </form>

          <div className="relative my-8">
            <div className="absolute inset-0 flex items-center">
              <div className="w-full border-t border-white/10"></div>
            </div>
            <div className="relative flex justify-center text-xs uppercase">
              <span className="bg-slate-900/50 backdrop-blur px-4 text-white/30 tracking-widest font-semibold">
                Ou continuer avec
              </span>
            </div>
          </div>

          <div className="space-y-3">
            <button
              className="w-full flex items-center justify-center gap-3 py-3 px-4 bg-gradient-to-r from-white/5 to-white/[0.02] border border-white/10 rounded-xl hover:border-white/20 hover:bg-white/10 hover:shadow-[0_0_20px_rgba(255,255,255,0.05)] transition-all duration-200 group"
              title="Connexion avec Google"
              type="button"
            >
              <svg
                className="w-5 h-5"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                  fill="#4285F4"
                />
                <path
                  d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                  fill="#34A853"
                />
                <path
                  d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                  fill="#FBBC05"
                />
                <path
                  d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                  fill="#EA4335"
                />
              </svg>
              <span className="text-white/90 font-medium">Google</span>
            </button>

            <button
              className="w-full flex items-center justify-center gap-3 py-3 px-4 bg-gradient-to-r from-white/5 to-white/[0.02] border border-white/10 rounded-xl hover:border-white/20 hover:bg-white/10 hover:shadow-[0_0_20px_rgba(255,255,255,0.05)] transition-all duration-200 group"
              title="Connexion avec Microsoft"
              type="button"
            >
              <svg
                className="w-5 h-5"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <rect x="1" y="1" width="9" height="9" fill="#F25022" />
                <rect x="14" y="1" width="9" height="9" fill="#7FBA00" />
                <rect x="1" y="14" width="9" height="9" fill="#00A4EF" />
                <rect x="14" y="14" width="9" height="9" fill="#FFB900" />
              </svg>
              <span className="text-white/90 font-medium">Microsoft</span>
            </button>

            <button
              className="w-full flex items-center justify-center gap-3 py-3 px-4 bg-gradient-to-r from-white/5 to-white/[0.02] border border-white/10 rounded-xl hover:border-[#1877F2]/30 hover:bg-[#1877F2]/5 hover:shadow-[0_0_20px_rgba(24,119,242,0.1)] transition-all duration-200 group"
              title="Connexion avec Facebook"
              type="button"
            >
              <svg
                className="w-5 h-5 group-hover:fill-[#1877F2] fill-white/80 transition-colors"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
              </svg>
              <span className="text-white/90 font-medium">Facebook</span>
            </button>
          </div>

          <div className="mt-8 pt-6 border-t border-white/5 text-center">
            <p className="text-white/40 text-sm">
              Pas encore de compte ?
              <a
                className="text-white/80 hover:text-primary transition-colors font-semibold ml-1"
                href="/company/register"
              >
                Créer un profil
              </a>
            </p>
          </div>
        </div>

        <div className="mt-10 flex justify-center gap-8">
          <div className="flex items-center gap-2.5">
            <span className="flex h-1.5 w-1.5 rounded-full bg-primary shadow-[0_0_8px_rgba(19,236,128,0.6)]"></span>
            <span className="text-[10px] uppercase tracking-widest text-white/30 font-bold">
              Système en ligne
            </span>
          </div>
          <div className="flex items-center gap-2.5">
            <span className="material-symbols-outlined text-[14px] text-white/30">
              verified_user
            </span>
            <span className="text-[10px] uppercase tracking-widest text-white/30 font-bold">
              Sécurité renforcée
            </span>
          </div>
        </div>
      </div>
    </div>
  );
}
