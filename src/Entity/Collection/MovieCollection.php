<?php
declare(strict_types=1);

namespace Entity\Collection;

use Entity\Movie;
use Database\MyPdo;
use PDO;

class MovieCollection
{
    /**
     * Récupère la liste de tous les films disponibles dans la base de données.
     *
     * @return Movie[] Tableau d'objets Movie triés par leur identifiant.
     */
    public static function findAll(): array
    {
        $db = MyPdo::getInstance();
        $stmt = $db->prepare("SELECT posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, title ,id FROM movie");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }

    /**
     * Récupère la liste de tous les films appartenant à un genre spécifique.
     *
     * @param int $genreId Identifiant unique du genre.
     * @return Movie[] Tableau d'objets Movie triés par titre alphabétique.
     */
    public static function findByGenreId(int $genreId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, title, originalTitle, releaseDate, tagline, overview, posterId
        FROM movie m
        JOIN movie_genre mg ON m.id = mg.movieId
        WHERE genreId = :genreId
        ORDER BY m.title
    SQL
        );
        $stmt->execute(['genreId' => $genreId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }
}