# Changelog

Tous les changements importants dans Qtix sont documentés dans ce fichier.

## [1.0.0] - 2026-06-10

### 🎉 Initial Release

**Core Features:**

- ✨ **App Core** - Main Qtix instance with initialization
- ✨ **API Wrapper** - Fetch with auto CSRF/token injection
- ✨ **Auth System** - Login, logout, token management
- ✨ **State Management** - Simple reactive store
- ✨ **Router** - SPA navigation without page reload
- ✨ **Notification System** - Toast notifications
- ✨ **Error Boundary** - Global error handling
- ✨ **Page System** - BMVC-like page organization
- ✨ **Components** - Modal, Table, Form
- ✨ **Utils** - Helpers, Storage, Loading manager

**Documentation:**

- 📖 README.md - Getting started
- 📖 API_REFERENCE.md - Complete API documentation
- 📖 INTEGRATION_GUIDE.md - Migration guide for existing apps
- 📖 EXAMPLES.md - Usage examples
- 📖 BASE_LAYOUT.html - HTML template example

**Features:**

- ✅ Alpine.js 3.x integration
- ✅ CSRF token auto-injection
- ✅ Bearer token auth
- ✅ Reactive state binding
- ✅ Route guards (auth, roles)
- ✅ Component lifecycle
- ✅ Error boundaries
- ✅ Loading manager
- ✅ Storage persistence
- ✅ Date/Currency formatting
- ✅ Debounce/Throttle utilities
- ✅ Form validation
- ✅ Table sorting/pagination/search

### 📦 Structure

```
qtix/
├── core/
│   ├── app.js
│   ├── api.js
│   ├── auth.js
│   ├── state.js
│   ├── router.js
│   ├── notification.js
│   └── error.js
├── page/
│   └── page.js
├── components/
│   ├── modal.js
│   ├── table.js
│   └── form.js
├── utils/
│   ├── helpers.js
│   ├── storage.js
│   ├── loading.js
│   └── index.js
├── qtix.js
├── bootstrap.js
├── README.md
├── API_REFERENCE.md
├── INTEGRATION_GUIDE.md
├── EXAMPLES.md
├── BASE_LAYOUT.html
└── package.json
```

### 🐛 Known Issues

- None at this time

### 🔄 Migration from Vanilla JS

See [INTEGRATION_GUIDE.md](INTEGRATION_GUIDE.md) for detailed migration steps.

### 📋 Quick Links

- [Documentation](README.md)
- [API Reference](API_REFERENCE.md)
- [Integration Guide](INTEGRATION_GUIDE.md)
- [Examples](EXAMPLES.md)
- [GitHub](https://github.com/quantix-saas/qtix)

---

## Future Roadmap

### [1.1.0] - Planned

- [ ] Advanced form validation rules
- [ ] File upload component
- [ ] DataGrid component
- [ ] i18n support
- [ ] Dark mode persistence
- [ ] PWA support
- [ ] WebSocket integration
- [ ] Offline support

### [1.2.0] - Planned

- [ ] ORM-like data models
- [ ] Query builder
- [ ] Middleware support
- [ ] Plugin system
- [ ] Testing utilities
- [ ] Performance monitoring
- [ ] Analytics integration

### [2.0.0] - Vision

- [ ] Vue 3 integration
- [ ] React hooks
- [ ] Svelte stores
- [ ] Full-stack framework
- [ ] TypeScript rewrite
- [ ] GraphQL support

---

## Contributors

- Quantix Team

## License

MIT - See LICENSE file
