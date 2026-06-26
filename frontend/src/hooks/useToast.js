import { useMemo } from "react";
import { useAppStore } from "../store/useAppStore";

export function useToast() {
  const addToast = useAppStore((state) => state.addToast);
  const removeToast = useAppStore((state) => state.removeToast);
  const clearToasts = useAppStore((state) => state.clearToasts);

  return useMemo(
    () => ({
      show: (message, options = {}) =>
        addToast({
          message,
          ...options,
        }),
      success: (message, options = {}) =>
        addToast({
          message,
          type: "success",
          title: options.title ?? "Succès",
          ...options,
        }),
      error: (message, options = {}) =>
        addToast({
          message,
          type: "error",
          title: options.title ?? "Erreur",
          ...options,
        }),
      warning: (message, options = {}) =>
        addToast({
          message,
          type: "warning",
          title: options.title ?? "Attention",
          ...options,
        }),
      info: (message, options = {}) =>
        addToast({
          message,
          type: "info",
          title: options.title ?? "Information",
          ...options,
        }),
      dismiss: removeToast,
      clear: clearToasts,
    }),
    [addToast, clearToasts, removeToast],
  );
}
