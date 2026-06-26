import { useMemo } from "react";
import { useAuth } from "./useAuth";

export function usePermissions() {
  const { user } = useAuth();

  return useMemo(() => {
    const roles = user?.roles ?? [];
    const permissions = user?.permissions ?? [];

    return {
      permissions,
      hasPermission: (permission) => {
        if (roles.includes("super_admin")) return true;
        return permissions.includes(permission);
      },
      hasAnyPermission: (requiredPermissions = []) =>
        requiredPermissions.some((permission) =>
          permissions.includes(permission),
        ),
      hasAllPermissions: (requiredPermissions = []) =>
        requiredPermissions.every((permission) =>
          permissions.includes(permission),
        ),
    };
  }, [user?.permissions, user?.roles]);
}
