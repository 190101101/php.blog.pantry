<?php 

namespace modulus\main\article\model;
use core\model;
use \library\error;
use \Valitron\Validator as v;
use old;
use User;
use Article;

class ArticleModel extends model
{
    public function ArticleColumn()
    {
        return $this->db->columns('article');
    }    

    public function keyword()
    {
        return $this->db->t1where('article', 'category_id != 1 ORDER BY article_view DESC LIMIT 144', [], 2);
    }    

    public function articleById($id)
    {
        return $this->db->t3where('article', 'category', 'section', 'article.article_status=1 && category.category_status=1 && section.section_status=1 && article.article_id=?', [$id]) ?: $this->return->code(404)->return('not_found')->get()->http();
    }    

    public function ArticleRead($section, $category, $article)
    {
        $article = $this->db->t3where('article', 'category', 'section', 'article.article_status=1 && category.category_status=1 && section.section_status=1 && article.article_status=1 && section.section_slug=? && category.category_slug=? && article.article_slug=?', [
            $section, $category, $article
        ]) ?: $this->return->code(404)->return('not_found')->get()->http();

        if(!Article::review($article->article_id)){
            $this->db->increment('article', 'article_view', $article->article_id);
            Article::create($article->article_id);
        }
        return $article;
    }

	public function ArticleCount()
    {
        return $this->db->t2count('save', 'article', 'article.article_status=1 && save.user_id=?', [User::user_id()])->count;
    }    

    public function ArticleList($start, $limit)
    {
        return $this->db->t2where('save', 'article', "article.article_status=1 && save.user_id=?
            ORDER BY article.article_id DESC LIMIT {$start}, {$limit}", [User::user_id()], 2, 2);
    }

    #
    public function UserById($id)
    {
        return $this->db->t1where('user', "user_id=?", [$id]);
    }

    #
    public function CategoryById($id)
    {
        return $this->db->t1where('category', "category_status=1 && category_id=?", [$id]);
    }

    #
    public function CategoryBySlug($slug)
    {
        return $this->db->t1where('category', "category_status=1 && category_slug=?", [$slug]);
    }

    #
    public function category()
    {
        return $this->db->t1where('category', "category_status=1", [], 2);
    }

    #
    public function ArticleByUserId($id)
    {
        return $this->db->t2where('save', 'article', 
            "save.user_id=? && article.article_status=1 && article.article_id=?", [
                User::user_id(), $id]) 
        ?: $this->return->code(404)->return('not_found', 'article')
            ->get()->http('article/page/1');
    }

    public function ArticleSave($id)
    {
        $article = $this->db->t2where('article', 'category', 'article.article_status=1 && article.article_id=? && category.category_status=1', [$id]) 
            ?: $this->return->code(404)->return('not_found')->get()->referer();

        !$this->db->t1where('save', 'article_id=? && user_id=? ', [
            $article->article_id, User::user_id()
        ]) ?: $this->return->code(404)->return('already_save')->get()->referer();

        $create = $this->db->create('save', [
            'user_id' => User::user_id(),
            'article_id' => $article->article_id
        ]);

        $create['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->referer();

        unset($id); unset($delete); unset($article);

        $this->return->code(200)->return('success')->get()->referer();
    }

    public function ArticleDelete($id)
    {
        $save = $this->db->t1where('save', 'user_id=? && save_id=?', [
            User::user_id(), $id
        ]) ?: $this->return->code(404)->return('not_found')->json();

        $delete = $this->db->delete('save', [
            'save_id' => $save->save_id,
        ], ['id' => 'save_id']);

        $delete['status'] == TRUE ?:
            $this->return->code(404)->return('error')->json();

        unset($id); unset($delete); unset($article);

        $this->return->code(200)->return('success')->json();
    }

    public function ArticleSearchEngine()
    {        
        $http1 = 'article/search/data/';

        $form = [
            'page',
            'field_value',
        ];

        #array diff keys
        array_different($form, $_GET) ?: 
            $this->return->code(404)->return('error_form')->get()->http();

        #peel tags of array
        $data = peel_tag_array($_GET);
        $data += ['page_key' => 'article/search/key/value'];
        $data += ['field_key' => 'article.article_slug'];

        #valitron
        $v = new v($data);

        $v->rule('required', 'page');
        $v->rule('required', 'page_key');
        $v->rule('required', 'field_key');
        $v->rule('required', 'field_value');

        $v->rule('lengthMin', 'field_value', 3);
        $v->rule('lengthMin', 'field_key', 3);

        $v->rule('lengthMax', 'field_value', 20);
        $v->rule('lengthMax', 'field_key', 100);

        $v->rule('equals', 'page', 'page_key');

        error::valitron($v);
        $seo = seo($data['field_value']);
        
        $this->return->http("{$http1}{$seo}/page/1");
    }

    public function articleSearchCount($value)
    {
        return $this->db->t3count('article', 'category', 'section', "article.article_status=1 && category.category_status=1 && section.section_status=1 && article.article_slug LIKE ? ORDER BY article.article_id DESC", ["%{$value}%"])->count
        ?: $this->return->code(404)->return('not_found')->get()->http();
    }

    public function ArticleSearch($value, $start, $limit)
    {
        return $this->db->t3where('article', 'category', 'section', "article.article_status=1 && category.category_status=1 && section.section_status=1 && article_slug LIKE ? 
            ORDER BY article.article_id DESC LIMIT {$start}, {$limit}", ["%{$value}%"], 2, 2);
    }

    /**/
    public function articleByUserCount($id)
    {
        return $this->db->t2count('article', 'user', "
            article.article_status=1 && article.article_type=1 && user.user_id=? 
            ORDER BY article.article_id DESC", [$id], 2)->count
        ?: $this->return->code(404)->return('not_found')->get()->http();
    }

    public function articleByUser($id, $start, $limit)
    {
        return $this->db->t2where('article', 'user', " article.article_status=1 && article.article_type=1 && user.user_id=? 
            ORDER BY article.article_id DESC LIMIT {$start}, {$limit}", [$id], 2, 2);
    }

    public function ArticleSimilar()
    {
        return Array_chunk($this->db->t3where('article', 'category', 'section', 
            "article.article_status=1 && category.category_status=1 && 
            section.section_status=1 ORDER BY article.article_view ASC LIMIT 6", [
        ], 2), 3);
    }

    public function ByCategoryCount($section, $category)
    {
        return $this->db->t3count('article', 'category', 'section', 'article.article_status=1 && category.category_status=1 && section.section_status=1 && category.category_slug=? && section.section_slug=?', [$category, $section])->count
        ?: $this->return->code(404)->return('empty', 'bu kategoriyada')->get()->http();
    }

    public function ByCategory($section, $category, $start, $limit)
    {
        return $this->db->t3where('article', 'category', 'section', "article.article_status=1 && category.category_status=1 && section.section_status=1 && category.category_slug=? && section.section_slug=? ORDER BY article.article_id
            DESC LIMIT {$start}, {$limit}", [$category, $section], 2, 2);
    }    
}

