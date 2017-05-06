$(window, document, undefined).ready(function() {
  $('input').blur(function() {
    var $this = $(this);
    if ($this.val())
      $this.addClass('used');
    else
      $this.removeClass('used');
  });

  var $ripples = $('.ripples');

  $ripples.on('click.Ripples', function(e) {
    var $this = $(this);
    var $offset = $this.parent().offset();
    var $circle = $this.find('.ripplesCircle');
    var x = e.pageX - $offset.left;
    var y = e.pageY - $offset.top;
    $circle.css({
      top: y + 'px',
      left: x + 'px'
    });
    $this.addClass('is-active');
  });

  $ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function(e) {
  	$(this).removeClass('is-active');
  });

  function passOrNo(data) {
    if(data == "1") {
      location.href = 'index.php';
    } else {
      $('#wrongCre').attr('style', "visibility: visible;");
      $('#wrongCre').html("Username already exists!");
    }
  }

  $('#login_form').submit(function(){
    if($('#pass_word').val() != $('#re_pass_word').val()) {
      $('#wrongCre').attr('style', "visibility: visible;");
      $('#wrongCre').html("Passwords do not match!");
    } else {
      $.ajax({
        url:'brain/registerPage.php',
        type:'POST',
        data:{"username": $('#user_name').val(), "password": $('#pass_word').val()},
        success:passOrNo
      });
    }
    return false;
  });
});
