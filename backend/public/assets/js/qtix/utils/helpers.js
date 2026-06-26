/**
 * Helpers Utilities - Qtix
 * Utilitaires et helpers divers
 */

/**
 * Format date
 */
export function formatDate(date, format = "DD/MM/YYYY") {
  const d = new Date(date);
  const day = String(d.getDate()).padStart(2, "0");
  const month = String(d.getMonth() + 1).padStart(2, "0");
  const year = d.getFullYear();
  const hours = String(d.getHours()).padStart(2, "0");
  const minutes = String(d.getMinutes()).padStart(2, "0");
  const seconds = String(d.getSeconds()).padStart(2, "0");

  return format
    .replace("DD", day)
    .replace("MM", month)
    .replace("YYYY", year)
    .replace("HH", hours)
    .replace("mm", minutes)
    .replace("ss", seconds);
}

/**
 * Format monnaie
 */
export function formatCurrency(amount, currency = "USD", locale = "en-US") {
  return new Intl.NumberFormat(locale, {
    style: "currency",
    currency,
  }).format(amount);
}

/**
 * Format nombre
 */
export function formatNumber(num, decimals = 2) {
  return Number(num).toFixed(decimals);
}

/**
 * Slugify
 */
export function slugify(text) {
  return text
    .toLowerCase()
    .trim()
    .replace(/[^\w\s-]/g, "")
    .replace(/\s+/g, "-")
    .replace(/-+/g, "-");
}

/**
 * Capitalize
 */
export function capitalize(text) {
  return text.charAt(0).toUpperCase() + text.slice(1);
}

/**
 * Truncate
 */
export function truncate(text, length = 50) {
  return text.length > length ? text.substring(0, length) + "..." : text;
}

/**
 * Debounce
 */
export function debounce(fn, delay = 300) {
  let timeout;
  return function (...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => fn(...args), delay);
  };
}
/**
 * get element by id
 */
export function el(id) {
  return document.getElementById(id);
}

/**
 * Throttle
 */
export function throttle(fn, delay = 300) {
  let lastCall = 0;
  return function (...args) {
    const now = Date.now();
    if (now - lastCall >= delay) {
      fn(...args);
      lastCall = now;
    }
  };
}

/**
 * Deep clone
 */
export function deepClone(obj) {
  return JSON.parse(JSON.stringify(obj));
}

/**
 * Merge objects
 */
export function merge(target, ...sources) {
  if (!sources.length) return target;
  const source = sources.shift();

  if (this.isObject(target) && this.isObject(source)) {
    for (const key in source) {
      if (this.isObject(source[key])) {
        if (!target[key]) Object.assign(target, { [key]: {} });
        this.merge(target[key], source[key]);
      } else {
        Object.assign(target, { [key]: source[key] });
      }
    }
  }

  return this.merge(target, ...sources);
}

/**
 * Check si object
 */
export function isObject(item) {
  return item && typeof item === "object" && !Array.isArray(item);
}

/**
 * Get from object par path
 */
export function getByPath(obj, path) {
  return path.split(".").reduce((current, prop) => current?.[prop], obj);
}

/**
 * Set dans object par path
 */
export function setByPath(obj, path, value) {
  const keys = path.split(".");
  const lastKey = keys.pop();
  const target = keys.reduce((current, key) => {
    if (!(key in current)) current[key] = {};
    return current[key];
  }, obj);
  target[lastKey] = value;
}

/**
 * Remove dupes from array
 */
export function removeDuplicates(arr, key = null) {
  if (key) {
    const seen = new Set();
    return arr.filter((item) => {
      const val = item[key];
      if (seen.has(val)) return false;
      seen.add(val);
      return true;
    });
  }
  return [...new Set(arr)];
}

/**
 * Query string builder
 */
export function buildQueryString(params) {
  const entries = Object.entries(params)
    .filter(
      ([, value]) => value !== null && value !== undefined && value !== "",
    )
    .map(
      ([key, value]) =>
        `${encodeURIComponent(key)}=${encodeURIComponent(value)}`,
    );
  return entries.join("&");
}

/**
 * Parse query string
 */
export function parseQueryString(qs) {
  const params = {};
  new URLSearchParams(qs).forEach((value, key) => {
    params[key] = value;
  });
  return params;
}

/**
 * Validate email
 */
export function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

/**
 * Generate UUID
 */
export function generateUUID() {
  return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function (c) {
    const r = (Math.random() * 16) | 0;
    const v = c === "x" ? r : (r & 0x3) | 0x8;
    return v.toString(16);
  });
}

/**
 * Sleep/delay
 */
export function delay(ms = 1000) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}

/**
 * Copy to clipboard
 */
export async function copyToClipboard(text) {
  try {
    await navigator.clipboard.writeText(text);
    return true;
  } catch (err) {
    console.error("Erreur copy:", err);
    return false;
  }
}

/**
 * Get color luminance
 */
export function getLuminance(color) {
  const hex = color.replace("#", "");
  const r = parseInt(hex.substring(0, 2), 16);
  const g = parseInt(hex.substring(2, 4), 16);
  const b = parseInt(hex.substring(4, 6), 16);
  return (0.299 * r + 0.587 * g + 0.114 * b) / 255;
}
