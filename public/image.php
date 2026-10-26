<?php

declare(strict_types=1);

use Entity\Image;
use Entity\Exception\EntityNotFoundException;

if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    http_response_code(302);
    header('/img/actor.png');
    exit();
}

try {
    $image = Image::findById((int)$_GET['id']);
    header('Content-Type: image/jpeg');
    echo $image->getJpeg();
} catch (EntityNotFoundException $e) {
    http_response_code(302);
    header('/img/actor.png');
}