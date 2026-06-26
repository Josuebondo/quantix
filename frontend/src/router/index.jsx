import { Navigate, Route, Routes } from "react-router-dom";
import AuthLayout from "../layouts/AuthLayout";
import DashboardLayout from "../layouts/DashboardLayout";
import PageStub from "../components/common/PageStub";
import { APP_ROUTES } from "../constants/routes";
import { useAuth } from "../hooks/useAuth";
import LoginPage from "../pages/auth/LoginPage";
import RegisterCompanyPage from "../pages/auth/RegisterCompanyPage";
import SigninPage from "../pages/auth/SigninPage";
import ActivationPage from "../pages/company/ActivationPage";
import WelcomePage from "../pages/company/WelcomePage";
import WorkspaceSetupPage from "../pages/company/WorkspaceSetupPage";

function ProtectedStubRoute({ route }) {
  const { isAuthenticated, ready } = useAuth();

  if (!ready) {
    return (
      <PageStub title="Chargement" path={route.path} status="initialisation" />
    );
  }

  if (route.requireAuth && !isAuthenticated) {
    console.log(
      "isAuthenticated:",
      isAuthenticated,
      "route.requireAuth:",
      route.requireAuth,
      "route.path:",
      route.path,
    );
    return <Navigate to="/login" replace />;

    return;
  }

  return <PageStub title={route.title} path={route.path} status="stub" />;
}

function AuthRouteElement({ route }) {
  if (route.path === "/login") {
    return <LoginPage />;
  }

  if (route.path === "/company/register") {
    return <RegisterCompanyPage />;
  }

  if (route.path === "/get-started") {
    return <SigninPage />;
  }

  if (route.path === "/company/activate") {
    return <ActivationPage />;
  }

  if (route.path === "/welcome") {
    return <WelcomePage />;
  }

  if (route.path === "/workspace/setup") {
    return <WorkspaceSetupPage />;
  }

  return <PageStub title={route.title} path={route.path} status="stub" />;
}

export default function AppRouter() {
  const authRoutes = APP_ROUTES.filter((route) => route.layout === "auth");
  const dashboardRoutes = APP_ROUTES.filter(
    (route) => route.layout === "dashboard",
  );

  return (
    <Routes>
      <Route element={<AuthLayout />}>
        {authRoutes.map((route) => (
          <Route
            key={route.path}
            path={route.path}
            element={<AuthRouteElement route={route} />}
          />
        ))}
      </Route>

      <Route element={<DashboardLayout />}>
        {dashboardRoutes.map((route) => (
          <Route
            key={route.path}
            path={route.path}
            element={<ProtectedStubRoute route={route} />}
          />
        ))}
      </Route>

      <Route path="*" element={<Navigate to="/404" replace />} />
    </Routes>
  );
}
