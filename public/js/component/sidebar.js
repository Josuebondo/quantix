/**
 * Sidebar Component
 * Gère l'ouverture/fermeture et la responsivité de la barre latérale
 */
export function sidebar() {
  return {
    isOpen: false,

    toggle() {
      this.isOpen = !this.isOpen;

      if (this.isOpen) {
        document.body.style.overflow = "hidden";
      } else {
        document.body.style.overflow = "";
      }
    },

    close() {
      this.isOpen = false;
      document.body.style.overflow = "";
    },

    handleEscapeKey(event) {
      if (event.key === "Escape" && this.isOpen) {
        this.close();
      }
    },

    handleOverlayClick() {
      this.close();
    },
  };
}
