#/bin/bash

php bin/console doctrine:database:drop --force --if-exists #/supprime la table TRES DANGEREUX! A EVITER EN PROD!!!
php bin/console doctrine:database:create --no-interaction #/créé la BDD
php bin/console doctrine:migrations:migrate --no-interaction #/fait la migration de la BDD
php bin/console doctrine:fixtures:load --no-interaction #/ charge les fixtures