## 0. Analyse des besoins (v1)

- [x] Lecture et compréhension du sujet
- [x] Identification des acteurs du système (Administrateur et Client)
- [x] Analyse des fonctionnalités attendues
- [x] Définition des règles de gestion
- [x] Détermination des opérations disponibles

## 1. Conception (v1)

### Base de données

- [x] Identification des entités
- [x] Définition des attributs
- [x] Détermination des relations entre les entités
- [x] Définition des clés primaires et étrangères
- [x] Conception du schéma relationnel
- [x] Vérification de la normalisation
- [x] Rédaction du fichier `base.sql`

### Règles métier

- [x] Définition des préfixes autorisés (033, 037)
- [x] Définition des types d'opérations (dépot, retrait, transfert)
- [x] Définition des barèmes de frais (tranches modifiables par l'admin)
- [x] Détermination des règles de calcul des frais
- [x] Détermination des règles de calcul du solde
- [x] Validation des règles métier (montant positif, solde suffisant, préfixe valide)

## 2. Initialisation du projet (v1)

- [x] Création du projet CodeIgniter 4
- [x] Configuration de l'environnement
- [x] Configuration de SQLite
- [x] Organisation des dossiers MVC
- [x] Configuration des routes

## 3. Base de données (v1)

- [x] Création des tables principales
- [x] Mise en place des contraintes et clefs étrangères
- [x] Création des index nécessaires
- [x] Création des vues pour reporting
- [x] Insertion des données initiales

## 4. Développement (v1)

### Côté Admin

- [x] Authentification admin
- [x] Gestion des utilisateurs
- [x] Gestion des préfixes et commissions
- [x] Gestion des types d'opérations
- [x] Gestion des barèmes de frais
- [x] Dashboard et reporting de base

### Côté Client

- [x] Login automatique par téléphone
- [x] Consultation du solde
- [x] Dépôt
- [x] Retrait
- [x] Transfert interne
- [x] Historique des opérations

## 5. Interface / Design (v1)

- [x] Intégration Bootstrap
- [x] Styles personnalisés
- [x] Navigation distincte admin/client
- [x] Messages de succès / erreur

---

## 0. Analyse des besoins (v2)

- [x] Revue du v1 et des corrections demandées
- [x] Définition de la gestion des autres opérateurs
- [x] Définition du modèle de commission externe
- [x] Définition des exigences de reporting détaillé

## 1. Conception (v2)

### Base de données

- [x] Extension du schéma `prefixes` avec `commission_percent`
- [x] Ajout de `telephone_dest` dans `operations`
- [ ] Ajout de `commission` dans `operations` si migration nécessaire
- [x] Mise à jour de `base.sql` pour la version v2

### Règles métier

- [x] Transferts vers autres opérateurs sans création de compte local
- [x] Frais = `baseFrais` + `commission` pour opérateurs externes
- [x] Commission prélevée sur l’émetteur seulement
- [x] Option d’inclure les frais sur le destinataire interne
- [x] Règles de validation pour envoi multi-destinataires

## 2. Initialisation du projet (v2)

- [x] Ajustement des routes si besoin
- [x] Ajout de la logique de service de transfert
- [x] Mise à jour des modèles et contrôleurs concernés
- [x] Mise à jour des vues admin et client

## 3. Base de données (v2)

- [x] Mise à jour du fichier `base.sql`
- [ ] Application des migrations / mise à jour de la base existante
- [x] Vérification des vues et des rapports
- [x] Validation des index et performances de requêtes

## 4. Développement (v2)

### Côté Admin

- [x] Edition des commissions `commission_percent` par préfixe
- [x] Page d’édition en masse des commissions
- [x] Barème modifiable avec ajout/suppression/édition
- [x] Reporting des gains détaillé par opérateur
- [x] Rapport transactionnel avec expéditeur/destinataire

### Côté Client

- [x] Transfert vers préfixes externes sans compte local
- [x] Option `Inclure les frais` pour destinataire interne
- [x] Envoi multi-destinataires avec répartition des arrondis
- [x] Historique avec numéro de destinataire conservé
- [x] Validation stricte des préfixes et des montants

## 5. Interface / Design (v2)

- [x] Clarification des formulaires de transfert
- [x] Ajout d’un tableau de gains détaillé
- [x] Affichage des commissions externes en admin
- [x] Conservation des styles et navigation v1

## Correction v2

- [x] Séparation claire entre frais perçus et commission externe
- [x] Transferts autres opérateurs sans création de compte local
- [x] Commission déduite de l’envoyeur, pas du destinataire interne
- [x] Historique et reporting détaillés
- [x] Tâches v2 structurées comme le v1

