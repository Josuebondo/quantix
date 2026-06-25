export function createModal(config = {}) {
  return {
    name: config.name,

    title: config.title || "",

    size: config.size || "md",

    loading: false,

    get opened() {
      return Alpine.store("modal").isOpen(this.name);
    },

    close() {
      Alpine.store("modal").close();
    },

    getSizeClass() {
      return {
        sm: "max-w-md",
        md: "max-w-xl",
        lg: "max-w-3xl",
        xl: "max-w-5xl",
        full: "max-w-7xl",
      }[this.size];
    },
  };
}
