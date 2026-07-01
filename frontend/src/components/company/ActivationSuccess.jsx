export default function ActivationSuccess({ email, onContinue }) {
  return (
    <section className="auth-card p-8 text-center space-y-5">
      <span className="material-symbols-outlined text-5xl text-emerald-400">
        check_circle
      </span>
      <h1 className="text-2xl font-semibold text-white">Compte active</h1>
      <p className="text-white/70">
        {email
          ? `Le compte ${email} est maintenant actif.`
          : "Votre compte est maintenant actif."}
      </p>
      <button
        type="button"
        onClick={onContinue}
        className="auth-btn-primary w-full py-3.5 bg-primary text-black font-semibold rounded-xl"
      >
        Continuer vers l'onboarding
      </button>
    </section>
  );
}
