window.QtixSidebar = {
  items: [
    {
      title: "Tableau de bord",
      icon: "dashboard",
      route: "/Accueil",
      module: "dashboard",
    },

    {
      title: "Entrepôts",
      icon: "warehouse",
      route: "/entrepots",
      module: "warehouses",
    },

    {
      title: "Produits",
      icon: "inventory_2",
      route: "/produits",
      module: "products",
    },

    {
      title: "Stock",
      icon: "inventory",
      route: "/stocks",
      module: "stocks",
    },

    {
      title: "Mouvements",
      icon: "swap_horiz",
      route: "/mouvements",
      module: "movements",
    },

    {
      title: "Achats",
      icon: "shopping_cart",
      route: "/achats",
      module: "purchases",
    },

    {
      title: "Rapports",
      icon: "analytics",
      route: "/rapports",
      module: "reports",
    },

    {
      separator: true,
      label: "ADMINISTRATION",
    },

    {
      title: "Teams",
      icon: "group",
      route: "/teams",
      module: "users",
    },

    {
      title: "Paramètres",
      icon: "settings",
      route: "/settings",
      module: "company",
    },

    {
      title: "Abonnement",
      icon: "payments",
      route: "/subscription",
      module: "subscriptions",
    },
  ],

  getItems() {
    const modules = Qtix.getUser()?.modules || [];

    return this.items.filter((item) => {
      if (item.separator) {
        return true;
      }

      if (!item.module) {
        return true;
      }

      return modules.includes(item.module);
    });
  },
  isActive(route, currentRoute) {
    console.log("route:", route, "curent :", currentRoute);
    return route === currentRoute;
  },
};
