<?php
declare(strict_types=1);

use Html\AppWebPage;
use Entity\Movie;
use Database\MyPdo;

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$movie = Movie::findById((int)$_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie->setTitle($_POST['title']);
    $movie->setReleaseDate($_POST['releaseDate']);
    $movie->setOverview($_POST['overview']);
    $movie->setOriginalTitle($_POST['originalTitle']);
    $movie->setTagline($_POST['tagline']);

    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $stmt = MyPdo::getInstance()->prepare("INSERT INTO image (jpeg) VALUES (:jpeg)");
        $stmt->execute(['jpeg' => file_get_contents($_FILES['poster']['tmp_name'])]);
        $movie->setPosterId((int)MyPdo::getInstance()->lastInsertId());
    }

    $movie->save();
    header("Location: movie.php?id=" . $movie->getId());
    exit();
}

$webPage = new AppWebPage("Modifier " . $movie->getTitle());
$webPage->appendCssUrl("css/style.css");

$html = "<div class=\"menu-nav\"><a href=\"index.php\">Accueil</a></div>";
$html .= "<h1>Modifier le film</h1>";
$html .= "<form method=\"POST\" enctype=\"multipart/form-data\" style=\"padding: 20px; color: white;\">";
$html .= "<input type=\"text\" name=\"title\" value=\"" . $movie->getTitle() . "\" required><br><br>";
$html .= "<input type=\"text\" name=\"originalTitle\" value=\"" . $movie->getOriginalTitle() . "\"><br><br>";
$html .= "<input type=\"text\" name=\"releaseDate\" value=\"" . $movie->getReleaseDate() . "\"><br><br>";
$html .= "<input type=\"text\" name=\"tagline\" value=\"" . $movie->getTagline() . "\"><br><br>";
$html .= "<textarea name=\"overview\">" . $movie->getOverview() . "</textarea><br><br>";
$html .= "<p>Changer le poster:</p>";
$html .= "<input type=\"file\" name=\"poster\"><br><br>";
$html .= "<button type=\"submit\">Enregistrer</button>";
$html .= "</form>";

$webPage->appendContent($html);
echo $webPage->toHtml();