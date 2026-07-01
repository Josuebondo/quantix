import axios from "axios";
import { useAppStore } from "../store/useAppStore";

const DEFAULT_TIMEOUT = Number(import.meta.env.VITE_API_TIMEOUT ?? 15000);

export function normalizeApiError(error) {
  const status = error?.response?.status ?? 0;
  const responseData = error?.response?.data;
  const requestUrl = error?.config?.url || error?.request?.responseURL || "";

  const fallbackMessage =
    status === 404
      ? "Endpoint introuvable (404). Verifiez que le backend BMVC est demarre et que le proxy Vite est configure."
      : "Une erreur API est survenue.";

  const message =
    responseData?.message ||
    responseData?.error ||
    error?.message ||
    fallbackMessage;

  return {
    message,
    status,
    code: responseData?.code ?? error?.code ?? "API_ERROR",
    url: requestUrl,
    details: responseData,
    raw: error,
  };
}

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL ?? "/",
  timeout: DEFAULT_TIMEOUT,
  withCredentials: true,
  headers: {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest",
  },
});

api.interceptors.request.use(
  (config) => {
    const silentLoading =
      Boolean(config?.meta?.silentLoading) ||
      config?.headers?.["X-Silent-Loading"] === "true";

    if (!silentLoading) {
      useAppStore.getState().beginLoading();
    }

    const token = useAppStore.getState().auth?.token;
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }

    const csrf = document
      .querySelector('meta[name="csrf-token"]')
      ?.getAttribute("content");
    if (csrf) {
      config.headers["X-CSRF-Token"] = csrf;
    }

    return config;
  },
  (error) => {
    const silentLoading =
      Boolean(error?.config?.meta?.silentLoading) ||
      error?.config?.headers?.["X-Silent-Loading"] === "true";

    if (!silentLoading) {
      useAppStore.getState().endLoading();
    }
    return Promise.reject(normalizeApiError(error));
  },
);

api.interceptors.response.use(
  (response) => {
    const silentLoading =
      Boolean(response?.config?.meta?.silentLoading) ||
      response?.config?.headers?.["X-Silent-Loading"] === "true";

    if (!silentLoading) {
      useAppStore.getState().endLoading();
    }
    return response;
  },
  async (error) => {
    const silentLoading =
      Boolean(error?.config?.meta?.silentLoading) ||
      error?.config?.headers?.["X-Silent-Loading"] === "true";

    if (!silentLoading) {
      useAppStore.getState().endLoading();
    }
    const normalized = normalizeApiError(error);

    if (
      normalized.status === 401 &&
      !normalized.url.includes("/api/auth/login") &&
      !normalized.url.includes("/api/auth/register")
    ) {
      useAppStore.getState().clearAuth();

      window.dispatchEvent(
        new CustomEvent("quantix:unauthorized", {
          detail: normalized,
        }),
      );
    }

    return Promise.reject(normalized);
  },
);

export async function apiRequest(config) {
  const response = await api.request(config);
  return response.data;
}

export async function apiUpload(url, formData, config = {}) {
  const response = await api.post(url, formData, {
    ...config,
    headers: {
      ...(config.headers ?? {}),
      "Content-Type": "multipart/form-data",
    },
  });

  return response.data;
}

export default api;
