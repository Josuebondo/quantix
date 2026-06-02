# 🏗️ Architecture Quantix

Bienvenue dans la section **Architecture**. Vous trouverez ici les détails techniques et les diagrammes de Quantix.

## 📚 Documents Architecture

### 📊 Guides Techniques
- **[PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)** - Résumé complet du projet
- **[VISUAL_SUMMARY.md](VISUAL_SUMMARY.md)** - Diagrammes et visualisations

---

## 📖 Contenu des Fichiers

### PROJECT_SUMMARY.md
Vue d'ensemble technique complète incluant:
- 🏗️ Architecture générale
- 📊 Structure de la base de données
- 🔌 Endpoints API
- 🧪 Guide de test
- 🔴 Travaux restants

**Temps de lecture**: ~25 minutes  
**Niveau**: Intermédiaire à Avancé

### VISUAL_SUMMARY.md
Diagrammes et visualisations incluant:
- 🎯 Flux utilisateur
- 🔄 Cycles de traitement
- 📦 Architecture système
- 🏛️ Modèles de données
- 🔌 Intégrations

**Temps de lecture**: ~15 minutes  
**Niveau**: Débutant à Intermédiaire

---

## 🎯 Par Cas d'Usage

### Je veux comprendre l'architecture générale
1. Lire [VISUAL_SUMMARY.md](VISUAL_SUMMARY.md) - Voir les diagrammes
2. Lire [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) - Comprendre les détails

### Je veux connaître la structure de données
1. Voir le schéma dans [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md#-database-schema)
2. Explorer les modèles de données

### Je veux voir les workflows
1. Consulter les diagrammes dans [VISUAL_SUMMARY.md](VISUAL_SUMMARY.md)
2. Lire les descriptions dans [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)

### Je veux intégrer Quantix
1. Comprendre l'architecture dans [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)
2. Consulter les diagrammes dans [VISUAL_SUMMARY.md](VISUAL_SUMMARY.md)
3. Aller à [Configuration & Setup](../setup/)

---

## 🔗 Liens Rapides

### Documentation
- **[Retour à la doc principale](../INDEX.md)**
- **[Guides d'utilisation](../guides/)**
- **[Configuration & Setup](../setup/)**
- **[API Reference](../api/)**

### Modèles & Flux
- **[Database Schema](PROJECT_SUMMARY.md#-database-schema)** - Structure BD
- **[User Flow](VISUAL_SUMMARY.md#-user-flow)** - Flux utilisateur
- **[API Endpoints](PROJECT_SUMMARY.md#-api-endpoints)** - Endpoints disponibles

---

## 📊 Structure du Projet

```
Quantix/
├── app/                 # Code applicatif
│   ├── Controleurs/    # Contrôleurs
│   ├── Modeles/        # Modèles
│   ├── Services/       # Services métier
│   └── Vues/          # Templates
├── public/             # Fichiers publics
│   ├── js/            # JavaScript
│   ├── css/           # Feuilles de style
│   └── images/        # Images
├── docs/              # Documentation
│   ├── guides/        # Guides
│   ├── setup/         # Configuration
│   ├── architecture/  # Architecture
│   └── api/           # API
└── database/          # Migrations BD
```

---

## 💡 Concepts Clés

### 🔑 Concepts
- **Multi-tenant**: Chaque entreprise = un workspace isolé
- **Wizard d'onboarding**: Configuration guidée à la création
- **State Persistence**: Sauvegarde du state du wizard
- **Idempotence**: Deployment sûr et rétentable

### 🏛️ Patterns
- **MVC**: Modèle-Vue-Contrôleur
- **Service Layer**: Couche métier séparée
- **ORM**: Modèles ORM pour la base de données
- **API RESTful**: Endpoints suivant les conventions REST

---

## 🧪 Exemple de Flux Complet

```
1. Utilisateur s'inscrit
   ↓
2. Email d'activation envoyé
   ↓
3. Utilisateur clique le lien
   ↓
4. Wizard d'onboarding
   ↓
5. Configuration du workspace
   ↓
6. Entreprise créée
   ↓
7. Accès au tableau de bord
```

Pour plus de détails → Voir [VISUAL_SUMMARY.md](VISUAL_SUMMARY.md)

---

## 📚 Lecteurs Recommandés

### Développeurs
- [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) - Comprendre la technique
- [VISUAL_SUMMARY.md](VISUAL_SUMMARY.md) - Voir les diagrammes
- [../setup/IMPLEMENTATION_GUIDE.md](../setup/IMPLEMENTATION_GUIDE.md) - Implémenter

### Architectes
- [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) - Vue d'ensemble
- [VISUAL_SUMMARY.md](VISUAL_SUMMARY.md) - Diagrammes
- [../api/](../api/) - API Reference

### Product Managers
- [VISUAL_SUMMARY.md](VISUAL_SUMMARY.md) - Workflows utilisateur
- [../guides/](../guides/) - Guides métier

---

**Version**: 1.0.0 | **Statut**: Production Ready
