## 0. Analyse des besoins

- [x] Lecture et comprehension du sujet
- [x] Identification des acteurs du systeme (Administrateur et Client)
- [x] Analyse des fonctionnalites attendues
- [x] Definition des regles de gestion
- [x] Determination des operations disponibles

## 1. Conception

### Base de donnees

- [x] Identification des entites
- [x] Definition des attributs
- [x] Determination des relations entre les entites
- [x] Definition des cles primaires et etrangeres
- [x] Conception du schema relationnel
- [x] Verification de la normalisation
- [x] Redaction du fichier base.sql

### Regles metier

- [x] Definition des prefixes autorises (033, 037)
- [x] Definition des types d'operations (depot, retrait, transfert)
- [x] Definition des baremes de frais (tranches modifiables par l'admin)
- [x] Determination des regles de calcul des frais (frais selon tranche du montant, par type d'operation)
- [x] Determination des regles de calcul du solde (credit/debit + frais preleves sur l'expediteur)
- [x] Definition des validations metiers (montant positif, solde suffisant, prefixe valide, destinataire existant)

## 2. Initialisation du projet

- [x] Creation du projet CodeIgniter 4
- [x] Configuration de l'environnement (.env, CI_ENVIRONMENT)
- [x] Configuration de SQLite (database.default.DBDriver = SQLite3)
- [x] Configuration de la connexion à la base
- [x] Organisation des dossiers MVC (Controllers/Client, Controllers/Admin, Models, Views, Filters, Libraries)
- [x] Configuration des routes (app/Config/Routes.php)

---

## 3. Base de donnees

Creation des tables :

- [x] users (comptes administrateurs)
- [x] clients (identite par numero de telephone)
- [x] prefixes
- [x] operation_types
- [x] baremes
- [x] comptes (lie a clients)
- [x] operations (historique, liee a comptes et operation_types)

Creation :

- [x] des contraintes (UNIQUE sur login, telephone, prefixe, code)
- [x] des cles etrangeres (comptes.client_id, operations.compte_id/compte_dest_id/operation_type_id, baremes.operation_type_id)
- [x] des index necessaires (idx_users_login, idx_clients_telephone, idx_baremes_type, idx_operations_compte, idx_operations_type)
- [x] des vues (v_gains_par_type, v_comptes_clients)
- [x] des donnees initiales (prefixes 033/037, types d'operation, bareme de frais retrait/transfert)

---

## 4. Developpement

### Cote Admin

- [x] Authentification reelle sur la table `users` (mot de passe hache avec password_hash/password_verify)
- [x] Seeder du compte admin par defaut (app/Database/Seeds/UserSeeder.php)
- [x] Gestion des comptes administrateurs (creation, activation/desactivation, suppression)
- [x] Configuration des prefixes (ajout, activation/desactivation, suppression)
- [x] Gestion des types d'operation (ajout, activation/desactivation)
- [x] Gestion du bareme de frais par tranche, par type d'operation (ajout, suppression)
- [x] Tableau de bord avec statistiques (nb comptes, solde total, nb operations, total des frais)
- [x] Situation des gains via les frais (vue v_gains_par_type)
- [x] Situation des comptes clients (vue v_comptes_clients)

### Cote Client

- [x] Login automatique par numero de telephone (creation auto du client + du compte si premiere connexion)
- [x] Verification du prefixe autorise a la connexion
- [x] Consultation du solde
- [x] Depot (credite le compte, gratuit par defaut)
- [x] Retrait (frais selon bareme, verification du solde suffisant)
- [x] Transfert vers un autre numero (frais selon bareme, prelevement chez l'expediteur uniquement)
- [x] Historique des operations (avec destinataire pour les transferts)

## 5. Interface / Design

- [x] Integration de Bootstrap 5
- [x] Feuille de style personnalisee (public/css/style.css) : palette dediee, cartes de solde en degrade, tuiles de menu, tableaux de bord admin avec statistiques colorees, pages de connexion habillees
- [x] Navigation distincte cote client (vert mobile money) et cote admin (sombre, accent bleu)
- [x] Messages de succes/erreur (flashdata) integres visuellement