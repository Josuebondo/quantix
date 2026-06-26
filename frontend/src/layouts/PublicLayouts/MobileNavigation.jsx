import { Link, useLocation } from "react-router-dom";
import { SIDEBAR_ITEMS } from "../../constants/routes";

export default function MobileNavigation() {
  const location = useLocation();

  return (
    <nav className="fixed bottom-0 left-0 right-0 z-50 border-t border-outline-variant bg-surface md:hidden">
      <div className="flex overflow-x-auto">
        {SIDEBAR_ITEMS.map((item) => {
          const active = location.pathname === item.path;

          return (
            <Link
              key={item.path}
              to={item.path}
              className={`min-w-[80px] flex flex-col items-center justify-center py-2 transition-colors ${
                active
                  ? "text-primary"
                  : "text-on-surface-variant hover:text-primary"
              }`}
            >
              <span className="material-symbols-rounded text-2xl">
                {item.icon}
              </span>

              <span className="mt-1 text-[11px] whitespace-nowrap">
                {item.label}
              </span>
            </Link>
          );
        })}
      </div>
    </nav>
  );
}
