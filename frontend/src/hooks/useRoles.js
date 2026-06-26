import { useMemo } from "react";
import { useAuth } from "./useAuth";

export function useRoles() {
  const { user } = useAuth();

  return useMemo(() => {
    const roles = user?.roles ?? [];

    return {
      roles,
      hasRole: (role) => roles.includes(role),
      hasAnyRole: (candidateRoles = []) =>
        candidateRoles.some((role) => roles.includes(role)),
      hasAllRoles: (candidateRoles = []) =>
        candidateRoles.every((role) => roles.includes(role)),
    };
  }, [user?.roles]);
}
