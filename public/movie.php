<?php

declare(strict_types=1);

use Html\AppWebPage;
use Entity\Movie;
use Entity\People;
use Entity\Collection\CastCollection;
use Entity\Exception\EntityNotFoundException;

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    http_response_code(400);
    exit("Paramètre 'id' manquant ou invalide");
}

try {
    $movie = Movie::findById((int)$_GET['id']);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit("Film introuvable");
}

$webPage = new AppWebPage("Films - " . $movie->getTitle());

$html = "<div class=\"menu\">";
$html .= "  <a href=\"index.php\">Accueil</a>";
$html .= "  <a href=\"edit.php?id=" . $movie->getId() . "\">Modifier</a>";
$html .= "  <a href=\"delete.php?id=" . $movie->getId() . "\" onclick=\"return confirm('Supprimer ce film ?')\">Supprimer</a>";
$html .= "</div>";

$html.= "<div class=\"movie-detail\">";
$html .= "<img class=\"poster\" src=\"image.php?id=" . $movie->getPosterId() . "\" alt=\"Affiche de " . $movie->getTitle() . "\">";
$html .= "<div class=\"movie-info\">";
$html .= "<div class=\"title-date\">";
$html .= "<span class=\"title\">" . $movie->getTitle() . "</span>";
$html .= "<span class=\"date\">" . $movie->getReleaseDate() . "</span>";
$html .= "</div>";
$html .= "<p class=\"original-title\">" . $movie->getOriginalTitle() . "</p>";
$html .= "<p class=\"tagline\">" . $movie->getTagline() . "</p>";
$html .= "<p class=\"overview\">" . $movie->getOverview() . "</p>";
$html .= "</div>";
$html .= "</div>";

$casting = CastCollection::findByMovieId($movie->getId());

$html .= "<h3>Distribution</h3>";
$html .= "<div class=\"cast-list\"><ul>";
foreach ($casting as $cast) {
    $people = People::findById($cast->getPeopleId());
    $html .= "<li>";
    $html .= "<a href=\"cast.php?id=" . $people->getId() . "\">";
    $html .= "<img src=\"image.php?id=" . $people->getAvatarId() . "\">";
    $html .= "<span class=\"cast-text\">";
    $html .= "<span class=\"role\">" . $cast->getRole() . "</span>";
    $html .= "<span class=\"actor-name\">" . $people->getName() . "</span>";
    $html .= "</span>";
    $html .= "</a>";
    $html .= "</li>";
}
$html .= "</ul></div>";
$webPage->appendContent($html);

echo $webPage->toHtml();