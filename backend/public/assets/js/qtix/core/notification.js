/**
 * Notification System - Qtix
 * Toast & error notifications
 */

class NotificationManager {
  constructor() {
    this.notifications = [];
    this.container = null;
    this.autoCloseTime = 4000;
  }

  /**
   * Initialiser le container
   */
  init(containerId = "toast-container") {
    this.container = document.getElementById(containerId);
    if (!this.container) {
      // Créer le container s'il n'existe pas
      this.container = document.createElement("div");
      this.container.id = containerId;
      this.container.className = "fixed bottom-6 right-4 z-50 space-y-2";
      document.body.appendChild(this.container);
    }
  }

  /**
   * Show success notification
   */
  success(message, options = {}) {
    return this.show(message, "success", options);
  }

  /**
   * Show error notification
   */
  error(message, options = {}) {
    return this.show(message, "error", options);
  }

  /**
   * Show warning notification
   */
  warning(message, options = {}) {
    return this.show(message, "warning", options);
  }

  /**
   * Show info notification
   */
  info(message, options = {}) {
    return this.show(message, "info", options);
  }

  /**
   * Show notification générique
   */
  show(message, type = "info", options = {}) {
    if (!this.container) {
      this.init();
    }

    const {
      duration = this.autoCloseTime,
      action = null,
      actionLabel = "Action",
    } = options;

    const id = Math.random();
    const notification = { id, message, type, duration, action };

    // Créer l'élément
    const element = this.createElement(notification, actionLabel);
    this.container.appendChild(element);
    this.notifications.push(notification);

    // Auto-close
    if (duration > 0) {
      setTimeout(() => {
        this.remove(id);
      }, duration);
    }

    return {
      id,
      dismiss: () => this.remove(id),
    };
  }

  /**
   * Créer l'élément HTML
   */
  createElement(notification, actionLabel) {
    const div = document.createElement("div");
    div.id = `notification-${notification.id}`;
    div.className = `notification notification-${notification.type}`;

    const colors = {
      success:
        "bg-green-500/20 dark:bg-green-500/10 border-green-500/30 text-green-700 dark:text-green-300",
      error:
        "bg-red-500/20 dark:bg-red-500/10 border-red-500/30 text-red-700 dark:text-red-300",
      warning:
        "bg-yellow-500/20 dark:bg-yellow-500/10 border-yellow-500/30 text-yellow-700 dark:text-yellow-300",
      info: "bg-blue-500/20 dark:bg-blue-500/10 border-blue-500/30 text-blue-700 dark:text-blue-300",
    };

    const icons = {
      success: "check_circle",
      error: "error",
      warning: "warning",
      info: "info",
    };

    div.className = `p-4 rounded-lg border backdrop-blur-sm ${colors[notification.type] || colors.info} flex items-start gap-3 min-w-80 shadow-lg animate-slideIn`;
    div.innerHTML = `
            <span class="material-symbols-outlined text-xl flex-shrink-0">${icons[notification.type]}</span>
            <div class="flex-1">
                <p class="font-medium">${notification.message}</p>
            </div>
            ${notification.action ? `<button class="text-xs font-semibold opacity-75 hover:opacity-100 transition-opacity">${actionLabel}</button>` : ""}
            <button class="text-opacity-50 hover:text-opacity-100 transition-opacity close-btn">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        `;

    // Close button
    div.querySelector(".close-btn").addEventListener("click", () => {
      this.remove(notification.id);
    });

    // Action button
    if (notification.action) {
      const actionBtn = div.querySelector("button:not(.close-btn)");
      if (actionBtn) {
        actionBtn.addEventListener("click", async () => {
          await notification.action();
          this.remove(notification.id);
        });
      }
    }

    return div;
  }

  /**
   * Remove une notification
   */
  remove(id) {
    const element = document.getElementById(`notification-${id}`);
    if (element) {
      element.remove();
    }
    this.notifications = this.notifications.filter((n) => n.id !== id);
  }

  /**
   * Clear tous les notifications
   */
  clearAll() {
    this.notifications.forEach((n) => this.remove(n.id));
  }

  /**
   * Set auto-close duration
   */
  setAutoCloseDuration(time) {
    this.autoCloseTime = time;
  }
}

export default new NotificationManager();
