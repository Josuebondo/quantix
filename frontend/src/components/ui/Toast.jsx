import { useEffect } from "react";
import { useAppStore } from "../../store/useAppStore";

const tone = {
  success: "bg-emerald-500/15 border-emerald-500/30 text-emerald-700",
  error: "bg-red-500/15 border-red-500/30 text-red-700",
  warning: "bg-yellow-500/15 border-yellow-500/30 text-yellow-700",
  info: "bg-blue-500/15 border-blue-500/30 text-blue-700",
};

const icon = {
  success: "check_circle",
  error: "error",
  warning: "warning",
  info: "info",
};

export default function ToastContainer() {
  const toasts = useAppStore((state) => state.toasts);
  const removeToast = useAppStore((state) => state.removeToast);

  useEffect(() => {
    const timers = toasts
      .filter((toast) => toast.duration > 0)
      .map((toast) =>
        window.setTimeout(() => {
          removeToast(toast.id);
        }, toast.duration),
      );

    return () => timers.forEach((timer) => window.clearTimeout(timer));
  }, [removeToast, toasts]);

  return (
    <div className="fixed bottom-6 right-4 z-[80] space-y-2">
      {toasts.map((toast) => (
        <div
          key={toast.id}
          className={`flex min-w-80 items-start gap-3 rounded-xl border p-4 shadow-lg backdrop-blur-sm ${tone[toast.type] ?? tone.info}`}
        >
          <span className="material-symbols-outlined text-xl">
            {icon[toast.type] ?? icon.info}
          </span>
          <div className="flex-1">
            <p className="text-sm font-semibold">{toast.title}</p>
            <p className="mt-1 text-sm">{toast.message}</p>
          </div>

          {toast.actionLabel && toast.onAction ? (
            <button
              type="button"
              onClick={() => {
                toast.onAction();
                removeToast(toast.id);
              }}
              className="text-xs font-semibold underline"
            >
              {toast.actionLabel}
            </button>
          ) : null}

          <button
            type="button"
            onClick={() => removeToast(toast.id)}
            className="text-on-surface-variant"
          >
            <span className="material-symbols-outlined text-lg">close</span>
          </button>
        </div>
      ))}
    </div>
  );
}
