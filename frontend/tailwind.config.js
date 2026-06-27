/** @type {import('tailwindcss').Config} */
import forms from "@tailwindcss/forms";
import containerQueries from "@tailwindcss/container-queries";

export default {
  darkMode: "class",
  content: ["./index.html", "./src/**/*.{js,jsx,ts,tsx}"],
  theme: {
    extend: {
      colors: {
        surface: "rgb(var(--surface) / <alpha-value>)",
        "primary-fixed-dim": "rgb(var(--primary-fixed-dim) / <alpha-value>)",
        "primary-container": "rgb(var(--primary-container) / <alpha-value>)",
        "secondary-fixed-dim":
          "rgb(var(--secondary-fixed-dim) / <alpha-value>)",
        "surface-container": "rgb(var(--surface-container) / <alpha-value>)",
        "on-primary-container":
          "rgb(var(--on-primary-container) / <alpha-value>)",
        "on-surface": "rgb(var(--on-surface) / <alpha-value>)",
        "on-secondary-fixed-variant":
          "rgb(var(--on-secondary-fixed-variant) / <alpha-value>)",
        "on-tertiary-fixed-variant":
          "rgb(var(--on-tertiary-fixed-variant) / <alpha-value>)",
        error: "rgb(var(--error) / <alpha-value>)",
        "surface-tint": "rgb(var(--surface-tint) / <alpha-value>)",
        primary: "rgb(var(--primary) / <alpha-value>)",
        "on-primary": "rgb(var(--on-primary) / <alpha-value>)",
        "on-error": "rgb(var(--on-error) / <alpha-value>)",
        "inverse-surface": "rgb(var(--inverse-surface) / <alpha-value>)",
        "surface-container-lowest":
          "rgb(var(--surface-container-lowest) / <alpha-value>)",
        "error-container": "rgb(var(--error-container) / <alpha-value>)",
        "secondary-container":
          "rgb(var(--secondary-container) / <alpha-value>)",
        "on-secondary": "rgb(var(--on-secondary) / <alpha-value>)",
        "tertiary-fixed-dim": "rgb(var(--tertiary-fixed-dim) / <alpha-value>)",
        background: "rgb(var(--background) / <alpha-value>)",
        "tertiary-fixed": "rgb(var(--tertiary-fixed) / <alpha-value>)",
        outline: "rgb(var(--outline) / <alpha-value>)",
        "primary-fixed": "rgb(var(--primary-fixed) / <alpha-value>)",
        "on-tertiary": "rgb(var(--on-tertiary) / <alpha-value>)",
        "surface-container-low":
          "rgb(var(--surface-container-low) / <alpha-value>)",
        "surface-container-highest":
          "rgb(var(--surface-container-highest) / <alpha-value>)",
        tertiary: "rgb(var(--tertiary) / <alpha-value>)",
        "on-surface-variant": "rgb(var(--on-surface-variant) / <alpha-value>)",
        "on-error-container": "rgb(var(--on-error-container) / <alpha-value>)",
        "on-background": "rgb(var(--on-background) / <alpha-value>)",
        "on-tertiary-container":
          "rgb(var(--on-tertiary-container) / <alpha-value>)",
        "secondary-fixed": "rgb(var(--secondary-fixed) / <alpha-value>)",
        "outline-variant": "rgb(var(--outline-variant) / <alpha-value>)",
        "on-primary-fixed": "rgb(var(--on-primary-fixed) / <alpha-value>)",
        "surface-bright": "rgb(var(--surface-bright) / <alpha-value>)",
        "inverse-on-surface": "rgb(var(--inverse-on-surface) / <alpha-value>)",
        "tertiary-container": "rgb(var(--tertiary-container) / <alpha-value>)",
        "surface-container-high":
          "rgb(var(--surface-container-high) / <alpha-value>)",
        secondary: "rgb(var(--secondary) / <alpha-value>)",
        "inverse-primary": "rgb(var(--inverse-primary) / <alpha-value>)",
        "on-tertiary-fixed": "rgb(var(--on-tertiary-fixed) / <alpha-value>)",
        "on-primary-fixed-variant":
          "rgb(var(--on-primary-fixed-variant) / <alpha-value>)",
        "surface-variant": "rgb(var(--surface-variant) / <alpha-value>)",
        "on-secondary-fixed": "rgb(var(--on-secondary-fixed) / <alpha-value>)",
        "surface-dim": "rgb(var(--surface-dim) / <alpha-value>)",
        "on-secondary-container":
          "rgb(var(--on-secondary-container) / <alpha-value>)",
        "background-dark": "rgb(var(--background-dark) / <alpha-value>)",
        "surface-dark": "rgb(var(--surface-dark) / <alpha-value>)",
        "surface-light": "rgb(var(--surface-light) / <alpha-value>)",
        "surface-container-lowest-alt":
          "rgb(var(--surface-container-lowest-alt) / <alpha-value>)",
        "border-dark": "rgb(var(--border-dark) / <alpha-value>)",
        "border-light": "rgb(var(--border-light) / <alpha-value>)",
        success: "rgb(var(--success) / <alpha-value>)",
        danger: "rgb(var(--danger) / <alpha-value>)",
        "red-accent": "rgb(var(--red-accent) / <alpha-value>)",
        "emerald-accent": "rgb(var(--emerald-accent) / <alpha-value>)",
        "emerald-custom": "rgb(var(--emerald-custom) / <alpha-value>)",
        "text-dark": "rgb(var(--text-dark) / <alpha-value>)",
        "text-light": "rgb(var(--text-light) / <alpha-value>)",
      },
      fontFamily: {
        "label-sm": ["JetBrains Mono"],
        "headline-lg": ["Hanken Grotesk"],
        "body-md": ["Inter"],
        "headline-md": ["Hanken Grotesk"],
        "display-xl": ["Hanken Grotesk"],
        "body-lg": ["Inter"],
        "display-xl-mobile": ["Hanken Grotesk"],
        display: ["Manrope", "sans-serif"],
      },
      fontSize: {
        "label-sm": [
          "13px",
          { lineHeight: "16px", letterSpacing: "0.05em", fontWeight: "500" },
        ],
        "headline-lg": [
          "48px",
          { lineHeight: "56px", letterSpacing: "-0.02em", fontWeight: "600" },
        ],
        "body-md": ["16px", { lineHeight: "24px", fontWeight: "400" }],
        "headline-md": [
          "32px",
          { lineHeight: "40px", letterSpacing: "-0.01em", fontWeight: "600" },
        ],
        "display-xl": [
          "72px",
          { lineHeight: "80px", letterSpacing: "-0.04em", fontWeight: "700" },
        ],
        "body-lg": ["18px", { lineHeight: "28px", fontWeight: "400" }],
        "display-xl-mobile": [
          "40px",
          { lineHeight: "48px", letterSpacing: "-0.02em", fontWeight: "700" },
        ],
      },
      borderRadius: {
        DEFAULT: "0.25rem",
        lg: "0.5rem",
        xl: "0.75rem",
        full: "9999px",
      },
      spacing: {
        unit: "4px",
        "stack-lg": "64px",
        "container-max": "1280px",
        "stack-sm": "16px",
        "stack-xl": "128px",
        "margin-mobile": "20px",
        "stack-md": "32px",
        gutter: "24px",
      },
    },
  },
  plugins: [forms, containerQueries],
};
