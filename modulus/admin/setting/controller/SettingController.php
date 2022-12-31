<?php 

namespace modulus\admin\setting\controller;
use modulus\admin\setting\model\SettingModel;
use core\controller;
use pagination;

class SettingController extends controller
{
    public $setting;
    
    public function __construct()
    {
        $this->setting = new SettingModel();
        $this->page = new pagination();
    }

    public function setting()
    {
        $this->layout('panel', 'admin', 'setting', 'setting', [
            'page' => $p = $this->page->page($this->setting->settingCount(), 5),
            'setting' => $this->setting->settingList($p->start, $p->limit),
            'column' => $this->setting->settingColumn(),
        ]);
    }

    public function show($id)
    {
        $this->layout('panel', 'admin', 'setting', 'show', [
            'setting' => $this->setting->settingShow($id),
            'column' => $this->setting->settingColumn(),
        ]);
    }

    public function create()
    {
        $this->layout('panel', 'admin', 'setting', 'create', [
            'column' => $this->setting->settingColumn(),
        ]);
    }

    public function settingCreate()
    {
        $this->setting->settingCreate();
    }

    public function update($id)
    {
        $this->layout('panel', 'admin', 'setting', 'update', [
            'setting' => $this->setting->settingShow($id),
            'column' => $this->setting->settingColumn(),
        ]);
    }

    public function settingUpdate()
    {
        $this->setting->settingUpdate();
    }

    
    public function settingSearchEngine()
    {
        $this->setting->settingSearchEngine();
    }

    public function settingSearch($key, $value)
    {
        $this->layout('panel', 'admin', 'setting', 'search', [
            'page' => $p = $this->page->page($this->setting->settingSearchCount($key, $value), 5),
            'setting' => $this->setting->settingSearch($key, $value, $p->start, $p->limit),
            'column' => $this->setting->settingColumn(),
            'search' => (object) ['key' => $key, 'value' => $value],
        ]);
    }
}