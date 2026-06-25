import { Outlet, useLocation } from "react-router-dom";
import Header from "../components/layout/Header";
import Footer from "../components/layout/Footer";
import { useEffect } from "react";
import { useAppStore } from "../store/useAppStore";

const STANDALONE_AUTH_PATHS = new Set([
  "/login",
  "/get-started",
  "/company/register",
  "/company/activate",
  "/welcome",
  "/workspace/setup",
]);

export default function AuthLayout() {
  const theme = useAppStore((state) => state.theme);
  const location = useLocation();
  const isStandalone = STANDALONE_AUTH_PATHS.has(location.pathname);

  useEffect(() => {
    document.documentElement.classList.toggle("dark", theme === "dark");
  }, [theme]);

  if (isStandalone) {
    return <Outlet />;
  }

  return (
    <div className="flex min-h-screen flex-col bg-surface-container-lowest text-on-surface">
      <Header />
      <div className="hero-pattern flex-1 px-4 py-6 md:px-8 md:py-10">
        <Outlet />
      </div>
      <Footer />
    </div>
  );
}
