/**
 * Action Menu Component
 * Gère l'affichage/fermeture des menus d'action
 */
export function actionMenu() {
  return {
    openMenuId: null,

    toggleMenu(menuId) {
      this.openMenuId = this.openMenuId === menuId ? null : menuId;
    },

    closeMenu() {
      this.openMenuId = null;
    },

    isMenuOpen(menuId) {
      return this.openMenuId === menuId;
    },

    handleDocumentClick(event) {
      const menus = document.querySelectorAll("[data-action-menu]");
      let clickedInMenu = false;

      menus.forEach((menu) => {
        if (menu.contains(event.target)) {
          clickedInMenu = true;
        }
      });

      if (!clickedInMenu) {
        this.closeMenu();
      }
    },
  };
}
