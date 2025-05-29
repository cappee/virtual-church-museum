<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$question = $input['question'];
$workId = $input['id'];

$xmlWorks = simplexml_load_file('../data/works.xml');

$foundWork = null;
foreach ($xmlWorks->work as $work) {
  if ((string)$work->id === $workId) {
    $foundWork = $work;
    break;
  }
}

$operaInfo = "Titolo: {$foundWork->title}\nDescrizione: {$foundWork->description}\nAnno: {$foundWork->year}";
$chiesaInfo = "La basilica è San Giovanni in Porta Latina a Roma";

$fullPrompt = "Informazioni sull'opera:\n$operaInfo\n\nInformazioni sulla chiesa:\n$chiesaInfo\n\nDomanda: $question";

echo json_encode(['prompt' => $fullPrompt]);
