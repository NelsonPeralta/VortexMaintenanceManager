*English below

# Vortex Maintenance Manager
	
## Sommaire
Vortex Maintenance Manager est une application web qui permet la création d’un système de gestion de maintenance.

Plus précisément, elle concentre sur la création de formulaires des travaux faits à l’intérieur d’une usine qu’on appelle des “Bons de Travail”.

Ceux-ci permettront de garder une archive de tous les détails qui concernent le travail comme le nombre de pièces utilisées et le nombre d’heures investis.

Finalement, ils serviront de guide pour une meilleure planification d’un même travail dans le futur.

## Installation
1. Installez Xampp(https://www.apachefriends.org/index.html).
	1.5 Copiez-collez le dossier "dev" du projet sous "C:\xampp\htdocs\". Renommez-le "vortexmaintenance".
2. Démarrez XAMPP Control Panel.
	2.5 Démarrez, sur XAMPP, les modules Apache et MySQL.
3. Accédez phpMyAdmin localement en écrivant dans votre navigateur web "http://localhost/phpmyadmin/index.php?route=/server/sql".
4. Cliquez sous l'onglet "SQL" et démarrez le code qui se retrouve dans "\vortexmaintenance\scripts\globaldb_creation.sql" 
	pour creer vos base de donnees par defaut, incluant la base de donnees globale. Il ne suffit que de copier-coller le code
	dans le champs de texte sous l'onglet mentionné et cliquer le bouton "Go" au bas-droit du module.
5. Accédez au site web en écrivant "http://localhost/vortexmaintenance/index.php" dans votre navigateur web.

## Utilisation
À partir de la page d'acceuil, Vous pouvez vous inscrire en cliquant sur Register et remplir les champs de donnees.

Votre compte et base de donnees sera créer si aucun utilisateur existe avec les informations données.

Connectez vous en cliquant sur le bouton Login et remplissez les champs de texte.

4 onglets s'afficherons a vous:
1. Work Orders
	Vous serez immédiatemment ammené sur cette page.
	
	Vous avez l'option de créer un nouveau bon de travail en cliquant sur "New Work Order". Une nouvelle fenetre s'ouvrira.
	Renplissez aumoins le champ "Titre" et cliquez sur "Save" pour sauvegarder le bon de travail. Vous pouvez maintenant fermer la fenêtre.
	Le bon de travail s'affichera dans la liste.
	
	Vous pouvez aussi cliquer sur un bon existant et une nouvelle page s'affichera. 
	Vous avez maintenant la possibilité de modifier, supprimer ou de ferme le bon de travail.
	
2. Employees
	Remplissez les champs de données dans la section "New Employee". Cliquez sur "Add Employee" pour ajouter le membre s'il n'existe pas déja.
	Ce nouveau membre s'affichera sur la liste.
	
	Cliquez sur le bouton "View" ou "Delete" pour modifier et supprimer un membre existant respectivement.
3. Equipement
	Remplissez les champs de données dans la section "New Equipement". Cliquez sur "Add Equipement" pour ajouter la machine si elle n'existe pas déja.
	Cette nouvelle machine s'affichera sur la liste.
	
	Cliquez sur le bouton "View" ou "Delete" pour modifier et supprimer une machine existant respectivement.
4. Inventory
	Remplissez les champs de données dans la section "New Part". Cliquez sur "Save New Part" pour ajouter la pièce si elle n'existe pas déja.
	Cette nouvelle machine s'affichera sur la liste.
	
	Cliquez une pièce existante pour visualiser et supprimer une pièce existante.
## Contact
nelsonperalta.prog@gmail.com

# Vortex Maintenance Manager

## Summary
Vortex Maintenance Manager is a web application that allows the creation of a maintenance management system.
Specifically, it focuses on creating forms of work done inside a factory called “Work Orders”.
These will allow you to keep an archive of all the details concerning the work such as the number of parts used and the number of hours invested.
Finally, they will serve as a guide for better planning of the same job in the future.
	
## Installation
1. Install Xampp (https://www.apachefriends.org/index.html).
	1.5 Copy and paste the "dev" folder of the project under "C:\xampp\htdocs\". Rename it to "vortexmaintenance".
2. Start XAMPP Control Panel.
	2.5 Start, in XAMPP, the Apache and MySQL modules.
3. Access phpMyAdmin locally by writing in your web browser "http://localhost/phpmyadmin/index.php?route=/server/sql".
4. Click on the "SQL" tab and start the code found in "\vortexmaintenance\scripts\globaldb_creation.sql"
	to create your default database, including the global database. Just copy and paste the code
	in the text field under the mentioned tab and click the "Go" button at the bottom right of the module.
5. Access the website by entering "http://localhost/vortexmaintenance/index.php" in your web browser.
	
## Use
From the home page, You can register by clicking on Register and fill in the data fields.
Your account and database will be created if no user exists with the given information.

Log in by clicking on the Login button and fill in the text fields.

4 tabs are displayed to you:
1. Work Orders
You will immediately be taken to this page.
You have the option of creating a new work order by clicking on "New Work Order". A new window will open.
Fill in the "Title" field at least and click on "Save" to save the work order. You can now close the window.
The work order will appear in the list.
You can also click on an existing voucher and a new page will appear.
You now have the option to modify, delete or close the work order.

2. Employees
Complete the data fields in the "New Employee" section. Click on "Add Employee" to add the member if it does not already exist.
This new member will appear on the list.
Click on the "View" or "Delete" button to modify and delete an existing member respectively.

3. Equipment
Fill in the data fields in the "New Equipment" section. Click on "Add Equipment" to add the machine if it does not already exist.
This new machine will appear on the list.
Click on the "View" or "Delete" button to modify and delete an existing machine respectively.
4. Inventory
Fill in the data fields in the "New Part" section. Click on "Save New Part" to add the part if it does not already exist.
This new machine will appear on the list.
Click an existing part to view and delete an existing part.
		
## Contact
	nelsonperalta.prog@gmail.com