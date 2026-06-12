# Qtix - Framework Frontend Quantix

**Qtix** est un framework frontend léger et modulaire conçu pour les applications SaaS avec Quantix. Il combine Alpine.js, Fetch API, routing SPA, state management et authentication.

## 🎯 Features

- ✅ **SPA Navigation** - Routing sans rechargement de page
- ✅ **API Wrapper** - Fetch avec token auto-injection
- ✅ **Auth System** - Login, logout, token persistence
- ✅ **State Management** - Simple store réactif
- ✅ **Components** - Modal, Table, Form réutilisables
- ✅ **Notifications** - Toast & error handling
- ✅ **Page System** - BMVC-like pour organiser le code
- ✅ **Error Boundary** - Gestion centralisée des erreurs
- ✅ **Loading Manager** - Gestion des états de chargement
- ✅ **Helpers** - Utilitaires (date, currency, etc.)

## 📦 Installation

```bash
# Copier le dossier qtix dans public/js/
cp -r public/js/qtix/* public/js/

# Importer dans votre HTML
<script type="module">
  import Qtix from '/js/qtix/qtix.js';
  await Qtix.init();
</script>
```

## 🚀 Quick Start

### Initialiser Qtix

```javascript
import Qtix from "/js/qtix/qtix.js";

await Qtix.init({
  apiBaseUrl: "/api",
  appContainer: "app",
  initialState: {
    user: null,
    company: null,
  },
});
```

### Navigation (Router)

```javascript
// Enregistrer une route
Qtix.registerRoute("/dashboard", {
  component: async () => {
    const data = await Qtix.get("/api/dashboard");
    return `<div>Dashboard</div>`;
  },
  requireAuth: true,
  roles: ["admin", "owner"],
});

// Naviguer
Qtix.navigate("/dashboard");
Qtix.goToPage("dashboard");
```

### Page System

```javascript
// Enregistrer une page
Qtix.registerPage("products", {
  url: "/api/products",
  route: "/products",
  template(data) {
    return `
      <div x-data="productsData">
        <h1>${data.title}</h1>
        <p>Total: ${data.count}</p>
      </div>
    `;
  },
  methods: {
    async deleteProduct(id) {
      await Qtix.delete(`/api/products/${id}`);
      Qtix.success("Produit supprimé");
      Qtix.reload();
    },
  },
  init(data) {
    // Appelé après rendu
    console.log("Page initialisée", data);
  },
});

// Naviguer vers page
Qtix.goToPage("products");
```

### API Calls

```javascript
// GET
const data = await Qtix.get("/api/users");

// POST
const result = await Qtix.post("/api/users", {
  name: "John",
  email: "john@example.com",
});

// PUT / PATCH / DELETE
await Qtix.put("/api/users/1", { name: "Jane" });
await Qtix.patch("/api/users/1", { active: true });
await Qtix.delete("/api/users/1");

// Upload fichier
const formData = new FormData();
formData.append("file", file);
await Qtix.upload("/api/upload", formData);
```

### Authentication

```javascript
// Login
const { success, user } = await Qtix.login("email@example.com", "password");

if (success) {
  Qtix.navigate("/dashboard");
}

// Get utilisateur courant
const user = Qtix.getUser();

// Check permission
if (Qtix.hasPermission("create_product")) {
  // ...
}

// Check rôle
if (Qtix.hasRole("admin")) {
  // ...
}

// Logout
Qtix.logout();

// Subscribe auth changes
Qtix.subscribeAuth((auth) => {
  console.log("Auth changed:", auth);
});
```

### State Management

```javascript
// Set state
Qtix.setState("user", { id: 1, name: "John" });

// Get state
const user = Qtix.getState("user");

// Update state
Qtix.updateState({
  user: { id: 1, name: "Jane" },
  company: { id: 1, name: "Acme" },
});

// Watch state
const unwatch = Qtix.watchState("user", (newValue, oldValue) => {
  console.log("User changed:", newValue);
});
unwatch(); // Stop watching

// Subscribe all state changes
const unsubscribe = Qtix.subscribeState((state) => {
  console.log("State changed:", state);
});
```

### Notifications

```javascript
// Success
Qtix.success("Opération réussie");

// Error
Qtix.error("Une erreur est survenue");

// Warning
Qtix.warning("Attention!");

// Info
Qtix.info("Information");

// Custom
Qtix.notify("Custom message", "success", {
  duration: 5000,
  action: async () => {
    console.log("Action clicked");
  },
  actionLabel: "Annuler",
});
```

### Error Handling

```javascript
// Ajouter handler personnalisé
Qtix.onError((error) => {
  console.error("Erreur globale:", error);
});

// Wrap fonction avec error handling
const safeFn = error.wrap(async () => {
  await Qtix.get("/api/data");
});

// Try-catch helper
const result = await error.tryAsync(async () => {
  return await Qtix.get("/api/data");
});
```

### Loading State

