import Button from "./Button";

export default function Pagination({ page = 1, totalPages = 1, onPageChange }) {
  const canPrev = page > 1;
  const canNext = page < totalPages;

  return (
    <div className="flex items-center justify-between gap-4 rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3">
      <p className="text-sm text-on-surface-variant">
        Page <span className="font-semibold text-on-surface">{page}</span> sur{" "}
        <span className="font-semibold text-on-surface">{totalPages}</span>
      </p>

      <div className="flex items-center gap-2">
        <Button
          variant="secondary"
          size="sm"
          disabled={!canPrev}
          onClick={() => onPageChange?.(page - 1)}
        >
          Précédent
        </Button>
        <Button
          variant="secondary"
          size="sm"
          disabled={!canNext}
          onClick={() => onPageChange?.(page + 1)}
        >
          Suivant
        </Button>
      </div>
    </div>
  );
}
