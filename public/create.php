<?php
declare(strict_types=1);


use Html\AppWebPage;
use Entity\Movie;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title'])) {
    $movie = Movie::create(
        0,
        $_POST['originalLanguage'] ?? 'fr',
        $_POST['originalTitle'] ?? $_POST['title'],
        $_POST['overview'] ?? '',
        $_POST['releaseDate'] ?? '',
        (int)($_POST['runtime'] ?? 0),
        $_POST['tagline'] ?? '',
        $_POST['title'],
        0
    );

    header("Location: index.php");
    exit();
}

$webPage = new AppWebPage("Ajouter un film");
$webPage->appendCssUrl("css/style.css");

$html= "<div class=\"menu-nav\"><a href=\"index.php\">Accueil</a></div>";
$html.= "<h1>Ajouter un film</h1>";
$html.= "<form method=\"POST\" style=\"padding: 20px; color: white;\">";
$html.= "  <input type=\"text\" name=\"title\" placeholder=\"Titre\" required><br><br>";
$html.= "  <input type=\"text\" name=\"originalTitle\" placeholder=\"Titre original\"><br><br>";
$html.= "  <input type=\"text\" name=\"originalLanguage\" placeholder=\"Langue\"><br><br>";
$html.= "  <input type=\"text\" name=\"releaseDate\" placeholder=\"Date\"><br><br>";
$html.= "  <input type=\"text\" name=\"runtime\" placeholder=\"Durée\"><br><br>";
$html.= "  <input type=\"text\" name=\"tagline\" placeholder=\"Accroche\"><br><br>";
$html.= "  <textarea name=\"overview\" placeholder=\"Synopsis\"></textarea><br><br>";
$html.= "  <button type=\"submit\">Créer le film</button>";
$html.= "</form>";

$webPage->appendContent($html);
echo $webPage->toHtml();