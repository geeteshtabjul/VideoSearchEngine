<?php
require('constants.php');
require_once './Config.php';
require('../vendor/autoload.php');
use Everyman\Neo4j\Client;
use Everyman\Neo4j\Cypher;

$m = new MongoClient("mongodb://127.0.0.1");
$db = $m->test;
$collection = $db->YoutubeVideos;
$cursor = $collection->find(
  array(
    "\$text" => array(
      "\$search" => $_POST['search_query']
    )
  ),
  array(
    "videoInfo.id" => true,
    "videoInfo.statistics.viewCount" => true,
    "score" => array(
      "\$meta" => "textScore"
    )
  )
);

$maxmax = 0;
foreach($cursor as $document) {
  if($document['videoInfo']['statistics']['viewCount'] > $maxmax) {
    $maxmax = $document['videoInfo']['statistics']['viewCount'];
  }
}

foreach($cursor as $document) {
  $document['score'] = $document['score']*(1 + $document['videoInfo']['statistics']['viewCount']/(4*$maxmax));
}

require('recoVideos.php');

$maxScoreNeo = max($recommendedVS);
foreach($recommendedVS as $key => $value) {
  $recommendedVS[$key] = ($value/$maxScoreNeo) * 25;
}

$maxScoreMongo = -1;
foreach($cursor as $document) {
  if($document['score'] > $maxScoreMongo) {
    $maxScoreMongo = $document['score'];
  }
}
foreach($cursor as $document) {
  $document['score'] = ($document['score']/$maxScoreMongo) * 100;
  if(isset($recommendedVS[$document['videoInfo']['id']])) {
    $recommendedVS[$document['videoInfo']['id']] = $recommendedVS[$document['videoInfo']['id']] + $document['score'];
  } else {
    $recommendedVS[$document['videoInfo']['id']] = $document['score'];
  }
}

$finalKeys = array();
for($i=0; $i < $MAX_VIDEOS; $i++) {
  $keys = array_keys($recommendedVS, max($recommendedVS));
  if($i + sizeof($keys) > $MAX_VIDEOS) {
    array_push($finalKeys, array_slice($keys, 0, $MAX_VIDEOS - $i - 1));
  } else {
    array_push($finalKeys, $keys);
    $i = $i + sizeof($keys) - 1;
  }
  $recommendedVS = array_diff_key ($recommendedVS, array_flip($keys));
}

for($i=0; $i < sizeof($finalKeys); $i++) {
  $cursor = $collection->find(array("videoInfo.id" => $finalKeys[$i][0]));
  $it = iterator_to_array($cursor);
  $document = $it[key($it)];
  if($i != 0) {
    echo $document_delimeter;
  }
  require('printRelevantVideos.php');
}
?>
