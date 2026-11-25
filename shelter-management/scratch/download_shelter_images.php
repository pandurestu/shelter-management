<?php

$shelters = [
    'baby-zoo' => [
        'name' => 'Baby Zoo',
        'query' => 'Lion cub white tiger cub baby animals',
        'fallback_url' => 'https://images.unsplash.com/photo-1534188753412-3e26d0d618d6?auto=format&fit=crop&w=1200&q=80', // Lion cub
    ],
    'australia-outback' => [
        'name' => 'Australia Outback',
        'query' => 'Kangaroo ring-tailed lemur Australia outback',
        'fallback_url' => 'https://images.unsplash.com/photo-1579762715118-a6f1d4b934f1?auto=format&fit=crop&w=1200&q=80', // Red kangaroo
    ],
    'bird-of-prey' => [
        'name' => 'Bird of Prey',
        'query' => 'Eagle hawk prey bird',
        'fallback_url' => 'https://images.unsplash.com/photo-1611689342806-0863700ce1e4?auto=format&fit=crop&w=1200&q=80', // Eagle
    ],
    'taman-buaya' => [
        'name' => 'Taman Buaya',
        'query' => 'Crocodile binturong reptile',
        'fallback_url' => 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=1200&q=80', // Crocodile
    ],
    'komodo-dragon' => [
        'name' => 'Komodo Dragon Island',
        'query' => 'Komodo dragon lizard',
        'fallback_url' => 'https://images.unsplash.com/photo-1557008075-7f2c5efa4cfd?auto=format&fit=crop&w=1200&q=80', // Komodo dragon
    ],
    'kampung-papua' => [
        'name' => 'Kampung Papua',
        'query' => 'Cassowary tree kangaroo Papua animal',
        'fallback_url' => 'https://images.unsplash.com/photo-1590682680695-43b964a3ae17?auto=format&fit=crop&w=1200&q=80', // Cassowary
    ],
    'bahtera-penguin' => [
        'name' => 'Bahtera Penguin',
        'query' => 'Penguin humboldt water zoo',
        'fallback_url' => 'https://images.unsplash.com/photo-1598439210625-5067c578f3f6?auto=format&fit=crop&w=1200&q=80', // Penguin swimming
    ],
    'primate-center' => [
        'name' => 'Primate Center',
        'query' => 'Orangutan chimpanzee primate',
        'fallback_url' => 'https://images.unsplash.com/photo-1540573133985-87b6da6d54a9?auto=format&fit=crop&w=1200&q=80', // Orangutan
    ],
    'lorong-reptil' => [
        'name' => 'Lorong Reptil & Satwa Malam',
        'query' => 'Reptile owl nocturnal terrarium snake',
        'fallback_url' => 'https://images.unsplash.com/photo-1533282960533-51328aa49826?auto=format&fit=crop&w=1200&q=80', // Owl nocturnal / snake
    ],
    'istana-panda' => [
        'name' => 'Istana Panda',
        'query' => 'Giant panda bamboo Taman Safari',
        'fallback_url' => 'https://images.unsplash.com/photo-1527118732049-c88155f2107c?auto=format&fit=crop&w=1200&q=80',
    ],
];

@mkdir(__DIR__.'/../public/images/shelters', 0777, true);

$ctx = stream_context_create([
    'http' => [
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36\r\n",
        'timeout' => 15,
    ],
]);

foreach ($shelters as $key => $info) {
    $dest = __DIR__."/../public/images/shelters/{$key}.jpg";
    echo "Downloading image for {$info['name']}... ";
    $data = @file_get_contents($info['fallback_url'], false, $ctx);
    if ($data !== false && strlen($data) > 5000) {
        file_put_contents($dest, $data);
        echo 'OK ('.round(strlen($data) / 1024)." KB)\n";
    } else {
        echo "FAILED\n";
    }
}
