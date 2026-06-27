import { useState } from "react";
import Navigation from "./Navigation";
import Logo from "./Logo";
import MobileNavigation from "./MobileNavigation";
import LanguageSwitcher from "./LanguageSwitcher";
import ThemeToggle from "../../components/common/ThemeToggle";
import LoginButton from "../../components/common/LoginButton";
// import GetStartedButton from "../../components/common/GetStartedButton";

export default function Header() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  return (
    <header className="sticky top-0 z-50 border-b border-outline-variant/30 bg-surface/80 backdrop-blur-xl">
      <div className="mx-auto flex h-16 max-w-7xl items-center justify-between px-6">
        {/* Logo */}
        <Logo />

        {/* Navigation Desktop */}
        <div className="hidden lg:block">
          <Navigation />
        </div>

        {/* Actions Desktop */}
        <div className="hidden lg:flex items-center gap-3">
          <ThemeToggle />
          <LanguageSwitcher />
          <LoginButton />
          {/* <GetStartedButton /> */}
        </div>

        {/* Menu Mobile */}
        <div className="lg:hidden flex items-center gap-2">
          <ThemeToggle />
          <button
            type="button"
            onClick={() => setMobileMenuOpen(true)}
            className="rounded-full p-2 text-on-surface transition-colors hover:bg-surface-container-high"
            aria-label="Ouvrir le menu"
          >
            <span className="material-symbols-outlined text-3xl">menu</span>
          </button>
          <MobileNavigation
            open={mobileMenuOpen}
            onClose={() => setMobileMenuOpen(false)}
          />
        </div>
      </div>
    </header>
  );
}
