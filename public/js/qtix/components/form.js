/**
 * Form Component - Qtix
 * Composant formulaire avec validation
 */

export function createForm(options = {}) {
  return {
    fields: options.fields || {},
    values: {},
    errors: {},
    touched: {},
    isSubmitting: false,
    submitted: false,

    init() {
      // Initialiser values depuis fields
      Object.keys(this.fields).forEach((name) => {
        this.values[name] = this.fields[name].value || "";
      });
    },

    setValue(name, value) {
      this.values[name] = value;
      this.touched[name] = true;
      this.validateField(name);
    },

    getValue(name) {
      return this.values[name];
    },

    validateField(name) {
      const field = this.fields[name];
      if (!field) return true;

      const value = this.values[name];
      const rules = field.rules || [];
      const errors = [];

      for (const rule of rules) {
        if (typeof rule === "function") {
          const error = rule(value);
          if (error) errors.push(error);
        } else if (rule === "required" && !value) {
          errors.push(`${field.label} est requis`);
        } else if (
          rule === "email" &&
          value &&
          !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
        ) {
          errors.push(`${field.label} doit être valide`);
        } else if (rule.startsWith("min:")) {
          const min = parseInt(rule.split(":")[1]);
          if (value.length < min) {
            errors.push(
              `${field.label} doit contenir au moins ${min} caractères`,
            );
          }
        } else if (rule.startsWith("max:")) {
          const max = parseInt(rule.split(":")[1]);
          if (value.length > max) {
            errors.push(
              `${field.label} doit contenir au maximum ${max} caractères`,
            );
          }
        }
      }

      this.errors[name] = errors.length > 0 ? errors : null;
      return !errors.length;
    },

    validateAll() {
      let isValid = true;
      Object.keys(this.fields).forEach((name) => {
        if (!this.validateField(name)) {
          isValid = false;
        }
        this.touched[name] = true;
      });
      return isValid;
    },

    hasError(name) {
      return (
        this.touched[name] && this.errors[name] && this.errors[name].length > 0
      );
    },

    getErrors(name) {
      return this.hasError(name) ? this.errors[name] : [];
    },

    async submit() {
      if (!this.validateAll()) {
        return false;
      }

      this.isSubmitting = true;
      this.submitted = true;

      try {
        if (options.onSubmit) {
          await options.onSubmit(this.values);
        }
        return true;
      } catch (error) {
        console.error("Form submit error:", error);
        return false;
      } finally {
        this.isSubmitting = false;
      }
    },

    reset() {
      this.values = {};
      this.errors = {};
      this.touched = {};
      this.submitted = false;

      Object.keys(this.fields).forEach((name) => {
        this.values[name] = this.fields[name].value || "";
      });
    },

    setErrors(fieldErrors) {
      this.errors = fieldErrors;
      Object.keys(fieldErrors).forEach((name) => {
        this.touched[name] = true;
      });
    },
  };
}

/**
 * HTML Template pour Form Field
 */
export function renderFormField(field) {
  const types = {
    text: "text",
    email: "email",
    password: "password",
    number: "number",
    date: "date",
    textarea: "textarea",
    select: "select",
  };

  const inputType = types[field.type] || "text";

  return `
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                ${field.label}
                ${field.rules?.includes("required") ? '<span class="text-red-500">*</span>' : ""}
            </label>
            
            ${
              inputType === "textarea"
                ? `
                <textarea
                    name="${field.name}"
                    placeholder="${field.placeholder || ""}"
                    @input="setValue('${field.name}', $event.target.value)"
                    :value="values['${field.name}']"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white"
                    rows="${field.rows || 4}"
                ></textarea>
            `
                : inputType === "select"
                  ? `
                <select
                    name="${field.name}"
                    @change="setValue('${field.name}', $event.target.value)"
                    :value="values['${field.name}']"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white"
                >
                    <option value="">-- Sélectionner --</option>
                    ${(field.options || [])
                      .map(
                        (opt) => `
                        <option value="${opt.value}">${opt.label}</option>
                    `,
                      )
                      .join("")}
                </select>
            `
                  : `
                <input
                    type="${inputType}"
                    name="${field.name}"
                    placeholder="${field.placeholder || ""}"
                    @input="setValue('${field.name}', $event.target.value)"
                    :value="values['${field.name}']"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white"
                />
            `
            }
            
            <div x-show="hasError('${field.name}')" class="mt-1">
                <template x-for="error in getErrors('${field.name}')" :key="error">
                    <p class="text-sm text-red-600 dark:text-red-400" x-text="error"></p>
                </template>
            </div>
        </div>
    `;
}

/**
 * HTML Template pour Form
 */
export function renderForm(config) {
  const { id, title, fields } = config;
  return `
        <form id="${id}" x-data="${id}" @submit.prevent="submit()" class="w-full max-w-lg">
            ${title ? `<h2 class="text-lg font-bold mb-6">${title}</h2>` : ""}
            
            <div class="space-y-4">
                ${Object.values(fields)
                  .map((field) => renderFormField(field))
                  .join("")}
            </div>
            
            <div class="mt-6 flex gap-3">
                <button 
                    type="submit"
                    :disabled="isSubmitting"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50"
                >
                    <span x-show="!isSubmitting">Soumettre</span>
                    <span x-show="isSubmitting">Envoi...</span>
                </button>
                <button 
                    type="button"
                    @click="reset()"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
                >
                    Réinitialiser
                </button>
            </div>
        </form>
    `;
}
