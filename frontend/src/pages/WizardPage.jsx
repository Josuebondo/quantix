import { useEffect, useMemo, useState } from "react";
import { useLocation, useNavigate, useSearchParams } from "react-router-dom";
import FinishSetup from "../components/company/FinishSetup";
import InviteUsers from "../components/company/InviteUsers";
import WizardLayout from "../components/company/WizardLayout";
import WorkspaceConfiguration from "../components/company/WorkspaceConfiguration";
import { companyService } from "../services/companyService";

const DEFAULT_STATE = {
  workspaceName: "",
  siteName: "",
  categories: [],
  currency: "USD",
  country: "RDC",
  timezone: "UTC+1",
  invitations: [],
};

const STEP_META = {
  "/onboarding/workspace": {
    key: "workspace",
    title: "Configuration du workspace",
    subtitle: "Parametres de base de votre entreprise",
    step: 1,
  },
  "/onboarding/users": {
    key: "users",
    title: "Inviter votre equipe",
    subtitle: "Ajoutez des utilisateurs optionnels",
    step: 2,
  },
  "/onboarding/finish": {
    key: "finish",
    title: "Finaliser",
    subtitle: "Validation et deploiement du workspace",
    step: 3,
  },
};

export default function WizardPage() {
  const navigate = useNavigate();
  const location = useLocation();
  const [searchParams] = useSearchParams();

  const [state, setState] = useState(DEFAULT_STATE);
  const [sessionId, setSessionId] = useState("");
  const [saving, setSaving] = useState(false);
  const [finishing, setFinishing] = useState(false);
  const [error, setError] = useState("");

  const meta = useMemo(() => {
    return STEP_META[location.pathname] || STEP_META["/onboarding/workspace"];
  }, [location.pathname]);

  useEffect(() => {
    const sid =
      searchParams.get("session") ||
      window.sessionStorage.getItem("wizard_session_id") ||
      "";
    if (!sid) {
      navigate("/onboarding", { replace: true });
      return;
    }

    setSessionId(sid);
    window.sessionStorage.setItem("wizard_session_id", sid);

    let cancelled = false;

    const loadWizard = async () => {
      try {
        const response = await companyService.wizardResume(sid);
        const payload = response?.data ?? response;

        if (payload?.success && payload?.data?.state && !cancelled) {
          setState((prev) => ({ ...prev, ...payload.data.state }));
        }
      } catch {
        // Keep default local state if resume fails.
      }
    };

    loadWizard();

    return () => {
      cancelled = true;
    };
  }, [navigate, searchParams]);

  const saveAndGo = async (patch, nextPath, instant = false) => {
    if (!sessionId) return;

    const nextState = { ...state, ...patch };
    setState(nextState);

    if (instant) {
      return;
    }

    try {
      setSaving(true);
      setError("");
      await companyService.wizardNext({
        wizardSessionId: sessionId,
        state: nextState,
        step: meta.step,
        dirtyFields: Object.keys(patch),
      });
      navigate(`${nextPath}?session=${encodeURIComponent(sessionId)}`);
    } catch (err) {
      setError(err?.message || "Sauvegarde impossible");
    } finally {
      setSaving(false);
    }
  };

  const finish = async () => {
    if (!sessionId) return;

    try {
      setFinishing(true);
      setError("");
      const response = await companyService.wizardFinish({
        wizardSessionId: sessionId,
        state,
      });
      const payload = response?.data ?? response;
      const redirectUrl = payload?.data?.redirectUrl || "/app";
      window.location.href = redirectUrl;
    } catch (err) {
      setError(err?.message || "Finalisation impossible");
      setFinishing(false);
    }
  };

  return (
    <WizardLayout
      currentStep={meta.key}
      title={meta.title}
      subtitle={meta.subtitle}
    >
      {meta.key === "workspace" ? (
        <WorkspaceConfiguration
          value={state}
          saving={saving}
          onNext={(patch) => saveAndGo(patch, "/onboarding/users")}
        />
      ) : null}

      {meta.key === "users" ? (
        <InviteUsers
          value={state}
          saving={saving}
          onBack={() =>
            navigate(
              `/onboarding/workspace?session=${encodeURIComponent(sessionId)}`,
            )
          }
          onNext={(patch, instant) => {
            if (instant) {
              setState((prev) => ({ ...prev, ...patch }));
              return;
            }
            saveAndGo(patch, "/onboarding/finish");
          }}
        />
      ) : null}

      {meta.key === "finish" ? (
        <FinishSetup
          state={state}
          error={error}
          finishing={finishing}
          onBack={() =>
            navigate(
              `/onboarding/users?session=${encodeURIComponent(sessionId)}`,
            )
          }
          onFinish={finish}
        />
      ) : null}

      {error && meta.key !== "finish" ? (
        <p className="text-sm text-red-400 mt-4">{error}</p>
      ) : null}
    </WizardLayout>
  );
}
