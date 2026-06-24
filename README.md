# API Restful - Gestion de Bibliothèque Universitaire

Ce projet est une API backend robuste développée avec **Laravel 11** permettant de gérer les emprunts de livres, l'authentification sécurisée des étudiants et l'administration du catalogue.

## 🚀 Fonctionnalités
- **Authentification & Rôles :** Inscription, connexion et déconnexion via **Laravel Sanctum**. Gestion des accès différenciés (Étudiant / Administrateur).
- **Catalogue de Livres :** CRUD complet accessible uniquement par l'administrateur. Consultation publique pour les étudiants.
- **Gestion des Emprunts :** Logique métier stricte (un livre emprunté devient indisponible), calcul automatique de la date limite (+15 jours), et gestion dynamique de la restitution avec mise à jour automatique.

## 🛠️ Installation et Démarrage

1. **Cloner le dépôt :**
```bash
   git clone [https://github.com/harmo912/api-bibliotheque-laravel.git](https://github.com/harmo912/api-bibliotheque-laravel.git)
   cd api-bibliotheque-laravel