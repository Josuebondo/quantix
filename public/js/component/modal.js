/**
 * Modal Component
 * Composant réutilisable pour les modales avec animations
 */
export function modal(initialOpen = false) {
    return {
        isOpen: initialOpen,
        
        open() {
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
            this.$nextTick(() => {
                this.$el.focus();
            });
        },
        
        close() {
            this.isOpen = false;
            document.body.style.overflow = '';
        },
        
        toggle() {
            this.isOpen ? this.close() : this.open();
        },
        
        handleEscapeKey(event) {
            if (event.key === 'Escape' && this.isOpen) {
                this.close();
            }
        },
        
        handleOverlayClick(event) {
            if (event.target === this.$el) {
                this.close();
            }
        }
    };
}
