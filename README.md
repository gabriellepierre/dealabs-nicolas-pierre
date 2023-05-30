# dealabs-nicolas-pierre

Générer les dossiers "vendor" et "var" : composer upgradesymfon
Utiliser PHP : docker exec -it -u root lpa_sf6_php bash

<!--  -->

php -S localhost:8000 -t public

(database create)

> php bin/console d:d:c
> Puis
> php bin/console make:migration

> php bin/console d:m:m

# Supprimer les migrations s'il y a des erreurs mais il faut refaire les 3 commandes précédentes pour regénérer le fichier de migrations.

# Lancer docker :

docker-compose build
docker-compose up

# S'il n'y a pas de .vendor

composer upgrade