```javascript
// Start loading
Qtix.startLoading();

// Stop loading
Qtix.stopLoading();

// Wrap async operation
await Qtix.loadAsync(async () => {
  const data = await Qtix.get("/api/heavy-operation");
  return data;
});
```

### Components

#### Modal

```javascript
import { createModal } from '/js/qtix/qtix.js';

const modalData = createModal({
  title: 'Confirmer',
  size: 'md',
  onClose: () => console.log('Modal fermée')
});

// Dans Alpine:
<div x-data="modalData">
  <button @click="open()">Ouvrir</button>

  <div x-show="isOpen" @click="handleBackdropClick($event)">
    <div>
      <h2 x-text="title"></h2>
      <p>Êtes-vous sûr?</p>
      <button @click="close()">Annuler</button>
      <button @click="close(); confirm()">Confirmer</button>
    </div>
  </div>
</div>
```

#### Table

```javascript
import { createTable } from '/js/qtix/qtix.js';

const tableData = createTable({
  items: [
    { id: 1, name: 'Product A', price: 100 },
    { id: 2, name: 'Product B', price: 200 }
  ],
  columns: [
    { key: 'name', label: 'Nom' },
    { key: 'price', label: 'Prix' }
  ],
  itemsPerPage: 10
});

// Dans Alpine:
<div x-data="tableData">
  <input
    type="text"
    placeholder="Rechercher..."
    @input="search($event.target.value)"
  />

  <table>
    <thead>
      <tr>
        <th @click="sort('name')">Nom</th>
        <th @click="sort('price')">Prix</th>
      </tr>
    </thead>
    <tbody>
      <template x-for="item in paginatedItems" :key="item.id">
        <tr>
          <td x-text="item.name"></td>
          <td x-text="item.price"></td>
        </tr>
      </template>
    </tbody>
  </table>

  <button @click="previousPage()">Précédent</button>
  <button @click="nextPage()">Suivant</button>
</div>
```

#### Form

```javascript
import { createForm } from '/js/qtix/qtix.js';

const formData = createForm({
  fields: {
    email: {
      label: 'Email',
      type: 'email',
      rules: ['required', 'email'],
      placeholder: 'email@example.com'
    },
    password: {
      label: 'Mot de passe',
      type: 'password',
      rules: ['required', 'min:8']
    }
  },
  onSubmit: async (values) => {
    const result = await Qtix.post('/api/login', values);
    if (result.success) {
      Qtix.success('Connexion réussie');
    }
  }
});

// Dans Alpine:
<form x-data="formData" @submit.prevent="submit()">
  <div>
    <label>Email</label>
    <input
      type="email"
      @input="setValue('email', $event.target.value)"
      :value="values.email"
    />
    <div x-show="hasError('email')">
      <template x-for="error in getErrors('email')">
        <p x-text="error"></p>
      </template>
    </div>
  </div>

  <button type="submit" :disabled="isSubmitting">
    <span x-show="!isSubmitting">Soumettre</span>
    <span x-show="isSubmitting">Envoi...</span>
  </button>
</form>
```

### Helpers

```javascript
import { helpers } from "/js/qtix/qtix.js";

// Date
helpers.formatDate(new Date(), "DD/MM/YYYY");

// Currency
helpers.formatCurrency(100, "USD");

// Slugify
helpers.slugify("Hello World"); // 'hello-world'

// Debounce
const debouncedSearch = helpers.debounce((query) => {
  Qtix.get("/api/search?q=" + query);
}, 300);

// Deep clone
const cloned = helpers.deepClone(obj);

// Merge
const merged = helpers.merge(obj1, obj2);

// Generate UUID
const id = helpers.generateUUID();
```

### Storage

```javascript
import { localStorage, sessionStorage } from "/js/qtix/qtix.js";

// Set
localStorage.set("user", { id: 1, name: "John" });

// Get
const user = localStorage.get("user");

// Check exists
if (localStorage.has("user")) {
  // ...
}

// Remove
localStorage.remove("user");

// Clear all
localStorage.clear();

// With expiry
localStorage.set("token", "abc123", 7); // 7 jours
```

## 📁 Architecture

```
qtix/
├── core/
│   ├── app.js          # Main app
│   ├── api.js          # API wrapper
│   ├── auth.js         # Auth system
│   ├── state.js        # State management
│   ├── router.js       # Router SPA
│   ├── notification.js # Notifications
│   └── error.js        # Error handling
├── page/
│   └── page.js         # Page system
├── components/
│   ├── modal.js        # Modal component
│   ├── table.js        # Table component
│   └── form.js         # Form component
├── utils/
│   ├── helpers.js      # Helpers
│   ├── storage.js      # Storage manager
│   └── loading.js      # Loading manager
└── qtix.js             # Entry point
```

## 🔒 Security

- CSRF token injection automatique
- Token localStorage + Bearer auth
- Route protection par rôle
- Global error boundary
- Content-Type validation

## 📝 License

MIT - Quantix SaaS
