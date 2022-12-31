<?php 

namespace modulus\admin\category\controller;
use modulus\admin\category\model\categoryModel;
use core\controller;
use pagination;

class CategoryController extends controller
{
    public $category;
    
    public function __construct()
    {
        $this->category = new categoryModel();
        $this->page = new pagination();
    }

    public function category()
    {
        $this->layout('panel', 'admin', 'category', 'category', [
            'page' => $p = $this->page->page($this->category->categoryCount(), 5),
            'category' => $this->category->categoryList($p->start, $p->limit),
            'column' => $this->category->categoryColumn()
        ]);
    }

    public function BySection($section)
    {
        $this->layout('panel', 'admin', 'category', 'BySection', [
            'page' => $p = $this->page->page($this->category->BySectionCount($section), 5),
            'category' => $this->category->BySectionList($section, $p->start, $p->limit),
            'column' => $this->category->CategoryColumn(),
            'section' => $section,
        ]);
    }


    public function show($id)
    {
        $this->layout('panel', 'admin', 'category', 'show', [
            'category' => $this->category->categoryShow($id),
            'column' => $this->category->categoryColumn()
        ]);
    }

    public function create()
    {
        $this->layout('panel', 'admin', 'category', 'create', [
            'category' => $this->category->category(),
            'section' => $this->category->Section(),
            'column' => $this->category->categoryColumn(),
        ]);
    }

    public function categoryCreate()
    {
        $this->category->categoryCreate();
    }

    public function update($id)
    {
        $this->layout('panel', 'admin', 'category', 'update', [
            'category' => $this->category->CategoryShow($id),
            'column' => $this->category->categoryColumn(),
            'section' => $this->category->Section(),
        ]);
    }

    public function categoryUpdate()
    {
        $this->category->categoryUpdate();
    }

    public function categoryDelete($id)
    {
        $this->category->categoryDelete($id);
    }

    public function categoryDestroy($id)
    {
        $this->category->categoryDestroy($id);
    }

    public function CategoryStatus($id)
    {
        $this->category->CategoryStatus($id);
    }

    public function categorySearchEngine()
    {
        $this->category->categorySearchEngine();
    }

    public function categorySearch($key, $value)
    {
        $this->layout('panel', 'admin', 'category', 'search', [
            'page' => $p = $this->page->page($this->category->categorySearchCount($key, $value), 5),
            'category' => $this->category->categorySearch($key, $value, $p->start, $p->limit),
            'column' => $this->category->categoryColumn(),
            'search' => (object) ['key' => $key, 'value' => $value],
        ]);
    }
}
