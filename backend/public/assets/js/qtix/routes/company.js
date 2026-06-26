export default function registerCompanyRoutes(Qtix) {
  Qtix.registerRoute("/entrepots", {
    component: async () => {
      return await fetch("/api/company/entrepots").then((r) => r.text());
    },
    requireAuth: false, // Accessible sans être connecté
  });
  Qtix.registerRoute("/mouvements", {
    component: async () => {
      return await fetch("/api/company/mouvements").then((r) => r.text());
    },
    requireAuth: false, // Accessible sans être connecté
  });
  Qtix.registerRoute("/teams", {
    component: async () => {
      return await fetch("/api/company/teams").then((r) => r.text());
    },
    requireAuth: true, // Accessible sans être connecté
    controller: "/assets/js/qtix/page/users/index.js",
  });
  Qtix.registerRoute("/dashboard", {
    component: async () => {
      return "<h1>Dashboard</h1>";
    },
    requireAuth: false, // Accessible sans être connecté
  });
}
