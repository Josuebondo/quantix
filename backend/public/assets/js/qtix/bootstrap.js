import Alpine from "/assets/js/vendor/alpine.js";
import Qtix from "/assets/js/qtix/qtix.js";
import { setupAlpineDirectives } from "/assets/js/qtix/alpine.js";
import registerWebRoutes from "./routes/web.js";
import registerCompanyRoutes from "./routes/company.js";

window.Alpine = Alpine;
window.Qtix = Qtix;

(async () => {
  await Qtix.init({
    apiBaseUrl: "/api",
    appContainer: "app",
    notificationsContainer: "notifications",
    loadingContainer: "loading", // ⚠️ assure-toi que ça existe dans HTML
    initialState: {
      user: null,
      company: null,
      theme: localStorage.getItem("theme") || "light",
    },
  });

  Qtix.onError((error) => {
    console.error("Global error:", error);

    if (error.status === 401) {
      return;
      window.location.href = "/login";
    }
  });

  const user = Qtix.getUser();
  if (user) {
    Qtix.setState("user", user);
  }

  Qtix.subscribeAuth((auth) => {
    Qtix.setState("user", auth.isAuthenticated ? auth.user : null);
  });

  registerWebRoutes(Qtix);
  registerCompanyRoutes(Qtix);

  Alpine.start();
})();
