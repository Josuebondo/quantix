import { useAuth } from "./useAuth";

export function useAppReady() {
  const { ready } = useAuth();
  return ready;
}
