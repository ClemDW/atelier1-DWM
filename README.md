# CharlyMatLoc - Location d'outils

> Application web de location de matériel de bricolage permettant aux particuliers de louer des outils selon leurs besoins. Développée dans le cadre du SAE Atelier-projet de Développement Web serveur avancé #1 - IUT Nancy-Charlemagne – BUT Informatique S5 – DWM.

![PHP](https://img.shields.io/badge/PHP-8.1-8892BF?style=flat-square&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat-square&logo=docker&logoColor=white)
![Slim](https://img.shields.io/badge/Slim_Framework-000000?style=flat-square&logo=slim&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black)
![REST API](https://img.shields.io/badge/API-REST-FF5733?style=flat-square&logo=api&logoColor=white)

## Groupe

- **[BESANCON Marcelin](https://github.com/NaasaX)** 
- **[DE WASCH Clément](https://github.com/ClemDW)** 
- **[TOPCU Semih](https://github.com/cemquo)** 
- **[SALZAR Manech](https://github.com/LeChenam)** 
- **[HERRMANN Vivien](https://github.com/Vivienhrm)**

---

## État d'avancement

### Fonctionnalités implémentées ✅

| Fonctionnalité | Description | État | Dev Front | Dev Back |
| -------------- | ----------- | ---- | --------- | -------- |
| Data & Schema SQL | Schémas et données SQL pour la base de données | ✅ | Clément | |
| Fonctionnalité 1 | Affichage du catalogue d'outils (nom, image, stock disponible) | ✅ | Marcelin | Manech |
| Fonctionnalité 2 | Détail d'un outil avec toutes les informations | ✅ | Semih | Manech |
| Fonctionnalité 3 | Sélection d'un outil pour une date donnée et ajout au panier | ✅ | X | Vivien |
| Fonctionnalité 4 | Visualisation du panier et calcul du montant total | ✅ | X | X |
| Fonctionnalité 5 | Inscription sur la plateforme et création de compte | ✅ | Semih & Vivien | Vivien |
| Fonctionnalité 6 | Authentification utilisateur | ✅ | Semih & Vivien | Vivien |
| Fonctionnalité 7 | Gestion du panier pour utilisateur authentifié | ✅ | X | X |
| Fonctionnalité 8 | Accès aux outils précédemment réservés (« Mes réservations ») | ✅ | X | X |
| Fonctionnalité 9 | Réservation sur plusieurs jours avec validation de disponibilité | ✅ | X | X |
| Fonctionnalité 10 | Gestion des exemplaires multiples d'un outil | ✅ | X | X |
| Filtrage par catégorie | Filtrage du catalogue par catégorie d'outils | ✅ | Vivien | Vivien |

### Fonctionnalités à venir 🔄

- Pagination du catalogue
- Système de paiement
- Notifications par email
- Interface d'administration
- API de gestion des stocks

---

## Description générale

CharlyMatLoc est une application web qui permet aux particuliers de louer du matériel de bricolage. L'application propose un catalogue d'outils disponibles, permettant aux utilisateurs de parcourir, filtrer et réserver les outils dont ils ont besoin selon leurs projets de bricolage ou travaux.

### Fonctionnalités principales

#### 🛠️ Catalogue d'outils
- **Affichage du catalogue** : Présentation des outils avec nom, image et nombre d'exemplaires disponibles
- **Détail d'un outil** : Page détaillée avec description complète, catégorie, tarif de location et image
- **Filtrage par catégorie** : Sélection de catégories pour filtrer les outils disponibles
- **Disponibilité en temps réel** : Affichage du stock disponible pour chaque outil

#### 👤 Gestion des utilisateurs
- **Inscription** : Création de compte utilisateur avec email et mot de passe
- **Authentification** : Connexion sécurisée avec gestion de session
- **Profil utilisateur** : Historique des réservations

#### 🛒 Système de panier et réservation
- **Ajout au panier** : Sélection d'outils pour une période donnée
- **Gestion du panier** : Visualisation, modification et suppression d'articles
- **Calcul automatique** : Montant total calculé selon la durée de location
- **Validation de disponibilité** : Vérification de la disponibilité des outils sur la période choisie

#### 📅 Gestion des réservations
- **Réservation sur période** : Possibilité de réserver pour plusieurs jours consécutifs
- **Gestion des exemplaires multiples** : Support pour plusieurs exemplaires du même outil
- **Historique des réservations** : Accès aux réservations passées dans le profil utilisateur

#### 🔧 Fonctionnalités techniques
- **API REST** : Endpoints pour la gestion des outils, catégories et réservations
- **Architecture modulaire** : Séparation claire entre présentation, logique métier et données
- **Interface responsive** : Utilisable sur tous types de supports (desktop, tablette, mobile)
- **Filtrage avancé** : Par catégorie et disponibilité pour une date donnée

---

## Architecture technique

### Backend (PHP/Slim Framework)
- **Framework** : Slim Framework pour le routage et la gestion des requêtes
- **Architecture hexagonale** : Séparation des couches (API, Application, Infrastructure)
- **Gestion des dépendances** : Injection de dépendances avec conteneur PHP-DI
- **Sécurité** : Middleware d'authentification et gestion des sessions

### Frontend (Vanilla JavaScript)
- **JavaScript ES6+** : Code modulaire avec imports/exports
- **Architecture SPA** : Single Page Application avec routage côté client
- **Gestion d'état** : Authentification et panier persistés localement
- **Interface responsive** : CSS avec support mobile-first

### Base de données (MySQL)
- **Schémas relationnels** : Tables pour utilisateurs, outils, catégories, réservations
- **Gestion des stocks** : Suivi des exemplaires disponibles par outil
- **Historique** : Conservation des réservations passées

### Conteneurisation (Docker)
- **Environnement isolé** : Application entièrement dockerisée
- **Services séparés** : PHP-FPM, Nginx, MySQL
- **Déploiement simplifié** : `docker-compose` pour l'orchestration

---

## Installation et lancement

### Prérequis
- Docker et Docker Compose installés
- Git

### Installation

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/Vivienhrm/SAE-S5-atelier1-DWM.git
   cd SAE-S5-atelier1-DWM
   ```

2. **Installer les dépendances PHP**
   ```bash
   cd app
   composer install
   cd ..
   ```

3. **Lancer l'application**
   ```bash
   docker-compose up --build -d
   ```

4. **Accéder à l'application**
   - Frontend : `http://localhost:10100`
   - Adminer (gestion BDD) : `http://localhost:10111`
   
   - API : `http://localhost:10101` 
   
   #### Exemple des routes de l'API :
   - `GET /outillages` - Liste des outils (avec filtrage par catégorie)
   - `GET /outillages/{id}` - Détail d'un outil
   - `GET /categories` - Liste des catégories

### Structure du projet
```
.
├── app/                    # Code backend PHP
│   ├── src/
│   │   ├── api/           # Contrôleurs API
│   │   ├── application_core/  # Logique métier
│   │   └── infrastructure/    # Accès données
│   ├── config/            # Configuration
│   └── public/            # Point d'entrée web
├── front/                 # Code frontend
│   ├── index.html         # Application principale
│   ├── js/               # JavaScript
│   ├── css/              # Styles compilés
│   └── scss/             # Styles sources
├── sql/                  # Scripts base de données
├── docker/               # Configuration Docker
└── docker-compose.yml    # Orchestration services
```

---

## Technologies utilisées

- **Backend** : PHP 8.1, Slim Framework 4, PHP-DI
- **Frontend** : HTML5, CSS3, JavaScript ES6+
- **Base de données** : MySQL 8.0
- **Conteneurisation** : Docker, Docker Compose
- **Outils** : Composer, npm, Sass

---

## Licence

Ce projet est réalisé dans le cadre pédagogique de l'IUT Nancy-Charlemagne.
