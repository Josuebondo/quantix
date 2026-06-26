/**
 * Dark Mode Toggle Component
 * Gère le basculement entre les modes clair et sombre
 */
export function darkModeToggle() {
    return {
        isDark: false,
        
        init() {
            // Vérifier la préférence sauvegardée ou la préférence système
            const savedMode = localStorage.getItem('darkMode');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            this.isDark = savedMode === 'true' || (savedMode === null && systemDark);
            this.updateTheme();
        },
        
        toggle() {
            this.isDark = !this.isDark;
            this.updateTheme();
            localStorage.setItem('darkMode', this.isDark);
        },
        
        updateTheme() {
            const html = document.documentElement;
            
            if (this.isDark) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        },
        
        get icon() {
            return this.isDark ? 'light_mode' : 'dark_mode';
        }
    };
}
