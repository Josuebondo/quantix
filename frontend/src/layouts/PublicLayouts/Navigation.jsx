import { NavLink } from "react-router-dom";

export const PUBLIC_NAV_LINKS = [
  { label: "Accueil", path: "/" },
  { label: "Fonctionnalités", path: "/features" },
  { label: "Tarifs", path: "/pricing" },
  { label: "Documentation", path: "/docs" },
  { label: "Blog", path: "/blog" },
  { label: "Contact", path: "/contact" },
];

export default function Navigation() {
  return (
    <nav className="flex items-center gap-8">
      {PUBLIC_NAV_LINKS.map((item) => (
        <NavLink
          key={item.path}
          to={item.path}
          className={({ isActive }) =>
            `transition font-medium ${
              isActive
                ? "text-primary"
                : "text-on-surface-variant hover:text-primary"
            }`
          }
        >
          {item.label}
        </NavLink>
      ))}
    </nav>
  );
}
