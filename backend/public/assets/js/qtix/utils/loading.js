/**
 * Loading Manager - Qtix
 * Gère les états de chargement
 */

import Qtix from "/assets/js/qtix/qtix.js";
import { html } from "/assets/js/qtix/components/loader.js";
class LoadingManager {
  constructor() {
    this.isLoading = false;
    this.loadingCount = 0;
    this.listeners = [];
    this.container = null;
  }

  /**
   * Initialiser le container
   */
  init(containerId = "loading") {
    this.container = document.getElementById(containerId);

    if (!this.container) return;

    // rendre le parent relatif si besoin
    if (getComputedStyle(this.container).position === "static") {
      this.container.classList.add("relative");
    }

    this.container.innerHTML = `
   
        ${html}

  `;
  }

  /**
   * Start loading
   */
  start() {
    this.loadingCount++;
    if (this.loadingCount === 1) {
      this.isLoading = true;
      this.show();
      this.notifyListeners();
    }
  }

  /**
   * Stop loading
   */
  stop() {
    this.loadingCount = Math.max(0, this.loadingCount - 1);
    if (this.loadingCount === 0) {
      this.isLoading = false;
      this.hide();
      this.notifyListeners();
    }
  }

  /**
   * Show le spinner
   */
  show() {
    this.container.classList.remove("hidden");
  }

  /**
   * Hide le spinner
   */
  hide() {
    this.container.classList.add("hidden");
  }

  /**
   * Subscribe aux changements
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
        isLoading: this.isLoading,
        count: this.loadingCount,
      });
    });
  }

  /**
   * Wrap une async function
   */
  async wrap(fn) {
    this.start();
    try {
      return await fn();
    } finally {
      this.stop();
    }
  }

  /**
   * Reset
   */
  reset() {
    this.loadingCount = 0;
    this.isLoading = false;
    this.hide();
    this.notifyListeners();
  }
}

export default new LoadingManager();
