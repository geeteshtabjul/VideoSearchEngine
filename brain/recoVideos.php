<?php
  //don't forget to set $mul before this!!
  function calcRecoScore($p, $o) {
    if($p > $o) {
      return $p + $o/4;
    } else {
      return $o + $p/4;
    }
  }

  require_once './Config.php';
  require_once('../vendor/autoload.php');
  use Everyman\Neo4j\Client;
  use Everyman\Neo4j\Cypher;
  $mul = 0.8;
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
  $res = mysqli_query($con,'SELECT videoId FROM click_log WHERE username = "' . $_POST["username"] . '" ORDER BY score DESC LIMIT 4');
  // $res = mysqli_query($con,'SELECT videoId FROM click_log WHERE username = "bob" ORDER BY score DESC LIMIT 4');
  $client = new Client('127.0.0.1', 7474);
  $recommendedVS = array();
  foreach($res as $sqlVideos) {
    //this query is also used in relatedVideos.php
    $queryTemplate = 'MATCH (n1)-[r]-(n2) WHERE n1.id <> n2.id AND n1.id = "' . $sqlVideos['videoId'] . '" WITH n2.id as id, collect(r) as relations return id, reduce(score = 0, T in relations| case when type(T) = "SAME_CHANNEL" then score + 14 when type(T) = "SIMILAR_DESC" then score + T.weight when type(T) = "SAME_CATEGORY" then score + 12 when type(T) = "COMMON_TAGS" then score + 5*T.weight end) as score order by score DESC LIMIT ' . $MAX_VIDEOS;
    $query = new Cypher\Query($client, $queryTemplate);
    $result = $query->getResultSet();
    foreach($result as $row) {
      if(isset($recommendedVS[$row['id']])) {
        $recommendedVS[$row['id']] = calcRecoScore($recommendedVS[$row['id']], $mul * $row['score']);
      } else {
        $recommendedVS[$row['id']] = $mul * $row['score'];
      }
    }
    if($mul != 1) {
      $mul = $mul - 0.2;
    }
  }
?>
