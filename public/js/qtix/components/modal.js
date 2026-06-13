/**
 * Modal Component - Qtix
 * Composant modal réutilisable avec Alpine
 */

export function createModal(options = {}) {
  return {
    isOpen: options.initialOpen || false,
    title: options.title || "Modal",
    content: options.content || "",
    size: options.size || "md", // sm, md, lg, xl
    backdrop: options.backdrop !== false,
    keyboard: options.keyboard !== false, // Close on ESC

    open() {
      this.isOpen = true;
      document.body.style.overflow = "hidden";
    },

    close() {
      this.isOpen = false;
      document.body.style.overflow = "";
      if (options.onClose) {
        options.onClose();
      }
    },

    toggle() {
      this.isOpen ? this.close() : this.open();
    },

    handleEscapeKey(event) {
      if (this.keyboard && event.key === "Escape" && this.isOpen) {
        this.close();
      }
    },

    handleBackdropClick(event) {
      if (this.backdrop && event.target === event.currentTarget) {
        this.close();
      }
    },

    getSizeClasses() {
      const sizes = {
        sm: "max-w-sm",
        md: "max-w-md",
        lg: "max-w-lg",
        xl: "max-w-xl",
      };
      return sizes[this.size] || sizes.md;
    },
  };
}

/**
 * HTML Template pour Modal
 */
export function renderModal(config) {
  const { id, title, size } = config;
  return `
        <div 
            id="${id}" 
            x-data="${id}"
            x-show="isOpen"
            @keydown.escape="handleEscapeKey"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            x-transition
        >
            <!-- Backdrop -->
            <div 
                x-show="isOpen"
                @click="handleBackdropClick($event)"
                class="fixed inset-0 bg-black/50 dark:bg-black/60 backdrop-blur-sm"
                x-transition
            ></div>
            
            <!-- Modal Content -->
            <div 
                class="relative bg-white dark:bg-slate-900 rounded-lg shadow-xl ${size || "max-w-md"} w-full z-10"
                x-transition
                @click.stop
            >
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">${title}</h2>
                    <button 
                        @click="close()"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                    >
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                
                <!-- Body -->
                <div class="px-6 py-4">
                    <slot name="content"></slot>
                </div>
                
                <!-- Footer -->
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <button 
                        @click="close()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
                    >
                        Fermer
                    </button>
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    `;
}
