/** @type {import('tailwindcss').Config} */
export default {
  darkMode: "class",

  content: [
    "./app/Vues/**/*.{php,js}",
    "./public/**/*.{js,css}",
    "./input.css",
  ],

  theme: {
    extend: {
      colors: {
        primary: "rgb(var(--color-primary) / <alpha-value>)",
        "primary-container":
          "rgb(var(--color-primary-container) / <alpha-value>)",
        "primary-fixed": "rgb(var(--color-primary-fixed) / <alpha-value>)",
        "primary-fixed-dim":
          "rgb(var(--color-primary-fixed-dim) / <alpha-value>)",
        "primary-dark": "rgb(var(--color-primary-dark) / <alpha-value>)",

        secondary: "rgb(var(--color-secondary) / <alpha-value>)",
        "secondary-container":
          "rgb(var(--color-secondary-container) / <alpha-value>)",
        "secondary-fixed": "rgb(var(--color-secondary-fixed) / <alpha-value>)",
        "secondary-fixed-dim":
          "rgb(var(--color-secondary-fixed-dim) / <alpha-value>)",

        tertiary: "rgb(var(--color-tertiary) / <alpha-value>)",
        "tertiary-container":
          "rgb(var(--color-tertiary-container) / <alpha-value>)",
        "tertiary-fixed": "rgb(var(--color-tertiary-fixed) / <alpha-value>)",
        "tertiary-fixed-dim":
          "rgb(var(--color-tertiary-fixed-dim) / <alpha-value>)",

        background: "rgb(var(--color-background) / <alpha-value>)",
        surface: "rgb(var(--color-surface) / <alpha-value>)",
        "surface-dim": "rgb(var(--color-surface-dim) / <alpha-value>)",
        "surface-bright": "rgb(var(--color-surface-bright) / <alpha-value>)",
        "surface-container":
          "rgb(var(--color-surface-container) / <alpha-value>)",
        "surface-container-low":
          "rgb(var(--color-surface-container-low) / <alpha-value>)",
        "surface-container-high":
          "rgb(var(--color-surface-container-high) / <alpha-value>)",
        "surface-container-highest":
          "rgb(var(--color-surface-container-highest) / <alpha-value>)",
        "surface-container-lowest":
          "rgb(var(--color-surface-container-lowest) / <alpha-value>)",
        "surface-variant": "rgb(var(--color-surface-variant) / <alpha-value>)",

        "on-primary": "rgb(var(--color-on-primary) / <alpha-value>)",
        "on-secondary": "rgb(var(--color-on-secondary) / <alpha-value>)",
        "on-tertiary": "rgb(var(--color-on-tertiary) / <alpha-value>)",
        "on-surface": "rgb(var(--color-on-surface) / <alpha-value>)",
        "on-background": "rgb(var(--color-on-background) / <alpha-value>)",
        "on-surface-variant":
          "rgb(var(--color-on-surface-variant) / <alpha-value>)",

        outline: "rgb(var(--color-outline) / <alpha-value>)",
        "outline-variant": "rgb(var(--color-outline-variant) / <alpha-value>)",

        error: "rgb(var(--color-error) / <alpha-value>)",
        "error-container": "rgb(var(--color-error-container) / <alpha-value>)",
        success: "rgb(var(--color-success) / <alpha-value>)",
        danger: "rgb(var(--color-danger) / <alpha-value>)",

        "red-accent": "rgb(var(--color-red-accent) / <alpha-value>)",
        "emerald-accent": "rgb(var(--color-emerald-accent) / <alpha-value>)",
        "emerald-custom": "rgb(var(--color-emerald-custom) / <alpha-value>)",

        "text-light": "rgb(var(--color-text-light) / <alpha-value>)",
        "text-dark": "rgb(var(--color-text-dark) / <alpha-value>)",

        "border-light": "rgb(var(--color-border-light) / <alpha-value>)",
        "border-dark": "rgb(var(--color-border-dark) / <alpha-value>)",
      },

      fontFamily: {
        "display-lg": ["Hanken Grotesk", "sans-serif"],
        "title-md": ["Hanken Grotesk", "sans-serif"],
        "body-sm": ["Inter", "sans-serif"],
        "headline-lg": ["Hanken Grotesk", "sans-serif"],
        "headline-lg-mobile": ["Hanken Grotesk", "sans-serif"],
        "label-mono": ["JetBrains Mono", "monospace"],
        "body-md": ["Inter", "sans-serif"],
        display: ["Manrope", "sans-serif"],
      },

      fontSize: {
        "display-lg": [
          "48px",
          {
            lineHeight: "56px",
            letterSpacing: "-0.02em",
            fontWeight: "700",
          },
        ],
        "title-md": [
          "20px",
          {
            lineHeight: "28px",
            fontWeight: "600",
          },
        ],
        "body-sm": [
          "14px",
          {
            lineHeight: "20px",
            fontWeight: "400",
          },
        ],
        "headline-lg": [
          "32px",
          {
            lineHeight: "40px",
            fontWeight: "600",
          },
        ],
        "headline-lg-mobile": [
          "24px",
          {
            lineHeight: "32px",
            fontWeight: "600",
          },
        ],
        "label-mono": [
          "12px",
          {
            lineHeight: "16px",
            letterSpacing: "0.05em",
            fontWeight: "500",
          },
        ],
        "body-md": [
          "16px",
          {
            lineHeight: "24px",
            fontWeight: "400",
          },
        ],
      },

      borderRadius: {
        DEFAULT: "0.125rem",
        lg: "0.25rem",
        xl: "0.5rem",
        full: "0.75rem",
      },

      spacing: {
        gutter: "24px",
        "container-max": "1440px",
        "margin-mobile": "16px",
        "margin-desktop": "40px",
        unit: "4px",
      },
    },
  },

  plugins: [
    require("@tailwindcss/forms"),
    require("@tailwindcss/container-queries"),
  ],
};
