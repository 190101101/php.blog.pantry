<?php 

namespace modulus\admin\section\controller;
use modulus\admin\section\model\SectionModel;
use core\controller;
use pagination;

class SectionController extends controller
{
    public $section;
    
    public function __construct()
    {
        $this->section = new SectionModel();
        $this->page = new pagination();
    }

    public function Section()
    {
        $this->layout('panel', 'admin', 'section', 'section', [
            'page' => $p = $this->page->page($this->section->sectionCount(), 5),
            'section' => $this->section->sectionList($p->start, $p->limit),
            'column' => $this->section->sectionColumn()
        ]);
    }

    public function show($id)
    {
        $this->layout('panel', 'admin', 'section', 'show', [
            'section' => $this->section->sectionShow($id),
            'column' => $this->section->sectionColumn()
        ]);
    }

    public function create()
    {
        $this->layout('panel', 'admin', 'section', 'create', [
            'section' => $this->section->section(),
            'column' => $this->section->sectionColumn(),
        ]);
    }

    public function sectionCreate()
    {
        $this->section->sectionCreate();
    }

    public function update($id)
    {
        $this->layout('panel', 'admin', 'section', 'update', [
            'section' => $this->section->sectionShow($id),
            'column' => $this->section->sectionColumn(),
        ]);
    }

    public function sectionUpdate()
    {
        $this->section->sectionUpdate();
    }

    public function sectionDelete($id)
    {
        $this->section->sectionDelete($id);
    }

    public function sectionDestroy($id)
    {
        $this->section->sectionDestroy($id);
    }
    
    public function SectionStatus($id)
    {
        $this->section->SectionStatus($id);
    }

    public function sectionSearchEngine()
    {
        $this->section->sectionSearchEngine();
    }

    public function sectionSearch($key, $value)
    {
        $this->layout('panel', 'admin', 'section', 'search', [
            'page' => $p = $this->page->page($this->section->sectionSearchCount($key, $value), 5),
            'section' => $this->section->sectionSearch($key, $value, $p->start, $p->limit),
            'column' => $this->section->sectionColumn(),
            'search' => (object) ['key' => $key, 'value' => $value],
        ]);
    }
}
