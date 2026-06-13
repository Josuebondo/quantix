/**
 * Storage Utilities - Qtix
 * Gère localStorage et sessionStorage
 */

class StorageManager {
  constructor(type = "local") {
    this.storage = window.localStorage;
  }

  /**
   * Set une valeur
   */
  set(key, value, expiryDays = null) {
    const data = {
      value: value,
      timestamp: Date.now(),
    };

    if (expiryDays) {
      data.expiry = Date.now() + expiryDays * 24 * 60 * 60 * 1000;
    }

    this.storage.setItem(key, JSON.stringify(data));
  }

  /**
   * Get une valeur
   */
  get(key, defaultValue = null) {
    const item = this.storage.getItem(key);

    if (!item) {
      return defaultValue;
    }

    try {
      const data = JSON.parse(item);

      // Check expiry
      if (data.expiry && Date.now() > data.expiry) {
        this.remove(key);
        return defaultValue;
      }

      return data.value || defaultValue;
    } catch (e) {
      console.error("Erreur parsing storage:", e);
      return defaultValue;
    }
  }

  /**
   * Check si clé existe
   */
  has(key) {
    return this.storage.getItem(key) !== null;
  }

  /**
   * Remove une clé
   */
  remove(key) {
    this.storage.removeItem(key);
  }

  /**
   * Clear tout
   */
  clear() {
    this.storage.clear();
  }

  /**
   * Get toutes les clés
   */
  keys() {
    return Object.keys(this.storage);
  }

  /**
   * Get size en bytes
   */
  size() {
    let size = 0;
    for (let key in this.storage) {
      if (this.storage.hasOwnProperty(key)) {
        size += this.storage[key].length + key.length;
      }
    }
    return size;
  }

  /**
   * Import depuis JSON
   */
  import(json) {
    try {
      const data = JSON.parse(json);
      Object.entries(data).forEach(([key, value]) => {
        this.set(key, value);
      });
      return true;
    } catch (e) {
      console.error("Erreur import storage:", e);
      return false;
    }
  }

  /**
   * Export vers JSON
   */
  export() {
    const data = {};
    for (let i = 0; i < this.storage.length; i++) {
      const key = this.storage.key(i);
      data[key] = this.get(key);
    }
    return JSON.stringify(data);
  }
}

export const localStorage = new StorageManager("local");
export const sessionStorage = new StorageManager("session");
