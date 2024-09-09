<?php

require_once __DIR__ . '/../autoload.php';

use App\Controllers\ArticleController;

$controller = new ArticleController();

$authorName = $_GET['author'];

if(!empty($authorName)) {
    $titles = $controller->getArticlesByAuthor($authorName);
    $num_articles = $controller->getTotalArticle($titles);
    
    echo "Sono stati trovati $num_articles Articoli di $authorName:<br />";
    foreach ($titles as $key => $title) {
        echo "- $title<br />";
    }

} else {
    echo "Per effettuare una ricerca è necessario specificare un autore.";
}

