import Button from "./Button";

export default function EmptyState({
  title = "Aucun élément",
  description = "Aucune donnée n'est disponible pour le moment.",
  actionLabel,
  onAction,
}) {
  return (
    <div className="rounded-2xl border border-dashed border-outline-variant bg-surface-container-low px-6 py-10 text-center">
      <span className="material-symbols-outlined text-4xl text-on-surface-variant">
        inbox
      </span>
      <h3 className="mt-3 text-lg font-semibold text-on-surface">{title}</h3>
      <p className="mx-auto mt-2 max-w-md text-sm text-on-surface-variant">
        {description}
      </p>
      {actionLabel ? (
        <Button className="mt-5" onClick={onAction}>
          {actionLabel}
        </Button>
      ) : null}
    </div>
  );
}
