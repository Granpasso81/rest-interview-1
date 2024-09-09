<?php

namespace App\Models;

class ArticleModel {
    private $baseUrl = "https://jsonmock.hackerrank.com/api/articles";

    public function fetchArticlesByAuthor($authorName = null) {

        $titles = array();
        if (!empty($authorName) && is_string($authorName)) {
            $titles = [];
            $page = 1;
            $totalPages = 1;
        
            do {
                $url = $this->baseUrl . "?author=" . urlencode($authorName) . "&page=" . $page;

                $response = $this->makeRequest($url);
        
                $data = json_decode($response, true);
        
                if (isset($data['error'])) {
                    throw new \Exception("Api error: " . $data['error']);
                }
        
                if (isset($data['total_pages'])) {
                    $totalPages = $data['total_pages'];
                } else {
                    throw new \Exception("Struttura API inaspettata");
                }
        
                foreach ($data['data'] as $article) {
                    $title = $this->getArticleTitle($article);
                    if ($title !== null) {
                        $titles[] = $title;
                    }
                }
        
                $page++;
            } while ($page <= $totalPages);
        } else {
            throw new \Exception("Per effettuare una ricerca è necessario specificare un autore.");
            return;
        }
    
        return $titles;
    }
    

    private function makeRequest($url = null) {

        if(!empty($url) && is_string($url)) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);  
            curl_setopt($ch, CURLOPT_NOBODY, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $response = curl_exec($ch);
        
            if ($response === false) {
                throw new \Exception('Errore: ' . curl_error($ch));
            }
        
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $body = substr($response, $headerSize);
        
            curl_close($ch);
        
            if ($httpCode >= 400) {
                throw new \Exception("Errore HTTP: $httpCode - $body");
            }
        } else {
            throw new \Exception("Url Non Valida");
        }
    
        return $body;
    }
    

    private function getArticleTitle($article) {
        if (!empty($article['title'])) {
            return $article['title'];
        } elseif (!empty($article['story_title'])) {
            return $article['story_title'];
        }
        return null;
    }
}