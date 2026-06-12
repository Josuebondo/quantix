export default function registerCompanyRoutes(Qtix) {
  Qtix.registerRoute("/company/teams", {
    component: async () => {
      return await fetch("/company/teams").then((r) => r.text());
    },
    requireAuth: false, // Accessible sans être connecté
  });

  Qtix.registerRoute("/company/users", {
    component: async () => {
      return await fetch("/pages/company/users.html").then((r) => r.text());
    },
    requireAuth: true,
  });
}
