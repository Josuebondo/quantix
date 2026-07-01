export default function ActivationLoading() {
  return (
    <section className="auth-card p-8 text-center space-y-4">
      <span className="material-symbols-outlined text-5xl text-primary animate-spin">
        autorenew
      </span>
      <h1 className="text-2xl font-semibold text-white">Activation en cours</h1>
      <p className="text-white/70">
        Verification du lien et initialisation de votre espace.
      </p>
    </section>
  );
}
