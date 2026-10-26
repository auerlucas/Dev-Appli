<?php
declare(strict_types=1);

use Html\AppWebPage;
use Database\MyPdo;
use Entity\Collection\MovieCollection;
use Entity\Movie;
use Entity\Image;


$webPage = new AppWebPage("Films");
$movies = MovieCollection::findAll();

$html = "<div class=\"menu\">";
$html .= "  <a href=\"index.php\">Accueil</a>";
$html .= "  <a href=\"create.php\">Créer un film</a>";
$html .= "</div>";

$html.= "<h1>Liste des films</h1> <div class=\"scroll\"> <ul>";
foreach ($movies as $movie) {
    $html .= "<li><a href=\"movie.php?id=" . $movie->getId() . "\">";
    $html .= "<img src=\"image.php?id=" . $movie->getPosterId() . "\">";
    $html .= $movie->getTitle();
    $html .= "</a></li>";
}
$html.="</ul> </div>";

$webPage->appendContent($html);

echo $webPage->toHtml();
