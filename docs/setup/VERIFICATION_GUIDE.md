# 🚀 GUIDE DE VÉRIFICATION - SYSTÈME WIZARD COMPLET

## 📋 Fichiers de Test Créés

### 1️⃣ `test_wizard_system.php`

**Vérification rapide du système**

```bash
php test_wizard_system.php
```

✅ Vérifie:

- Existence de tous les fichiers critiques
- Présence des classes PHP
- Fonctions helpers (now, logger, uuid)
- Méthodes Requete (json, headers)
- Routes enregistrées dans web.php

---

### 2️⃣ `test_wizard_flow.sh`

**Test complet du flux avec cURL**

```bash
bash test_wizard_flow.sh
```

✅ Teste:

- Activation du compte
- Initialisation wizard
- Reprise de session
- Autosave de l'état
- Génération de SKU
- Déploiement final (IDEMPOTENT)
- Vérification idempotence

**Requirements:**

- cURL installé
- JWT token disponible
- Base de données en place

---

### 3️⃣ `Quantix_Wizard_Postman.json`

**Collection Postman pour tester via UI**

**Import dans Postman:**

1. Ouvrir Postman
2. File → Import
3. Sélectionner `Quantix_Wizard_Postman.json`
4. Configurer variables:
   - `base_url`: http://localhost:8000
   - `jwt_token`: Votre token JWT
   - `wizard_session_id`: UUID de la session
   - `idempotency_key`: UUID unique

✅ Contient 9 requêtes:

- Activation
- Initialiser Wizard
- Reprendre Session
- Autosave (Étape 1)
- Autosave (Étape 2)
- Récupérer Permissions
- Générer SKU
- Déployer Workspace
- Vérifier Idempotence

---

### 4️⃣ `TESTING_CHECKLIST.md`

**Checklist complète de validation**

Contient:

- ✅ 6 phases de vérification
- ✅ 100+ points de contrôle
- ✅ Tests manuels détaillés
- ✅ Tests d'erreurs et edge cases
- ✅ Tests de performance
- ✅ Vérifications database

---

## 🎯 FLUX DE TEST RECOMMANDÉ

### **ÉTAPE 1: Vérification Rapide (5 min)**

```bash
# Vérifier que tous les fichiers sont en place
php test_wizard_system.php

# Résultat attendu:
# ✅ 7/7 fichiers critiques présents
# ✅ Routes enregistrées dans web.php
```

### **ÉTAPE 2: Tester l'API avec Postman (20 min)**

```
1. Importer Quantix_Wizard_Postman.json
2. Configurer les variables (base_url, jwt_token)
3. Exécuter dans l'ordre:
   - Activation
   - Initialiser Wizard
   - Reprendre Session
   - Autosave (2x)
   - Récupérer Permissions
   - Générer SKU
   - Déployer Workspace
   - Vérifier Idempotence (même key 2x)

✅ Attendu:
   - Code 200/201 pour chaque requête
   - sessionId retourné depuis /init
   - État restauré depuis /resume
   - companyId retourné depuis /deploy
   - Même companyId pour 2e deploy (idempotence)
```

### **ÉTAPE 3: Test du Flux Complet (30 min)**

```bash
# Avec JWT token et email d'activation valide:
bash test_wizard_flow.sh

✅ Attendu:
   - Token activation valide → User activé
   - Wizard init → sessionId retourné
   - Autosave → État fusionné
   - Deploy → Company créée
   - Deploy 2x → Même résultat (idempotent)
```

### **ÉTAPE 4: Vérifier la Base de Données**

```sql
-- Vérifier tables créées
SHOW TABLES LIKE 'wizard_%';
-- Attendu: wizard_sessions, activation_tokens

-- Vérifier columns ajoutées
DESCRIBE users;
-- Attendu: wizard_session_id, activation_status, activated_at

-- Vérifier données après deploy
SELECT * FROM wizard_sessions WHERE status='deployed';
SELECT * FROM company WHERE wizard_session_id IS NOT NULL;

-- Vérifier idempotency
SELECT idempotency_key, deployment_metadata FROM wizard_sessions
WHERE deployment_metadata LIKE '%company_id%';
-- Attendu: Un seul deployment par idempotency_key
```

### **ÉTAPE 5: Valider Spécifiquement**

