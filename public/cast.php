<?php
declare(strict_types=1);

use Html\AppWebPage;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\People;
use Entity\Movie;
use Entity\Collection\CastCollection;

try{
    if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) {
        header("Location: index.php");
        exit();
    }
    $id = (int)$_GET['id'];

    $people = People::findById($id);

    $webPage = new AppWebPage("Films - " . $people->getName());

    $html = "<div class=\"menu\">";
    $html.= "  <a href=\"index.php\">Accueil</a>";
    $html.= "</div>";

    $html.= "<div class=\"movie-detail\">";
    $html.= "<img class=\"poster\" src=\"image.php?id=" . $people->getAvatarId() . "\">";
    $html.= "<div class=\"movie-info\">";
    $html.= "<div class=\"title-date\">";
    $html.= "<span class=\"title\">" . $people->getName() . "</span>";
    $html.= "<span class=\"date\">" . $people->getBirthday() . "</span>";
    $html.= "</div>";

    if ($people->getDeathday()) {
        $html .= "<p class=\"original-title\">Décès : " . $people->getDeathday() . "</p>";
    }

    $html.= "<p class=\"tagline\">" . $people->getPlaceOfBirth() . "</p>";
    $html.= "<p class=\"overview\">" . $people->getBiography() . "</p>";
    $html.= "</div>";
    $html.= "</div>";

    $html .= "<h3>Filmographie</h3>";
    $html .= "<div class=\"cast-list\"><ul>";

    $casts = CastCollection::findByPeopleId($id);
    foreach ($casts as $cast) {
        try {
                $movie = Movie::findById($cast->getMovieId());

                $html .= "<li>";
                $html .= "<a href=\"movie.php?id=" . $movie->getId() . "\">";
                $html .= "<img src=\"image.php?id=" . $movie->getPosterId() . "\">";
                $html .= "<span class=\"movie-info\">";
                $html .= "<span class=\"title\">" . $movie->getTitle() . "</span>";
                $html .= "<span class=\"date\">" . $cast->getRole() . " (" . $movie->getReleaseDate() . ")</span>";
                $html .= "</span>";
                $html .= "</a>";
                $html .= "</li>";
        } catch (EntityNotFoundException $e) {
            continue;
        }
    }

    $html .= "</ul></div>";
    $webPage->appendContent($html);

    echo $webPage->toHtml();

} catch (ParameterException) {
http_response_code(400);
echo "Requête invalide : paramètre manquant ou incorrect.";
} catch (EntityNotFoundException) {
http_response_code(404);
echo "Pochette introuvable.";
} catch (Exception) {
http_response_code(500);
echo "Erreur interne du serveur.";
}