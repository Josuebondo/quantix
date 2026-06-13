<?php \Core\Vue::extends('layouts.app'); ?>
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