<?php
declare(strict_types=1);

namespace Entity\Collection;

use Entity\Genre;
use Database\MyPdo;
use PDO;
class GenreCollection
{
    /**
     * Récupère la liste de tous les genres disponibles dans la base de données.
     *
     * @return Genre[] Tableau d'objets Genre triés par leur identifiant.
     */
    public static function findAll(): array
    {
        $db = MyPdo::getInstance();
        $stmt = $db->prepare("SELECT name, id FROM genre");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Genre::class);
    }
}