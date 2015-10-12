# Galerie de photo sous CakePHP 3.0

[![Build Status](https://api.travis-ci.org/cakephp/app.png)](https://travis-ci.org/cakephp/app)
[![License](https://poser.pugx.org/cakephp/app/license.svg)](https://packagist.org/packages/cakephp/app)

Il s'agit d'un système basique de galerie photo.
Réalisé sous CakePHP 3.0.

Version largement simplifié :
- la gestion des "albums" a été supprimée.
- le système d'ajout des photos se fait par glisser/déposer. 

Peu de styles. Peu de javascripts. Juste le nécéssaire.
L'upload géré via ajax. Suppression réalisées via un simple get sans confirmation (au lieu de post certainement  plus adapté).

## Installation

Manuelle
Cloner, 
Installer la base de donnée sql fournie, 
Modifier le fichier de config config/app.php avec vos données de connexion mysql

## Notes

Système non destiné à la production en l'état ou dérrière un espace memmbre sécurisé.
Des versions similaires sont également disposibles sous Codeigniter, FuelPHP et Laravel
