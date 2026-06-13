/**
 * App Core - Qtix
 * Initialisation et orchestration de l'application
 */

import api from "./api.js";
import auth from "./auth.js";
import state from "./state.js";
import router from "./router.js";
import notification from "./notification.js";
import error from "./error.js";
import page from "../page/page.js";
import loading from "../utils/loading.js";

class Qtix {
  constructor() {
    this.initialized = false;
    this.config = {};
  }

  /**
   * Initialiser Qtix
   */
  async init(config = {}) {
    this.config = {
      apiBaseUrl: config.apiBaseUrl || "/api",
      appContainer: config.appContainer || "app",
      notificationsContainer: config.notificationsContainer || "notifications",
      loadingContainer: config.loadingContainer || "loading",
      autoInit: config.autoInit !== false,
      ...config,
    };

    // Setup API
    api.baseUrl = this.config.apiBaseUrl;

    // Setup error handling
    error.init();
    api.onError((err) => {
      if (err.status === 401) {
        auth.logout();
      } else {
        error.handleError(err);
      }
    });

    // Setup notifications
    notification.init(this.config.notificationsContainer);

    // Setup loading
    loading.init(this.config.loadingContainer);

    // Setup router
    router.init(this.config.appContainer);

    // Setup state
    state.init(this.config.initialState || {});

    // Charger user si authentifié
    if (auth.isLoggedIn()) {
      try {
        await auth.loadUser();
      } catch (err) {
        console.error("Erreur chargement utilisateur:", err);
      }
    }

    this.initialized = true;
    return this;
  }

  /**
   * Naviguer vers une page
   */
  async navigate(path, data = {}) {
    return router.navigate(path, data);
  }

  /**
   * Navigate vers page registrée
   */
  async goToPage(name, params = {}) {
    return page.go(name, params);
  }

  /**
   * Enregistrer une page
   */
  registerPage(name, config) {
    return page.register(name, config);
  }

  /**
   * Enregistrer une route
   */
  registerRoute(path, config) {
    return router.register(path, config);
  }

  // ===== API Methods =====

  /**
   * GET request
   */
  async get(url, options = {}) {
    return api.get(url, options);
  }

  /**
   * POST request
   */
  async post(url, data = {}, options = {}) {
    return api.post(url, data, options);
  }

  /**
   * PUT request
   */
  async put(url, data = {}, options = {}) {
    return api.put(url, data, options);
  }

  /**
   * PATCH request
   */
  async patch(url, data = {}, options = {}) {
    return api.patch(url, data, options);
  }

  /**
   * DELETE request
   */
  async delete(url, options = {}) {
    return api.delete(url, options);
  }

  /**
   * Upload fichier
   */
  async upload(url, formData, options = {}) {
    return api.upload(url, formData, options);
  }

  // ===== Auth Methods =====

  /**
   * Login
   */
  async login(email, password) {
    return auth.login(email, password);
  }

  /**
   * Logout
   */
  logout() {
    return auth.logout();
  }

  /**
   * Register
   */
  async register(data) {
    return auth.register(data);
  }

  /**
   * Get utilisateur courant
   */
  getUser() {
    return auth.getUser();
  }

  /**
   * Check permission
   */
  hasPermission(permission) {
    return auth.hasPermission(permission);
  }

  /**
   * Check rôle
   */
  hasRole(role) {
    return auth.hasRole(role);
  }

  /**
   * Subscribe auth
   */
  subscribeAuth(callback) {
    return auth.subscribe(callback);
  }

  // ===== State Methods =====

  /**
   * Get state
   */
  getState(key) {
    return state.get(key);
  }

  /**
   * Set state
   */
  setState(key, value) {
    return state.set(key, value);
  }

  /**
   * Update state
   */
  updateState(updates) {
    return state.update(updates);
  }

  /**
   * Watch state
   */
  watchState(key, callback) {
    return state.watch(key, callback);
  }

  /**
   * Subscribe state
   */
  subscribeState(callback) {
    return state.subscribe(callback);
  }

  // ===== Notification Methods =====

  /**
   * Show notification
   */
  notify(message, type = "info", options = {}) {
    return notification.show(message, type, options);
  }

  /**
   * Success notification
   */
  success(message, options = {}) {
    return notification.success(message, options);
  }

  /**
   * Error notification
   */
  error(message, options = {}) {
    return notification.error(message, options);
  }

  /**
   * Warning notification
   */
  warning(message, options = {}) {
    return notification.warning(message, options);
  }

  /**
   * Info notification
   */
  info(message, options = {}) {
    return notification.info(message, options);
  }

  // ===== Error Methods =====

  /**
   * On error handler
   */
  onError(callback) {
    return error.onError(callback);
  }

  // ===== Loading Methods =====

  /**
   * init loading
   */
  iniLoading(containerId) {
    return loading.init(containerId);
  }
  /**
   * Start loading
   */
  startLoading() {
    return loading.start();
  }

  /**
   * Stop loading
   */
  stopLoading() {
    return loading.stop();
  }

  /**
   * Wrap async en loading
   */
  async loadAsync(fn) {
    try {
      if (this.loading?.wrap) {
        return await this.loading.wrap(fn);
      }
      return await fn();
    } catch (err) {
      console.error(err);
      throw err;
    }
  }

  // ===== Utility Methods =====

  /**
   * Reload page data
   */
  async reload() {
    return router.reload();
  }

  /**
   * Get config
   */
  getConfig() {
    return this.config;
  }

  /**
   * Check si initialized
   */
  isInitialized() {
    return this.initialized;
  }
}

export default new Qtix();
