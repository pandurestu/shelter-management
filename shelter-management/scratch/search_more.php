<?php

function searchCommons($term)
{
    $url = 'https://commons.wikimedia.org/w/api.php?action=query&list=search&srsearch='.urlencode($term).'&srnamespace=6&format=json';
    $ctx = stream_context_create([
        'http' => [
            'header' => "User-Agent: ShelterBot/1.0 (info@shelter.con)\r\n",
            'timeout' => 10,
        ],
    ]);
    $res = @file_get_contents($url, false, $ctx);
    if (! $res) {
        return [];
    }
    $data = json_decode($res, true);

    return $data['query']['search'] ?? [];
}

function getFileUrl($title)
{
    $url = 'https://commons.wikimedia.org/w/api.php?action=query&titles='.urlencode($title).'&prop=imageinfo&iiprop=url&iiurlwidth=1200&format=json';
    $ctx = stream_context_create([
        'http' => [
            'header' => "User-Agent: ShelterBot/1.0 (info@shelter.con)\r\n",
            'timeout' => 10,
        ],
    ]);
    $res = @file_get_contents($url, false, $ctx);
    if (! $res) {
        return null;
    }
    $data = json_decode($res, true);
    $pages = $data['query']['pages'] ?? [];
    foreach ($pages as $p) {
        if (! empty($p['imageinfo'][0]['thumburl'])) {
            return $p['imageinfo'][0]['thumburl'];
        }
        if (! empty($p['imageinfo'][0]['url'])) {
            return $p['imageinfo'][0]['url'];
        }
    }

    return null;
}

$queries = [
    'baby-zoo' => 'tiger cub lion cub baby zoo',
    'kampung-papua' => 'Casuarius casuarius wild bird',
    'istana-panda' => 'Giant panda eating bamboo',
];

foreach ($queries as $key => $q) {
    echo "=== Searching for: $key ($q) ===\n";
    $results = searchCommons($q);
    $count = 0;
    foreach ($results as $r) {
        $fileTitle = $r['title'];
        $url = getFileUrl($fileTitle);
        echo ' - '.$fileTitle.' -> '.$url."\n";
        $count++;
        if ($count >= 3) {
            break;
        }
    }
}
