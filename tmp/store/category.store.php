<?php 

dd(byte(memory()));

$faker = Faker\Factory::create();

$data = [];

for($i = 0; $i < 1000; $i++){
    $title = replace_all(char_map($faker->sentence(rand(1, 4))), ',.!');
    $data[] = [
        'article_title' => $title,
        'article_slug' => seo(strtolower($title)),
        'article_text' => $faker->sentence(200),
        'article_view' => rand(1000, 10000),
        'category_id' => rand(2, 30),
    ];
}

$store = [];
foreach($data as $key => $value){
    $store[] = [
        'article_title' => $value['article_title'],
        'article_slug' => $value['article_slug'],
        'article_text' => $value['article_text'],
        'article_view' => $value['article_view'],
        'category_id' => $value['category_id'],
    ];
}

dd(db()->store('article', [
    'article_title',
    'article_slug',
    'article_text',
    'article_view',
    'category_id',
] , $store));

dd(byte(memory()));


$categorys = db()->t1('category', 2);

foreach($categorys as $key)
{
 $category = db()->t1where('category', 'category_id=?', [$key->category_id]);

 db()->update('category', [
     'category_id' => $category->category_id,
     'category_count' => db()->t1count('article', 'category_id=?', [$category->category_id])->count
 ], ['id' => 'category_id']);
}
