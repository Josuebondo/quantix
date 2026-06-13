export default function registerWebRoutes(Qtix) {
  Qtix.registerRoute("/Accueil", {
    component: async () => {
      return await fetch("/spa/home").then((r) => r.text());
    },
    requireAuth: false, // Accessible sans être connecté
  });

  Qtix.registerRoute("/login", {
    component: async () => {
      return "<h1>Login</h1>";
    },
  });
  Qtix.registerRoute("/app", {
    component: async () => {
      return await fetch("/app").then((r) => r.text());
    },
    requireAuth: false, // Nécessite une authentification
  });
  Qtix.registerRoute("/dashboard", {
    component: async () => {
      return "<h1>Dashboard</h1>";
    },
    requireAuth: false, // Accessible sans être connecté
  });
  Qtix.registerRoute("/company/teams", {
    component: async () => {
      return await fetch("/company/teams").then((r) => r.text());
    },
    requireAuth: false, // Accessible sans être connecté
  });

  Qtix.registerRoute("/products", {
    component: async () => {
      return await fetch("/spa/products").then((r) => r.text());
    },
  });
}
