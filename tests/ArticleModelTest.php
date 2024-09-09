<?php

use PHPUnit\Framework\TestCase;
use App\Models\ArticleModel;

class ArticleModelTest extends TestCase {
    private $articleModel;

    protected function setUp(): void {
        $this->articleModel = new ArticleModel();
    }

    public function testFetchArticlesByAuthor() {
        $authorName = "epaga";
        $result = $this->articleModel->fetchArticlesByAuthor($authorName);
        
        $this->assertIsArray($result);

        $this->assertNotEmpty($result);
    }

    public function testFetchArticlesByAuthorInvalidAuthor() {
        $authorName = "---";
        $result = $this->articleModel->fetchArticlesByAuthor($authorName);
        
        $this->assertEmpty($result);
    }
}
