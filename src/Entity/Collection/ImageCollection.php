<?php
declare(strict_types=1);

namespace Entity\Collection;

use Entity\Image;
use Database\MyPdo;
use PDO;

class ImageCollection
{
    /**
     * Récupère la liste de toutes les images disponibles dans la base de données.
     *
     * @return Image[] Tableau d'objets Image triés par leur identifiant.
     */
    public static function findAll(): array
    {
        $db = MyPdo::getInstance();
        $stmt = $db->prepare("SELECT jpeg, id FROM image");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Image::class);
    }
}