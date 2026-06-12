/**
 * Router - Qtix
 * Navigation SPA sans page reload
 */

import auth from "./auth.js";

class Router {
  constructor() {
    this.routes = {};
    this.currentRoute = null;
    this.beforeHooks = [];
    this.afterHooks = [];
    this.pageContainer = null;
    this._navigating = false;
  }

  /**
   * Enregistrer une route
   */
  register(path, config) {
    this.routes[path] = {
      component: config.component || null,
      init: config.init || null,
      methods: config.methods || {},
      requireAuth: config.requireAuth !== false,
      roles: config.roles || [],
      ...config,
    };
  }

  /**
   * Navigate vers une route
   */
  async navigate(path, data = {}) {
    if (this._navigating) return;

    this._navigating = true;

    try {
      for (const hook of this.beforeHooks) {
        const shouldContinue = await hook(path);
        if (!shouldContinue) return;
      }

      const route = this.routes[path];

      if (!route) {
        console.warn(`Route non trouvée: ${path}`);
        return;
      }

      // if (route.requireAuth && !auth.isLoggedIn()) {
      //   window.location.href = "/login";
      //   return;
      // }

      if (route.roles?.length > 0) {
        const hasRole = route.roles.some((role) => auth.hasRole(role));

        if (!hasRole) {
          console.warn("Accès refusé");
          return;
        }
      }

      await this.loadComponent(path, route, data);

      this.currentRoute = { path, route, data };

      for (const hook of this.afterHooks) {
        await hook(path, route);
      }
    } finally {
      this._navigating = false;
    }
  }
  /**
   * Charger un composant
   */
  async loadComponent(path, route, data) {
    try {
      this._loading = true;
      // console.log("Loading route:", path, route);
      // return;
      const comp = route.component;

      if (typeof comp === "function") {
        this.pageContainer.innerHTML = await comp(data);
      } else if (
        typeof comp === "object" &&
        typeof comp.template === "function"
      ) {
        this.pageContainer.innerHTML = comp.template(data);
      } else {
        throw new Error("Route invalide: component doit être une fonction");
      }

      // 🔥 important pour Alpine / bindings Qtix
      // if (window.Alpine) {
      //   window.Alpine.initTree(this.pageContainer);
      // }
    } catch (error) {
      console.error("Erreur loadComponent:", error);

      this.pageContainer.innerHTML = `
      <div class="p-6 text-red-500">
        <h2>Erreur de chargement</h2>
        <p>${error.message}</p>
      </div>
    `;
    } finally {
      this._loading = false;
    }
  }

  /**
   * Before navigation hook
   */
  before(callback) {
    this.beforeHooks.push(callback);
  }

  /**
   * After navigation hook
   */
  after(callback) {
    this.afterHooks.push(callback);
  }

  /**
   * Back browser
   */
  back() {
    window.history.back();
  }

  /**
   * Forward browser
   */
  forward() {
    window.history.forward();
  }

  /**
   * Get route courante
   */
  getCurrentRoute() {
    return this.currentRoute;
  }

  /**
   * Recharger les données sans refresh
   */
  async reload() {
    if (!this.currentRoute) return;

    const { path, route, data } = this.currentRoute;
    await this.loadComponent(path, route, data);

    if (window.Alpine) {
      window.Alpine.flushAndStopDeferringMutations?.();
    }
  }

  /**
   * Initialiser le router avec popstate
   */
  init(containerId = "app") {
    this.pageContainer = document.getElementById(containerId);

    // Gérer le back/forward button
    window.addEventListener("popstate", async (event) => {
      if (event.state?.path) {
        await this.navigate(event.state.path, event.state.data || {});
      }
    });
  }

  /**
   * Définir une route par défaut
   */
  setDefaultRoute(path) {
    if (!window.location.pathname || window.location.pathname === "/") {
      this.navigate(path);
    }
  }
}

export default new Router();
