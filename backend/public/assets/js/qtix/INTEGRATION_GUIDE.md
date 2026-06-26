# Qtix Integration Guide

Guide complet pour intégrer Qtix dans vos pages existantes.

## 1. Setup Initial

### Étape 1: Inclure Alpine et Qtix

Dans votre fichier de base (layout.php ou base.php):

```php
<!-- En haut du <head> -->
<meta name="csrf-token" content="<?php echo csrf_token(); ?>">

<!-- Styles -->
<link rel="stylesheet" href="/css/tailwind.css">

<!-- Scripts -->
<script type="module">
    import bootstrap from '/js/qtix/bootstrap.js';
</script>
```

### Étape 2: Containers HTML

```html
<body>
  <!-- App Container (page content ira ici) -->
  <div id="app"></div>

  <!-- Notifications Container -->
  <div id="notifications"></div>

  <!-- Loading Container -->
  <div id="loading"></div>
</body>
```

## 2. Migration des Pages Existantes

### Avant (Vanilla JS)

```javascript
// team.php
function initDarkMode() {
  const toggle = document.getElementById("darkModeToggle");
  toggle.addEventListener("click", () => {
    document.documentElement.classList.toggle("dark");
  });
}

function initModals() {
  const btn = document.getElementById("btnInviteUser");
  const modal = document.getElementById("modalInvitation");
  btn.addEventListener("click", () => {
    modal.classList.remove("hidden");
  });
}

document.addEventListener("DOMContentLoaded", () => {
  initDarkMode();
  initModals();
});
```

### Après (Qtix + Alpine)

```php
<!-- Dans app/Vues/company/team.php -->
<div x-data="teamPageData" @keydown.escape="closeModals()">

    <!-- Dark Mode Toggle -->
    <button @click="toggleDarkMode()">
        <span x-text="darkModeIcon"></span>
    </button>

    <!-- Tabs -->
    <div class="flex gap-4">
        <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'font-bold' : ''">
            Users
        </button>
        <button @click="activeTab = 'invitations'" :class="activeTab === 'invitations' ? 'font-bold' : ''">
            Invitations
        </button>
    </div>

    <!-- Tab Contents -->
    <div x-show="activeTab === 'users'">
        <!-- Content -->
    </div>

    <!-- Modals -->
    <div x-show="showInviteModal" @click="handleBackdropClick($event)">
        <!-- Modal -->
    </div>

</div>

<script type="module">
import Qtix from '/js/qtix/qtix.js';

// Team page data
window.teamPageData = {
    activeTab: 'users',
    showInviteModal: false,
    showRoleModal: false,
    isDark: false,

    async init() {
        // Load data
        const data = await Qtix.get('/api/company/team');
        this.users = data.users;
        this.invitations = data.invitations;
    },

    toggleDarkMode() {
        this.isDark = !this.isDark;
        const html = document.documentElement;
        if (this.isDark) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }
        localStorage.setItem('darkMode', this.isDark);
    },

    get darkModeIcon() {
        return this.isDark ? 'light_mode' : 'dark_mode';
    },

    openInviteModal() {
        this.showInviteModal = true;
    },

    closeModals() {
        this.showInviteModal = false;
        this.showRoleModal = false;
    },

    handleBackdropClick(e) {
        if (e.target === e.currentTarget) {
            this.closeModals();
        }
    },

    async inviteUser(email) {
        const result = await Qtix.post('/api/company/team/invite', {
            email: email
        });

        if (result.success) {
            Qtix.success('Invitation sent');
            this.closeModals();
            this.init(); // Reload
        } else {
            Qtix.error(result.error);
        }
    }
};
</script>
```

## 3. Page System Integration

### Enregistrer une Page

```javascript
import Qtix from '/js/qtix/qtix.js';

// Dans votre bootstrap ou setup file
Qtix.registerPage('company-team', {
    url: '/api/company/team',
    route: '/company/team',

    template(data) {
        return `
            <div x-data="teamData">
                <!-- Page content here -->
            </div>
        `;
    },

    methods: {
        async deleteUser(id) {
            await Qtix.delete(\`/api/users/\${id}\`);
            Qtix.success('User deleted');
            Qtix.reload();
        }
    },

    init(data) {
        console.log('Team page initialized');
    }
});
```

## 4. API Integration

### Ancien Approach (fetch direct)

```javascript
fetch("/api/users", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content,
  },
  body: JSON.stringify({ name: "John" }),
})
  .then((r) => r.json())
  .then((data) => console.log(data))
  .catch((err) => console.error(err));
```

### Nouveau Approach (Qtix)

