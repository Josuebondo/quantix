export default function PageStub({ title, path, status = "stub" }) {
  const badgeClass =
    status === "initialisation"
      ? "bg-secondary/15 text-secondary"
      : "bg-primary/10 text-primary";

  return (
    <main className="flex min-h-[50vh] items-center justify-center p-6 md:p-10">
      <section className="w-full max-w-3xl rounded-2xl border border-outline-variant bg-surface-container-lowest p-8 shadow-sm">
        <div className="flex flex-wrap items-center gap-3">
          <span className="text-xs font-semibold uppercase tracking-[0.18em] text-on-surface-variant">
            Infrastructure React
          </span>
          <span
            className={`rounded-full px-3 py-1 text-xs font-semibold ${badgeClass}`}
          >
            {status}
          </span>
        </div>

        <h1 className="mt-4 text-2xl font-semibold text-on-surface md:text-3xl">
          {title}
        </h1>
        <p className="mt-3 max-w-2xl text-sm leading-6 text-on-surface-variant md:text-base">
          Cette route BMVC est bien enregistrée dans React Router, mais la page
          métier n&apos;a pas encore été migrée conformément au plan de
          transition progressive.
        </p>

        {path ? (
          <div className="mt-6 rounded-xl border border-outline-variant/80 bg-surface-container p-4 text-sm text-on-surface-variant">
            Route: <span className="font-mono text-on-surface">{path}</span>
          </div>
        ) : null}
      </section>
    </main>
  );
}
