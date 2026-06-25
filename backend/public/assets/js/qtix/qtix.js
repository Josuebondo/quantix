/**
 * Qtix - Main Entry Point
 * Framework frontend léger pour Quantix SaaS
 */

// Core
export { default as app } from "./core/app.js";
export { default as api } from "./core/api.js";
export { default as auth } from "./core/auth.js";
export { default as state } from "./core/state.js";
export { default as router } from "./core/router.js";
export { default as notification } from "./core/notification.js";
export { default as error } from "./core/error.js";

// Page System
export { default as page } from "./page/page.js";

// Components
export { createModal } from "./components/modal.js";
export { createTable, renderTable } from "./components/table.js";
export { createForm, renderForm, renderFormField } from "./components/form.js";

// Utils
export * as helpers from "./utils/helpers.js";
export { localStorage, sessionStorage } from "./utils/storage.js";
export { default as loading } from "./utils/loading.js";

// Main app instance - ready to use
import app from "./core/app.js";
export default app;

// Version
export const VERSION = "1.0.0";

// Convenience init
export async function initQtix(config = {}) {
  return app.init(config);
}
