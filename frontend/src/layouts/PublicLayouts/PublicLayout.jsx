import { Outlet } from "react-router-dom";
import { useEffect } from "react";
import { useAppStore } from "../../store/useAppStore";
import Header from "./Header";
import Footer from "./Footer";

export default function PublicLayout() {
  const theme = useAppStore((state) => state.theme);

  useEffect(() => {
    document.documentElement.classList.toggle("dark", theme === "dark");
  }, [theme]);

  return (
    <div className="theme-shell flex min-h-screen flex-col bg-background text-on-surface">
      <Header />

      <main className="flex-1">
        <Outlet />
      </main>

      <Footer />
    </div>
  );
}
