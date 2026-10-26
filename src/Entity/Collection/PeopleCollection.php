<?php
declare(strict_types=1);

namespace Entity\Collection;

use Entity\People;
use Database\MyPdo;
use PDO;
class PeopleCollection
{
    /**
     * Récupère la liste de toutes les personnes disponibles dans la base de données.
     *
     * @return People[] Tableau d'objets People triés par leur identifiant.
     */
    public static function findAll(): array
    {
        $db = MyPdo::getInstance();
        $stmt = $db->prepare("SELECT avatarId, birthday, deathday, name, biography, placeOfBirth, id FROM people");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, People::class);
    }
}