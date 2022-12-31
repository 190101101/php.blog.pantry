<?php 

dd(byte(memory()));

$data = [];

for($i = 0; $i < 300; $i++){
    $data[] = [
        'guest_ip' => REMOTE_RAND(),
        'guest_visit' => time() + 3600,
    ];
}

$store = [];
foreach($data as $key => $value){
    $store[] = [
        'guest_ip' => $value['guest_ip'],
        'guest_visit' => $value['guest_visit'],
    ];
}

dd(db()->store('guest', [
    'guest_ip',
    'guest_visit',
] , $store));

dd(byte(memory()));

