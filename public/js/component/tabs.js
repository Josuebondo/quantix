/**
 * Tabs Component
 * Gère la navigation par onglets avec gestion d'état
 */
export function tabs(defaultTab = "users") {
  return {
    activeTab: defaultTab,

    selectTab(tabName) {
      this.activeTab = tabName;
    },

    isActive(tabName) {
      return this.activeTab === tabName;
    },
  };
}
