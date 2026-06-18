/**
 * Auth System - Qtix
 * Gère login, logout, token, route protection
 */

import api from "./api.js";

class AuthManager {
  constructor() {
    this.user = null;
    this.isAuthenticated = false;
    this.token = localStorage.getItem("auth_token");
    this.listeners = [];

    // Charger l'utilisateur si token existe
    if (this.token) {
      this.isAuthenticated = true;
      this.loadUser();
    }
  }

  /**
   * Charge les infos utilisateur
   */
  async loadUser() {
    try {
      const response = await api.get("/auth/me", { headers: api.getHeaders() });
      this.user = response.user;
      this.notifyListeners();
      // console.log("Utilisateur chargé:", response);
    } catch (error) {
      console.error("Erreur chargement utilisateur:", error);
      this.logout();
    }
  }

  /**
   * Login
   */
  async login(email, password) {
    try {
      const response = await api.post("/auth/login", { email, password });
      // return response;
      this.token = response.data.tokens.access_token;

      this.user = response.user || response.data.user;
      this.isAuthenticated = true;
      this.redirectUrl = response.data.redirect_url || "/app";

      api.setToken(this.token);
      localStorage.setItem("auth_token", this.token);
      localStorage.setItem("user", JSON.stringify(this.user));

      this.notifyListeners();
      return {
        success: true,
        user: this.user,
        redirectUrl: this.redirectUrl,
        data: response.data,
      };
    } catch (error) {
      console.error("Login error:", error);
      return { success: false, error: error.message };
    }
  }

  /**
   * Logout
   */
  logout() {
    this.token = null;
    this.user = null;
    this.isAuthenticated = false;

    api.setToken(null);
    localStorage.removeItem("auth_token");
    localStorage.removeItem("user");

    this.notifyListeners();

    // Rediriger vers login
    window.location.href = "/logout";
  }

  /**
   * Register
   */
  async register(data) {
    try {
      const response = await api.post("/auth/register", data);

      this.token = response.token;
      this.user = response.user;
      this.isAuthenticated = true;

      api.setToken(this.token);
      localStorage.setItem("auth_token", this.token);

      this.notifyListeners();
      return { success: true, user: this.user };
    } catch (error) {
      return { success: false, error: error.message };
    }
  }

  /**
   * Refresh token
   */
  async refreshToken() {
    try {
      const response = await api.post("/auth/refresh");
      this.token = response.token;
      api.setToken(this.token);
      localStorage.setItem("auth_token", this.token);
      return true;
    } catch (error) {
      this.logout();
      return false;
    }
  }

  /**
   * Update profil utilisateur
   */
  async updateProfile(data) {
    try {
      const response = await api.put("/auth/profile", data);
      this.user = response.data || response;
      localStorage.setItem("user", JSON.stringify(this.user));
      this.notifyListeners();
      return { success: true, user: this.user };
    } catch (error) {
      return { success: false, error: error.message };
    }
  }

  /**
   * Change password
   */
  async changePassword(currentPassword, newPassword) {
    try {
      await api.post("/auth/change-password", {
        current_password: currentPassword,
        new_password: newPassword,
      });
      return { success: true };
    } catch (error) {
      return { success: false, error: error.message };
    }
  }

  /**
   * Check si authentifié
   */
  isLoggedIn() {
    return this.isAuthenticated && !!this.token;
  }

  /**
   * Get utilisateur courant
   */
  getUser() {
    return this.user;
  }

  /**
   * Get token
   */
  getToken() {
    return this.token;
  }

  /**
   * Check permission
   */
  hasPermission(permission) {
    if (!this.user) return false;
    if (this.user.roles.includes("super_admin")) return true; // Super admin a tout
    return this.user.permissions?.includes(permission) || false;
  }

  /**
   * Check rôle
   */
  hasRole(role) {
    if (!this.user) return false;
    return this.user.roles.includes(role);
  }

  /**
   * Subscribe aux changements d'auth
   */
  subscribe(callback) {
    this.listeners.push(callback);
    return () => {
      this.listeners = this.listeners.filter((l) => l !== callback);
    };
  }

  /**
   * Notifier les listeners
   */
  notifyListeners() {
    this.listeners.forEach((callback) => {
      callback({
        isAuthenticated: this.isAuthenticated,
        user: this.user,
        token: this.token,
      });
    });
  }
}

export default new AuthManager();
