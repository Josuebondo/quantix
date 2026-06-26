export function initModalStore() {
  document.addEventListener("alpine:init", () => {
    Alpine.store("modal", {
      active: null,

      data: {},

      open(name, payload = {}) {
        this.active = name;
        this.data = payload;

        document.body.style.overflow = "hidden";
      },

      close() {
        this.active = null;
        this.data = {};

        document.body.style.overflow = "";
      },

      isOpen(name) {
        return this.active === name;
      },
    });
  });
}
