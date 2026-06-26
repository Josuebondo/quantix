// src/router/index.jsx

import { Navigate, Route, Routes } from "react-router-dom";

import PublicLayout from "../layouts/PublicLayouts";
import AuthLayout from "../layouts/AuthLayout";
import DashboardLayout from "../layouts/DashboardLayout";

import PageStub from "../components/common/PageStub";

import { APP_ROUTES } from "../constants/routes";

import { useAuth } from "../hooks/useAuth";

function LoadingPage({ route }) {
  return (
    <PageStub title="Chargement..." path={route.path} status="initialisation" />
  );
}

function StubPage({ route }) {
  return <PageStub title={route.title} path={route.path} status="stub" />;
}

function ProtectedRoute({ route }) {
  const { ready, isAuthenticated, hasRole, hasPermission } = useAuth();

  if (!ready) {
    return <LoadingPage route={route} />;
  }

  if (route.requireAuth && !isAuthenticated) {
    return <Navigate replace to="/login" />;
  }

  if (route.roles?.length) {
    const allowed = route.roles.some((role) => hasRole(role));

    if (!allowed) {
      return <Navigate replace to="/403" />;
    }
  }

  if (route.permissions?.length) {
    const allowed = route.permissions.every((permission) =>
      hasPermission(permission),
    );

    if (!allowed) {
      return <Navigate replace to="/403" />;
    }
  }

  const Component = route.component;

  if (!Component) {
    return <StubPage route={route} />;
  }

  return <Component />;
}

function PublicRoute({ route }) {
  const Component = route.component;

  if (!Component) {
    return <StubPage route={route} />;
  }

  return <Component />;
}

export default function AppRouter() {
  const publicRoutes = APP_ROUTES.filter((route) => route.layout === "public");

  const authRoutes = APP_ROUTES.filter((route) => route.layout === "auth");

  const dashboardRoutes = APP_ROUTES.filter(
    (route) => route.layout === "dashboard",
  );

  return (
    <Routes>
      {/* PUBLIC */}
      <Route element={<PublicLayout />}>
        {publicRoutes.map((route) => (
          <Route
            key={route.path}
            path={route.path}
            element={<PublicRoute route={route} />}
          />
        ))}
      </Route>

      {/* AUTH */}
      <Route element={<AuthLayout />}>
        {authRoutes.map((route) => (
          <Route
            key={route.path}
            path={route.path}
            element={<PublicRoute route={route} />}
          />
        ))}
      </Route>

      {/* DASHBOARD */}
      <Route element={<DashboardLayout />}>
        {dashboardRoutes.map((route) => (
          <Route
            key={route.path}
            path={route.path}
            element={<ProtectedRoute route={route} />}
          />
        ))}
      </Route>

      {/* 404 */}
      <Route path="*" element={<Navigate replace to="/404" />} />
    </Routes>
  );
}
