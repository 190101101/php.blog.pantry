<?php 

namespace modulus\main\info\controller;
use modulus\main\info\model\infoModel;
use core\controller;
use pagination;

class InfoController extends controller
{
    public $info;
    
    public function __construct()
    {
        $this->info = new infoModel();
        $this->page = new pagination();
    }

    public function AboutPage()
    {
        $this->layout('main', 'main', 'info', 'about', []);
    }
}
