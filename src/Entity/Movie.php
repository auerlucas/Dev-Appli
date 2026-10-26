<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;
use Entity\Exception\EntityNotFoundException;

class Movie
{
    public ?int $posterId;
    public string $originalLanguage;
    public string $originalTitle;
    public string $overview;
    public string $releaseDate;
    public int $runtime;
    public ?string $tagline;
    public string $title;
    private ?int $id;

    /**
     * @return int
     */
    public function getPosterId()
    {
        return $this->posterId;
    }

    /**
     * @param int $posterId
     * @return Movie
     */
    public function setPosterId($posterId)
    {
        $this->posterId = $posterId;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage()
    {
        return $this->originalLanguage;
    }

    /**
     * @param string $originalLanguage
     * @return Movie
     */
    public function setOriginalLanguage($originalLanguage)
    {
        $this->originalLanguage = $originalLanguage;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalTitle()
    {
        return $this->originalTitle;
    }

    /**
     * @param string $originalTitle
     * @return Movie
     */
    public function setOriginalTitle($originalTitle)
    {
        $this->originalTitle = $originalTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     * @return Movie
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;
        return $this;
    }

    /**
     * @return string
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     * @return Movie
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * @param int $runtime
     * @return Movie
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    /**
     * @param string|null $tagline
     * @return Movie
     */
    public function setTagline(string|null $tagline)
    {
        $this->tagline = $tagline;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * @return Movie
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Crée une nouvelle instance de Movie et l'insère dans la base de données.
     *
     * @param int $posterId Identifiant de l'image de l'affiche.
     * @param string $originalLanguage Langue d'origine du film.
     * @param string $originalTitle Titre original du film.
     * @param string $overview Synopsis / résumé du film.
     * @param string $releaseDate Date de sortie.
     * @param int $runtime Durée du film en minutes.
     * @param string $tagline Phrase d'accroche.
     * @param string $title Titre principal en français.
     * @param int $id Identifiant du film.
     * @return Movie L'objet Movie créé et initialisé.
     */
    public static function create(int $posterId, string $originalLanguage,string $originalTitle, string $overview,
                                  string $releaseDate, int $runtime, string $tagline, string $title, int $id): Movie
    {
        if ($id ==null){
            $stmt = MyPdo::getInstance()->prepare(
                <<<SQL
                INSERT INTO movie (posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, title)
                VALUES (:posterId, :originalLanguage, :originalTitle, :overview, :releaseDate, :runtime, :title)
                SQL);
            $stmt->execute([':posterId'=>$posterId, ':originalLanguage'=>$originalLanguage, ':originalTitle'=>$originalTitle,
                            ':overview'=>$overview,':releaseDate'=>$releaseDate, ':runtime'=>$runtime, ':title'=>$title]);

        }else{
            $stmt = MyPdo::getInstance()->prepare(
                <<<SQL
                INSERT INTO movie (posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, title ,id)
                VALUES (:posterId, :originalLanguage, :originalTitle, :overview, :releaseDate, :runtime, :title, :id)
                SQL);
            $stmt->execute([':posterId'=>$posterId, ':originalLanguage'=>$originalLanguage, ':originalTitle'=>$originalTitle,
                            ':overview'=>$overview,':releaseDate'=>$releaseDate, ':runtime'=>$runtime, ':title'=>$title, ':id'=>$id]);
        }

        $movie = new Movie();
        $movie->setPosterId($posterId);
        $movie->setOriginalLanguage($originalLanguage);
        $movie->setOriginalTitle($originalTitle);
        $movie->setOverview($overview);
        $movie->setReleaseDate($releaseDate);
        $movie->setRuntime($runtime);
        $movie->setTitle($title);
        $movie->setId($id);

        return $movie;
    }
    /**
     * Retourne le film correspondant à l'identifiant donné
     * @param int $id
     * @return Movie
     * @throws EntityNotFoundException
     */
    public static function findById(int $id): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, title, tagline
        FROM movie
        WHERE id = :id
        SQL
        );
        $stmt->execute([':id' => $id]);
        $movie = $stmt->fetchObject(Movie::class);

        if (!$movie) {
            throw new EntityNotFoundException("Aucun film trouvé avec l'id : {$id}");
        }

        return $movie;
    }

    /**
     * Supprime le film actuel de la base de données.
     *
     * @return void
     */
    public function delete(): void
    {
        $stmt = MyPdo::getInstance()->prepare(
            "DELETE FROM movie WHERE id = :id"
        );
        $stmt->execute(['id' => $this->id]);
    }

    /**
     * Met à jour les données du film actuel dans la base de données.
     *
     * @return void
     */
    protected function update(): void
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            UPDATE movie
            SET title = :title,
                originalTitle = :originalTitle,
                releaseDate = :releaseDate,
                tagline = :tagline,
                overview = :overview,
                posterId = :posterId
            WHERE id = :id
        SQL
        );

        $stmt->execute([
            'id'=> $this->id,
            'title' => $this->title,
            'originalTitle'=> $this->originalTitle,
            'releaseDate'=> $this->releaseDate,
            'tagline'=> $this->tagline,
            'overview'=> $this->overview,
            'posterId'=> $this->posterId
        ]);
    }

    /**
     * Sauvegarde le film en base de données.
     *
     * @return void
     */
    public function save(): void
    {
        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }
}