import Navigation from "./Navigation";
import Logo from "./Logo";
import MobileNavigation from "./MobileNavigation";
import LanguageSwitcher from "./LanguageSwitcher";
import ThemeToggle from "../../components/common/ThemeToggle";
// import LoginButton from "../../components/common/LoginButton";
// import GetStartedButton from "../../components/common/GetStartedButton";

export default function Header() {
  return (
    <header className="sticky top-0 z-50 border-b bg-white">
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
          {/* <LoginButton />
          <GetStartedButton /> */}
        </div>

        {/* Menu Mobile */}
        <div className="lg:hidden">
          <MobileNavigation />
        </div>
      </div>
    </header>
  );
}
