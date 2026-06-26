import { useMemo } from "react";
import { useAppStore } from "../store/useAppStore";

export function useLoading() {
  const loadingCount = useAppStore((state) => state.loadingCount);
  const beginLoading = useAppStore((state) => state.beginLoading);
  const endLoading = useAppStore((state) => state.endLoading);
  const resetLoading = useAppStore((state) => state.resetLoading);

  return useMemo(
    () => ({
      loadingCount,
      isLoading: loadingCount > 0,
      beginLoading,
      endLoading,
      resetLoading,
      wrap: async (fn) => {
        beginLoading();
        try {
          return await fn();
        } finally {
          endLoading();
        }
      },
    }),
    [beginLoading, endLoading, loadingCount, resetLoading],
  );
}
