import {
  createContext,
  useCallback,
  useContext,
  useEffect,
  useMemo,
  useState,
} from "react";
import { authService } from "../services/authService";
import { useAppStore } from "../store/useAppStore";

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const auth = useAppStore((state) => state.auth);
  const setAuth = useAppStore((state) => state.setAuth);
  const setUser = useAppStore((state) => state.setUser);
  const clearAuth = useAppStore((state) => state.clearAuth);
  const addToast = useAppStore((state) => state.addToast);
  const [ready, setReady] = useState(false);

  const loadCurrentUser = useCallback(async () => {
    if (!auth?.token) {
      setReady(true);
      return null;
    }

    try {
      const response = await authService.me();
      const user =
        response?.data?.user ?? response?.user ?? response?.data ?? null;
      setUser(user);
      setReady(true);
      return user;
    } catch (error) {
      clearAuth();
      setReady(true);
      return null;
    }
  }, [auth?.token, clearAuth, setUser]);

  useEffect(() => {
    loadCurrentUser();
  }, [loadCurrentUser]);

  const login = useCallback(
    async (payload) => {
      const response = await authService.login(payload);
      const data = response?.data ?? response;
      const token = data?.data?.tokens?.access_token ?? data?.token ?? null;
      const user = data?.data?.user ?? data?.user ?? null;

      if (!token) {
        throw new Error("Token manquant dans la réponse de connexion.");
      }

      setAuth({ token, user });
      addToast({
        type: "success",
        title: "Connexion",
        message: "Connexion réussie.",
      });

      return data;
    },
    [addToast, setAuth],
  );

  const logout = useCallback(async () => {
    try {
      await authService.logout();
    } catch {
      // Ignore backend logout errors and clear local auth anyway.
    }
    clearAuth();
  }, [clearAuth]);

  const register = useCallback(async (payload) => {
    return authService.register(payload);
  }, []);

  const refresh = useCallback(async () => {
    const response = await authService.refresh();
    const data = response?.data ?? response;
    const token = data?.data?.tokens?.access_token ?? data?.token ?? null;

    if (token) {
      useAppStore.getState().setToken(token);
    }

    return data;
  }, []);

  const value = useMemo(
    () => ({
      ready,
      user: auth.user,
      token: auth.token,
      isAuthenticated: auth.isAuthenticated,
      login,
      logout,
      register,
      refresh,
      loadCurrentUser,
    }),
    [
      auth.isAuthenticated,
      auth.token,
      auth.user,
      loadCurrentUser,
      login,
      logout,
      ready,
      refresh,
      register,
    ],
  );

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
}

export function useAuthContext() {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error("useAuthContext doit être utilisé dans AuthProvider.");
  }
  return context;
}
