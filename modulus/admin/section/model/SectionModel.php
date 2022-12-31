<?php 

namespace modulus\admin\section\model;
use core\model;
use \library\error;
use \Valitron\Validator as v;
use old;
use User;

class SectionModel extends model
{
    public function SectionColumn()
    {        
        return $this->db->columns('section');
    }    
    
    #
    public function Section()
    {
        return $this->db->t1where('section', "section_id>0", [], 2);
    }

    #
	public function sectionCount()
    {
        return $this->db->t1count('section', "section_id > 0", [])->count;
    }    

    public function sectionList($start, $limit)
    {
        return $this->db->t1where('section', "section_id > 0
            ORDER BY section_id DESC LIMIT {$start}, {$limit}", [], 2, 2);
    }

    #
    public function sectionShow($id)
    {
        return $this->db->t1where('section', "section_id=?", [$id]) ?:
            $this->return->code(404)->return('not_found')->get()->referer();
    }

    public function sectionCreate()
    {
        $http1 = 'panel/section/create';

        $form = [
            'section_title',
            'section_text',
        ];

        #array diff keys
        array_different($form, $_POST) ?: 
            $this->return->code(404)->return('error_form')->get()->referer();

        #peel tags of array
        $data = peel_tag_array($_POST);
        old::create($data);

        #check via valitron
        $v = new v($data);

        $v->rule('required', 'section_title');
        $v->rule('required', 'section_text');

        $v->rule('lengthMin', 'section_title', 3);
        $v->rule('lengthMin', 'section_text', 3);

        $v->rule('lengthMax', 'section_title', 20);
        $v->rule('lengthMax', 'section_text', 200);

        error::valitron($v, $http1);

        #if not found section
        $data += ['section_slug' => seo($data['section_title'])];

        !$this->db->t1where('section', 'section_slug=?', [$data['section_slug']])
            ?: $this->return->code(404)->return('already_have')->get()->referer();

        $create = $this->db->create('section', $data);

        $create['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->referer();
        
        old::delete($data);

        #unset variables
        unset($http1); unset($data); unset($_POST); unset($v); unset($form);

        $this->return->code(200)->return('success')->get()->referer();
    }

    public function sectionUpdate()
    {
        $form = [
            'section_title',
            'section_text',
            'section_created',
            'section_id',
        ];

        #array diff keys
        array_different($form, $_POST) ?: 
            $this->return->code(404)->return('error_form')->get()->referer();

        #peel tags of array
        $data = peel_tag_array($_POST);
        old::create($data);

        #check via valitron
        $http1 = "panel/section/update/{$data['section_id']}";
        $v = new v($data);

        $v->rule('required', 'section_title');
        $v->rule('required', 'section_text');
        $v->rule('required', 'section_created');

        $v->rule('lengthMin', 'section_title', 3);
        $v->rule('lengthMin', 'section_text', 3);

        $v->rule('lengthMax', 'section_title', 20);
        $v->rule('lengthMax', 'section_text', 300);

        error::valitron($v, $http1);

        #if not found section
        $data += ['section_updated' => date('Y-m-d H:i:s')];
        $data += ['section_slug' => seo($data['section_title'])];

        #
        !$this->db->t1where('section', 'section_slug = ? && section_id != ?', [
            $data['section_slug'], $data['section_id'],
        ]) ?: $this->return->code(404)->return('already_have')->get()->referer();

        #
        $this->db->t1where('section', 'section_id=?', [
            $data['section_id'],
        ]) ?: $this->return->code(404)->return('already_have')->get()->referer();

        $update = $this->db->update('section', $data, ['id' => 'section_id']);

        $update['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->referer();
        
        old::delete($data);
        
        #unset variables
        unset($http1); unset($data); unset($_POST); unset($v); unset($form);

        $this->return->code(200)->return('success')->get()->referer();
    }

    public function SectionDelete($id)
    {
        $section = $this->db->t1where('section', 'section_id != 1 && section_id=?', [$id]) 
            ?: $this->return->code(404)->return('not_found')->json();

        $section = $this->db->t1where('section', 'section_id=?', [
            $section->section_id
        ]) ?: $this->return->code(404)->return('not_found')->json();

        $this->db->update('section', [
            'section_id' => $section->section_id, 
            'section_count' => $section->section_count -= 1, 
        ], ['id' => 'section_id']); 

        $this->db->update('section', [
            'section_id' => 1, 
            'section_count' => 
            $this->db->t1where('section', 'section_id=?', [1])->section_count +=
            $this->db->t1count('category', 'section_id=?', [$section->section_id])->count
        ], ['id' => 'section_id']); 

        $this->db->update('category', [
            'section_id' => $section->section_id, 
            'category.section_id' => 1, 
        ], ['id' => 'section_id', 'p2' => 'section_id']); 

        $delete = $this->db->delete('section', [
            'section_id' => $section->section_id
        ], ['id' => 'section_id']);

        $delete['status'] == TRUE ?:
            $this->return->code(404)->return('error')->json();

        unset($id); unset($delete); unset($section);

        $this->return->code(200)->return('success')->json();
    }

    public function sectionDeletes($id)
    {
        $section = $this->db->t1where('section', 'section_id != 1 && section_id=?', [$id]) ?: 
            $this->return->code(404)->return('not_found')->json();

        $this->db->update('category', [
            'section_id' => $section->section_id, 
            'category.section_id' => 1, 
        ], ['id' => 'section_id', 'p2' => 'section_id']); 
        
        $delete = $this->db->delete('section', [
            'section_id' => $section->section_id
        ], ['id' => 'section_id']);

        $delete['status'] == TRUE ?:
            $this->return->code(404)->return('error')->json();

        unset($id); unset($delete); unset($section);

        $this->return->code(200)->return('success')->json();
    }

    public function sectionDestroy($id)
    {
        $http1 = 'panel/section/page/1';
        
        $section = $this->db->t1where('section', 'section_id != 1 && section_id=?', [$id]) 
            ?: $this->return->code(404)->return('not_found')->get()->http($http1);

        $section = $this->db->t1where('section', 'section_id=?', [
            $section->section_id
        ]) ?: $this->return->code(404)->return('not_found')->get()->http($http1);

        $this->db->update('section', [
            'section_id' => $section->section_id, 
            'section_count' => $section->section_count -= 1, 
        ], ['id' => 'section_id']); 

        $this->db->update('section', [
            'section_id' => 1, 
            'section_count' => 
            $this->db->t1where('section', 'section_id=?', [1])->section_count +=
            $this->db->t1count('category', 'section_id=?', [$section->section_id])->count
        ], ['id' => 'section_id']); 

        $this->db->update('category', [
            'section_id' => $section->section_id, 
            'category.section_id' => 1, 
        ], ['id' => 'section_id', 'p2' => 'section_id']); 

        $delete = $this->db->delete('section', [
            'section_id' => $section->section_id
        ], ['id' => 'section_id']);

        $delete['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->http($http1);

        unset($id); unset($delete); unset($section);
        
        $this->return->code(200)->return('success')->get()->http($http1);
    }

    public function SectionStatus($id)
    {
        $section = $this->db->t1where('section', 'section_id!=1 && section_id=?', [$id]) ?:
            $this->return->code(404)->return('not_found')->json();

        $update = $this->db->update('section', [
            'section_id' => $section->section_id,
            'section_status' => $section->section_status == 1 ? 0 : 1,
        ], ['id' => 'section_id']);

        $update['status'] == TRUE
            ? $this->return->code(200)->return('success')->json()
            : $this->return->code(200)->return('error')->json();
    }

    public function sectionSearchEngine()
    {
        $http1 = 'panel/section/search/data/';
        $http2 = 'panel/section/page/1';

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
        $data += ['page_key' => 'panel/section/search/key/value'];

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

    public function sectionSearchCount($key, $value)
    {
        $http1 = 'panel/section/page/1';
        return $this->db->t1count('section', "{$key} LIKE ? ", [
            "%{$value}%"
        ])->count ?: $this->return->code(404)->return('not_found')->get()->http($http1);
    }

    public function sectionSearch($key, $value, $start, $limit)
    {
        return $this->db->t1where('section', "{$key} LIKE ? 
            ORDER BY section.section_id DESC LIMIT {$start}, {$limit}", [
            "%{$value}%"
        ], 2, 2);
    }
}

