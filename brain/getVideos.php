<?php
$m = new MongoClient("mongodb://127.0.0.1");
$db = $m->test;
$collection = $db->YoutubeVideos;
require('constants.php');
for($i=0; $i < $_POST['length']; $i++) {
  $cursor = $collection->find(array("videoInfo.id" => $_POST[$i]));
  $it = iterator_to_array($cursor);
  $document = $it[key($it)];
  if($i != 0) {
    echo $document_delimeter;
  }
  require('printRelevantVideos.php');
}
?>
