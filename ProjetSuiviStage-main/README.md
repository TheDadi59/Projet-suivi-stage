# Projet Plateforme suivi

# Mise en place du projet et de l'environnement de développement

1. Cloner repo et se placer dans le dossier laravelsuivi8

2. Installer les dépendances composer :

```shell
composer install
```

3. Installer les dépendances NPM :

```shell
npm install
```

_Nous pouvons maintenant configurer la base de données via Laragon._

4. Définir root password :

Ouvrir un terminal dans Laragon et se connecter à la BDD en tapant :

```shell
mysql -u root
```

On peut ensuite définir le mot de passe root, il sera utilisé pour se connecter à PhpMyAdmin et dans le fichier .env.

Commandes à réaliser :

```sql
ALTER USER 'root'@'localhost' IDENTIFIED BY 'root_pwd';
FLUSH privileges;
```

On peut ensuite quitter la console mysql avec la commande
```sql
exit;
```

5. Copier le fichier .env.example en .env

6. Modifier les identifiants de connexion à la BDD dans le fichier .env

7. Vérifier existance des deux BDD (suivi et ent) (via phpmyadmin), ou les créer.

8. Réaliser les migrations de chacun des BDD (dans l'ordre)

Pour l'ENT :
```shell
php artisan migrate:fresh --path .\database\migrations\ENT\ --database ent
```

Pour la base propre à l'app :
```shell
php artisan migrate:fresh --path .\database\migrations\Suivi\ --database suivi
```

9. Remplir les BDD avec les seeders

```shell
php artisan db:seed
```

# Lancement de l'App

Dans un terminal il suffit d'executer :

```shell
php artisan serve
```

# Compilation des ressources

Les ressources (js/css) doivent se trouver dans le dossier ressources. Il ne faut pas les modifier dans le dossier public !!!

Lorsqu'une ressource est modifié il faut lancer une compilation de manière à quelle soit mise à jour dans le dossier public :

```shell
npm run dev
```

Le fichier webpack.mix.js contient la liste des ressources à compiler lors de la création d'un nouveau fichier il est important l'ajouter à ce fichier sans quoi il ne sera pas compilé.

# Modifications app

### 1. Modifier la liste des extensions de fichiers autorisées.

La liste des extensions autorisées lors de la mise en ligne de fichiers ce situe dans le fichier ```APIController.php``` situé dans le chemin ```app/Http/Controllers/Suivi```.

Le nom de la constance est EXTENSIONS_AUTORISES.

### 2. Sécuriser les routes critiques

Les routes ayant besoin d'un contrôle spécifiques sont marquées par le commentaire suivant : ```TODO Securité route```

### 3. Modifier la structure des noms de fichiers uploadés

Il est possible de modifier le nom des fichiers crées lors de la validation d'un jalon.

Pour cela il faut modifier la construction de la chaine dans la fonction ```postValideJalon``` du controleur ```APIController```.

Elle est identifiable avec ce commentaire :

```text
/**
 * Configuration du nom du fichier sur le serveur
 *
 * Nom Prénom - Nom du jalon
 */
```

# Fonctions utiles

### Importer une activité

1. Insérer une nouvelle activité à suivre dans la base de données :
```sql
INSERT INTO activite
VALUES (valeur_id_template, valeur_id_utilisateur_referent, valeur_id_utilisateur_suivi, valeur_date_debut, valeur_est_cloture);
```

2. Associer les valeurs aux attributs de l'activité :
```sql
INSERT INTO valeur_attribut
VALUES (valeur_id_valeur_attribut, valeur_id_activite, valeur_id_attribut, valeur_valeur);
```

Un exemple de code pour insérer une activité est disponible dans le fichier "testNouvelleActivite.php"

# Perspectives d'amélioration

- Transférer un email à la DP en cas de problème au sein d'un jalon
- Ajouter la possibilité de faire des exports personnalisés pour la vue DP
- Créer une interface pour créer et modifier les templates et leurs jalons
- Intégrer un envoi de notifications via l'application IMT Nord Europe
- Dans la table "Attribut" du modèle de données ajouter une colonne "type" de valeur qui permettrai de savoir si la donnée est une url, un numéro de téléphone ou un email. Cela permet par exemple de créer automatique des liens mailto