```
✅ Debounce Autosave (1500ms):
   - Envoyer 5 autosave rapidement
   - Vérifier que only 1-2 requêtes arrivent au serveur

✅ Idempotency Key:
   - Deploy avec key "abc123"
   - Deploy 2e fois avec clé "abc123"
   - Vérifier companyId identique

✅ Resume Session:
   - Créer session
   - Actualiser page
   - Vérifier état restauré sans perte

✅ Dirty Fields:
   - Modifier 2 champs
   - Autosave
   - Vérifier que seulement ces 2 champs sont envoyés
```

---

## 🔍 POINTS DE VÉRIFICATION CRITIQUES

### Architecture ✅

- [x] CompanyController avec 10 endpoints
- [x] WizardService avec 4 méthodes principales
- [x] WizardSession model avec ORM
- [x] Routes enregistrées dans web.php
- [x] Helpers global (now, logger, uuid)

### API ✅

- [x] Requete::json() parse le body
- [x] Requete::headers() extrait headers
- [x] Endpoints acceptent JSON
- [x] Réponses JSON valides
- [x] Middleware MiddlewareAuth appliqué

### État ✅

- [x] wizardSession (UUID + statut)
- [x] wizardDraftState (11 champs)
- [x] uiState (isDirty, isSaving)
- [x] dirtyFields Set (tracking)
- [x] Debounce 1500ms effectif

### Persistance ✅

- [x] wizard_sessions table
- [x] activation_tokens table
- [x] users.wizard_session_id
- [x] company.setup_completed_at
- [x] last_saved_at tracking

### Sécurité ✅

- [x] JWT authentication
- [x] Idempotency key required
- [x] CSRF token en place
- [x] Validation input
- [x] Middleware auth sur routes

---

## 🎓 EXEMPLES DE REQUÊTES

### Activation

```bash
curl -X POST http://localhost:8000/api/company/activate \
  -H "Content-Type: application/json" \
  -d '{"token":"JWT_TOKEN"}'
```

### Initialiser Wizard

```bash
curl -X POST http://localhost:8000/api/wizard/init \
  -H "Authorization: Bearer JWT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{}'
```

### Autosave

```bash
curl -X POST http://localhost:8000/api/wizard/autosave \
  -H "Authorization: Bearer JWT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "wizardSessionId": "uuid-here",
    "state": {"workspaceName": "Test"},
    "step": 1,
    "dirtyFields": ["workspaceName"]
  }'
```

### Deploy (Idempotent)

```bash
curl -X POST http://localhost:8000/api/wizard/deploy \
  -H "Authorization: Bearer JWT_TOKEN" \
  -H "X-Idempotency-Key: unique-key-123" \
  -H "Content-Type: application/json" \
  -d '{
    "wizardSessionId": "uuid-here",
    "state": {...complete state...}
  }'
```

---

## 📊 SUCCÈS ATTENDU

### Après les tests, vous devriez voir:

✅ **Activation:**

- Email reçu avec lien activation
- Lien valide et fonctionnel
- Redirect /welcome après activation
- Page affiche user info et company

✅ **Wizard Initialization:**

- Session créée dans DB (UUID unique)
- Statut = 'draft'
- État initial préchargé
- Page affiche formulaire complet

✅ **State Management:**

- Autosave déclenché toutes les 1500ms
- Only dirty fields envoyés
- last_saved_at updaté
- State fusionné correctement

✅ **Deployment:**

- Company créée après deploy
- Session marquée 'deployed'
- deployed_at enregistré
- Redirect /dashboard avec companySlug

✅ **Idempotency:**

- Deploy 2x = Même companyId
- Pas de duplicate companies
- idempotency_key unique dans DB

---

## 🆘 TROUBLESHOOTING

### "Helpers functions not found"

→ Vérifier que core/Helpers.php est inclus dans l'autoloader

### "Class not found: App\Controleurs\CompanyController"

→ Vérifier namespace et use statements

### "Method json() not found on Requete"

→ Vérifier que les méthodes sont ajoutées à core/Requete.php

### "JWT token invalid"

→ Vérifier que token n'est pas expiré et signature correcte

### "Idempotency key not working"

→ Vérifier que X-Idempotency-Key header est en lowercase

### "Autosave trop lent"

→ Vérifier que debounce est implémenté (1500ms)

---

## ✨ CONCLUSION

Tous les fichiers et la logique sont en place.
Les 3 outils de test fournis permettent de vérifier:

1. ✅ **Rapidement** - test_wizard_system.php (5 min)
2. ✅ **Complètement** - Postman Collection (20 min)
3. ✅ **En détail** - Manual checklist (30 min)

Le système est **prêt pour la production** une fois les tests passés! 🚀
