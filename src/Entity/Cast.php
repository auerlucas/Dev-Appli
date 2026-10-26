<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use PDO;

class Cast
{
    private int $id;
    private int $movieId;
    private int $peopleId;
    private ?string $role;
    private int $orderIndex;

    /***
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /***
     * @param int $id
     * @return $this
     */
    public function setId(int $id): Cast
    {
        $this->id = $id;
        return $this;
    }

    /***
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /***
     * @param int $movieId
     * @return $this
     */
    public function setMovieId(int $movieId): Cast
    {
        $this->movieId = $movieId;
        return $this;
    }

    /***
     * @return int
     */
    public function getPeopleId(): int
    {
        return $this->peopleId;
    }

    /***
     * @param int $peopleId
     * @return $this
     */
    public function setPeopleId(int $peopleId): Cast
    {
        $this->peopleId = $peopleId;
        return $this;
    }

    /***
     * @return ?string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /***
     * @param ?string $role
     * @return $this
     */
    public function setRole(?string $role): Cast
    {
        $this->role = $role;
        return $this;
    }

    /***
     * @return int
     */
    public function getOrderIndex(): int
    {
        return $this->orderIndex;
    }

    /***
     * @param int $orderIndex
     * @return $this
     */
    public function setOrderIndex(int $orderIndex): Cast
    {
        $this->orderIndex = $orderIndex;
        return $this;
    }

    /**
     * Récupère un rôle (cast) spécifique par son identifiant unique.
     *
     * @param int $id Identifiant unique du rôle.
     * @return Cast L'objet Cast correspondant à l'identifiant.
     * @throws EntityNotFoundException Si aucun rôle ne correspond à cet identifiant.
     */
    public static function findById(int $id): Cast
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id, movieId, peopleId, role, orderIndex
            FROM cast
            WHERE  id = :id
        SQL
        );

        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Cast::class);
        $cast = $stmt->fetch();

        if (!$cast) {
            throw new EntityNotFoundException("Aucune cover trouver avec : {$id}");
        }
        return $cast;
    }
}