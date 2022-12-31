<?php 

namespace modulus\admin\setting\model;
use core\model;
use \library\error;
use \Valitron\Validator as v;
use old;

class SettingModel extends model
{
    public function settingColumn()
    {        
        return $this->db->columns('setting');
    }    

	public function settingCount()
    {
	    return $this->db->t1count('setting', 'setting_id > 0', [])->count;
    }    

    public function settingList($start, $limit)
    {
        return $this->db->t1where('setting', "setting_id > 0
            ORDER BY setting_id DESC LIMIT {$start}, {$limit}", [], 2, 2);
    }

    public function settingShow($id)
    {
        return $this->db->t1where('setting', "setting_id = ?", [$id]) ?:
            $this->return->code(404)->return('not_found')->get()->referer();
    }

    public function settingUpdate()
    {
        $form = [
            'setting_id',
            'setting_description',
            'setting_key',
            'setting_value',
            'setting_type',
        ];
   
        #array diff keys
        array_different($form, $_POST) ?: 
            $this->return->code(404)->return('error_form')->get()->referer();

        #peel tags of array
        $data = peel_tag_array($_POST);
        old::create($data);

        #check via valitron
        $v = new v($data);

        $v->rule('required', 'setting_id');
        $v->rule('required', 'setting_description');
        $v->rule('required', 'setting_key');
        $v->rule('required', 'setting_value');
        $v->rule('required', 'setting_type');

        $v->rule('lengthMin', 'setting_key', 1);
        $v->rule('lengthMax', 'setting_key', 100);
        
        $v->rule('lengthMin', 'setting_type', 2);
        $v->rule('lengthMax', 'setting_type', 50);

        $v->rule('lengthMin', 'setting_value', 1);
        $v->rule('lengthMax', 'setting_value', 1000);
        
        $http1 = "panel/setting/update/{$data['setting_id']}";
        error::valitron($v, $http1);

        $data += ['setting_updated' => date('Y-m-d H:i:s')];
        #if not found setting
        $update = $this->db->update('setting', $data, ['id' => 'setting_id']);

        $update['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->referer();
        
        #unset variables
        unset($http1); unset($data); unset($_POST); unset($v); unset($form);

        $this->return->code(200)->return('success')->get()->referer();
    }

    public function settingSearchEngine()
    {
        $http1 = 'panel/setting/search/data/';
        $http2 = 'panel/setting/page/1';

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
        $data += ['page_key' => 'panel/setting/search/key/value'];

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

    public function settingSearchCount($key, $value)
    {
        $http1 = 'panel/setting/page/1';
        return $this->db->t1count('setting', "{$key} LIKE ? ", [
            "%{$value}%"
        ])->count ?: $this->return->code(404)->return('not_found')->get()->http($http1);
    }

    public function settingSearch($key, $value, $start, $limit)
    {
        return $this->db->t1where('setting', "{$key} LIKE ? 
            ORDER BY setting_id DESC LIMIT {$start}, {$limit}", [
            "%{$value}%"
        ], 2, 2);
    }
}

