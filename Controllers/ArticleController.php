<?php

namespace App\Controllers;

use App\Models\ArticleModel;
use App\Utilities\CacheUtility;

class ArticleController {
    private $model;
    private $cache;

    public function __construct() {
        $this->model = new ArticleModel();
        $this->cache = new CacheUtility();
    }

    public function getArticlesByAuthor($authorName = null) {
     
        if (!empty($authorName) && is_string($authorName)) {
            $cacheKey = "articles_".$authorName;
            
            $cachedData = $this->cache->get($cacheKey);
            
            if ($cachedData !== false) {
                return $cachedData;
            }
            try {
                $titles = $this->model->fetchArticlesByAuthor($authorName);
            } catch (\Exception $e) {
                echo "Si è verificato un errore nella chiamata all'API: " . $e->getMessage();
                return [];
            }
            
            $this->cache->set($cacheKey, $titles, 3600);
        } else {
            throw new \Exception("Per effettuare una ricerca è necessario specificare un autore.");
            return;
        }

        return $titles;
    }


    public function getTotalArticle($article_lists = null) {
        
        $tot_articles = 0;
        if(!empty($article_lists) && is_array($article_lists)) {
            $tot_articles = count($article_lists);
        }

        return $tot_articles;
    }
    
}