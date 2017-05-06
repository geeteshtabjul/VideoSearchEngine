<?php
  require_once('../vendor/autoload.php');
  require_once('constants.php');
  use Everyman\Neo4j\Client;
  use Everyman\Neo4j\Cypher;
  $client = new Client('127.0.0.1', 7474);
  //this query is also used in search.php
  $queryTemplate = 'MATCH (n1)-[r]-(n2) WHERE n1.id <> n2.id AND n1.id = "' . $_POST['videoId'] . '" WITH n2.id as id, collect(r) as relations return id, reduce(score = 0, T in relations| case when type(T) = "SAME_CHANNEL" then score + 14 when type(T) = "SIMILAR_DESC" then score + T.weight when type(T) = "SAME_CATEGORY" then score + 12 when type(T) = "COMMON_TAGS" then score + 5*T.weight end) as score order by score DESC LIMIT ' . $_POST['limit'];
  $query = new Cypher\Query($client, $queryTemplate);
  $result = $query->getResultSet();

  require('recoVideos.php');
  foreach($result as $row) {
    if(isset($recommendedVS[$row['id']])) {
      $recommendedVS[$row['id']] = calcRecoScore($recommendedVS[$row['id']], $row['score']);
    } else {
      $recommendedVS[$row['id']] = $row['score'];
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

  $m = new MongoClient("mongodb://127.0.0.1");
  $db = $m->test;
  $collection = $db->YoutubeVideos;

  for($i=0; $i < sizeof($finalKeys); $i++) {
    if(!isset($finalKeys[$i][0])) {
      continue;
    }
    if($finalKeys[$i][0] == $_POST['videoId']) {
      continue;
    }
    $cursor = $collection->find(array("videoInfo.id" => $finalKeys[$i][0]));
    $it = iterator_to_array($cursor);
    $document = $it[key($it)];
    if($i != 0) {
      echo $document_delimeter;
    }
    require('printRelevantVideos.php');
  }
  // $i = 0;
  // foreach($result as $row) {
  //   if($i != 0) {
  //     echo $document_delimeter;
  //   } else {
  //     $i++;
  //   }
  // 	echo $row['id'] . $delimeter . $row['score'];
  // }
?>
