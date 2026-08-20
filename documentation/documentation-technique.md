# Documentation technique — Breizh'Nature

## 1. Installation

### Prérequis

- WAMP (Apache 2.4, MySQL/MariaDB, PHP 8.2)
- WordPress (dernière version stable)
- Git

### Installation de l'environnement

1. **Créer le VirtualHost** dans WAMP pointant vers un dossier local (ex. `C:\wamp64\www\breizh-nature`), avec l'entrée correspondante dans le fichier `hosts` de Windows (`www.breizhnature.local`).
2. **Créer la base de données** MySQL (`eni-breizhnature`, collation `utf8mb4_unicode_ci`).
3. **Installer WordPress** dans le dossier du VirtualHost, avec un préfixe de tables personnalisé (`bzn_`) plutôt que le préfixe par défaut `wp_`, par mesure de sécurité (réduit la surface d'attaque des injections SQL automatisées ciblant le préfixe par défaut).

### Installation du thème

Le thème n'est **pas installé via l'admin WordPress** (aucun fichier `.zip`) : il est développé directement dans le dépôt Git (`theme/`), puis relié à WordPress via un **lien symbolique** (`mklink /D` sous Windows) entre `wp-content/themes/breizh-nature` et le dossier `theme/` du dépôt. Cette approche permet d'éditer le code directement dans l'IDE tout en gardant WordPress à jour en temps réel, sans copier manuellement les fichiers à chaque modification.

Activer ensuite le thème dans **Apparence → Thèmes**.

### Installation du plugin

Même principe : lien symbolique entre `wp-content/plugins/breizh-nature-reservations` et le dossier `plugin/` du dépôt. Activer le plugin dans **Extensions**.

### Configuration post-installation

Après activation du thème, aller dans **Réglages → Permaliens** et cliquer sur "Enregistrer les modifications" (sans rien changer) : cette action force WordPress à régénérer ses règles de réécriture d'URL, indispensables pour que les URLs du Custom Post Type `activite` (ex. `/activites/nom-activite/`) fonctionnent correctement.

## 2. Architecture

### Principe directeur : séparation thème / plugin

Le projet applique strictement la séparation des responsabilités demandée par le sujet :
- **Le thème** gère uniquement la présentation et l'affichage (templates, CSS, structure HTML).
- **Le plugin** gère la logique métier des réservations, indépendamment du thème.

Conséquence testable : si le thème est désactivé ou remplacé, le plugin continue de fonctionner et les données de réservation restent intactes, car elles sont stockées et traitées entièrement en dehors du thème. Le seul point de contact entre les deux est la fonction `breizh_nature_reservation_form()`, appelée depuis le thème via un test `function_exists()` — si le plugin est désactivé, le thème continue de s'afficher normalement, simplement sans le formulaire.

### Architecture du thème

```
theme/
├── style.css                          # Feuille de styles + en-tête d'identification du thème
├── functions.php                      # Point d'entrée : charge les classes du dossier inc/
├── index.php                          # Template de secours (fallback du Template Hierarchy)
├── front-page.php                     # Page d'accueil
├── header.php / footer.php            # Structure commune (nav, hero, footer)
├── page.php / single.php / 404.php    # Templates standards WordPress
├── single-activite.php                # Fiche détaillée d'une activité
├── archive-activite.php               # Liste + filtrage des activités
├── inc/
│   ├── class-cpt-activite.php         # Déclaration du CPT "activite"
│   ├── class-metabox-activite.php     # Champs personnalisés sécurisés (date, lieu, tarif...)
│   ├── class-taxonomies-activite.php  # Taxonomies "type_activite" et "niveau"
│   ├── class-filtres-activite.php     # Filtrage des activités (pre_get_posts)
│   └── class-roles.php                # Rôle "Gestionnaire" aux droits limités
└── assets/images/                     # Images du thème
```

Chaque fonctionnalité est isolée dans sa propre classe PHP, chargée depuis `functions.php` via `require`. Ce découpage facilite la maintenance : une modification sur les taxonomies, par exemple, ne touche qu'un seul fichier clairement identifié.

### Architecture du plugin

```
plugin/
├── breizh-nature-reservations.php     # Fichier principal : en-tête + chargement des classes
├── includes/
│   ├── class-reservation.php          # CPT "reservation" + création sécurisée des demandes
│   ├── class-form.php                 # Formulaire visiteur + traitement de la soumission
│   └── class-admin.php                # Interface admin : colonnes, gestion des statuts
```

### Choix techniques principaux

- **Thème développé manuellement** (aucun thème existant utilisé comme base), suivant la méthodologie des thèmes de démarrage pour développeurs (structure de fichiers standard type Underscores/_s, aucun framework CSS).
- **Programmation orientée objet** pour l'ensemble des fonctionnalités du thème et du plugin (une classe par responsabilité), plutôt qu'une approche procédurale, afin de structurer le code et de préparer une éventuelle montée en complexité.
- **Meta boxes en PHP natif plutôt qu'ACF** pour les champs personnalisés de l'activité : ces champs sont une fonctionnalité principale explicitement demandée par le sujet (section 3.1), leur délégation complète à un plugin tiers serait difficilement justifiable à l'oral.
- **CSS Grid** pour la grille de cartes d'activités (`repeat(auto-fill, minmax(280px, 1fr))`) : rend la mise en page responsive sans écrire de media queries pour le nombre de colonnes.

## 3. Base de données

### Choix retenu : Custom Post Types + post meta (Solution A du sujet)

Les activités et les réservations sont stockées via les mécanismes natifs de WordPress (`wp_posts`, `wp_postmeta`, `wp_terms`/`wp_term_taxonomy`/`wp_term_relationships` pour les taxonomies), plutôt que via des tables SQL personnalisées.

**Justification du choix :**
- Développement plus rapide, cohérent avec le calendrier du projet.
- Bénéficie nativement de toutes les fonctionnalités WordPress (interface d'administration, capacités/rôles, API REST, requêtes optimisées par les index existants).
- Pour le volume de données attendu (activités et réservations d'une association), les performances des tables natives sont largement suffisantes.

**Limite assumée :** à très grande échelle (plusieurs dizaines de milliers de réservations), une table SQL dédiée deviendrait plus pertinente pour les performances de requêtes complexes — c'est un axe d'évolution identifié plutôt qu'un besoin actuel.

### Pourquoi une taxonomie plutôt qu'un champ meta pour le "Niveau" ?

Un champ meta ne bénéficie d'aucune page d'archive automatique ; une taxonomie oui (`register_taxonomy` génère nativement des URLs filtrables comme `/niveau/facile/`), répondant directement à l'exigence du sujet ("les taxonomies devront être exploitables dans les pages d'archives"). Les tables de taxonomies sont également mieux indexées pour le filtrage que `wp_postmeta`, qui mélange les métadonnées de tous les types de contenu.

## 4. Sécurité

Mesures mises en œuvre, systématiquement sur chaque formulaire et traitement de données utilisateur :

| Mesure | Où | Protection contre |
|---|---|---|
| `wp_nonce_field()` / `wp_verify_nonce()` | Meta box activité, formulaire de réservation, changement de statut | CSRF (soumission de formulaire à l'insu de l'utilisateur) |
| `current_user_can()` | Sauvegarde des champs, changement de statut | Élévation de privilèges (un utilisateur non autorisé modifie du contenu) |
| `sanitize_text_field()` / `sanitize_email()` / `sanitize_textarea_field()` | Tous les champs texte des formulaires | XSS stocké (injection de scripts malveillants en base) |
| `esc_html()` / `esc_attr()` / `esc_url()` | Tout affichage de données utilisateur | XSS réfléchi (au moment de l'affichage) |
| `absint()` | Champs numériques (durée, participants) | Injection de valeurs non numériques |
| `is_email()` | Champ e-mail du formulaire de réservation | Données mal formées en base |
| `wp_safe_redirect()` | Redirection après soumission du formulaire | Open redirect (redirection vers un domaine externe malveillant) |
| Préfixe de table personnalisé (`bzn_`) | Base de données | Injections SQL automatisées ciblant le préfixe `wp_` par défaut |
| Rôle "Gestionnaire" aux capacités limitées | Gestion des utilisateurs | Sur-privilège d'un compte non administrateur |

## 5. Tests

- **Test fonctionnel manuel** : création, modification et suppression d'activités ; soumission du formulaire de réservation (cas valide et cas avec champs manquants) ; changement de statut d'une réservation depuis l'admin.
- **Test de résilience thème/plugin** : désactivation du thème avec le plugin actif — les données de réservation restent intactes en base, confirmant l'indépendance des deux composants.
- **Test responsive** : vérification de l'affichage sur plusieurs largeurs d'écran (mobile, tablette, desktop) via le mode responsive des outils de développement du navigateur.
- **Test de sécurité manuel** : tentative de soumission du formulaire sans nonce valide (rejetée), tentative d'accès direct aux fichiers PHP du thème et du plugin (bloquée par la vérification `ABSPATH`).

## 6. Améliorations possibles

Axes identifiés mais non développés dans le temps imparti au projet, à assumer comme perspectives d'évolution :
- API REST complète avec authentification
- Recherche AJAX sans rechargement de page
- Tests automatisés et intégration continue (CI/CD)
- Tableau de bord avec statistiques avancées
- Table SQL dédiée aux réservations si le volume de données venait à augmenter significativement
