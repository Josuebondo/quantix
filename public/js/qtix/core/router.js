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

  async navigate(path, data = {}, _internal = false) {
    if (this._navigating) return;

    this._navigating = true;

    try {
      for (const hook of this.beforeHooks) {
        const shouldContinue = await hook(path);
        if (!shouldContinue) return;
      }

      const route = this.routes[path];

      // ⚠️ SAFE fallback (NE PAS rappeler navigate)
      if (!route) {
        console.warn(`Route non trouvée: ${path}`);

        if (path !== "/404") {
          await this.navigate("/404", {}, true);
        }
        return;
      }

      if (route.requireAuth && !auth.isLoggedIn()) {
        window.location.href = "/login";
        return;
      }

      if (route.roles.length > 0) {
        const hasRole = route.roles.some((role) => auth.hasRole(role));
        if (!hasRole) {
          if (path !== "/403") {
            await this.navigate("/403", {}, true);
          }
          return;
        }
      }

      if (route.component) {
        await this.loadComponent(path, route, data);
      }

      // ⚠️ pushState seulement si pas interne
      if (!_internal) {
        window.history.pushState({ path, data }, "", path);
      }

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
      if (!this.pageContainer) {
        this.pageContainer = document.getElementById("app");
      }

      if (!this.pageContainer) {
        console.error("Page container #app non trouvé");
        return;
      }

      // Si c'est une fonction
      if (typeof route.component === "function") {
        const html = await route.component(data);
        this.pageContainer.innerHTML = html;
      } else {
        // Si c'est une URL
        const response = await fetch(route.component);
        const html = await response.text();
        this.pageContainer.innerHTML = html;
      }

      // Exécuter init
      if (route.init && typeof route.init === "function") {
        await route.init.call({
          ...route.methods,
          data,
          navigate: (p) => this.navigate(p),
        });
      }

      // Déclencher Alpine
      if (window.Alpine) {
        window.Alpine?.flushAndStopDeferringMutations?.();
      }
    } catch (error) {
      console.error("Erreur chargement composant:", error);
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
