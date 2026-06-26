import { NavLink } from "react-router-dom";
import { SIDEBAR_ITEMS } from "../../constants/routes";
import quantixLogo from "../../assets/images/quantix_logo.jpeg";

export default function Sidebar() {
  return (
    <aside className="hidden w-20 shrink-0 flex-col items-center border-r border-border-dark bg-slate-900 py-6 md:flex">
      <div className="mb-8 flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl shadow-lg shadow-primary/20">
        <img
          src={quantixLogo}
          alt="Quantix"
          className="h-full w-full object-cover"
        />
      </div>

      <nav className="flex flex-1 flex-col gap-4">
        {SIDEBAR_ITEMS.map((item) => (
          <NavLink
            key={item.path}
            to={item.path}
            title={item.label}
            className={({ isActive }) =>
              `group relative flex h-12 w-12 items-center justify-center rounded-xl transition-all ${
                isActive
                  ? "bg-primary/15 text-primary"
                  : "text-slate-500 hover:bg-slate-800 hover:text-primary"
              }`
            }
          >
            <span className="material-symbols-outlined">{item.icon}</span>
            <span className="pointer-events-none absolute left-14 whitespace-nowrap rounded bg-slate-700 px-2 py-1 text-[10px] text-white opacity-0 transition-opacity group-hover:opacity-100">
              {item.label}
            </span>
          </NavLink>
        ))}
      </nav>

      <NavLink
        to="/logout"
        title="Déconnexion"
        className="group relative mt-4 flex h-12 w-12 items-center justify-center rounded-xl text-slate-500 transition-all hover:bg-slate-800 hover:text-primary"
      >
        <span className="material-symbols-outlined">logout</span>
        <span className="pointer-events-none absolute left-14 whitespace-nowrap rounded bg-slate-700 px-2 py-1 text-[10px] text-white opacity-0 transition-opacity group-hover:opacity-100">
          Déconnexion
        </span>
      </NavLink>
    </aside>
  );
}
