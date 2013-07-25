=== Minecraft Online Users Widget ===
Contributors: pirmax
Donate link: http://pirmax.fr/
Tags: minecraft, online, users, widget, user, player, display, affichage, extension, plugin, afficher
Requires at least: 3.0
Tested up to: 3.5.2
Stable tag: trunk

Plugin Widget permettant d'afficher les joueurs en ligne d'un serveur Minecraft dans le menu d'un blog Wordpress.

== Description ==

Le plugin <b>Minecraft OnlineUsers Widget</b> est un plugin permettant d'afficher les joueurs en ligne d'un serveur dans le menu du blog grâce à la fonction "query" de CraftBukkit.Soutenez le créateur de cette extension en vous abonnant à sa chaîne : <a href="http://www.youtube.com/user/PirmaxLePoulpeRouge" target="_blank">PirmaxLePoulpeRouge</a>.

== Installation ==

L'installation est simple, mais vous devez cependant pouvoir modifier le contenu du fichier <code>server.properties</code> disponible dans le dossier racine du serveur CraftBukkit.

Ensuite, pour activer le widget, vous devez activer <code>enable-query</code> (<b>enable-query=true</b>) dans le fichier <code>server.properties</code> de votre serveur CraftBukkit puis red&eacute;marrer votre serveur.

Rendez-vous dans le pannel des widgets sur votre blog Wordpress, et ajoutez le widget <code>Minecraft OnlineUsers</code>, configurez ensuite l'ip et le port du serveur ainsi que le nombre de slot de votre serveur, puis cliquez sur <code>Enregistrer</code>.

== Screenshots ==

1. Exemple d'affichage de deux joueurs en ligne

== Changelog ==

= 2.1 =

* Ajout d'une option pour modifier le CSS du Widget* Ajout d'une option pour modifier le texte écrit si aucun joueur est connecté* Possibilité de gérer la taille des avatars* Utilisation des avatars de Minotar.net* Résolution des erreurs PHP qui empêchaient le bon fonctionnement du plugin

= 1.1 =

* Ajout de l'option <code>Nombre de slot du serveur</code> dans le widget

= 1.0 =

* Première version