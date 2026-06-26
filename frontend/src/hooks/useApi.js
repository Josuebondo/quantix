import { useMemo } from "react";
import api, { apiRequest, apiUpload } from "../services/api";
import { useToast } from "./useToast";

export function useApi() {
  const toast = useToast();

  return useMemo(
    () => ({
      client: api,
      request: apiRequest,
      upload: apiUpload,
      get: async (url, config) => (await api.get(url, config)).data,
      post: async (url, data, config) =>
        (await api.post(url, data, config)).data,
      put: async (url, data, config) => (await api.put(url, data, config)).data,
      patch: async (url, data, config) =>
        (await api.patch(url, data, config)).data,
      delete: async (url, config) => (await api.delete(url, config)).data,
      withToast: async (promiseFactory, messages = {}) => {
        try {
          const result = await promiseFactory();
          if (messages.success) {
            toast.success(messages.success);
          }
          return result;
        } catch (error) {
          toast.error(messages.error ?? error.message);
          throw error;
        }
      },
    }),
    [toast],
  );
}
