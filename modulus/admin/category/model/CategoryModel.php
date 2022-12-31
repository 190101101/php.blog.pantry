<?php 

namespace modulus\admin\category\model;
use core\model;
use \library\error;
use \Valitron\Validator as v;
use old;
use User;

class CategoryModel extends model
{
    public function categoryColumn()
    {        
        return $this->db->columns('category');
    }    
    
    #
    public function category()
    {
        return $this->db->t1where('category', "category_id>0", [], 2);
    }

    public function section()
    {
        return $this->db->t1where('section', "section_id>0", [], 2);
    }

    #
	public function categoryCount()
    {
        return $this->db->t2count('category', 'section', "category_id > 0", [])->count;
    }    

    public function categoryList($start, $limit)
    {
        return $this->db->t2where('category', 'section', "category_id > 0
            ORDER BY category_id DESC LIMIT {$start}, {$limit}", [], 2, 2);
    }
    
    #
    public function BySectionCount($section)
    {
        return $this->db->t2count('category', 'section', 
            "section.section_slug=?", [$section])->count;
    }    

    public function BySectionList($section, $start, $limit)
    {
        return $this->db->t2where('category', 'section', 
            "section.section_slug=? ORDER BY category_id DESC LIMIT {$start}, {$limit}", [
                $section
            ], 2, 2);
    }
   

    #
    public function CategoryShow($id)
    {
        return $this->db->t2where('category', 'section', "category_id=?", [$id]) ?:
            $this->return->code(404)->return('not_found')->get()->referer();
    }

    public function categoryCreate()
    {
        $http1 = 'panel/category/create';

        $form = [
            'category_title',
            'category_text',
            'section_id',
        ];

        #array diff keys
        array_different($form, $_POST) ?: 
            $this->return->code(404)->return('error_form')->get()->referer();

        #peel tags of array
        $data = peel_tag_array($_POST);
        old::create($data);

        #check via valitron
        $v = new v($data);

        $v->rule('required', 'category_title');
        $v->rule('required', 'category_text');
        $v->rule('required', 'section_id');

        $v->rule('lengthMin', 'category_title', 3);
        $v->rule('lengthMin', 'category_text', 3);

        $v->rule('lengthMax', 'category_title', 20);
        $v->rule('lengthMax', 'category_text', 200);

        error::valitron($v, $http1);

        $data += ['category_slug' => seo($data['category_title'])];

        !$this->db->t1where('category', 'category_slug=?', [$data['category_slug']])
            ?: $this->return->code(404)->return('already_have')->get()->referer();

        $section = $this->db->t1where('section', 'section_id=?', [
            $data['section_id']
        ]) ?: $this->return->code(404)->return('not_found', 'section')->get()->referer();

        $update = $this->db->update('section', [
            'section_id' => $section->section_id,
            'section_count' => $section->section_count += 1
        ], ['id' => 'section_id']);

        #if not found category
        $create = $this->db->create('category', $data);

        $create['status'] == TRUE && $update['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->referer();
        
        old::delete($data);

        #unset variables
        unset($http1); unset($data); unset($_POST); unset($v); unset($form);

        $this->return->code(200)->return('success')->get()->referer();
    }

    public function categoryUpdate()
    {
        $form = [
            'category_title',
            'category_text',
            'category_created',
            'category_id',
            'section_id',
            'old_section_id',
        ];

        #array diff keys
        array_different($form, $_POST) ?: 
            $this->return->code(404)->return('error_form')->get()->referer();

        #peel tags of array
        $data = peel_tag_array($_POST);
        old::create($data);

        #check via valitron
        $http1 = "panel/category/update/{$data['category_id']}";
        $v = new v($data);

        $v->rule('required', 'category_title');
        $v->rule('required', 'category_text');
        $v->rule('required', 'category_created');
        $v->rule('required', 'category_id');
        $v->rule('required', 'section_id');

        $v->rule('lengthMin', 'category_title', 3);
        $v->rule('lengthMin', 'category_text', 3);

        $v->rule('lengthMax', 'category_title', 20);
        $v->rule('lengthMax', 'category_text', 300);

        error::valitron($v, $http1);

        #if not found category
        $data += ['category_updated' => date('Y-m-d H:i:s')];
        $data += ['category_slug' => seo($data['category_title'])];

        #
        !$this->db->t1where('category', 'category_slug = ? && category_id != ?', [
            $data['category_slug'], $data['category_id'],
        ]) ?: $this->return->code(404)->return('already_have')->get()->referer();
        
        #
        $category = $this->db->t1where('category', 'category_id = ?', [
            $data['category_id'],
        ]) ?: $this->return->code(404)->return('already_have')->get()->referer();

        if($data['section_id'] != $data['old_section_id'])
        {
            $old_section = $this->db->t1where('section', 'section_id=?', [
                $data['old_section_id']
            ]) ?: $this->return->code(404)->return('not_found', 'section')->get()->referer();

            $this->db->update('section', [
                'section_id' => $old_section->section_id,
                'section_count' => $old_section->section_count -= 1,
            ], ['id' => 'section_id']);

            $new_section = $this->db->t1where('section', 'section_id=?', [
                $data['section_id']
            ]) ?: $this->return->code(404)->return('not_found', 'section')->get()->referer();

            $this->db->update('section', [
                'section_id' => $new_section->section_id,
                'section_count' => $new_section->section_count += 1,
            ], ['id' => 'section_id']);
        }

        $data = except($data, ['old_section_id']);
        $update = $this->db->update('category', $data, ['id' => 'category_id']);

        $update['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->referer();
        
        old::delete($data);
        
        #unset variables
        unset($http1); unset($data); unset($_POST); unset($v); unset($form);

        $this->return->code(200)->return('success')->get()->referer();
    }

    public function categoryDelete($id)
    {
        $category = $this->db->t1where('category', 'category_id != 1 && category_id=?', [$id]) 
            ?: $this->return->code(404)->return('not_found')->json();

        $section = $this->db->t1where('section', 'section_id=?', [
            $category->section_id
        ]) ?: $this->return->code(404)->return('not_found')->json();

        $this->db->update('section', [
            'section_id' => $category->section_id, 
            'section_count' => $section->section_count -= 1, 
        ], ['id' => 'section_id']); 

        $this->db->update('category', [
            'category_id' => 1, 
            'category_count' => 
            $this->db->t1where('category', 'category_id=?', [1])->category_count +=
            $this->db->t1count('article', 'category_id=?', [$category->category_id])->count
        ], ['id' => 'category_id']); 

        $this->db->update('article', [
            'category_id' => $category->category_id, 
            'article.category_id' => 1, 
        ], ['id' => 'category_id', 'p2' => 'category_id']); 

        $delete = $this->db->delete('category', [
            'category_id' => $category->category_id
        ], ['id' => 'category_id']);

        $delete['status'] == TRUE ?:
            $this->return->code(404)->return('error')->json();

        unset($id); unset($delete); unset($category);

        $this->return->code(200)->return('success')->json();
    }

    public function categoryDestroy($id)
    {
        $http1 = 'panel/category/page/1';
        
        $category = $this->db->t1where('category', 'category_id != 1 && category_id=?', [$id]) 
            ?: $this->return->code(404)->return('not_found')->get()->http($http1);

        $section = $this->db->t1where('section', 'section_id=?', [
            $category->section_id
        ]) ?: $this->return->code(404)->return('not_found')->get()->http($http1);

        $this->db->update('section', [
            'section_id' => $category->section_id, 
            'section_count' => $section->section_count -= 1, 
        ], ['id' => 'section_id']); 

        $this->db->update('category', [
            'category_id' => 1, 
            'category_count' => 
            $this->db->t1where('category', 'category_id=?', [1])->category_count +=
            $this->db->t1count('article', 'category_id=?', [$category->category_id])->count
        ], ['id' => 'category_id']); 

        $this->db->update('article', [
            'category_id' => $category->category_id, 
            'article.category_id' => 1, 
        ], ['id' => 'category_id', 'p2' => 'category_id']); 

        $delete = $this->db->delete('category', [
            'category_id' => $category->category_id
        ], ['id' => 'category_id']);

        $delete['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->http($http1);

        unset($id); unset($delete); unset($category);

        $this->return->code(200)->return('success')->get()->http($http1);
    }

    public function CategoryStatus($id)
    {
        $category = $this->db->t1where('category', 'category_id!=1 && category_id=?', [$id]) ?:
            $this->return->code(404)->return('not_found')->json();

        $update = $this->db->update('category', [
            'category_id' => $category->category_id,
            'category_status' => $category->category_status == 1 ? 0 : 1,
        ], ['id' => 'category_id']);

        $update['status'] == TRUE
            ? $this->return->code(200)->return('success')->json()
            : $this->return->code(200)->return('error')->json();
    }

    public function categorySearchEngine()
    {
        $http1 = 'panel/category/search/data/';
        $http2 = 'panel/category/page/1';

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
        $data += ['page_key' => 'panel/category/search/key/value'];

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

    public function categorySearchCount($key, $value)
    {
        $http1 = 'panel/category/page/1';
        return $this->db->t2count('category', 'section', "category.{$key} LIKE ? ", [
            "%{$value}%"
        ])->count ?: $this->return->code(404)->return('not_found')->get()->http($http1);
    }

    public function categorySearch($key, $value, $start, $limit)
    {
        return $this->db->t2where('category', 'section', "category.{$key} LIKE ? 
            ORDER BY category.category_id DESC LIMIT {$start}, {$limit}", [
            "%{$value}%"
        ], 2, 2);
    }
}

