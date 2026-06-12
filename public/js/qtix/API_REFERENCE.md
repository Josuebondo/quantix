# Qtix - API Reference

Documentation complète des modules et API de Qtix.

## Table of Contents

- [App (Core)](#app-core)
- [API](#api)
- [Auth](#auth)
- [State](#state)
- [Router](#router)
- [Notification](#notification)
- [Error](#error)
- [Page](#page)
- [Components](#components)
- [Utils](#utils)

---

## App (Core)

Point d'entrée principal de Qtix.

### Initialisation

```javascript
import Qtix from "/js/qtix/qtix.js";

await Qtix.init({
  apiBaseUrl: "/api",
  appContainer: "app",
  notificationsContainer: "notifications",
  loadingContainer: "loading",
  initialState: {},
});
```

### API Methods

#### `navigate(path, data)`

Navigation SPA sans rechargement.

```javascript
await Qtix.navigate("/dashboard", { id: 1 });
```

#### `goToPage(name, params)`

Navigation vers une page enregistrée.

```javascript
await Qtix.goToPage("products", { page: 1 });
```

#### `registerRoute(path, config)`

Enregistrer une route.

```javascript
Qtix.registerRoute("/dashboard", {
  component: async () => "<div>Dashboard</div>",
  requireAuth: true,
  roles: ["admin"],
});
```

#### `registerPage(name, config)`

Enregistrer une page (voir Page System).

#### Configuration Methods

- `getConfig()` - Get configuration
- `isInitialized()` - Check if ready

---

## API

Wrapper HTTP avec token auto-injection.

### Methods

#### `get(url, options)`

```javascript
const data = await Qtix.get("/api/users");
const data = await Qtix.get("/api/users", { headers: { "X-Custom": "value" } });
```

#### `post(url, data, options)`

```javascript
const result = await Qtix.post("/api/users", {
  name: "John",
  email: "john@example.com",
});
```

#### `put(url, data, options)`

```javascript
await Qtix.put("/api/users/1", { name: "Jane" });
```

#### `patch(url, data, options)`

```javascript
await Qtix.patch("/api/users/1", { active: true });
```

#### `delete(url, options)`

```javascript
await Qtix.delete("/api/users/1");
```

#### `upload(url, formData, options)`

```javascript
const form = new FormData();
form.append("file", file);
await Qtix.upload("/api/upload", form);
```

### Configuration

#### `setToken(token)`

Set authorization token.

```javascript
Qtix.api.setToken("eyJhbGc...");
```

#### `getToken()`

Get current token.

```javascript
const token = Qtix.api.getToken();
```

#### `onError(callback)`

Setup global error handler.

```javascript
Qtix.api.onError((error) => {
  console.error("API Error:", error);
});
```

---

## Auth

Système d'authentification complet.

### Methods

#### `login(email, password)`

```javascript
const { success, user, error } = await Qtix.login(
  "user@example.com",
  "password",
);

if (success) {
  Qtix.navigate("/dashboard");
}
```

#### `logout()`

```javascript
Qtix.logout(); // Redirige vers /login
```

#### `register(data)`

```javascript
const { success, user, error } = await Qtix.register({
  name: "John Doe",
  email: "john@example.com",
  password: "secret123",
});
```

#### `refreshToken()`

```javascript
const success = await Qtix.auth.refreshToken();
```

#### `updateProfile(data)`

```javascript
const { success, user } = await Qtix.auth.updateProfile({
  name: "Jane Doe",
  avatar: "url...",
});
```

#### `changePassword(currentPassword, newPassword)`

```javascript
const { success, error } = await Qtix.auth.changePassword("old", "new");
```

#### `getUser()`

```javascript
const user = Qtix.getUser();
// { id, name, email, role, permissions, ... }
```

#### `getToken()`

```javascript
const token = Qtix.auth.getToken();
```

#### `isLoggedIn()`

```javascript
if (Qtix.auth.isLoggedIn()) {
  // User is authenticated
}
```

#### `hasPermission(permission)`

```javascript
if (Qtix.hasPermission("create_product")) {
  // Show button
}
```

#### `hasRole(role)`

```javascript
if (Qtix.hasRole("admin")) {
  // Show admin panel
}
```

#### `subscribe(callback)`

Subscribe to auth changes.

```javascript
const unsubscribe = Qtix.subscribeAuth((auth) => {
  console.log("Auth state:", auth);
  // { isAuthenticated, user, token }
});

// Unsubscribe
unsubscribe();
```

---

## State

Simple state management system.

### Methods

#### `set(key, value)`

```javascript
Qtix.setState("user", { id: 1, name: "John" });
```

#### `get(key)`

```javascript
const user = Qtix.getState("user");
```

#### `update(updates)`

```javascript
Qtix.updateState({
  user: { id: 1 },
  company: { id: 1 },
});
```

#### `delete(key)`

```javascript
Qtix.state.delete("tempData");
```

#### `clear()`

```javascript
Qtix.state.clear(); // Clear all state
```

#### `watch(key, callback)`

Watch specific state key.

```javascript
const unwatch = Qtix.watchState("user", (newValue, oldValue) => {
  console.log("User changed from:", oldValue, "to:", newValue);
});

unwatch(); // Stop watching
```

#### `subscribe(callback)`

Subscribe to all state changes.

```javascript
const unsubscribe = Qtix.subscribeState((state) => {
  console.log("Full state:", state);
});

unsubscribe();
```

#### `has(key)`

```javascript
if (Qtix.state.has("user")) {
  // ...
}
```

#### `persist(key, storageKey)`

Persist state to localStorage.

```javascript
Qtix.state.persist("user", "cached_user");
```

---

## Router

SPA routing without page reload.

### Methods

#### `navigate(path, data)`

```javascript
await Qtix.navigate("/products", { id: 1 });
```

#### `register(path, config)`

```javascript
Qtix.registerRoute("/products", {
  component: () => "<div>Products</div>",
  init: function () {
    /* ... */
  },
  methods: {
    /* ... */
  },
  requireAuth: true,
  roles: ["admin"],
});
```

#### `before(hook)`

Execute before navigation.

```javascript
Qtix.router.before(async (path) => {
  console.log("Navigating to:", path);
  return true; // Continue navigation
});
```

#### `after(hook)`

Execute after navigation.

```javascript
Qtix.router.after(async (path, route) => {
  console.log("Navigated to:", path);
});
```

#### `back()`

```javascript
Qtix.router.back();
```

#### `forward()`

```javascript
Qtix.router.forward();
```

#### `reload()`

Reload current page data.

```javascript
await Qtix.reload();
```

#### `getCurrentRoute()`

```javascript
const route = Qtix.router.getCurrentRoute();
// { path, route, data }
```

---

## Notification

Toast & message notifications.

### Methods

#### `success(message, options)`

```javascript
Qtix.success("Operation completed");
Qtix.success("Undo?", {
  duration: 5000,
  action: async () => {
    // Undo logic
  },
  actionLabel: "Undo",
});
```

#### `error(message, options)`

```javascript
Qtix.error("An error occurred");
```

#### `warning(message, options)`

```javascript
Qtix.warning("Warning message");
```

#### `info(message, options)`

```javascript
Qtix.info("Info message");
```

#### `show(message, type, options)`

```javascript
const notif = Qtix.notify("Custom message", "success", { duration: 3000 });
notif.dismiss(); // Dismiss immediately
```

#### `clearAll()`

```javascript
Qtix.notification.clearAll();
```

#### `setAutoCloseDuration(time)`

```javascript
Qtix.notification.setAutoCloseDuration(5000);
```

---

## Error

Global error handling.

### Methods

#### `init()`

```javascript
Qtix.error.init(); // Called by Qtix.init()
```

#### `onError(callback)`

```javascript
Qtix.onError((error) => {
  console.error("Caught error:", error);
});
```

#### `handleError(error)`

```javascript
Qtix.error.handleError(new Error("Something broke"));
```

#### `wrap(fn)`

```javascript
const safeFn = Qtix.error.wrap(async () => {
  return await Qtix.get("/api/data");
});
```

#### `tryAsync(fn)`

```javascript
const result = await Qtix.error.tryAsync(async () => {
  return await Qtix.get("/api/data");
});

if (result.error) {
  // Handle error
}
```

---

## Page

BMVC-like page system.

### Register Page

```javascript
Qtix.registerPage("products", {
  url: "/api/products",
  method: "GET",
  route: "/products",
  cache: true,

  template(data) {
    return `
      <div>
        <h1>${data.title}</h1>
        <p>Items: ${data.items.length}</p>
      </div>
    `;
  },

  data: {
    // default data
  },

  methods: {
    async deleteItem(id) {
      await Qtix.delete(`/api/products/${id}`);
      Qtix.success("Item deleted");
      Qtix.reload();
    },
  },

  init(data) {
    console.log("Page loaded with data:", data);
  },
});
```

### Methods

#### `go(name, params)`

```javascript
await Qtix.goToPage("products", { page: 1 });
```

#### `getCurrentPage()`

```javascript
const page = Qtix.page.getCurrentPage();
// { name, page, params }
```

#### `reloadCurrent()`

```javascript
await Qtix.page.reloadCurrent();
```

#### `preload(name)`

Pre-load page data.

```javascript
await Qtix.page.preload("products");
```

---

## Components

### Modal

```javascript
import { createModal } from '/js/qtix/qtix.js';

const modal = createModal({
  title: 'Confirm Action',
  size: 'md', // sm, md, lg, xl
  backdrop: true,
  keyboard: true, // ESC to close
  onClose: () => {
    console.log('Modal closed');
  }
});

// Usage in Alpine
<div x-data="modal">
  <button @click="open()">Open</button>
  <div x-show="isOpen" @click="handleBackdropClick($event)">
    <h2 x-text="title"></h2>
    <button @click="close()">Close</button>
  </div>
</div>
```

### Table

```javascript
import { createTable } from "/js/qtix/qtix.js";

const table = createTable({
  items: [
    { id: 1, name: "Product A", price: 100 },
    { id: 2, name: "Product B", price: 200 },
  ],
  columns: [
    { key: "name", label: "Name" },
    { key: "price", label: "Price" },
  ],
  itemsPerPage: 10,
});

// Methods
table.sort("name"); // Sort by column
table.search("query"); // Search
table.goToPage(2); // Go to page
table.nextPage() / table.previousPage();
table.toggleRow(id); // Select row
table.toggleAllRows(); // Select all
table.getSelectedItems(); // Get selected
```

### Form

```javascript
import { createForm } from "/js/qtix/qtix.js";

const form = createForm({
  fields: {
    email: {
      label: "Email",
      type: "email",
      rules: ["required", "email"],
      placeholder: "email@example.com",
    },
    password: {
      label: "Password",
      type: "password",
      rules: ["required", "min:8"],
    },
    role: {
      label: "Role",
      type: "select",
      options: [
        { value: "admin", label: "Admin" },
        { value: "user", label: "User" },
      ],
    },
  },

  onSubmit: async (values) => {
    const result = await Qtix.post("/api/users", values);
    if (result.success) {
      Qtix.success("User created");
    }
  },
});

// Methods
form.setValue("email", "new@example.com");
form.getValue("email");
form.validateField("email");
form.validateAll();
form.hasError("email");
form.getErrors("email");
form.submit();
form.reset();
form.setErrors({ email: ["Already exists"] });
```

---

## Utils

### Helpers

```javascript
import { helpers } from "/js/qtix/qtix.js";

// Date
helpers.formatDate(new Date(), "DD/MM/YYYY HH:mm");

// Currency
helpers.formatCurrency(100, "USD", "en-US");

// Number
helpers.formatNumber(3.14159, 2); // '3.14'

// String
helpers.slugify("Hello World"); // 'hello-world'
helpers.capitalize("john"); // 'John'
helpers.truncate("Long text...", 10); // 'Long text.'

// Function
const debouncedFn = helpers.debounce(fn, 300);
const throttledFn = helpers.throttle(fn, 300);

// Object
const cloned = helpers.deepClone(obj);
const merged = helpers.merge(obj1, obj2);
helpers.getByPath(obj, "user.profile.name");
helpers.setByPath(obj, "user.profile.name", "John");

// Array
helpers.removeDuplicates([1, 2, 2, 3]); // [1, 2, 3]
helpers.removeDuplicates(users, "id"); // By key

// Query String
helpers.buildQueryString({ page: 1, sort: "name" });
helpers.parseQueryString("page=1&sort=name");

// Validation
helpers.validateEmail("test@example.com");

// UUID
const id = helpers.generateUUID();

// Other
await helpers.delay(1000);
await helpers.copyToClipboard("text");
```

### Storage

```javascript
import { localStorage, sessionStorage } from "/js/qtix/qtix.js";

// Set (with expiry)
localStorage.set("user", { id: 1 }, 7); // 7 days

// Get
const user = localStorage.get("user");

// Check exists
localStorage.has("user");

// Remove
localStorage.remove("user");

// Clear all
localStorage.clear();

// Keys
localStorage.keys();

// Size
localStorage.size();

// Import/Export
localStorage.import(json);
const json = localStorage.export();
```

### Loading

```javascript
import { loading } from "/js/qtix/qtix.js";

// Start/Stop
Qtix.startLoading();
Qtix.stopLoading();

// Wrap async
await Qtix.loadAsync(async () => {
  return await Qtix.get("/api/heavy");
});

// Subscribe
const unsubscribe = loading.subscribe((state) => {
  console.log("Loading:", state.isLoading);
});

// Reset
loading.reset();
```

---

## Complete Example

```javascript
import Qtix, { createModal, createForm, helpers } from "/js/qtix/qtix.js";

// Initialize
await Qtix.init();

// Register page
Qtix.registerPage("users", {
  url: "/api/users",
  route: "/users",
  template(data) {
    return `
      <div x-data="usersPage">
        <h1>Users</h1>
        <button @click="openModal()">Add User</button>
        <table>
          <template x-for="user in items">
            <tr>
              <td x-text="user.name"></td>
              <td x-text="helpers.formatDate(user.created_at)"></td>
            </tr>
          </template>
        </table>
      </div>
    `;
  },
  methods: {
    items: [],

    async openModal() {
      // ...
    },

    async deleteUser(id) {
      await Qtix.delete(`/api/users/${id}`);
      Qtix.success("User deleted");
      Qtix.reload();
    },
  },
});

// Navigate
Qtix.navigate("/users");
```

---

For more examples, see [EXAMPLES.md](EXAMPLES.md)
