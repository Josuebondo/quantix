  <!-- Top Navigation Bar -->

  <header class="w-full top-0 sticky z-50 bg-surface-container-lowest dark:bg-inverse-surface border-b border-outline-variant dark:border-on-surface-variant/30 shadow-sm transition-all duration-300">
      <div class="flex items-center justify-between px-gutter py-unit max-w-container-max mx-auto h-20">
          <!-- Brand Logo -->
          <div class="flex items-center gap-2">
              <img alt="Quantix Logo" class="h-10 w-auto object-contain dark:brightness-200" src="<?= asset('images/quantix_logo.jpeg') ?>" />
          </div>
          <!-- Desktop Navigation Links -->
          <nav class="hidden md:flex items-center gap-8">
              <a class="text-on-surface-variant dark:text-surface-variant font-medium text-body-sm hover:text-primary dark:hover:text-primary-fixed transition-colors py-1" href="#">Solutions</a>
              <a class="text-on-surface-variant dark:text-surface-variant font-medium text-body-sm hover:text-primary dark:hover:text-primary-fixed transition-colors py-1" href="#">Pricing</a>
              <a class="text-on-surface-variant dark:text-surface-variant font-medium text-body-sm hover:text-primary dark:hover:text-primary-fixed transition-colors py-1" href="#">Resources</a>
              <a class="text-on-surface-variant dark:text-surface-variant font-medium text-body-sm hover:text-primary dark:hover:text-primary-fixed transition-colors py-1" href="#">About Us</a>
          </nav>
          <!-- Actions -->
          <div class="flex items-center gap-4">
              <!-- Theme Toggle Button -->
              <button class="p-2 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-low dark:hover:bg-on-surface-variant/20 rounded-xl transition-all active:scale-95 flex items-center justify-center" id="theme-toggle">
                  <span class="material-symbols-outlined hidden dark:block" id="theme-toggle-dark-icon">light_mode</span>
                  <span class="material-symbols-outlined dark:hidden" id="theme-toggle-light-icon">dark_mode</span>
              </button>
              <button class="hidden md:block px-4 py-2 font-medium text-body-sm text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-low dark:hover:bg-on-surface-variant/20 rounded-xl transition-all active:scale-95">
                  Login
              </button>
              <button class="px-6 py-2 font-medium text-body-sm bg-primary dark:bg-primary-fixed dark:text-on-primary-fixed rounded-xl hover:shadow-md hover:opacity-90 transition-all active:scale-95">
                  Start Free Trial
              </button>
              <!-- Mobile Menu Trigger -->
              <button class="md:hidden p-2 text-primary dark:text-primary-fixed">
                  <span class="material-symbols-outlined">menu</span>
              </button>
          </div>
      </div>
  </header>