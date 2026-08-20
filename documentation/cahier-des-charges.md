# Cahier des charges — Breizh'Nature

## 1. Contexte et besoin client

L'association **Breizh'Nature** organise régulièrement des activités liées à la nature et au patrimoine breton : randonnées, sorties découverte, ateliers pédagogiques, visites de sites naturels, événements et animations familiales.

**Besoin exprimé :** un site Internet permettant :
- aux visiteurs de consulter les activités proposées et de demander une réservation ;
- à l'association de gérer elle-même l'ensemble des contenus depuis l'administration WordPress, **sans compétence technique**.

## 2. Utilisateurs cibles

| Profil | Besoins |
|---|---|
| **Visiteur du site** | Consulter les activités, filtrer selon ses critères (type, niveau, lieu), demander une réservation facilement |
| **Gestionnaire** (bénévole/salarié association) | Créer et modifier les activités, consulter les demandes de réservation — sans accès aux réglages techniques du site |
| **Administrateur** | Accès complet : gestion des utilisateurs, réglages, thème, plugins |

## 3. Fonctionnalités attendues

### 3.1 Gestion des activités
Chaque activité comprend : titre, description, image principale, date, heure, durée, lieu, niveau de difficulté, nombre maximal de participants, tarif, catégorie, statut.

### 3.2 Classement des activités
Deux critères de classement exploitables en filtrage : **type d'activité** (Randonnée, Découverte, Patrimoine, Faune, Flore, Famille, Atelier) et **niveau** (Facile, Intermédiaire, Difficile).

### 3.3 Réservation
Le visiteur peut, depuis la fiche d'une activité, soumettre une demande de réservation (nom, prénom, e-mail, téléphone, nombre de participants, commentaire). L'association consulte et traite ces demandes depuis l'administration, avec trois statuts possibles : En attente, Acceptée, Refusée.

### 3.4 Recherche et filtrage
Le visiteur peut filtrer la liste des activités par type, niveau et lieu, directement depuis la page d'archive.

### 3.5 Gestion des utilisateurs
Deux niveaux d'accès distincts : Administrateur (accès complet) et Gestionnaire (gestion des activités et consultation des réservations uniquement).

## 4. Exigences non-fonctionnelles

| Exigence | Traitement dans le projet |
|---|---|
| **Expérience utilisateur** | Interface claire, navigation cohérente, filtrage intuitif |
| **Responsive design** | Grille CSS adaptative (mobile, tablette, desktop) sans framework externe |
| **Sécurité** | Nonces, échappement des sorties, nettoyage des entrées, requêtes préparées natives WordPress (voir documentation technique, section 4) |
| **Accessibilité** | Textes alternatifs sur les images, focus clavier visible, structure sémantique HTML |
| **Référencement (SEO)** | Balises title dynamiques, structure de titres H1/H2/H3, URLs lisibles |
| **Performance** | Images optimisées, CSS/JS minimal, pas de dépendance externe lourde |
| **Maintenabilité** | Séparation stricte thème/plugin, code orienté objet documenté, variables CSS centralisées |

## 5. Architecture technique retenue

- **Thème WordPress développé manuellement** (aucune base de thème existant), suivant la méthodologie des thèmes de démarrage pour développeurs.
- **Plugin indépendant** pour toute la logique métier de réservation, conformément à la séparation présentation/fonctionnalités demandée.
- **Custom Post Types et taxonomies natifs WordPress** pour la structuration des données (voir justification détaillée dans la documentation technique).

## 6. Livrables

1. Site WordPress fonctionnel (environnement de développement local)
2. Thème personnalisé (dépôt Git, dossier `theme/`)
3. Plugin personnalisé (dépôt Git, dossier `plugin/`)
4. Dépôt Git versionné avec historique de commits explicites
5. Documentation technique (`documentation/documentation-technique.md`)
6. Ce cahier des charges
7. Présentation de soutenance
