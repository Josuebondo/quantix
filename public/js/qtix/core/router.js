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
    this.currentController = null;
    this.historyStack = [];
    this.historyIndex = -1;
  }

  /**
   * Enregistrer une route
   */
  register(path, config) {
    this.routes[path] = {
      component: config.component || null,
      controller: config.controller || null,
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

      const cleanPath = this.normalize(path);

      const route = this.routes[cleanPath];

      if (!route) {
        // console.warn(`Route non trouvée: ${cleanPath}`);

        setTimeout(() => {
          this.navigate("/404");
        }, 0);

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
      // si on avance normalement (pas back/forward)
      this.historyStack = this.historyStack.slice(0, this.historyIndex + 1);

      this.historyStack.push({
        path: cleanPath,
        data,
      });

      this.historyIndex++;
      await this.loadComponent(cleanPath, route, data);

      this.currentRoute = { cleanPath, route, data };

      for (const hook of this.afterHooks) {
        await hook(cleanPath, route);
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

      // Détruire la page précédente
      if (
        this.currentController &&
        typeof this.currentController.destroy === "function"
      ) {
        await this.currentController.destroy();
      }

      const comp = route.component;

      if (typeof comp === "function") {
        this.pageContainer.innerHTML = await comp(data);
      } else if (
        typeof comp === "object" &&
        typeof comp.template === "function"
      ) {
        this.pageContainer.innerHTML = comp.template(data);
      } else {
        throw new Error("Route invalide");
      }

      // Alpine
      if (window.Alpine) {
        window.Alpine.initTree(this.pageContainer);
      }

      // Charger le contrôleur frontend
      if (route.controller) {
        const controller = await import(route.controller);

        this.currentController = controller;

        if (typeof controller.init === "function") {
          await controller.init(data);
        }
      }
    } catch (error) {
      console.error(error);
    } finally {
      this._loading = false;
    }
  }
  normalize(path) {
    if (!path) return "/";

    // retirer hash si SPA hash mode
    path = path.replace(/^#/, "");

    // garantir slash initial
    if (!path.startsWith("/")) {
      path = "/" + path;
    }

    // retirer slash final sauf root
    if (path.length > 1 && path.endsWith("/")) {
      path = path.slice(0, -1);
    }

    return path;
  }
  goTo404() {
    return this.navigate("/404");
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
    if (this.historyIndex > 0) {
      this.historyIndex--;
      const previous = this.historyStack[this.historyIndex];

      this.navigate(previous.path, previous.data);
    }
  }

  /**
   * Forward browser
   */
  forward() {
    if (this.historyIndex < this.historyStack.length - 1) {
      this.historyIndex++;
      const next = this.historyStack[this.historyIndex];

      this.navigate(next.path, next.data);
    }
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

    const { cleanPath, route, data } = this.currentRoute;
    await this.loadComponent(cleanPath, route, data);

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
