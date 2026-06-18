/**
 * API Wrapper - Qtix
 * Gère les requêtes HTTP avec token, erreurs globales, etc.
 */

class ApiManager {
  constructor() {
    this.baseUrl = "/api";
    this.token = localStorage.getItem("auth_token");
    this.loading = false;
    this.errorCallback = null;
  }

  /**
   * Définit le callback d'erreur global
   */
  onError(callback) {
    this.errorCallback = callback;
  }

  /**
   * Construit les headers avec token
   */
  getHeaders(customHeaders = {}) {
    const headers = {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest",

      ...customHeaders,
    };

    // Ajouter le CSRF token si présent
    const csrfToken = document.querySelector(
      'meta[name="csrf-token"]',
    )?.content;
    if (csrfToken) {
      headers["X-CSRF-Token"] = csrfToken;
    }

    // Ajouter le token d'auth
    if (this.token) {
      headers["Authorization"] = `Bearer ${this.token}`;
    }

    return headers;
  }

  /**
   * Gère la réponse
   */
  async handleResponse(response) {
    if (!response.ok) {
      const error = await response.json().catch(() => ({
        message: `HTTP ${response.status}: ${response.statusText}`,
      }));

      const err = new Error(error.message || "API Error");
      err.status = response.status;
      err.data = error;
      console.error("API Error:", err);
      if (this.errorCallback) {
        this.errorCallback(err);
      }

      throw err;
    }

    return response.json();
  }

  /**
   * GET Request
   */
  async get(url, options = {}) {
    this.loading = true;
    try {
      const fullUrl = url.startsWith("http") ? url : `${this.baseUrl}${url}`;
      const response = await fetch(fullUrl, {
        method: "GET",
        headers: this.getHeaders(options.headers),
        ...options,
      });
      return await this.handleResponse(response);
    } catch (error) {
      throw error;
    } finally {
      this.loading = false;
    }
  }

  /**
   * POST Request
   */
  async post(url, data = {}, options = {}) {
    this.loading = true;
    try {
      const fullUrl = url.startsWith("http") ? url : `${this.baseUrl}${url}`;
      const response = await fetch(fullUrl, {
        method: "POST",
        headers: this.getHeaders(options.headers),
        body: JSON.stringify(data),
        ...options,
      });
      return await this.handleResponse(response);
    } catch (error) {
      throw error;
    } finally {
      this.loading = false;
    }
  }

  /**
   * PUT Request
   */
  async put(url, data = {}, options = {}) {
    this.loading = true;
    try {
      const fullUrl = url.startsWith("http") ? url : `${this.baseUrl}${url}`;
      const response = await fetch(fullUrl, {
        method: "PUT",
        headers: this.getHeaders(options.headers),
        body: JSON.stringify(data),
        ...options,
      });
      return await this.handleResponse(response);
    } catch (error) {
      throw error;
    } finally {
      this.loading = false;
    }
  }

  /**
   * DELETE Request
   */
  async delete(url, options = {}) {
    this.loading = true;
    try {
      const fullUrl = url.startsWith("http") ? url : `${this.baseUrl}${url}`;
      const response = await fetch(fullUrl, {
        method: "DELETE",
        headers: this.getHeaders(options.headers),
        ...options,
      });
      return await this.handleResponse(response);
    } catch (error) {
      throw error;
    } finally {
      this.loading = false;
    }
  }

  /**
   * PATCH Request
   */
  async patch(url, data = {}, options = {}) {
    this.loading = true;
    try {
      const fullUrl = url.startsWith("http") ? url : `${this.baseUrl}${url}`;
      const response = await fetch(fullUrl, {
        method: "PATCH",
        headers: this.getHeaders(options.headers),
        body: JSON.stringify(data),
        ...options,
      });
      return await this.handleResponse(response);
    } catch (error) {
      throw error;
    } finally {
      this.loading = false;
    }
  }

  /**
   * Upload fichier
   */
  async upload(url, formData, options = {}) {
    this.loading = true;
    try {
      const fullUrl = url.startsWith("http") ? url : `${this.baseUrl}${url}`;
      const headers = this.getHeaders(options.headers);
      delete headers["Content-Type"]; // FormData gérera ça

      const response = await fetch(fullUrl, {
        method: "POST",
        headers,
        body: formData,
        ...options,
      });
      return await this.handleResponse(response);
    } catch (error) {
      throw error;
    } finally {
      this.loading = false;
    }
  }

  /**
   * Update token
   */
  setToken(token) {
    this.token = token;
    if (token) {
      localStorage.setItem("auth_token", token);
    } else {
      localStorage.removeItem("auth_token");
    }
  }

  /**
   * Récupère le token
   */
  getToken() {
    return this.token;
  }

  /**
   * Check si loading
   */
  isLoading() {
    return this.loading;
  }
}

export default new ApiManager();
