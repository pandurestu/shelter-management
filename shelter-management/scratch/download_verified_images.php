<?php

$destDir = __DIR__.'/../public/images/shelters';
@mkdir($destDir, 0777, true);

$images = [
    'baby-zoo' => [
        'name' => 'Baby Zoo (Anak Singa / Harimau)',
        'urls' => [
            'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c9/Lion_cub_%28Panthera_leo%29_6_weeks.jpg/1280px-Lion_cub_%28Panthera_leo%29_6_weeks.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/2/23/Lion_cubs_%28Panthera_leo%29_3_weeks.jpg/1280px-Lion_cubs_%28Panthera_leo%29_3_weeks.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/1/13/Tiger_cub_resting.jpg/1280px-Tiger_cub_resting.jpg',
        ],
    ],
    'australia-outback' => [
        'name' => 'Australia Outback (Kanguru Merah)',
        'urls' => [
            'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Red_Kangaroos_at_Sturt_National_Park_NSW.jpg/1280px-Red_Kangaroos_at_Sturt_National_Park_NSW.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0c/Kangaroo_Australia_01_11_2008_-_retouch.JPG/1280px-Kangaroo_Australia_01_11_2008_-_retouch.JPG',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Osphranter_rufus_-_Tierpark_Hagenbeck_01.jpg/1280px-Osphranter_rufus_-_Tierpark_Hagenbeck_01.jpg',
        ],
    ],
    'bird-of-prey' => [
        'name' => 'Bird of Prey (Elang Jawa)',
        'urls' => [
            'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0b/Nisaetus_bartelsi_%28Elang_Jawa%29.jpg/1280px-Nisaetus_bartelsi_%28Elang_Jawa%29.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a3/Elang_Jawa_%28Nisaetus_Bartelsi%29.jpg/1280px-Elang_Jawa_%28Nisaetus_Bartelsi%29.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/5/50/Elang_Jawa_Nisaetus_bartelsi_Bandung_Zoo_2_cropped.jpg/1280px-Elang_Jawa_Nisaetus_bartelsi_Bandung_Zoo_2_cropped.jpg',
        ],
    ],
    'taman-buaya' => [
        'name' => 'Taman Buaya (Buaya Muara Taman Safari Indonesia)',
        'urls' => [
            'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/TamanSafariIndonesia259.jpg/1280px-TamanSafariIndonesia259.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/8/80/TamanSafariIndonesia261.jpg/1280px-TamanSafariIndonesia261.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/7/76/Crocodylus_porosus_top.jpg/1280px-Crocodylus_porosus_top.jpg',
        ],
    ],
    'komodo-dragon' => [
        'name' => 'Komodo Dragon Island (Komodo Dragon)',
        'urls' => [
            'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/KomodoDragons.jpg/1280px-KomodoDragons.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Komodo_dragon_%28Varanus_komodoensis%29.jpg/1280px-Komodo_dragon_%28Varanus_komodoensis%29.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/8/80/Komodo_dragon_Varanus_komodoensis_Ragunan_Zoo_2.jpg/1280px-Komodo_dragon_Varanus_komodoensis_Ragunan_Zoo_2.jpg',
        ],
    ],
    'kampung-papua' => [
        'name' => 'Kampung Papua (Burung Kasuari Gelambir Ganda)',
        'urls' => [
            'https://upload.wikimedia.org/wikipedia/commons/thumb/b/be/Casuarius_casuarius_in_Australia.jpg/1280px-Casuarius_casuarius_in_Australia.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/e/e7/Wild_cassowary_walking_at_Mission_Beach_IMG_3933.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b3/Casuarius_casuarius_2.jpg/1280px-Casuarius_casuarius_2.jpg',
        ],
    ],
    'bahtera-penguin' => [
        'name' => 'Bahtera Penguin (Penguin Humboldt Berenang)',
        'urls' => [
            'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1f/Spheniscus_humboldti_-Chester_Zoo_-swimming-8a.jpg/1280px-Spheniscus_humboldti_-Chester_Zoo_-swimming-8a.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/0/07/Spheniscus_humboldti_-side_view_-Zoo_Landau-8a.jpg/1280px-Spheniscus_humboldti_-side_view_-Zoo_Landau-8a.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Spheniscus_humboldti_Zoo_Landau_01.jpg/1280px-Spheniscus_humboldti_Zoo_Landau_01.jpg',
        ],
    ],
    'primate-center' => [
        'name' => 'Primate Center (Orangutan Taman Safari Indonesia)',
        'urls' => [
            'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Bornean_orangutan_Taman_Safari.jpg/1280px-Bornean_orangutan_Taman_Safari.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/b/be/Orang_Utan%2C_Semenggok_Forest_Reserve%2C_Sarawak%2C_Borneo%2C_Malaysia.JPG/1280px-Orang_Utan%2C_Semenggok_Forest_Reserve%2C_Sarawak%2C_Borneo%2C_Malaysia.JPG',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bb/Orang_Utan%2C_Singapore_Zoo.JPG/1280px-Orang_Utan%2C_Singapore_Zoo.JPG',
        ],
    ],
    'lorong-reptil' => [
        'name' => 'Lorong Reptil & Satwa Malam (Green Tree Python)',
        'urls' => [
            'https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Green_Tree_Python_0A2A0428.jpg/1280px-Green_Tree_Python_0A2A0428.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/Morelia-viridis.jpg/1280px-Morelia-viridis.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1f/Green_Tree_Python_juvenile_A22I6572.jpg/1280px-Green_Tree_Python_juvenile_A22I6572.jpg',
        ],
    ],
    'istana-panda' => [
        'name' => 'Istana Panda (Giant Panda Makan Bambu)',
        'urls' => [
            'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2d/Giant_panda_eating_bamboo_Taipei_Zoo.jpg/1280px-Giant_panda_eating_bamboo_Taipei_Zoo.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/Panda_eating_bamboo_in_Panda_Base.jpg/1280px-Panda_eating_bamboo_in_Panda_Base.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Grosser_Panda.JPG/1280px-Grosser_Panda.JPG',
        ],
    ],
];

$ctx = stream_context_create([
    'http' => [
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\nAccept: image/webp,image/apng,image/*,*/*;q=0.8\r\n",
        'timeout' => 20,
    ],
]);

foreach ($images as $key => $item) {
    echo "Downloading {$item['name']}... ";
    $saved = false;
    $dest = "{$destDir}/{$key}.jpg";

    foreach ($item['urls'] as $url) {
        $data = @file_get_contents($url, false, $ctx);
        if ($data !== false && strlen($data) > 10000) {
            file_put_contents($dest, $data);
            echo 'SUCCESS via '.basename($url).' ('.round(strlen($data) / 1024)." KB)\n";
            $saved = true;
            break;
        }
    }

    if (! $saved) {
        echo "FAILED ALL URLS\n";
    }
}