```javascript
const result = await Qtix.post("/api/users", { name: "John" });
if (result.success) {
  Qtix.success("User created");
}
```

## 5. Auth Integration

### Vérifier Permissions dans la Vue

```html
<!-- Avant: PHP check -->
<?php if (auth()->user()->hasRole('admin')): ?>
<button>Delete</button>
<?php endif; ?>

<!-- Après: Alpine + Qtix -->
<button x-show="Qtix.hasRole('admin')">Delete</button>
```

### Logout & Auto-redirect

```javascript
// Avant: Redirect manuel
window.location.href = "/logout";

// Après: Qtix gère tout
Qtix.logout(); // Auto-redirige vers /login
```

## 6. State Management

### Partager données entre composants

```javascript
// Dans une page/component
Qtix.setState("selectedUser", user);

// Dans un autre component
const user = Qtix.getState("selectedUser");

// Watch pour réactivité
Qtix.watchState("selectedUser", (newUser) => {
  console.log("User selected:", newUser);
});
```

## 7. Notifications

### Avant: toastr or custom

```javascript
// Custom toast logic
showNotification("Success message", "success");
```

### Après: Qtix notifications

```javascript
Qtix.success("Success message");
Qtix.error("Error message");
Qtix.warning("Warning message");
```

## 8. Loading States

### Avant: Manual toggle

```javascript
showSpinner();
const data = await fetch("/api/data");
hideSpinner();
```

### Après: Auto-managed

```javascript
const data = await Qtix.loadAsync(async () => {
  return await Qtix.get("/api/data");
});
// Spinner géré automatiquement
```

## 9. Error Handling

### Setup global handler

```javascript
Qtix.onError((error) => {
  console.error("Global error:", error);

  if (error.status === 401) {
    // Auto handled - redirect to login
  } else if (error.status === 403) {
    Qtix.error("Permission denied");
  }
});
```

## 10. Components Migration

### Modal Exemple

**Avant:**

```html
<div id="modal" class="hidden">
  <div class="modal-content">...</div>
</div>

<script>
  const modal = document.getElementById("modal");
  const btn = document.getElementById("btnOpen");
  btn.addEventListener("click", () => {
    modal.classList.remove("hidden");
  });
</script>
```

**Après:**

```html
<div x-data="myModal" x-show="isOpen">
  <div @click="close()">Close</div>
</div>

<script>
  import { createModal } from "/js/qtix/qtix.js";

  window.myModal = createModal({
    title: "My Modal",
    onClose: () => console.log("Closed"),
  });
</script>
```

## 11. Best Practices

### ✅ DO's

- Use `x-data` for component state
- Use Alpine directives (@click, x-show, etc.)
- Use Qtix for all API calls
- Use notifications for user feedback
- Use state for shared data
- Organize code by feature

### ❌ DON'Ts

- Manual DOM manipulation
- jQuery or other libraries
- Inline fetch calls
- Alert() for messages
- Global variables
- Mixed state management

## 12. Performance Tips

1. **Lazy load pages** - Use preload()
2. **Cache API results** - State management
3. **Debounce search** - Use helpers.debounce()
4. **Lazy components** - Load on demand
5. **Minify Qtix** - In production

## 13. Debugging

### Enable logging

```javascript
// Check Qtix state
console.log(Qtix.state.getAll());

// Check auth
console.log(Qtix.getUser());

// Check current route
console.log(Qtix.router.getCurrentRoute());

// Browser DevTools
window.Qtix; // Access from console
```

## 14. Troubleshooting

### Qtix not initialized

```javascript
// Make sure to await init
await Qtix.init();
```

### Alpine directives not working

```javascript
// Make sure Alpine is loaded before app code
import bootstrap from "/js/qtix/bootstrap.js";
```

### CSRF token missing

```html
<!-- Add to layout -->
<meta name="csrf-token" content="<?php echo csrf_token(); ?>" />
```

### API calls failing

```javascript
// Check API base URL
Qtix.getConfig().apiBaseUrl;

// Check token
Qtix.api.getToken();

// Check network tab in DevTools
```

## Checklist de Migration

- [ ] Include Alpine & Qtix scripts
- [ ] Setup containers (app, notifications, loading)
- [ ] Migrate page from vanilla JS to Alpine
- [ ] Replace fetch with Qtix API calls
- [ ] Replace alert/toast with Qtix notifications
- [ ] Setup state management if needed
- [ ] Update auth checks to use Qtix
- [ ] Register pages with page system
- [ ] Test all functionality
- [ ] Update error handling
- [ ] Document any custom logic
- [ ] Performance test
- [ ] Deploy & monitor
