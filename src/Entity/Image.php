<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;
use Entity\Exception\EntityNotFoundException;

class Image
{
    private int $id;
    private string $jpeg;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Image
     */
    public function setId(int $id): Image
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * @param string $jpeg
     * @return Image
     */
    public function setJpeg(string $jpeg): Image
    {
        $this->jpeg = $jpeg;
        return $this;
    }

    /**
     * Récupère une image spécifique par son identifiant unique.
     *
     * @param int $id Identifiant unique de l'image.
     * @return Image L'objet Image contenant les données binaires correspondantes.
     * @throws EntityNotFoundException Si aucune image ne correspond à cet identifiant.
     */
    public static function findById(int $id): Image
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id, jpeg
            FROM image
            WHERE  id = :id
        SQL
        );

        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Image::class);
        $image = $stmt->fetch();

        if (!$image) {
            throw new EntityNotFoundException("Aucune cover trouver avec : {$id}");
        }
        return $image;
    }
}