<?php
declare(strict_types=1);

use Entity\Movie;
use Entity\Exception;

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    try {
        $movie= Movie::findById((int)$_GET['id']);
        $movie->delete();
    } catch (Exception $e) {
    }
}

header("Location: index.php");
exit();