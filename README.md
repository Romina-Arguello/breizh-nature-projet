# Breizh'Nature — Le portail des activités nature en Bretagne

Site WordPress développé pour l'association fictive **Breizh'Nature**, permettant de présenter et gérer des activités liées à la nature et au patrimoine breton (randonnées, sorties découverte, ateliers, événements).

Projet réalisé dans le cadre du titre **Développeur Web et Web Mobile (D2WM, RNCP niveau 5, Bac+2)** — ENI École Informatique.

## Sommaire

- [Contexte](#contexte)
- [Fonctionnalités](#fonctionnalités)
- [Stack technique](#stack-technique)
- [Installation](#installation)
- [Structure du dépôt](#structure-du-dépôt)
- [Documentation](#documentation)

## Contexte

L'association Breizh'Nature souhaite un site permettant :
- aux visiteurs de consulter les activités proposées et de demander une réservation ;
- à l'association de gérer elle-même les contenus depuis l'administration WordPress, sans compétence technique.

## Fonctionnalités

- Gestion des activités via un Custom Post Type dédié (`activite`)
- Classement par taxonomies personnalisées : **Type d'activité** et **Niveau**
- Fiche détaillée par activité (date, heure, durée, lieu, tarif, participants, statut)
- Filtrage des activités par type, niveau et lieu
- **Plugin indépendant** de réservation (formulaire visiteur sécurisé + gestion des demandes côté admin)
- Rôle utilisateur dédié **Gestionnaire** aux droits limités
- Thème développé manuellement, responsive, sans framework CSS

## Stack technique

| Composant | Choix |
|---|---|
| CMS | WordPress (dernière version stable) |
| Serveur local | WAMP (Apache, MySQL, PHP 8.2) |
| Thème | Développé manuellement (méthode "starter theme" pour développeurs) |
| Stockage des données | Custom Post Types + post meta natifs WordPress |
| Versionnement | Git / GitHub |
| IDE | PhpStorm |

## Installation

Voir la documentation complète : [`documentation/documentation-technique.md`](documentation/documentation-technique.md#installation)

Résumé rapide :
1. Installer WAMP et créer un VirtualHost pointant vers ce projet
2. Créer une base de données MySQL et installer WordPress
3. Créer un lien symbolique entre `theme/` et `wp-content/themes/breizh-nature`
4. Créer un lien symbolique entre `plugin/` et `wp-content/plugins/breizh-nature-reservations`
5. Activer le thème **Breizh Nature** et le plugin **Breizh'Nature Réservations**
6. Aller dans Réglages → Permaliens et cliquer sur "Enregistrer" (régénère les règles d'URL du CPT)

## Structure du dépôt

```
breizh-nature-projet/
├── theme/              # Thème WordPress développé manuellement
├── plugin/              # Plugin de réservations (indépendant du thème)
├── documentation/        # Documentation technique, cahier des charges
└── README.md
```

## Documentation

La documentation technique complète (architecture, choix techniques, base de données, sécurité, tests) se trouve dans [`documentation/documentation-technique.md`](documentation/documentation-technique.md).
