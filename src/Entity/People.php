<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class People
{
    private int $id;
    private ?int $avatarId;
    private string $name;
    private ?string $birthday;
    private ?string $deathday;
    private ?string $biography;
    private ?string $placeOfBirth;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return People
     */
    public function setId(int $id): People
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }

    /**
     * @param int|null $avatarId
     * @return People
     */
    public function setAvatarId(?int $avatarId): People
    {
        $this->avatarId = $avatarId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return People
     */
    public function setName(string $name): People
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * @param string|null $birthday
     * @return People
     */
    public function setBirthday(?string $birthday): People
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }

    /**
     * @param string|null $deathday
     * @return People
     */
    public function setDeathday(?string $deathday): People
    {
        $this->deathday = $deathday;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBiography(): ?string
    {
        return $this->biography;
    }

    /**
     * @param string|null $biography
     * @return People
     */
    public function setBiography(?string $biography): People
    {
        $this->biography = $biography;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    /**
     * @param string|null $placeOfBirth
     * @return People
     */
    public function setPlaceOfBirth(?string $placeOfBirth): People
    {
        $this->placeOfBirth = $placeOfBirth;
        return $this;
    }
    /**
     * Retourne la personne correspondant à l’identifiant donné
     * @param int $id
     * @return People
     * @throws EntityNotFoundException
     */
    public static function findById(int $id): People
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, avatarId, name, birthday, deathday, biography, placeOfBirth
        FROM people
        WHERE id = :id
        SQL
        );
        $stmt->execute([':id' => $id]);
    $people = $stmt->fetchObject(People::class);

    if (!$people) {
        throw new EntityNotFoundException(" Aucune personne trouvée avec l’id : {$id} ");
    }

    return $people;
}
}