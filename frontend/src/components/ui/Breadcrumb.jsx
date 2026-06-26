import { Link } from "react-router-dom";

export default function Breadcrumb({ items = [] }) {
  if (!items.length) return null;

  return (
    <nav aria-label="Breadcrumb" className="mb-5">
      <ol className="flex flex-wrap items-center gap-2 text-sm text-on-surface-variant">
        {items.map((item, index) => {
          const isLast = index === items.length - 1;

          return (
            <li
              key={`${item.label}-${index}`}
              className="flex items-center gap-2"
            >
              {item.href && !isLast ? (
                <Link to={item.href} className="hover:text-primary">
                  {item.label}
                </Link>
              ) : (
                <span className={isLast ? "font-medium text-on-surface" : ""}>
                  {item.label}
                </span>
              )}

              {!isLast ? <span>/</span> : null}
            </li>
          );
        })}
      </ol>
    </nav>
  );
}
