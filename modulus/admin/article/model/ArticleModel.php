<?php 

namespace modulus\admin\article\model;
use core\model;
use \library\error;
use \Valitron\Validator as v;
use old;
use User;

class ArticleModel extends model
{
    public function ArticleColumn()
    {        
        return $this->db->columns('article');
    }    

    #
    public function category()
    {
        return $this->db->t1where('category', "category_id > 0 ORDER BY category_id DESC", [], 2);
    }

	public function ArticleCount()
    {
        return $this->db->t3count('article', 'category', 'section', "article.article_id > 0 ORDER BY article.article_id DESC", [])->count;
    }    

    public function ArticleList($start, $limit)
    {
        return $this->db->t3where('article', 'category', 'section', "article.article_id > 0
            ORDER BY article_id DESC LIMIT {$start}, {$limit}", [], 2, 2);
    }

    #
    public function ByCategoryCount($section, $category)
    {
        return $this->db->t3count('article', 'category', 'section', 
            "section.section_slug=? && category.category_slug=?", [$section, $category])->count;
    }    

    public function ByCategoryList($section, $category, $start, $limit)
    {
        return $this->db->t3where('article', 'category', 'section', 
            "section.section_slug=? && category.category_slug=?
            ORDER BY article_id DESC LIMIT {$start}, {$limit}", [$section, $category], 2, 2);
    }

    #
    public function UserById($id)
    {
        return $this->db->t1where('user', "user_id=?", [$id]);
    }

    #
    public function CategoryById($id)
    {
        return $this->db->t1where('category', "category_id=?", [$id]);
    }

    #
    public function ArticleShow($id)
    {
        return $this->db->t2where('article', 'category', "article_id = ?", [$id]) ?:
            $this->return->code(404)->return('not_found')->get()->referer();
    }

    public function ArticleCreate()
    {
        $http1 = 'panel/article/create';

        $form = [
            'article_title',
            'article_text',
            'category_id',
        ];

        #array diff keys
        array_different($form, $_POST) ?: 
            $this->return->code(404)->return('error_form')->get()->referer();

        #peel tags of array
        $article_text = $_POST['article_text'];
        $data = peel_tag_array(except($_POST, ['article_text']));
        $data += ['article_text' => $article_text];
        old::create($data);

        #check via valitron
        $v = new v($data);

        $v->rule('required', 'article_title');
        $v->rule('required', 'article_text');
        $v->rule('required', 'category_id');

        $v->rule('lengthMin', 'article_title', 3);
        $v->rule('lengthMin', 'article_text', 10);

        $v->rule('lengthMax', 'article_title', 100);
        $v->rule('lengthMax', 'article_text', 30000);

        error::valitron($v, $http1);

        #if not found article
        $data += ['article_slug' => seo($data['article_title'])];

       !$this->db->t1where('article', 'article_slug=?', [$data['article_slug']])
            ?: $this->return->code(404)->return('already_have')->get()->referer();

        $category = $this->db->t1where('category', 'category_id=?', [
            $data['category_id']
        ]) ?: $this->return->code(404)->return('not_found', 'category')->get()->referer();

        $update = $this->db->update('category', [
            'category_id' => $category->category_id,
            'category_count' => $category->category_count += 1
        ], ['id' => 'category_id']);

        $create = $this->db->create('article', $data);

        $create['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->referer();
        
        old::delete($data);

        #unset variables
        unset($http1); unset($data); unset($_POST); unset($v); unset($form);

        $this->return->code(200)->return('success')->get()->referer();
    }

    public function ArticleUpdate()
    {
        $form = [
            'article_title',
            'article_text',
            'article_view',
            'category_id',
        ];

        #array diff keys
        array_different($form, $_POST) ?: 
            $this->return->code(404)->return('error_form')->get()->referer();

        #peel tags of array
        $article_text = $_POST['article_text'];
        $data = peel_tag_array(except($_POST, ['article_text']));
        $data += ['article_text' => $article_text];
        old::create($data);

        #check via valitron
        $http1 = "panel/article/update/{$data['article_id']}";
        $v = new v($data);

        $v->rule('required', 'article_title');
        $v->rule('required', 'article_text');
        $v->rule('required', 'article_view');
        $v->rule('required', 'category_id');

        $v->rule('lengthMin', 'article_title', 3);
        $v->rule('lengthMin', 'article_text', 10);

        $v->rule('lengthMax', 'article_title', 100);
        $v->rule('lengthMax', 'article_text', 30000);

        error::valitron($v, $http1);

        $data += ['article_slug' => seo($data['article_title'])];

        #
        !$this->db->t1where('article', 'article_slug = ? && article_id != ?', [
            $data['article_slug'], $data['article_id'],
        ]) ?: $this->return->code(404)->return('already_have')->get()->referer();

        #
        $article = $this->db->t1where('article', 'article_id = ?', [
            $data['article_id'],
        ]) ?: $this->return->code(404)->return('not_found', 'article')->get()->referer();

        #
        if($data['category_id'] != $data['old_category_id'])
        {
            $old_category = $this->db->t1where('category', 'category_id=?', [
                $data['old_category_id']
            ]) ?: $this->return->code(404)->return('not_found', 'category')->get()->referer();

            $this->db->update('category', [
                'category_id' => $old_category->category_id,
                'category_count' => $old_category->category_count -= 1,
            ], ['id' => 'category_id']);

            $new_category = $this->db->t1where('category', 'category_id=?', [
                $data['category_id']
            ]) ?: $this->return->code(404)->return('not_found', 'category')->get()->referer();

            $this->db->update('category', [
                'category_id' => $new_category->category_id,
                'category_count' => $new_category->category_count += 1,
            ], ['id' => 'category_id']);
        }

        #if not found article
        $data = except($data, ['old_category_id']);
        $data += ['article_updated' => date('Y-m-d H:i:s')];
        $update = $this->db->update('article', $data, ['id' => 'article_id']);

        $update['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->referer();
        
        old::delete($data);
        
        #unset variables
        unset($http1); unset($data); unset($_POST); unset($v); unset($form);

        $this->return->code(200)->return('success')->get()->referer();
    }

    public function ArticleDelete($id)
    {
        $article = $this->db->t1where('article', 'article_id=?', [$id]) ?: 
            $this->return->code(404)->return('not_found')->json();

        $this->db->delete('save', [
            'article_id' => $article->article_id
        ], ['id' => 'article_id']);

        $delete = $this->db->delete('article', [
            'article_id' => $article->article_id
        ], ['id' => 'article_id']);

        $delete['status'] == TRUE ?:
            $this->return->code(404)->return('error')->json();

        unset($id); unset($delete); unset($article);

        $this->return->code(200)->return('success')->json();
    }

    public function ArticleDestroy($id)
    {
        $http1 = 'panel/article/page/1';
        
        $article = $this->db->t1where('article', 'article_id=?', [$id]) ?: 
            $this->return->code(404)->return('not_found')->get()->http($http1);

        $this->db->delete('save', [
            'article_id' => $article->article_id
        ], ['id' => 'article_id']);

        $delete = $this->db->delete('article', [
            'article_id' => $article->article_id
        ], ['id' => 'article_id']);

        $delete['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->http($http1);

        unset($id); unset($delete); unset($article);

        $this->return->code(200)->return('success')->get()->http($http1);
    }

    public function ArticleStatus($article_id)
    {
        $article = $this->db->t1where('article', 'article_id=?', [$article_id]) ?:
            $this->return->code(404)->return('not_found')->json();

        $update = $this->db->update('article', [
            'article_id' => $article->article_id,
            'article_status' => $article->article_status == 1 ? 0 : 1,
        ], ['id' => 'article_id']);

        $update['status'] == TRUE
            ? $this->return->code(200)->return('success')->json()
            : $this->return->code(200)->return('error')->json();
    }

    public function ArticleSearchEngine()
    {
        $http1 = 'panel/article/search/data/';
        $http2 = 'panel/article/page/1';

        $form = [
            'page',
            'field_key',
            'field_value',
        ];

        #array diff keys
        array_different($form, $_GET) ?: 
            $this->return->code(404)->return('error_form')->get()->referer();

        #peel tags of array
        $data = peel_tag_array($_GET);
        $data += ['page_key' => 'panel/article/search/key/value'];

        #valitron
        $v = new v($data);

        $v->rule('required', 'page');
        $v->rule('required', 'field_key');
        $v->rule('required', 'field_value');

        $v->rule('lengthMin', 'field_value', 1);
        $v->rule('lengthMin', 'field_key', 2);

        $v->rule('lengthMax', 'field_value', 20);
        $v->rule('lengthMax', 'field_key', 100);

        $v->rule('equals', 'page', 'page_key');

        error::valitron($v, $http2);        
        
        $this->return->http("{$http1}{$data['field_key']}/{$data['field_value']}/page/1");
    }

    public function articleSearchCount($key, $value)
    {
        $http1 = 'panel/article/page/1';
        return $this->db->t3count('article', 'category', 'section', "article.{$key} LIKE ? ", [
            "%{$value}%"
        ])->count ?: $this->return->code(404)->return('not_found')->get()->http($http1);
    }

    public function ArticleSearch($key, $value, $start, $limit)
    {
        return $this->db->t3where('article', 'category', 'section', "article.{$key} LIKE ? 
            ORDER BY article.article_id DESC LIMIT {$start}, {$limit}", [
            "%{$value}%"
        ], 2, 2);
    }
}

