# 🔌 API Reference Quantix

Bienvenue dans la section **API Reference**. Vous trouverez ici la documentation complète des APIs de Quantix.

## 📚 Documentation API

### 🔐 Authentification
- **[AUTH_API.md](AUTH_API.md)** - API d'authentification et autorisation

### 🏛️ Fondamentaux
- **[Requete.md](Requete.md)** - Documentation de la classe Requete
- **[Reponse.md](Reponse.md)** - Documentation de la classe Reponse
- **[Routeur.md](Routeur.md)** - Documentation du routeur

### 💾 Données
- **[Modele.md](Modele.md)** - Documentation des modèles ORM
- **[Validation.md](Validation.md)** - Règles de validation

### 🌍 Utilités
- **[Traduction.md](Traduction.md)** - Système de traduction i18n

---

## ⚡ Guide Rapide par Sujet

### 🔐 Je dois m'authentifier
1. Lire [AUTH_API.md](AUTH_API.md)
2. Implémenter l'authentification JWT
3. Tester avec les endpoints d'auth

### 📤 Je dois faire une requête
1. Voir [Requete.md](Requete.md) - Comment construire
2. Consulter les examples dans [Reponse.md](Reponse.md)

### 📥 Je dois traiter une réponse
1. Voir [Reponse.md](Reponse.md) - Structure de réponse
2. Gérer les erreurs appropriées

### 💾 Je dois manipuler les données
1. Consulter [Modele.md](Modele.md) - ORM
2. Implémenter la validation avec [Validation.md](Validation.md)

### 🌍 Je dois supporter plusieurs langues
1. Utiliser [Traduction.md](Traduction.md)
2. Mettre en place les fichiers de langue

### 🔀 Je dois setup le routage
1. Consulter [Routeur.md](Routeur.md)
2. Définir les routes dans web.php

---

## 📋 Fichiers Détaillés

### AUTH_API.md
Documentation complète de l'authentification incluant:
- 🔐 Authentification utilisateur
- 🎫 Gestion des tokens JWT
- 👤 Récupération de l'utilisateur
- 🚪 Déconnexion
- ✅ Vérification des permissions

**Endpoints couverts**:
- `/api/auth/login` - Connexion
- `/api/auth/register` - Inscription
- `/api/auth/logout` - Déconnexion
- `/api/auth/user` - Profil utilisateur

### Requete.md
Documentation de la classe Requete pour:
- 📥 Récupérer les données de requête
- 🔍 Accéder aux paramètres
- 📋 Traiter les formulaires
- 📎 Gérer les fichiers uploadés

### Reponse.md
Documentation de la classe Reponse pour:
- 📤 Retourner des données JSON
- ⚠️ Gérer les erreurs
- 🔄 Redirection
- 📄 Templates

### Modele.md
Documentation du système ORM incluant:
- 🔄 Requêtes CRUD
- 🔀 Relations entre modèles
- 🔍 Filtrage et tri
- 💾 Sauvegarde de données

### Routeur.md
Documentation du routeur pour:
- 🛣️ Définir les routes
- 🎯 Mapping contrôleur/action
- 🔗 Paramètres dynamiques
- 🛡️ Middleware

### Validation.md
Documentation du système de validation:
- ✓ Règles de validation
- 🚨 Messages d'erreur
- 🔍 Validation personnalisée
- 📊 Validation complexe

### Traduction.md
Documentation du système i18n:
- 🌍 Fichiers de langue
- 📝 Traduction de chaînes
- 🔄 Pluralisation
- 🌐 Locale courante

---

## 🔗 Flux API Complet

### Flux de Création d'Entreprise
```
1. POST /api/auth/register
   - Body: { company_name, admin_email, admin_password }
   - Response: { user_id, company_id, token }

2. GET /company/activate?token=xyz
   - Vérifier le token
   - Activer le compte

3. POST /api/wizard/init
   - Headers: { Authorization: Bearer token }
   - Response: { sessionId, status }

4. POST /api/wizard/autosave
   - Headers: { Authorization: Bearer token }
   - Body: { wizardSessionId, state, step }
   - Response: { success, lastSavedAt }

5. POST /api/wizard/deploy
   - Headers: { Authorization, X-Idempotency-Key }
   - Body: { wizardSessionId, state }
   - Response: { success, companyId }

6. GET /dashboard
   - Headers: { Authorization: Bearer token }
   - Response: Dashboard data
```

---

## 🎯 Cas d'Usage Courants

### Cas 1: Connexion Utilisateur
```javascript
POST /api/auth/login
{
  "email": "user@example.com",
  "password": "password123"
}
→ { "token": "jwt...", "user": {...} }
```
Voir: [AUTH_API.md](AUTH_API.md#login)

### Cas 2: Créer une Entreprise
```javascript
POST /api/auth/register
{
  "company_name": "Ma Société",
  "admin_email": "admin@example.com",
  "admin_password": "password123"
}
```
Voir: [AUTH_API.md](AUTH_API.md#register)

### Cas 3: Requête Authentifiée
```javascript
GET /api/wizard/resume?session=uuid
Headers: { Authorization: Bearer {token} }
```
Voir: [Requete.md](Requete.md)

### Cas 4: Validation de Données
```php
$v->ajouter('email', ['required', 'email']);
$v->ajouter('password', ['required', 'min:8']);
if (!$v->valider($data)) { /* erreurs */ }
```
Voir: [Validation.md](Validation.md)

---

## 🔗 Liens Rapides

### Documentation
- **[Retour à la doc principale](../INDEX.md)**
- **[Guides d'utilisation](../guides/)**
- **[Configuration & Setup](../setup/)**
- **[Architecture](../architecture/)**

### Ressources
- **[Postman Collection](../../Quantix_Wizard_Postman.json)** - Tests API via Postman
- **[Endpoints Complets](../ONBOARDING_SAAS_FLOW.md)** - Tous les endpoints

---

## 💡 Bonnes Pratiques

✅ **Authentification**: Toujours envoyer le token JWT  
✅ **Validation**: Valider côté serveur même après côté client  
✅ **Erreurs**: Consulter les codes HTTP et messages d'erreur  
✅ **Idempotence**: Utiliser les clés d'idempotence pour les opérations critiques  
✅ **Documentation**: Consulter les exemples fournis  

---

## 🆘 Dépannage

### "Token invalide"
→ Vérifier le header `Authorization: Bearer {token}`

### "Validation échouée"
→ Consulter [Validation.md](Validation.md) pour les règles

### "Endpoint non trouvé"
→ Vérifier le routeur dans [Routeur.md](Routeur.md)

### "Base de données introuvable"
→ Consulter [Modele.md](Modele.md) pour les relations

---

**Version**: 1.0.0 | **Statut**: Production Ready
