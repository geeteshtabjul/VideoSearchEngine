var document_delimeter = "[|]";
var delimeter = "|+|";
var tag_delimeter = "|=|";
var MAX_VIDEOS = 10;

$(document).ready(function() {
  $('#search_form').submit(function(){
    $.ajax({
      url:'brain/search.php',
      type:'POST',
      data:{"username": username, search_query: $('#search_query').val()},
      success:populateVideos
    });
    return false;
 });

 function popTopBar(data) {
   $('#video_may_like').html('');
   $('#video_may_like').append('<h3>Videos you may like:</h3>');
   var dataArray = data.split(document_delimeter);
   var i=0, j=0;
   for(i=0; i<dataArray.length; i++) {
     var videoDetails = dataArray[i].split(delimeter);
     var tags = videoDetails[2].split(tag_delimeter).join(', ');
     $('#video_may_like').append('<div class="video_may_like_list"><div class="video_may_like_img_div"><a href="#"><img id="' + videoDetails[12] + '" class="video_may_like_source" src="' + videoDetails[1] + '" /></a><a href="#"><p id="' + videoDetails[12] + '" class="video_may_like_title">' + videoDetails[5] + '</p></a><p class="video_may_like_tags"><i class="material-icons">local_offer</i> ' + tags + '</p><div class="video_may_like_content_div"><p class="video_may_like_view_count"><i class="material-icons">remove_red_eye</i> ' + videoDetails[8] + '</p><p class="video_may_like_channel_title"><i class="material-icons">tv</i> '+videoDetails[4]+'</p></div></div></div>');
   }
 }

 function populateVideosMayLike(data) {
   var dataArray = data.split(delimeter);
   var input = {};
   for(var l = 0; l < dataArray.length; l++) {
     input[l] = dataArray[l];
   }
   input['length'] = dataArray.length;
   $.ajax({
     url:'brain/getVideos.php',
     type:'POST',
     data:input,
     success:popTopBar
   });
 }

 $.ajax({
   url:'brain/getMayLikeVideos.php',
   type:'POST',
   data:{"username": username},
   success:populateVideosMayLike
 });
});

function populateVideos(data) {
  var dataArray = data.split(document_delimeter);
  var i=0, j=0;
  $('#video_result').html('');
  for(i=0; i<dataArray.length; i++) {
    var videoDetails = dataArray[i].split(delimeter);
    var tags = videoDetails[2].split(tag_delimeter).join(', ');
    $('#video_result').append('<div class="video_item"><div class="video_item_img_div"><a href="#"><img id="' + videoDetails[12] + '" class="video_item_source" src="' + videoDetails[1] + '" /></a> <a href="#"><p id="' + videoDetails[12] + '" class="video_item_title">' + videoDetails[5] + '</p></a><p class="video_item_tags"><i class="material-icons">local_offer</i> ' + tags + '</p><div class="video_item_content_div"><p class="video_item_view_count"><i class="material-icons">remove_red_eye</i> ' + videoDetails[8] + '</p><p class="video_item_channel_title"><i class="material-icons">tv</i> '+videoDetails[4]+'</p></div></div></div>');
  }
}

function populateRelatedVideos(data) {
  var videoScores = {}, input = {};
  var dataArray = data.split(document_delimeter);
  for(var i = 0; i < dataArray.length; i++) {
    var videoId = dataArray[i].split(delimeter)[0];
    var score = dataArray[i].split(delimeter)[1];
    videoScores[videoId] = score;
    input[i] = videoId;
  }
  input['length'] = dataArray.length;
  $.ajax({
    url:'brain/getVideos.php',
    type:'POST',
    data:input,
    success:populateVideos
  });
}

function loadVideo(dataI) {
  $('#video_display').html('');
  var data = dataI.split(document_delimeter)[0];
  var videoDetails = data.split(delimeter);
  var tags = videoDetails[2].split(tag_delimeter).join(", ");

  $('#video_display').append('<img class="video_display_img" src="' + videoDetails[0] + '" /><p class="video_display_title">' + videoDetails[5] + '</p><div class="video_display_1"><div class="pad"><p class="video_display_pubAt"><i class="material-icons">today</i> ' + videoDetails[3].split("T")[0] + '</p><p class="video_display_viewC_favC"><i class="material-icons">remove_red_eye</i> ' + videoDetails[8] + ' <i class="material-icons">favorite</i> ' + videoDetails[9] + '</p></div></div><div class="video_display_2"><div class="pad"><p class="video_display_channelTitle"><i class="material-icons">tv</i> ' + videoDetails[4] + '</p><p class="video_display_likeC_dislikeC_commentC"><i class="material-icons">thumb_up</i> ' + videoDetails[11] + ' <i class="material-icons">thumb_down</i> ' + videoDetails[10] + ' <i class="material-icons">mode_comment</i> ' + videoDetails[7] + '</p></div></div><p class="video_display_description_title">Description:</p><p class="video_display_description">' + videoDetails[6] + '</p><br /><p class="video_display_tags">Tags: ' + tags + '</p>');

  $.ajax({
    url:'brain/relatedVideos.php',
    type:'POST',
    data:{"username": username, limit: MAX_VIDEOS, videoId: videoDetails[12]},
    success:populateVideos
  });
}

function openVideo(videoId) {
  $.ajax({
    url:'brain/updateScore.php',
    type:'POST',
    data:{"username": username, "videoId": videoId.target.id}
  });

  $.ajax({
    url:'brain/getVideos.php',
    type:'POST',
    data:{length: 1, 0: videoId.target.id},
    success:loadVideo
  });
}

$(document).on("click", '.video_item_source, .video_item_title', openVideo);
$(document).on("click", '.video_may_like_source, .video_may_like_title', openVideo);
