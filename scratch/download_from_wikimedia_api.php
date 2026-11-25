<?php

$fileTitles = [
    'baby-zoo' => 'File:Lion cub (Panthera leo) 6 weeks.jpg',
    'australia-outback' => 'File:Red Kangaroos at Sturt National Park NSW.jpg',
    'bird-of-prey' => 'File:Elang Jawa (Nisaetus Bartelsi).jpg',
    'taman-buaya' => 'File:TamanSafariIndonesia259.jpg',
    'komodo-dragon' => 'File:KomodoDragons.jpg',
    'kampung-papua' => 'File:Wild cassowary walking at Mission Beach IMG 3933.jpg',
    'bahtera-penguin' => 'File:Spheniscus humboldti -Chester Zoo -swimming-8a.jpg',
    'primate-center' => 'File:Bornean orangutan Taman Safari.jpg',
    'lorong-reptil' => 'File:Morelia-viridis.jpg',
    'istana-panda' => 'File:Giant panda eating bamboo Taipei Zoo.jpg',
];

$altTitles = [
    'baby-zoo' => ['File:Tiger cub in zoo.jpg', 'File:Lion cub.jpg', 'File:Lion cubs (Panthera leo) 3 weeks.jpg', 'File:Tiger cub resting.jpg'],
    'australia-outback' => ['File:Osphranter rufus - Tierpark Hagenbeck 01.jpg', 'File:Kangaroo Australia 01 11 2008 - retouch.JPG'],
    'bird-of-prey' => ['File:Nisaetus bartelsi (Elang Jawa).jpg', 'File:Elang Jawa Nisaetus bartelsi Bandung Zoo 2 cropped.jpg'],
    'taman-buaya' => ['File:TamanSafariIndonesia261.jpg', 'File:TamanSafariIndonesia260.jpg', 'File:Crocodylus porosus top.jpg'],
    'komodo-dragon' => ['File:Komodo dragon (Varanus komodoensis).jpg', 'File:Komodo dragon Varanus komodoensis Ragunan Zoo 2.jpg'],
    'kampung-papua' => ['File:Casuarius casuarius in Australia.jpg', 'File:Casuarius casuarius 2.jpg'],
    'bahtera-penguin' => ['File:Spheniscus humboldti -Dublin Zoo -swimming-8a.jpg', 'File:Spheniscus humboldti Zoo Landau 01.jpg'],
    'primate-center' => ['File:Orangutan Kalimantan.jpg', 'File:Orang Utan, Singapore Zoo.JPG'],
    'lorong-reptil' => ['File:Green Tree Python 0A2A0428.jpg', 'File:Green Tree Python juvenile A22I6572.jpg'],
    'istana-panda' => ['File:Panda eating bamboo in Panda Base.jpg', 'File:Grosser Panda.JPG'],
];

function fetchFileDirectUrl($title)
{
    $api = 'https://commons.wikimedia.org/w/api.php?action=query&titles='.urlencode($title).'&prop=imageinfo&iiprop=url&iiurlwidth=1280&format=json';
    $ch = curl_init($api);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'ShelterBot/1.0 (info@shelter.con)');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $res = curl_exec($ch);
    curl_close($ch);

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

function downloadImageFile($url, $dest)
{
    $ch = curl_init($url);
    $fp = fopen($dest, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $res = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    fclose($fp);

    if ($res && $httpCode == 200 && filesize($dest) > 10000) {
        return true;
    }
    @unlink($dest);

    return false;
}

$destDir = __DIR__.'/../public/images/shelters';
@mkdir($destDir, 0777, true);

foreach ($fileTitles as $key => $mainTitle) {
    $dest = "{$destDir}/{$key}.jpg";
    echo "Processing $key... ";

    $candidates = array_merge([$mainTitle], $altTitles[$key] ?? []);
    $success = false;

    foreach ($candidates as $title) {
        $url = fetchFileDirectUrl($title);
        if ($url) {
            echo "URL found ($title)... ";
            if (downloadImageFile($url, $dest)) {
                echo 'DOWNLOADED ('.round(filesize($dest) / 1024)." KB) OK\n";
                $success = true;
                break;
            } else {
                echo 'DL FAILED, trying next... ';
            }
        }
    }

    if (! $success) {
        echo "FAILED ALL CANDIDATES\n";
    }
}
