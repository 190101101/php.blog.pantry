<?php 

namespace modulus\admin\panel\controller;
use modulus\admin\panel\model\PanelModel;
use core\controller;

class PanelController extends controller
{
    public $panel;
    
    public function __construct()
    {
        $this->panel = new PanelModel();
    }

    public function index()
    {
        $this->layout('panel', 'admin', 'panel', 'panel', [
            'guest' => $this->panel->GuestCount(),
            'article' => $this->panel->ArticleCount(),
            'setting' => $this->panel->SettingCount(),
            'section' => $this->panel->SectionCount(),
            'category' => $this->panel->CategoryCount(),
        ]);
    }
}
