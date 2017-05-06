<?php
echo $document["videoInfo"]["snippet"]["thumbnails"]["high"]["url"] . $delimeter;
echo $document["videoInfo"]["snippet"]["thumbnails"]["default"]["url"] . $delimeter;
if(isset($document["videoInfo"]["snippet"]["tags"])) {
  echo implode($tag_delimeter, $document["videoInfo"]["snippet"]["tags"]);
}
echo $delimeter;
echo $document["videoInfo"]["snippet"]["publishedAt"] . $delimeter;
echo $document["videoInfo"]["snippet"]["channelTitle"] . $delimeter;
echo $document["videoInfo"]["snippet"]["title"] . $delimeter;
echo $document["videoInfo"]["snippet"]["description"] . $delimeter;
echo $document["videoInfo"]["statistics"]["commentCount"] . $delimeter;
echo $document["videoInfo"]["statistics"]["viewCount"] . $delimeter;
echo $document["videoInfo"]["statistics"]["favoriteCount"] . $delimeter;
echo $document["videoInfo"]["statistics"]["dislikeCount"] . $delimeter;
echo $document["videoInfo"]["statistics"]["likeCount"] . $delimeter;
echo $document["videoInfo"]["id"];
?>
