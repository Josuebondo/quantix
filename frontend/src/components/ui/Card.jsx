import { cn } from "../../utils/cn";

export default function Card({
  className,
  title,
  subtitle,
  children,
  actions,
}) {
  return (
    <section
      className={cn(
        "rounded-2xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm",
        className,
      )}
    >
      {(title || subtitle || actions) && (
        <header className="mb-4 flex items-start justify-between gap-4">
          <div>
            {title ? (
              <h3 className="text-lg font-semibold text-on-surface">{title}</h3>
            ) : null}
            {subtitle ? (
              <p className="mt-1 text-sm text-on-surface-variant">{subtitle}</p>
            ) : null}
          </div>
          {actions ? <div>{actions}</div> : null}
        </header>
      )}
      {children}
    </section>
  );
}
