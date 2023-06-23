# dealabs-nicolas-pierre

Le tableur avec nos réalisations se trouve dans /public/consignes

# Générer les dossiers "vendor" et "var" :

composer install

# Générer le dossier "node_modules" :

npm install

# ou

yarn install

<!--  -->

# Afficher les modifications en JS :

npm run watch

<!--  -->

# Lancement du projet SANS DOCKER :

php -S localhost:8000 -t public

# Lancer docker :

docker-compose build
docker-compose up

# Utiliser PHP :

docker exec -it -u root lpa_sf6_php bash

<!--  -->

# Création de la base de données :

> php bin/console d:d:c

# Puis

> php bin/console make:migration

# Puis

> php bin/console d:m:m

# Charger les fixtures :

> php bin/console doctrine:fixtures:load

# Supprimer les migrations s'il y a des erreurs mais il faut refaire les 3 commandes précédentes pour regénérer le fichier de migrations.
