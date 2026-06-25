import { create } from "zustand";
import { persist, createJSONStorage } from "zustand/middleware";

const STORAGE_KEY = "quantix_frontend_store";

export const useAppStore = create(
  persist(
    (set, get) => ({
      theme: "light",
      sidebarOpen: false,
      loadingCount: 0,
      toasts: [],
      auth: {
        token: null,
        user: null,
        isAuthenticated: false,
      },

      setTheme: (theme) => set({ theme }),
      toggleTheme: () =>
        set((state) => ({
          theme: state.theme === "dark" ? "light" : "dark",
        })),

      setSidebarOpen: (isOpen) => set({ sidebarOpen: isOpen }),
      toggleSidebar: () =>
        set((state) => ({
          sidebarOpen: !state.sidebarOpen,
        })),

      beginLoading: () =>
        set((state) => ({
          loadingCount: state.loadingCount + 1,
        })),
      endLoading: () =>
        set((state) => ({
          loadingCount: Math.max(0, state.loadingCount - 1),
        })),
      resetLoading: () => set({ loadingCount: 0 }),

      addToast: (toast) => {
        const id = crypto?.randomUUID?.() ?? String(Date.now());
        const normalized = {
          id,
          title: toast?.title ?? "Information",
          message: toast?.message ?? "",
          type: toast?.type ?? "info",
          duration: toast?.duration ?? 4000,
          actionLabel: toast?.actionLabel ?? null,
          onAction: toast?.onAction ?? null,
        };

        set((state) => ({ toasts: [...state.toasts, normalized] }));
        return id;
      },
      removeToast: (id) =>
        set((state) => ({
          toasts: state.toasts.filter((item) => item.id !== id),
        })),
      clearToasts: () => set({ toasts: [] }),

      setToken: (token) =>
        set((state) => ({
          auth: {
            ...state.auth,
            token,
            isAuthenticated: Boolean(token),
          },
        })),
      setUser: (user) =>
        set((state) => ({
          auth: {
            ...state.auth,
            user,
            isAuthenticated: Boolean(state.auth.token),
          },
        })),
      setAuth: ({ token, user }) =>
        set(() => ({
          auth: {
            token: token ?? null,
            user: user ?? null,
            isAuthenticated: Boolean(token),
          },
        })),
      clearAuth: () =>
        set(() => ({
          auth: {
            token: null,
            user: null,
            isAuthenticated: false,
          },
        })),

      hasRole: (role) => {
        const roles = get().auth.user?.roles ?? [];
        return roles.includes(role);
      },
      hasPermission: (permission) => {
        const user = get().auth.user;
        if (!user) return false;
        const roles = user.roles ?? [];
        if (roles.includes("super_admin")) return true;
        return (user.permissions ?? []).includes(permission);
      },
    }),
    {
      name: STORAGE_KEY,
      storage: createJSONStorage(() => localStorage),
      partialize: (state) => ({
        theme: state.theme,
        auth: state.auth,
      }),
    },
  ),
);
