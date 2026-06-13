/**
 * Error Boundary - Qtix
 * Gère les erreurs globales
 */

import notification from "./notification.js";

class ErrorBoundary {
  constructor() {
    this.handlers = [];
    this.initialized = false;
  }

  /**
   * Initialiser l'error boundary
   */
  init() {
    if (this.initialized) return;

    // Catch les erreurs non gérées
    window.addEventListener("error", (event) => {
      this.handleError(event.error || event.message);
    });

    // Catch les promesses non gérées
    window.addEventListener("unhandledrejection", (event) => {
      this.handleError(event.reason);
    });

    // Gérer les erreurs API via le manager
    this.setupApiErrorHandler();

    this.initialized = true;
  }

  /**
   * Gérer une erreur
   */
  handleError(error) {
    console.error("Error:", error);

    // Exécuter les handlers personnalisés
    this.handlers.forEach((handler) => {
      try {
        handler(error);
      } catch (e) {
        console.error("Handler error:", e);
      }
    });

    // Afficher une notification
    const message =
      error?.message || String(error) || "Une erreur est survenue";
    notification.error(message);

    // Log en production
    if (process.env.NODE_ENV === "production") {
      this.logError(error);
    }
  }

  /**
   * Setup error handler pour API
   */
  setupApiErrorHandler() {
    // Sera appelé par le api manager
  }

  /**
   * Ajouter un handler personnalisé
   */
  onError(callback) {
    this.handlers.push(callback);
  }

  /**
   * Log l'erreur (pour production)
   */
  async logError(error) {
    try {
      // Envoyer à un service de monitoring
      // await fetch('/api/errors/log', {
      //     method: 'POST',
      //     headers: { 'Content-Type': 'application/json' },
      //     body: JSON.stringify({
      //         message: error?.message,
      //         stack: error?.stack,
      //         url: window.location.href,
      //         timestamp: new Date()
      //     })
      // });
    } catch (e) {
      console.error("Erreur logging:", e);
    }
  }

  /**
   * Wrap une fonction avec error handling
   */
  wrap(fn) {
    return async (...args) => {
      try {
        return await fn(...args);
      } catch (error) {
        this.handleError(error);
        throw error;
      }
    };
  }

  /**
   * Try-catch helper
   */
  tryAsync(fn) {
    return fn().catch((error) => {
      this.handleError(error);
      return { error };
    });
  }
}

export default new ErrorBoundary();
