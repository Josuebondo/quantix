export default function ActivationError({ message }) {
  return (
    <section className="auth-card p-8 text-center space-y-5">
      <span className="material-symbols-outlined text-5xl text-red-400">
        error
      </span>
      <h1 className="text-2xl font-semibold text-white">
        Activation impossible
      </h1>
      <p className="text-white/70">{message || "Lien invalide ou expire."}</p>
      <a
        href="/login"
        className="block w-full py-3.5 bg-white/10 text-white font-semibold rounded-xl hover:bg-white/15 transition-colors"
      >
        Retour a la connexion
      </a>
    </section>
  );
}
