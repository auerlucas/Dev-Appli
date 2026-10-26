<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Genre
{
    private string $name;
    private int $id;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Genre
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Genre
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Crée une nouvelle instance de Genre et l'insère dans la base de données.
     *
     * @param string $name Le nom du genre.
     * @param int $id L'identifiant du genre (peut être 0 ou null pour l'auto-incrément).
     * @return Genre L'objet Genre fraîchement créé.
     */
    public static function create(string $name, int $id): Genre
    {
        if ($id ==null){
            $stmt = MyPdo::getInstance()->prepare(
                <<<SQL
                INSERT INTO genre (name)
                VALUES (:name)
                SQL);
            $stmt->execute([':name'=>$name]);

        }else{
            $stmt = MyPdo::getInstance()->prepare(
                <<<SQL
                INSERT INTO genre (id, name)
                VALUES (:id, :name)
                SQL);
            $stmt->execute([':id'=>$id, ':name'=>$name]);
        }

        $genre = new Genre();
        $genre->setName($name);
        $genre->setId($id);

        return $genre;
    }
}