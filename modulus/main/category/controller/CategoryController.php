<?php 

namespace modulus\main\category\controller;
use modulus\main\category\model\CategoryModel;
use core\controller;
use pagination;

class CategoryController extends controller
{
    public $category;
    
    public function __construct()
    {
        $this->category = new CategoryModel();
        $this->page = new pagination();
    }

    public function category()
    {
        $this->layout('main', 'main', 'category', 'category', [
            'page' => $p = $this->page->page($this->category->CategoryCount(), 12),
            'category' => $this->category->CategoryList($p->start, $p->limit),
        ]);
    }
}
