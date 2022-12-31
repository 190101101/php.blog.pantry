<?php 

    public function ByCategory($id)
    {
        $this->layout('main', 'main', 'article', 'ByCategory', [
            'page' => $p = $this->page->page($this->article->ByCategoryCount($id), 12),
            'article' => $this->article->ByCategory($id, $p->start, $p->limit),
            'category' => $this->article->CategoryById($id),
            'id' => $id
        ]);
    }

    #model
    
    public function ByCategoryCount($id)
    {
        return $this->db->t2count('article', 'category', 
            'article.article_status = 1 && category.category_id=?', [$id])->count;
    }

    public function ByCategory($id, $start, $limit)
    {
        return $this->db->t2where('article', 'category', 
            "article.article_status = 1 && category.category_id=? ORDER BY article.article_id
            DESC LIMIT {$start}, {$limit}", [$id], 2, 2);
    }   

 ?>


<h3 class="mt-4 mb-3"><?php echo $data->category->category_title; ?> 
    <small>by üzrə məqalələr</small>
</h3>
<?php breadcump();  ?>

<div class="row">
    <div class="col-lg-9">
        <div class="row">
            <?php include(MW.'article.php'); ?>
        </div>

        <ul class="pagination justify-content-center">
            <?php pagination::selector($data->page, "category/article/{$data->id}/"); ?>
        </ul>

        <?php if($data->page->count): ?>
        <span>
            <span>found <?php echo $data->page->count ?> articles / </span>
            <span>there are <?php echo $data->page->length; ?> pages</span>
        </span>
        <?php endif; ?>
    </div>

    <?php include(MW.'section.php'); ?>

</div>


<?php 



/*
for($i = 1; $i <= 12; $i++)
{
    $section = db()->t1where('section', 'section_id=?', [$i]);

    db()->update('section', [
        'section_id' => $section->section_id,
        'section_count' => db()->t1count('category', 'section_id=?', [$section->section_id])->count
    ], ['id' => 'section_id']);
}
*/


// for($i = 1; $i <= 36; $i++)
// {
//  $category = db()->t1where('category', 'category_id=?', [$i]);

//  db()->update('category', [
//      'category_id' => $category->category_id,
//      'category_count' => db()->t1count('article', 'category_id=?', [$category->category_id])->count
//  ], ['id' => 'category_id']);
// }

 ?>