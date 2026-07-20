# Version 1

## 0. Analyse des besoins

- Lecture et comprehension du sujet
- Identification des acteurs du systeme (Administrateur et Client)
- Analyse des fonctionnalites attendues
- Definition des regles de gestion
- Determination des operations disponibles

## 1. Conception

### Base de donnees

- Identification des entites
- Definition des attributs
- Determination des relations entre les entites
- Definition des cles primaires et etrangeres
- Conception du schema relationnel
- Verification de la normalisation
- Redaction du fichier basesql

### Regles metier

- Definition des prefixes autorises
- Definition des types d'operations
- Definition des baremes de frais
- Determination des regles de calcul des frais
- Determination des regles de calcul du solde
- Definition des validations metiers

## 2. Initialisation du projet

- Creation du projet CodeIgniter 4
- Configuration de l'environnement
- Configuration de SQLite
- Configuration de la connexion à la base
- Organisation des dossiers MVC
- Configuration des routes

---

## 3. Base de donnees

Creation des tables :

- utilisateurs
- clients
- prefixes
- types_operations
- baremes_frais
- comptes
- operations

Creation :

- des contraintes
- des cles etrangeres
- des index necessaires
- des donnees initiales