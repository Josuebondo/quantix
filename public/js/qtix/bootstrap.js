import Alpine from "https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/module.esm.js";
import Qtix from "/js/qtix/qtix.js";
import { setupAlpineDirectives } from "/js/qtix/alpine.js";

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

  Alpine.start();
})();
