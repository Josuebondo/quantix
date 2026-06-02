# Documentation API Authentication BAuth

## Vue d'ensemble

L'API d'authentification Quantix utilise la librairie BAuth de BMVC pour fournir une gestion moderne et sécurisée de l'authentification avec tokens JWT.

## Base URL

```
http://localhost:8000/api/auth
```

## Endpoints

### 1. Connexion (Login)

**POST** `/api/auth/login`

Authentifier un utilisateur avec email et mot de passe.

#### Request Body

```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

#### Success Response (200)

```json
{
  "success": true,
  "message": "Connexion réussie",
  "data": {
    "user": {
      "id": "550e8400-e29b-41d4-a716-446655440000",
      "email": "user@example.com",
      "first_name": "John",
      "last_name": "Doe",
      "status": "active"
    },
    "tokens": {
      "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
      "refresh_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
      "expires_in": 3600
    }
  }
}
```

#### Error Response (401)

```json
{
  "success": false,
  "message": "Mot de passe incorrect",
  "status": 401
}
```

---

### 2. Enregistrement (Register)

**POST** `/api/auth/register`

Créer un nouveau compte utilisateur.

#### Request Body

```json
{
  "email": "newuser@example.com",
  "password": "securePassword123",
  "first_name": "Jane",
  "last_name": "Smith",
  "company_id": "550e8400-e29b-41d4-a716-446655440001"
}
```

#### Success Response (201)

```json
{
  "success": true,
  "message": "Compte créé avec succès",
  "data": {
    "user": {
      "id": "550e8400-e29b-41d4-a716-446655440002",
      "email": "newuser@example.com",
      "first_name": "Jane",
      "last_name": "Smith"
    },
    "tokens": {
      "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
      "refresh_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
      "expires_in": 3600
    }
  }
}
```

#### Error Response (409)

```json
{
  "success": false,
  "message": "Cet email est déjà utilisé",
  "status": 409
}
```

---

### 3. Renouvellement Token (Refresh)

**POST** `/api/auth/refresh`

Renouveler l'access token à partir du refresh token.

#### Request Body

```json
{
  "refresh_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

#### Success Response (200)

```json
{
  "success": true,
  "message": "Tokens renouvelés",
  "data": {
    "tokens": {
      "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
      "refresh_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
      "expires_in": 3600
    }
  }
}
```

#### Error Response (401)

```json
{
  "success": false,
  "message": "Refresh token invalide",
  "status": 401
}
```

---

### 4. Vérification Token (Verify)

**GET** `/api/auth/verify`

Vérifier que le token actuel est valide et obtenir les infos utilisateur.

#### Headers

```
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
```

#### Success Response (200)

```json
{
  "success": true,
  "message": "Token valide",
  "data": {
    "user": {
      "id": "550e8400-e29b-41d4-a716-446655440000",
      "email": "user@example.com",
      "first_name": "John",
      "last_name": "Doe",
      "status": "active"
    },
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
  }
}
```

#### Error Response (401)

```json
{
  "success": false,
  "message": "Token invalide",
  "status": 401
}
```

---

### 5. Déconnexion (Logout)

**POST** `/api/auth/logout`

Déconnecter l'utilisateur et invalider ses sessions.

#### Headers

```
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
```

#### Success Response (200)

```json
{
  "success": true,
  "message": "Déconnexion réussie",
  "data": {}
}
```

#### Error Response (401)

```json
{
  "success": false,
  "message": "Token requis",
  "status": 401
}
```

---

## JWT Token Format

Les tokens JWT sont au format standard:

```
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI1NTBlODQwMC1lMjliLTQxZDQtYTcxNi00NDY2NTU0NDAwMDAiLCJlbWFpbCI6InVzZXJAZXhhbXBsZS5jb20iLCJpYXQiOjE2ODQwMDAwMDAsImV4cCI6MTY4NDAwMzYwMH0.signature
```

### Payload

```json
{
  "sub": "550e8400-e29b-41d4-a716-446655440000",
  "email": "user@example.com",
  "iat": 1684000000,
  "exp": 1684003600
}
```

- **sub**: Identifiant unique de l'utilisateur (UUID)
- **email**: Email de l'utilisateur
- **iat**: Timestamp d'émission
- **exp**: Timestamp d'expiration

---

## Codes de Réponse

| Code | Signification                    |
| ---- | -------------------------------- |
| 200  | Succès                           |
| 201  | Ressource créée                  |
| 401  | Non authentifié / Token invalide |
| 403  | Compte désactivé                 |
| 404  | Utilisateur introuvable          |
| 409  | Conflit (email existant)         |
| 422  | Données invalides                |
| 500  | Erreur serveur                   |

---

## Exemples avec cURL

### Login

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password123"
  }'
```

### Register

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "email": "newuser@example.com",
    "password": "securePassword123",
    "first_name": "Jane",
    "last_name": "Smith",
    "company_id": "550e8400-e29b-41d4-a716-446655440001"
  }'
```

### Verify Token

```bash
curl -X GET http://localhost:8000/api/auth/verify \
  -H "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
```

### Logout

```bash
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
```

---

## Configuration

### Variables d'environnement (.env)

```env
AUTH_JWT_SECRET=your-secret-key-change-in-production
JWT_EXPIRES_IN=3600
JWT_REFRESH_EXPIRES_IN=604800
```

---

## Sécurité

✅ **Bonnes pratiques implémentées:**

- Mots de passe hachés avec BCRYPT (cost 12)
- Tokens JWT avec signature HMAC-SHA256
- Expiration automatique des tokens
- Refresh tokens pour renouvellement sécurisé
- Validation des données en entrée
- Protection contre les injections SQL
- Sessions invalidées à la déconnexion

---

## Support

Pour toute question ou problème, contactez l'équipe de développement.
