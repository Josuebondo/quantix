/**
 * Service d'authentification client
 * Gère les appels API d'authentification
 */

class AuthService {
  constructor(baseUrl = "/api/auth") {
    this.baseUrl = baseUrl;
    this.accessToken = localStorage.getItem("access_token");
    this.refreshToken = localStorage.getItem("refresh_token");
  }

  /**
   * Connexion utilisateur
   */
  async login(email, password) {
    try {
      const response = await fetch(`${this.baseUrl}/login`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ email, password }),
      });

      const data = await response.json();

      if (data.success) {
        this.setTokens(data.data.tokens);
        return {
          success: true,
          user: data.data.user,
          tokens: data.data.tokens,
        };
      }

      return { success: false, message: data.message };
    } catch (error) {
      console.error("Erreur de connexion:", error);
      return { success: false, message: "Erreur de connexion" };
    }
  }

  /**
   * Enregistrement nouvel utilisateur
   */
  async register(userData) {
    try {
      const response = await fetch(`${this.baseUrl}/register`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(userData),
      });

      const data = await response.json();

      if (data.success) {
        this.setTokens(data.data.tokens);
        return {
          success: true,
          user: data.data.user,
          tokens: data.data.tokens,
        };
      }

      return { success: false, message: data.message };
    } catch (error) {
      console.error("Erreur d'enregistrement:", error);
      return { success: false, message: "Erreur d'enregistrement" };
    }
  }

  /**
   * Renouveler les tokens
   */
  async refreshTokens() {
    try {
      const response = await fetch(`${this.baseUrl}/refresh`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ refresh_token: this.refreshToken }),
      });

      const data = await response.json();

      if (data.success) {
        this.setTokens(data.data.tokens);
        return { success: true, tokens: data.data.tokens };
      }

      return { success: false, message: data.message };
    } catch (error) {
      console.error("Erreur de renouvellement:", error);
      return { success: false, message: "Erreur de renouvellement" };
    }
  }

  /**
   * Vérifier le token actuel
   */
  async verifyToken() {
    try {
      const response = await fetch(`${this.baseUrl}/verify`, {
        method: "GET",
        headers: {
          Authorization: `Bearer ${this.accessToken}`,
        },
      });

      const data = await response.json();

      if (data.success) {
        return { success: true, user: data.data.user };
      }

      return { success: false, message: data.message };
    } catch (error) {
      console.error("Erreur de vérification:", error);
      return { success: false, message: "Erreur de vérification" };
    }
  }

  /**
   * Déconnexion
   */
  async logout() {
    try {
      const response = await fetch(`${this.baseUrl}/logout`, {
        method: "POST",
        headers: {
          Authorization: `Bearer ${this.accessToken}`,
          "Content-Type": "application/json",
        },
      });

      const data = await response.json();

      if (data.success) {
        this.clearTokens();
        return { success: true };
      }

      return { success: false, message: data.message };
    } catch (error) {
      console.error("Erreur de déconnexion:", error);
      // Nettoyer les tokens même en cas d'erreur
      this.clearTokens();
      return { success: false, message: "Erreur de déconnexion" };
    }
  }

  /**
   * Enregistrer les tokens
   */
  setTokens(tokens) {
    this.accessToken = tokens.access_token;
    this.refreshToken = tokens.refresh_token;

    localStorage.setItem("access_token", tokens.access_token);
    localStorage.setItem("refresh_token", tokens.refresh_token);
    localStorage.setItem(
      "token_expires_at",
      Date.now() + tokens.expires_in * 1000,
    );
  }

  /**
   * Effacer les tokens
   */
  clearTokens() {
    this.accessToken = null;
    this.refreshToken = null;

    localStorage.removeItem("access_token");
    localStorage.removeItem("refresh_token");
    localStorage.removeItem("token_expires_at");
  }

  /**
   * Obtenir l'access token
   */
  getAccessToken() {
    return this.accessToken;
  }

  /**
   * Vérifier si l'utilisateur est connecté
   */
  isAuthenticated() {
    const expiresAt = localStorage.getItem("token_expires_at");

    if (!this.accessToken || !expiresAt) {
      return false;
    }

    return Date.now() < parseInt(expiresAt);
  }

  /**
   * Obtenir l'header Authorization
   */
  getAuthHeader() {
    if (!this.accessToken) {
      return null;
    }

    return {
      Authorization: `Bearer ${this.accessToken}`,
      "Content-Type": "application/json",
    };
  }

  /**
   * Faire une requête authentifiée
   */
  async fetchAuthenticated(url, options = {}) {
    // Vérifier si le token est expiré
    if (!this.isAuthenticated()) {
      // Essayer de renouveler
      const refresh = await this.refreshTokens();
      if (!refresh.success) {
        this.clearTokens();
        window.location.href = "/login";
        return null;
      }
    }

    const headers = {
      ...this.getAuthHeader(),
      ...options.headers,
    };

    const response = await fetch(url, {
      ...options,
      headers,
    });

    // Si 401, essayer de renouveler le token
    if (response.status === 401) {
      const refresh = await this.refreshTokens();
      if (refresh.success) {
        // Refaire la requête avec le nouveau token
        headers["Authorization"] = `Bearer ${this.accessToken}`;
        return fetch(url, {
          ...options,
          headers,
        });
      } else {
        // Redirection vers login
        this.clearTokens();
        window.location.href = "/login";
      }
    }

    return response;
  }
}

// Initialiser le service
const authService = new AuthService();

/**
 * Exemple d'utilisation
 */

// Connexion
// const loginResult = await authService.login('user@example.com', 'password123');
// if (loginResult.success) {
//     console.log('Connecté:', loginResult.user);
// }

// Faire une requête authentifiée
// const response = await authService.fetchAuthenticated('/api/documents');
// const data = await response.json();
