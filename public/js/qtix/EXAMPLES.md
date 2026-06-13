/\*\*

- Exemple d'utilisation de Qtix avec team.php
- Démontre l'intégration complète
  \*/

import Qtix, {
createModal,
createTable,
createForm,
helpers
} from '/js/qtix/qtix.js';

// ============== Initialisation ==============

await Qtix.init({
apiBaseUrl: '/api',
appContainer: 'app',
initialState: {
users: [],
invitations: [],
roles: []
}
});

// ============== Enregistrer Pages ==============

// Dashboard Team Page
Qtix.registerPage('team', {
url: '/api/company/team',
route: '/company/team',

template(data) {
return `
<main x-data="teamPage" x-init="init()">
<!-- Tabs -->
<div class="flex gap-8 mb-8 border-b">
<button
@click="activeTab = 'users'"
:class="activeTab === 'users' ? 'border-b-2 border-primary font-bold' : ''" >
👥 Utilisateurs
</button>
<button
@click="activeTab = 'invitations'"
:class="activeTab === 'invitations' ? 'border-b-2 border-primary font-bold' : ''" >
✉️ Invitations
</button>
<button
@click="activeTab = 'roles'"
:class="activeTab === 'roles' ? 'border-b-2 border-primary font-bold' : ''" >
🔐 Rôles
</button>
</div>

        <!-- Tab: Users -->
        <div x-show="activeTab === 'users'">
          <button @click="openInviteModal()" class="mb-4 px-4 py-2 bg-primary text-white rounded">
            + Inviter
          </button>
          <div x-data="usersTable">
            <!-- Table template here -->
          </div>
        </div>

        <!-- Tab: Invitations -->
        <div x-show="activeTab === 'invitations'">
          <div x-data="invitationsTable">
            <!-- Table template here -->
          </div>
        </div>

        <!-- Tab: Roles -->
        <div x-show="activeTab === 'roles'">
          <button @click="openRoleModal()" class="mb-4 px-4 py-2 bg-primary text-white rounded">
            + Créer Rôle
          </button>
          <div x-data="rolesTable">
            <!-- Table template here -->
          </div>
        </div>

        <!-- Modal Invitation -->
        <div x-data="invitationModal">
          <!-- Modal template here -->
        </div>

        <!-- Modal Role -->
        <div x-data="roleModal">
          <!-- Modal template here -->
        </div>
      </main>
    `;

},

methods: {
activeTab: 'users',

    async init() {
      const data = await Qtix.get('/api/company/team');
      Qtix.updateState({
        users: data.users,
        invitations: data.invitations,
        roles: data.roles
      });
    },

    openInviteModal() {
      // ...
    },

    openRoleModal() {
      // ...
    },

    async inviteUser(email) {
      const result = await Qtix.post('/api/company/team/invite', {
        email,
        role: 'member'
      });

      if (result.success) {
        Qtix.success('Invitation envoyée');
        Qtix.reload();
      }
    },

    async removeUser(userId) {
      const result = await Qtix.delete(`/api/company/team/users/${userId}`);

      if (result.success) {
        Qtix.success('Utilisateur supprimé');
        Qtix.reload();
      }
    }

}
});

// ============== Users Table ==============

const usersTable = createTable({
items: Qtix.getState('users'),
columns: [
{ key: 'name', label: 'Nom' },
{ key: 'email', label: 'Email' },
{ key: 'role', label: 'Rôle' },
{ key: 'status', label: 'Statut' },
{ key: 'lastLogin', label: 'Dernière connexion' }
],
itemsPerPage: 10
});

// Subscribe to state changes
Qtix.watchState('users', (newUsers) => {
usersTable.items = newUsers;
});

// ============== Invitations Table ==============

const invitationsTable = createTable({
items: Qtix.getState('invitations'),
columns: [
{ key: 'email', label: 'Email' },
{ key: 'role', label: 'Rôle' },
{ key: 'sentDate', label: 'Envoyée' },
{ key: 'status', label: 'Statut' }
]
});

Qtix.watchState('invitations', (newInvitations) => {
invitationsTable.items = newInvitations;
});

// ============== Invitation Modal ==============

const invitationModal = createModal({
title: 'Inviter un utilisateur',
size: 'md',
onClose: () => {
invitationForm.reset();
}
});

const invitationForm = createForm({
fields: {
email: {
label: 'Email',
type: 'email',
rules: ['required', 'email'],
placeholder: 'email@example.com'
},
role: {
label: 'Rôle',
type: 'select',
rules: ['required'],
options: [
{ value: 'admin', label: 'Administrateur' },
{ value: 'member', label: 'Membre' },
{ value: 'viewer', label: 'Lecteur' }
]
},
message: {
label: 'Message (optionnel)',
type: 'textarea',
rows: 3,
placeholder: 'Message personnalisé...'
}
},

onSubmit: async (values) => {
await Qtix.post('/api/company/team/invite', values);
Qtix.success('Invitation envoyée avec succès');
invitationModal.close();
Qtix.reload();
}
});

// ============== Role Modal ==============

const roleModal = createModal({
title: 'Créer un rôle',
size: 'lg'
});

const roleForm = createForm({
fields: {
name: {
label: 'Nom du rôle',
type: 'text',
rules: ['required', 'min:3'],
placeholder: 'Ex: Superviseur Stock'
},
description: {
label: 'Description',
type: 'textarea',
rows: 3,
placeholder: 'Description du rôle...'
},
permissions: {
label: 'Permissions',
type: 'checkbox-group',
options: [
{ value: 'create_user', label: 'Créer utilisateurs' },
{ value: 'edit_user', label: 'Modifier utilisateurs' },
{ value: 'delete_user', label: 'Supprimer utilisateurs' },
{ value: 'view_reports', label: 'Voir rapports' }
]
}
},

onSubmit: async (values) => {
await Qtix.post('/api/company/team/roles', values);
Qtix.success('Rôle créé');
roleModal.close();
Qtix.reload();
}
});

// ============== Routes ==============

// Navigate to team page
Qtix.navigate('/company/team');

// Or use page system
Qtix.goToPage('team');

// ============== Export for Alpine ==============

window.teamPage = {
activeTab: 'users',
init() {
const data = Qtix.getState('users'); // From initialized state
}
};

window.usersTable = usersTable;
window.invitationsTable = invitationsTable;
window.invitationModal = invitationModal;
window.invitationForm = invitationForm;
window.roleModal = roleModal;
window.roleForm = roleForm;
