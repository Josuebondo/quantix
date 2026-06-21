/**
 * State Management - Qtix
 * Store simple et réactif
 */

class StateManager {
  constructor() {
    this.state = {};
    this.subscribers = {};
    this.watchers = {};
  }

  /**
   * Initialiser le store avec des données initiales
   */
  init(initialState = {}) {
    this.state = { ...initialState };
  }

  /**
   * Set une valeur dans le store
   */
  set(key, value) {
    const oldValue = this.state[key];
    this.state[key] = value;

    // Notifier les watchers
    if (this.watchers[key]) {
      this.watchers[key].forEach((callback) => {
        callback(value, oldValue);
      });
    }

    // Notifier les subscribers
    this.notifySubscribers();
  }

  /**
   * Get une valeur du store
   */
  get(key) {
    return this.state[key];
  }

  /**
   * Get tout le store
   */
  getAll() {
    return { ...this.state };
  }

  /**
   * Update multiple keys à la fois
   */
  update(updates) {
    Object.keys(updates).forEach((key) => {
      this.set(key, updates[key]);
    });
  }

  /**
   * Delete une clé
   */
  delete(key) {
    delete this.state[key];
    this.notifySubscribers();
  }

  /**
   * Clear le store
   */
  clear() {
    this.state = {};
    this.notifySubscribers();
  }

  /**
   * Watch une clé spécifique
   */
  watch(key, callback) {
    if (!this.watchers[key]) {
      this.watchers[key] = [];
    }
    this.watchers[key].push(callback);

    // Retourner une fonction pour unwatch
    return () => {
      this.watchers[key] = this.watchers[key].filter((c) => c !== callback);
    };
  }

  /**
   * Subscribe à tous les changements
   */
  subscribe(callback) {
    const id = Math.random();
    this.subscribers[id] = callback;

    // Retourner une fonction pour unsubscribe
    return () => {
      delete this.subscribers[id];
    };
  }

  /**
   * Notifier les subscribers
   */
  notifySubscribers() {
    Object.values(this.subscribers).forEach((callback) => {
      callback(this.state);
    });
  }

  /**
   * Vérifier si une clé existe
   */
  has(key) {
    return key in this.state;
  }

  /**
   * Merge des données
   */
  merge(key, data) {
    if (typeof this.state[key] === "object" && this.state[key] !== null) {
      this.set(key, { ...this.state[key], ...data });
    }
  }

  /**
   * Persist en localStorage
   */
  persist(key, storageKey) {
    const stored = localStorage.getItem(storageKey);
    if (stored) {
      try {
        this.set(key, JSON.parse(stored));
      } catch (e) {
        console.error("Erreur parsing state:", e);
      }
    }

    // Synchroniser les changements
    this.watch(key, (value) => {
      localStorage.setItem(storageKey, JSON.stringify(value));
    });
  }

  /**
   * Restore depuis localStorage
   */
  restore(storageKey) {
    const stored = localStorage.getItem(storageKey);
    if (stored) {
      try {
        return JSON.parse(stored);
      } catch (e) {
        console.error("Erreur parsing stored state:", e);
        return null;
      }
    }
    return null;
  }
}

export default new StateManager();
