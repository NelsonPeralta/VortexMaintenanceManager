• Titre
	*** Vortex Maintenance Manager
	
• Sommaire
	Vortex Maintenance Manager est une application web qui permet la création d’un système de gestion de maintenance. 
	Plus précisément, elle concentre sur la création de formulaires des travaux faits à l’intérieur d’une usine qu’on appelle des “Bons de Travail”. 
	Ceux-ci permettront de garder une archive de tous les détails qui concernent le travail comme le nombre de pièces utilisées et le nombre d’heures investis.
	Finalement, ils serviront de guide pour une meilleure planification d’un même travail dans le futur.
	
Brève présentation de votre projet.
• Installation
	1. Installez Xampp(https://www.apachefriends.org/index.html)
		1.5 Copiez-collez le dossier racine du projet sous C:\xampp\htdocs\
	2. Démarrez Apache et MySQL de Xampp
	3. Accédez phpMyAdmin localement en écrivant se texte dans votre navigateur web: http://localhost/phpmyadmin/index.php?route=/server/sql
	4. Démarrez le code qui se retrouve dans \\ProjetSynthese\\dev\\scripts\\globaldb_creation.sql sur phpMyAdmin pour creer vos base de donnees par defaut
	5. Accédez au site web en écrivant http://localhost/ProjetSynthese/dev/index.php dans votre navigateur web.

• Utilisation
	À partir de la page d'acceuil, Vous pouvez vous inscrire en cliquant sur Register et remplir les champs de donnees.
	Votre compte et base de donnees sera creer si aucun utilisateur existe avec les informations donnees.
	
	Connectez vous en cliquant sur le bouton Login.
	
	4 onglets s'affichent a vous:
		** Work Orders
			Vous avez l'option de creer un nouveau bon de travail en cliquant sur New Work Order. Une nouvelle fenetre s'ouvrira.
			Renplissez aumoins le champ Titre et cliquez sur Save pour sauvegarder le bon. Fermez la fenetre.
			Le nouveau bon s'affichera dans la liste de bons.
			
			Cliquez sur un bon existant. Vous avez le choix de modifier, supprimer ou de ferme le bon.
			
		** Employees
			Remplissez les champs de donnees dans la section New Employee. Cliquez sur Add Employee pour ajouter le membre si il n'existe pas deja.
			Ce nouveau membre s'affichera sur la liste.
			
			Cliquez sur le bouton View ou Delete pour modifier et supprimer un membre existant respectivement.
		** Equipement
			Remplissez les champs de donnees dans la section New Equipement. Cliquez sur Add Equipement pour ajouter la machine si elle n'existe pas deja.
			Cette nouvelle machine s'affichera sur la liste.
			
			Cliquez sur le bouton View ou Delete pour modifier et supprimer un Equipement existant respectivement.
		** Inventory
			Remplissez les champs de donnees dans la section New Part. Cliquez sur Save New Part pour ajouter la piece si elle n'existe pas deja.
			Cette nouvelle machine s'affichera sur la liste.
			
			Cliquez une piece existante pour visualiser et supprimer une piece existante.

• Références
	Je n'ai pas pris en une seule note les références dont je me suis servi. 
	Elles se retrouvent dans le code si il y en a, car je ne me souviens pas avoir pris du code d'ailleur dont je n'ai pas appris en classe.
• Contact
	nelsonperalta.prog@gmail.com
