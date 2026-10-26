# SAE2-01 - Développement application

Nom des membres du binôme : AUER, BUGNICOURT
Prénom des membres du binôme : LUCAS, NOAM
login des membres du binôme : auer0003, bugn0011

## Description

Application web de consultation d'une base de données de films.
Permet d'afficher la liste des films, le détail d'un film avec ses
acteurs, et le détail d'un acteur avec sa filmographie.

## Installation

1. Cloner le dépôt : git clone https://iut-info.univ-reims.fr/gitlab/auer0003/sae2-01.git
2. Installer les dépendances : composer install
3. Créer un fichier .mypdo.ini a la racine du projet avec la configuration de la base de données

## Lancement

composer start
puis ouvrir http://localhost:8000

## Fonctionnalités

Liste de tous les films
Détail d'un film avec sa distribution
Détail d'un acteur avec la liste de ses films 
Affiche / Photo par défaut si l'image n'existe pas (Pas fonctionnel)


## Scripts Composer 

composer test:cs -tests de qualité
composer start -lance le serveur

SAE 2-01
        bin/
            run-server.bat -lancement du serveur Windows

            run-server.sh -lancement du serveur Linux

        public/
            
            css/

                style.css -Mise en forme

            img/

                actor.png -photo acteur par défaut

                movie.png -affiche de film par défaut

            
            index.php -code liste des films

            movie.php -code détails d'un films + acteurs

            cast.php -code détails d'un acteurs + films

            image.php -affiche une image depuis la base

            delete.php -retire un film

            edit.php -modifie une film

            create.php -créer un film

            src/

                Database/

                            MyPdo.php -Connexion a la base de données

                Entity/

                            Collection/

                                        CastCollection.php -collection de casts

                                        GenreCollection.php -collection de genres

                                        ImageCollection.php -collection d'images

                                        MovieCollection.php -collection de films

                                        PeopleCollection.php -collection de personnes

                            Exception/

                                        EntityNotFoundException.php

                                        ParameterException.php

                            Cast.php

                            Genre.php

                            Image.php

                            Movie.php

                            People.php

            Html/

                    AppWebPage.php -Page web perso

                    WebPage.php -Page web de base

        .gitignore

        .myPdo.ini -Configuration base de données

        composer.json

        README.md  