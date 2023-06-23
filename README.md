# dealabs-nicolas-pierre

<pre><code>Le tableur avec nos réalisations se trouve dans /public/consignes</code></pre>

## Cloner le repo

git@github.com:gabriellepierre/dealabs-nicolas-pierre.git

# Lancer docker :

<!-- Attention, il faut s'assurer qu'il n'y a pas de dossier /data dans le dossier .docker/ -->

`docker-compose build`

`docker-compose up`

## Utiliser PHP :

`docker exec -it -u root lpa_sf6_php bash`

# Mise en place de l'environnement de dev

### Générer les dossiers "vendor" et "var" :

`composer install`

### Générer le dossier "node_modules" :

`yarn install`

### Mettre à jour les modifications en JS :

`yarn run watch`

#### Avant de faire les migrations :

Créez à la main un dossier "migrations" à la racine du projet

### Création de la base de données :

> `php bin/console d:d:c`
> Il est possible qu'elle soit déjà créée, dans ce cas passez à l'étape suivante

### Puis

> `php bin/console make:migration`

### Puis

> `php bin/console d:m:m`

### Charger les fixtures :

> `php bin/console doctrine:fixtures:load`

Bien entrer "yes" lorqu'il demande si on veut purger la DB

# Lancer le projet

localhost:8081

# Pour se connecter

Il existe 5 utilisateurs.

> username1, username2, username3, username4, username5
> pour chacun de ces utilisateurs, le mot de passe est : `test`
> Seul le username1 a posté des deals.
