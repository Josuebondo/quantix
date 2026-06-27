import { Link, NavLink } from "react-router-dom";
import { PUBLIC_NAV_LINKS } from "./Navigation";

export default function MobileNavigation({ open, onClose }) {
  return (
    <div
      className={`fixed inset-0 z-[60] md:hidden ${open ? "pointer-events-auto" : "pointer-events-none"}`}
      aria-hidden={!open}
    >
      <button
        type="button"
        aria-label="Fermer le menu"
        onClick={onClose}
        className={`absolute inset-0 bg-on-surface/60 backdrop-blur-sm transition-opacity duration-300 ${
          open ? "opacity-100" : "opacity-0"
        }`}
      />

      <aside
        className={`absolute right-0 top-0 flex h-full w-[86%] max-w-sm flex-col border-l border-outline-variant bg-background shadow-2xl transition-transform duration-300 ease-out ${
          open ? "translate-x-0" : "translate-x-full"
        }`}
      >
        <div className="flex items-center justify-between border-b border-outline-variant/40 px-gutter py-5">
          <Link to="/" onClick={onClose} className="flex items-center gap-2">
            <span className="rounded-xl bg-primary px-3 py-2 text-sm font-bold text-on-primary">
              Q
            </span>
            <div>
              <div className="font-headline-md text-lg font-bold text-on-surface">
                Quantix
              </div>
              <div className="text-xs text-on-surface-variant">
                Smart Inventory
              </div>
            </div>
          </Link>

          <button
            type="button"
            onClick={onClose}
            className="rounded-full p-2 text-on-surface-variant transition-colors hover:bg-surface-container-high"
            aria-label="Fermer"
          >
            <span className="material-symbols-outlined text-3xl">close</span>
          </button>
        </div>

        <div className="flex flex-1 flex-col gap-6 px-gutter py-8">
          <div className="flex flex-wrap gap-2">
            <span className="rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-primary">
              IA-Propulsé
            </span>
            <span className="rounded-full border border-outline-variant/30 bg-surface-container-highest px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">
              SaaS Platform
            </span>
          </div>

          <nav className="flex flex-col gap-4 text-lg font-semibold">
            {PUBLIC_NAV_LINKS.map((item) => (
              <NavLink
                key={item.path}
                to={item.path}
                onClick={onClose}
                className={({ isActive }) =>
                  `rounded-xl px-4 py-3 transition-colors ${
                    isActive
                      ? "bg-primary/10 text-primary"
                      : "text-on-surface hover:bg-surface-container-high hover:text-primary"
                  }`
                }
              >
                {item.label}
              </NavLink>
            ))}
          </nav>

          <div className="mt-auto space-y-4 border-t border-outline-variant/40 pt-6">
            <Link
              to="/login"
              onClick={onClose}
              className="block rounded-xl border border-outline-variant/30 px-4 py-3 text-center font-medium text-on-surface transition-colors hover:bg-surface-container-highest"
            >
              Connexion
            </Link>
            <Link
              to="/company/register"
              onClick={onClose}
              className="block rounded-xl bg-primary px-4 py-4 text-center font-bold text-on-primary transition-all hover:brightness-110"
            >
              Commencer gratuitement
            </Link>
          </div>
        </div>
      </aside>
    </div>
  );
}
