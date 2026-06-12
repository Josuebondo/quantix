/**
 * Page System - Qtix
 * Système de pages BMVC-like
 */

import api from "../core/api.js";
import router from "../core/router.js";
import notification from "../core/notification.js";

class PageManager {
  constructor() {
    this.pages = {};
    this.currentPage = null;
  }

  /**
   * Enregistrer une page
   */
  register(name, config) {
    this.pages[name] = {
      url: config.url,
      method: config.method || "GET",
      data: config.data || {},
      init: config.init || null,
      methods: config.methods || {},
      template: config.template || null,
      cache: config.cache !== false,
      ...config,
    };

    // Enregistrer aussi dans le routeur
    router.register(config.route || `/${name}`, {
      component: async (params) => {
        return await this.loadPage(name, params);
      },
      init: async function () {
        if (this.init) {
          await this.init.call(this);
        }
      },
      methods: config.methods || {},
      ...config,
    });
  }

  /**
   * Charger une page
   */
  async loadPage(name, params = {}) {
    const page = this.pages[name];

    if (!page) {
      notification.error(`Page '${name}' non trouvée`);
      return "<div>Page non trouvée</div>";
    }

    this.currentPage = { name, page, params };

    try {
      // Récupérer les données
      let pageData = page.data;

      if (page.url) {
        const response = await api[page.method.toLowerCase()](page.url, params);
        pageData = response.data || response;
      }

      // Créer le contexte
      const context = {
        ...pageData,
        ...page.methods,
        params,
        navigate: (path) => router.navigate(path),
        reload: () => router.reload(),
        get: (key) => pageData[key],
        set: (key, value) => {
          pageData[key] = value;
        },
      };

      // Render le template
      let html = "";
      if (page.template && typeof page.template === "function") {
        html = await page.template.call(context, pageData);
      } else if (page.template) {
        html = page.template;
      }

      // Exécuter init
      if (page.init && typeof page.init === "function") {
        await page.init.call(context, pageData);
      }

      return html;
    } catch (error) {
      console.error(`Erreur chargement page '${name}':`, error);
      notification.error(`Erreur chargement de la page: ${error.message}`);
      return "<div>Erreur chargement de la page</div>";
    }
  }

  /**
   * Naviguer vers une page
   */
  async go(name, params = {}) {
    const page = this.pages[name];
    // if (!page) {
    //   console.error(`Page '${name}' non enregistrée`);
    //   return;
    // }

    await router.navigate(page.route || `/${name}`, params);
  }

  /**
   * Get page courante
   */
  getCurrentPage() {
    return this.currentPage;
  }

  /**
   * Recharger page courante
   */
  async reloadCurrent() {
    if (this.currentPage) {
      await this.loadPage(this.currentPage.name, this.currentPage.params);
    }
  }

  /**
   * Pré-charger une page
   */
  async preload(name) {
    const page = this.pages[name];
    if (page && page.url) {
      try {
        await api[page.method.toLowerCase()](page.url);
      } catch (error) {
        console.error(`Erreur preload page '${name}':`, error);
      }
    }
  }
}

export default new PageManager();
