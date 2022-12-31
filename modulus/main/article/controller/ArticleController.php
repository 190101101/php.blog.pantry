<?php 

namespace modulus\main\article\controller;
use modulus\main\article\model\ArticleModel;
use core\controller;
use pagination;

class ArticleController extends controller
{
    public $article;
    
    public function __construct()
    {
        $this->article = new ArticleModel();
        $this->page = new pagination();
    }

    public function article()
    {
        $this->layout('general', 'main', 'article', 'article', [
            'page' => $p = $this->page->page($this->article->ArticleCount(), 5),
            'article' => $this->article->ArticleList($p->start, $p->limit),
            'column' => $this->article->ArticleColumn(),
        ]);
    }

    public function ArticleSave($id)
    {
        $this->article->ArticleSave($id);
    }

    public function ArticleDelete($id)
    {
        $this->article->ArticleDelete($id);
    }

    public function ArticleSearchEngine()
    {
        $this->article->ArticleSearchEngine();
    }

    public function ArticleSearch($value)
    {        
        $this->layout('main', 'main', 'article', 'search', [
            'page' => $p = $this->page->page($this->article->articleSearchCount($value), 12),
            'article' => $this->article->ArticleSearch($value, $p->start, $p->limit),
            'search' => (object) ['value' => $value],
        ]);
    }

    public function articleByUser($id)
    {
        $this->layout('main', 'main', 'article', 'byUser', [
            'page' => $p = $this->page->page($this->article->articleByUserCount($id), 10),
            'article' => $this->article->articleByUser($id, $p->start, $p->limit),
            'user' => $this->article->UserById($id)
        ]);
    }

    public function articleById($id)
    {
        $this->layout('main', 'main', 'article', 'read', [
            'article' => $this->article->articleById($id),
            'similar' => $this->article->ArticleSimilar(),
            'keyword' => $this->article->keyword(),
        ]);
    }
    
    public function ArticleRead($section, $category, $article)
    {
        $this->layout('main', 'main', 'article', 'read', [
            'article' => $this->article->ArticleRead($section, $category, $article),
            'similar' => $this->article->ArticleSimilar(),
            'keyword' => $this->article->keyword(),
        ]);
    }

    public function ByCategory($section, $category)
    {
        $this->layout('main', 'main', 'article', 'ByCategory', [
            'page' => $p = $this->page->page($this->article->ByCategoryCount($section, $category), 12),
            'article' => $this->article->ByCategory($section, $category, $p->start, $p->limit),
            'category' => $this->article->CategoryBySlug($category),
        ]);
    }
}
