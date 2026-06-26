import { useState } from "react";
import { companyService } from "../../services/companyService";

export default function WelcomePage() {
  const [loading, setLoading] = useState(false);
  const [errorMessage, setErrorMessage] = useState("");

  const initializeWizard = async () => {
    try {
      setErrorMessage("");
      setLoading(true);

      const response = await companyService.wizardInit({});
      const payload = response?.data ?? response;

      if (!payload?.success || !payload?.data?.sessionId) {
        throw new Error(payload?.message || "Failed to initialize wizard");
      }

      const sessionId = payload.data.sessionId;
      window.location.href = `/workspace/setup?session=${encodeURIComponent(sessionId)}`;
    } catch (error) {
      setErrorMessage(
        error?.message || "Erreur lors de l'initialisation du wizard",
      );
      setLoading(false);
    }
  };

  return (
    <div className="auth-shell font-body-md overflow-x-hidden text-[#e0e3e5] min-h-screen">
      <div className="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div className="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary/10 rounded-full blur-[120px]"></div>
        <div className="absolute top-[60%] -right-[5%] w-[30%] h-[30%] bg-primary/5 rounded-full blur-[100px]"></div>
      </div>

      <header className="w-full h-20 flex justify-center items-center px-margin-desktop sticky top-0 z-50">
        <div className="w-full max-w-container-max-width flex justify-between items-center">
          <div className="flex items-center gap-3">
            <img
              alt="Quatinx Logo"
              className="h-10 w-auto"
              src="/images/quantix_logo.jpeg"
            />
            <span className="font-headline-md text-headline-md text-on-surface tracking-tight">
              Quatinx
            </span>
          </div>
          <div className="flex items-center gap-4">
            <button
              className="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors"
              type="button"
            >
              help
            </button>
            <button
              className="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors"
              type="button"
            >
              settings
            </button>
          </div>
        </div>
      </header>

      <main className="min-h-screen flex flex-col items-center justify-center px-4 py-12 relative">
        <div className="max-w-[720px] w-full text-center space-y-12">
          <section className="space-y-6">
            <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-surface-container-high border border-outline-variant text-primary font-label-sm uppercase tracking-widest mb-4">
              <span className="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
              Systeme Pret
            </div>
            <h1 className="font-display-lg text-display-lg text-on-surface leading-none">
              Bienvenue a bord !
            </h1>
            <p className="font-body-lg text-body-lg text-on-surface-variant max-w-[540px] mx-auto">
              Commencons par configurer votre espace de travail{" "}
              <span className="text-on-surface font-semibold">Quatinx</span>{" "}
              pour l'adapter a vos besoins operationnels specifiques.
            </p>
          </section>

          <div
            className="space-y-4 text-left"
            role="list"
            aria-label="Etapes de configuration"
          >
            <div className="glass-card p-6 rounded-xl flex items-center justify-between step-transition group cursor-pointer border border-white/5 bg-[rgba(29,32,34,0.4)] backdrop-blur-[12px]">
              <div className="flex items-center gap-5">
                <div className="w-12 h-12 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                  <span className="material-symbols-outlined text-2xl">
                    work
                  </span>
                </div>
                <div>
                  <h3 className="font-headline-md text-body-lg text-on-surface">
                    Workspace
                  </h3>
                  <p className="text-label-sm text-on-surface-variant">
                    Devise, langue et parametres regionaux.
                  </p>
                </div>
              </div>
              <div className="flex items-center gap-3">
                <span className="text-label-sm text-on-surface-variant bg-surface-container px-3 py-1 rounded-full border border-outline-variant group-hover:border-primary/50 transition-colors">
                  Pret a configurer
                </span>
                <span className="material-symbols-outlined text-on-surface-variant group-hover:text-primary">
                  chevron_right
                </span>
              </div>
            </div>

            <div className="glass-card p-6 rounded-xl flex items-center justify-between step-transition group cursor-pointer border border-white/5 bg-[rgba(29,32,34,0.4)] backdrop-blur-[12px]">
              <div className="flex items-center gap-5">
                <div className="w-12 h-12 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                  <span className="material-symbols-outlined text-2xl">
                    language
                  </span>
                </div>
                <div>
                  <h3 className="font-headline-md text-body-lg text-on-surface">
                    Sites
                  </h3>
                  <p className="text-label-sm text-on-surface-variant">
                    Creez votre premier Entrepot ou Point de Vente.
                  </p>
                </div>
              </div>
              <div className="flex items-center gap-3">
                <span className="text-label-sm text-on-surface-variant bg-surface-container px-3 py-1 rounded-full border border-outline-variant group-hover:border-primary/50 transition-colors">
                  Pret a configurer
                </span>
                <span className="material-symbols-outlined text-on-surface-variant group-hover:text-primary">
                  chevron_right
                </span>
              </div>
            </div>

            <div className="glass-card p-6 rounded-xl flex items-center justify-between step-transition group cursor-pointer border border-white/5 bg-[rgba(29,32,34,0.4)] backdrop-blur-[12px]">
              <div className="flex items-center gap-5">
                <div className="w-12 h-12 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                  <span className="material-symbols-outlined text-2xl">
                    category
                  </span>
                </div>
                <div>
                  <h3 className="font-headline-md text-body-lg text-on-surface">
                    Structure d'Inventaire
                  </h3>
                  <p className="text-label-sm text-on-surface-variant">
                    Categories et produits initiaux.
                  </p>
                </div>
              </div>
              <div className="flex items-center gap-3">
                <span className="text-label-sm text-on-surface-variant bg-surface-container px-3 py-1 rounded-full border border-outline-variant group-hover:border-primary/50 transition-colors">
                  Pret a configurer
                </span>
                <span className="material-symbols-outlined text-on-surface-variant group-hover:text-primary">
                  chevron_right
                </span>
              </div>
            </div>

            <div className="glass-card p-6 rounded-xl flex items-center justify-between step-transition group cursor-pointer border border-white/5 bg-[rgba(29,32,34,0.4)] backdrop-blur-[12px]">
              <div className="flex items-center gap-5">
                <div className="w-12 h-12 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                  <span className="material-symbols-outlined text-2xl">
                    group
                  </span>
                </div>
                <div>
                  <h3 className="font-headline-md text-body-lg text-on-surface">
                    Equipe
                  </h3>
                  <p className="text-label-sm text-on-surface-variant">
                    Roles et invitations collaborateurs.
                  </p>
                </div>
              </div>
              <div className="flex items-center gap-3">
                <span className="text-label-sm text-on-surface-variant bg-surface-container px-3 py-1 rounded-full border border-outline-variant group-hover:border-primary/50 transition-colors">
                  Pret a configurer
                </span>
                <span className="material-symbols-outlined text-on-surface-variant group-hover:text-primary">
                  chevron_right
                </span>
              </div>
            </div>
          </div>

          <div className="pt-8 space-y-6">
            {!loading ? (
              <button
                className="auth-btn-primary w-full py-5 px-8 rounded-xl bg-primary text-on-primary font-bold text-body-lg emerald-glow hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-3"
                onClick={initializeWizard}
                type="button"
              >
                Commencer la configuration
                <span className="material-symbols-outlined font-bold">
                  arrow_forward
                </span>
              </button>
            ) : (
              <button
                className="auth-btn-primary w-full py-5 px-8 rounded-xl bg-primary text-on-primary font-bold text-body-lg emerald-glow transition-all flex items-center justify-center gap-3"
                type="button"
                disabled
                aria-busy="true"
              >
                Initialisation du wizard...
                <span className="material-symbols-outlined animate-spin">
                  autorenew
                </span>
              </button>
            )}

            {loading ? (
              <div className="space-y-2" aria-hidden="true">
                <div className="h-3 skeleton-line"></div>
                <div className="h-3 skeleton-line w-4/5 mx-auto"></div>
              </div>
            ) : null}

            {errorMessage ? (
              <div>
                <div
                  className="rounded-xl border border-error/10 p-8 text-center space-y-4 bg-[rgba(29,32,34,0.4)] backdrop-blur-[12px]"
                  role="alert"
                >
                  <div className="flex justify-center">
                    <span className="material-symbols-outlined text-5xl text-error">
                      error
                    </span>
                  </div>
                  <p className="text-on-surface-variant">{errorMessage}</p>
                </div>
              </div>
            ) : null}

            <div className="flex items-center justify-center gap-2 text-on-surface-variant">
              <span className="material-symbols-outlined text-lg">
                schedule
              </span>
              <span className="font-label-sm">
                Installation estimee : 4 minutes
              </span>
            </div>
          </div>
        </div>
      </main>

      <footer className="w-full py-8 border-t border-outline-variant/30 mt-auto">
        <div className="max-w-container-max-width mx-auto px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-4 text-on-surface-variant font-label-sm">
          <p>© 2024 Quatinx Enterprise. Tous droits reserves.</p>
          <div className="flex gap-8">
            <a className="hover:text-primary transition-colors" href="#">
              Confidentialite
            </a>
            <a className="hover:text-primary transition-colors" href="#">
              Support Technique
            </a>
            <a className="hover:text-primary transition-colors" href="#">
              Documentation
            </a>
          </div>
        </div>
      </footer>
    </div>
  );
}
