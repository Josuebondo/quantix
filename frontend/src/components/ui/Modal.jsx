import { useEffect } from "react";
import { cn } from "../../utils/cn";

const sizeMap = {
  sm: "max-w-md",
  md: "max-w-xl",
  lg: "max-w-3xl",
  xl: "max-w-5xl",
};

export default function Modal({
  open,
  onClose,
  title,
  children,
  size = "md",
  footer,
}) {
  useEffect(() => {
    if (!open) return;

    const onEsc = (event) => {
      if (event.key === "Escape") onClose?.();
    };

    window.addEventListener("keydown", onEsc);
    return () => window.removeEventListener("keydown", onEsc);
  }, [onClose, open]);

  if (!open) return null;

  return (
    <div
      className="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 animate-fade-in"
      onClick={onClose}
    >
      <div
        className={cn(
          "w-full rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-xl animate-modal-in",
          sizeMap[size] ?? sizeMap.md,
        )}
        onClick={(event) => event.stopPropagation()}
      >
        {title ? (
          <h2 className="text-xl font-semibold text-on-surface">{title}</h2>
        ) : null}
        <div className="mt-4">{children}</div>
        {footer ? (
          <footer className="mt-6 flex justify-end gap-2">{footer}</footer>
        ) : null}
      </div>
    </div>
  );
}
