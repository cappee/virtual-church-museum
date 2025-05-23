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
            $works[] = [
                'id' => (string) $work->id,
                //'image' => (string) "http://localhost:8000/data/photos/" . (string) $work->id,
                'image' => (string) "http://localhost:8000/data/photos/monalisa.png",
                'title' => (string) $work->title,
                'yaw' => (float) $work->coord->yaw,
                'pitch' => (float) $work->coord->pitch,
            ];
        }
        echo json_encode($works);
        break;
    }