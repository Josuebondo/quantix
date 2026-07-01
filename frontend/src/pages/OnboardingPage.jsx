import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { companyService } from "../services/companyService";

export default function OnboardingPage() {
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  const startWizard = async () => {
    try {
      setLoading(true);
      setError("");

      const response = await companyService.wizardInit({});
      const payload = response?.data ?? response;

      if (!payload?.success || !payload?.data?.sessionId) {
        throw new Error(payload?.message || "Initialisation impossible");
      }

      const sessionId = payload.data.sessionId;
      navigate(
        `/onboarding/workspace?session=${encodeURIComponent(sessionId)}`,
      );
    } catch (err) {
      if (err?.status === 401) {
        setError(
          "Session non authentifiee. Reouvrez le lien d'activation ou reconnectez-vous.",
        );
      } else {
        setError(err?.message || "Erreur lors du demarrage du wizard");
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <main className="min-h-screen bg-slate-950 bg-pattern text-white px-4 py-16 flex items-center justify-center">
      <section className="auth-card p-8 max-w-2xl w-full space-y-6 text-center">
        <h1 className="text-3xl font-semibold">Bienvenue a bord</h1>
        <p className="text-white/70">
          Lancez la configuration initiale de votre workspace puis finalisez
          votre onboarding.
        </p>

        <button
          type="button"
          onClick={startWizard}
          disabled={loading}
          className="auth-btn-primary w-full py-3.5 bg-primary text-black font-semibold rounded-xl"
        >
          {loading ? "Initialisation..." : "Commencer la configuration"}
        </button>

        {error ? <p className="text-red-400 text-sm">{error}</p> : null}
      </section>
    </main>
  );
}
