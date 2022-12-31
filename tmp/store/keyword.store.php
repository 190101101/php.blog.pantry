<?php 

dd(byte(memory()));

$faker = Faker\Factory::create();

$data = [];

for($i = 0; $i < 100; $i++){

    $explode = explode(' ', str_replace('.','',$faker->sentence(1)));

    $data[] = [
        'keyword_title' => strtolower($explode[0]),
    ];
}

$store = [];
foreach($data as $key => $value){
    $store[] = [
        'keyword_title' => $value['keyword_title'],
    ];
}

dd(db()->store('keyword', [
    'keyword_title',
] , $store));

dd(byte(memory()));


?>

<!-- 
    <div class="my-3">
        <?php 
            $faker = Faker\Factory::create();
            for($i = 0; $i < 100; $i++):
         ?>
            <a href="#" class="text-secondary ml-1">
                #<?php echo $faker->sentence(1); ?>
            </a>
        <?php endfor; ?>
    </div>
 -->
