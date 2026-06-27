import { useEffect } from "react";
import { useAppStore } from "../../store/useAppStore";

export default function ThemeToggle() {
  const theme = useAppStore((state) => state.theme);
  const toggleTheme = useAppStore((state) => state.toggleTheme);

  useEffect(() => {
    document.documentElement.classList.toggle("dark", theme === "dark");
  }, [theme]);

  return (
    <button
      type="button"
      onClick={toggleTheme}
      className="inline-flex items-center justify-center rounded-full p-2 transition-colors hover:bg-surface-container-high"
      id="theme-toggle"
      title="Changer de thème"
      aria-label="Changer de thème"
    >
      <span className="material-symbols-outlined text-[24px] leading-none">
        {theme === "dark" ? "light_mode" : "dark_mode"}
      </span>
    </button>
  );
}
