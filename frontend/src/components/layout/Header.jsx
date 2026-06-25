import quantixLogo from "../../assets/images/quantix_logo.jpeg";
import { useAppStore } from "../../store/useAppStore";

export default function Header() {
  const theme = useAppStore((state) => state.theme);
  const toggleTheme = useAppStore((state) => state.toggleTheme);

  return (
    <header className="sticky top-0 z-40 w-full border-b border-outline-variant bg-surface-container-lowest/95 shadow-sm backdrop-blur">
      <div className="mx-auto flex h-20 max-w-container-max items-center justify-between px-gutter py-unit">
        <div className="flex items-center gap-3">
          <img
            src={quantixLogo}
            alt="Quantix Logo"
            className="h-10 w-auto object-contain"
          />
          <span className="hidden text-sm font-semibold text-on-surface-variant md:inline-block">
            Quantix SaaS
          </span>
        </div>

        <div className="flex items-center gap-2 md:gap-4">
          <button
            type="button"
            onClick={toggleTheme}
            className="flex items-center justify-center rounded-xl p-2 text-on-surface-variant transition-all hover:bg-surface-container"
          >
            <span className="material-symbols-outlined">
              {theme === "dark" ? "light_mode" : "dark_mode"}
            </span>
          </button>
          <button
            type="button"
            className="hidden rounded-xl px-4 py-2 text-sm font-medium text-on-surface-variant transition-all hover:bg-surface-container md:block"
          >
            Login
          </button>
          <button
            type="button"
            className="rounded-xl bg-primary px-6 py-2 text-sm font-medium text-on-primary transition-all hover:opacity-90"
          >
            Start Free Trial
          </button>
        </div>
      </div>
    </header>
  );
}
