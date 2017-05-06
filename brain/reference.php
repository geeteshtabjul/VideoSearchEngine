<?php
  require_once './Config.php';
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
  $res = mysqli_query($con,"SELECT * FROM course_count");
  //var_dump($res);
  foreach($res as $lol) {
    //var_dump($lol);
  }

  require('vendor/autoload.php');
  use Everyman\Neo4j\Client;
  use Everyman\Neo4j\Cypher;

  $client = new Client('127.0.0.1', 7474);

  $queryTemplate = "MATCH (n) RETURN n";
  $query = new Cypher\Query($client, $queryTemplate);
  $result = $query->getResultSet();

  foreach($result as $row) {
  	//echo $row['n']->getProperty('id') . "<br />";
  }

  $m = new MongoClient("mongodb://127.0.0.1");
  $db = $m->test;
  $collection = $db->YoutubeVideos;
  $cursor = $collection->find();
  // iterate cursor to display title of documents
  $i = 1;
  foreach ($cursor as $document) {
    //echo $i . ") " . $document["videoInfo"]["snippet"]["title"] . "<br />";
    $i = $i + 1;
  }
?>
