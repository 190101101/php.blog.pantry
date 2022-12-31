<?php 

dd(byte(memory()));

db()->create('section', [
    'section_title' => 'other',
    'section_slug' => 'other',
    'section_text' => 'other',
    'section_status' => 0,
]);

$faker = Faker\Factory::create();

$data = [];

for($i = 0; $i < 4; $i++){
    $title = replace_all(char_map($faker->sentence(1)), ',.!');
    $data[] = [
        'section_title' => $title,
        'section_slug' => seo(strtolower($title)),
        'section_text' => $faker->sentence(5),
    ];
}

$store = [];
foreach($data as $key => $value){
    $store[] = [
        'section_title' => $value['section_title'],
        'section_slug' => $value['section_slug'],
        'section_text' => $value['section_text'],
    ];
}

dd(db()->store('section', [
    'section_title',
    'section_slug',
    'section_text',
] , $store));

dd(byte(memory()));
