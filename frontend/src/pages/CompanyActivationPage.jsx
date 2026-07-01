import { useEffect, useMemo, useState } from "react";
import { useNavigate, useSearchParams } from "react-router-dom";
import ActivationError from "../components/company/ActivationError";
import ActivationLoading from "../components/company/ActivationLoading";
import ActivationSuccess from "../components/company/ActivationSuccess";
import { authService } from "../services/authService";
import { useAppStore } from "../store/useAppStore";

export default function CompanyActivationPage() {
  const [searchParams] = useSearchParams();
  const navigate = useNavigate();
  const setAuth = useAppStore((state) => state.setAuth);

  const token = useMemo(() => searchParams.get("token") || "", [searchParams]);
  // console.log("Activation token:", token);
  const [status, setStatus] = useState("loading");
  const [email, setEmail] = useState("");
  const [error, setError] = useState("");

  useEffect(() => {
    let cancelled = false;

    const activate = async () => {
      if (!token) {
        setStatus("error");
        setError("Token manquant dans l'URL.");
        return;
      }

      try {
        const response = await authService.activateCompany({ token });
        const payload = response?.data ?? response;

        if (!payload?.success) {
          throw new Error(payload?.message || "Activation echouee.");
        }

        const accessToken = payload?.data?.auth?.access_token || null;
        const user = payload?.data?.user || null;

        if (accessToken) {
          setAuth({ token: accessToken, user });
        }

        setEmail(user?.email || "");
        if (!cancelled) setStatus("success");

        setTimeout(() => {
          navigate("/onboarding", { replace: true });
        }, 1400);
      } catch (err) {
        console.error("Activation failed:", err);
        if (!cancelled) {
          setStatus("error");
          setError(err?.message || "Activation impossible.");
        }
      }
    };

    activate();

    return () => {
      cancelled = true;
    };
  }, [navigate, setAuth, token]);

  return (
    <main className="min-h-screen bg-slate-950 bg-pattern text-white px-4 py-16 flex items-center justify-center">
      <div className="w-full max-w-xl">
        {status === "loading" ? <ActivationLoading /> : null}
        {status === "success" ? (
          <ActivationSuccess
            email={email}
            onContinue={() => navigate("/onboarding", { replace: true })}
          />
        ) : null}
        {status === "error" ? <ActivationError message={error} /> : null}
      </div>
    </main>
  );
}
