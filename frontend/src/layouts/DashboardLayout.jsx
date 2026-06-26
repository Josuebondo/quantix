import { Outlet } from "react-router-dom";

import { useEffect } from "react";
import { useAppStore } from "../store/useAppStore";

export default function DashboardLayout() {
  const theme = useAppStore((state) => state.theme);

  useEffect(() => {
    document.documentElement.classList.toggle("dark", theme === "dark");
  }, [theme]);

  return (
    <div className="theme-shell min-h-screen bg-background text-on-surface md:flex">
      <div className="flex min-h-screen flex-1 flex-col">
        {/* <Header /> */}
        <main className="flex-1 px-4 py-6 md:px-8 md:py-8">
          <Outlet />
        </main>
      </div>
    </div>
  );
}
