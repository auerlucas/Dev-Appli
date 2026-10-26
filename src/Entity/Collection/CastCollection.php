<?php
declare(strict_types=1);

namespace Entity\Collection;

use Entity\Cast;
use Database\MyPdo;
use PDO;
class CastCollection
{
    /**
     * Retourne les acteurs
     * @param int $movieId
     * @return Cast[]
     */
    public static function findByMovieId(int $movieId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, movieId, peopleId, role, orderIndex
        FROM cast
        WHERE movieId = :movieId
        ORDER BY orderIndex
        SQL
        );
        $stmt->execute([':movieId' => $movieId]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, Cast::class);
    }

    /**
     * Récupère la liste des rôles (cast) associés à un acteur grâce à son identifiant.
     *
     * @param int $peopleId Identifiant unique de l'acteur.
     * @return Cast[] Tableau d'objets Cast représentant la filmographie de l'acteur.
     */
    public static function findByPeopleId(int $peopleId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id, movieId, peopleId, role, orderIndex
            FROM cast
            WHERE peopleId = :peopleId
            SQL
        );
        $stmt->execute([':peopleId' => $peopleId]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, Cast::class);
    }
}