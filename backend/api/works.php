<?php
header('Access-Control-Allow-Origin: *');

$xmlFile = __DIR__ . '/../data/works.xml';

$action = $_GET['action'] ?? 'xml';

switch ($action) {
    case 'xml':
        header('Content-Type: application/xml');
        echo file_get_contents($xmlFile);
        break;
    case 'list':
        header('Content-Type: application/json');
        $xml = simplexml_load_file($xmlFile);
        $works = [];

        foreach ($xml->work as $work) {
            $id = (string) $work->id;
            $imagePaths = [];

            $basePath = __DIR__ . "/../data/photos/";
            $baseUrl = "http://localhost:8000/data/photos/";

            $i = 1;
            do {
                $filename = $i === 1 ? "$id.jpeg" : "{$id}_$i.jpeg";
                $fullPath = $basePath . $filename;
                if (file_exists($fullPath)) {
                    $imagePaths[] = $baseUrl . $filename;
                    $i++;
                } else {
                    break;
                }
            } while (true);

            $works[] = [
                'id' => $id,
                'images' => $imagePaths,
                'title' => (string) $work->title,
                'subtitle' => (string) $work->subtitle,
                'description' => isset($work->description) ? (string) $work->description : null,
                'year' => (int) $work->year,
                'location' => (string) $work->location,
                'yaw' => (float) $work->coord->yaw,
                'pitch' => (float) $work->coord->pitch,
            ];
        }
        echo json_encode($works);
        break;
    }