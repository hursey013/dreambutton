$(function () {
  $('form').on('submit', function() {
    $(".alert").remove();
    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "index.php",
      data: formData,
      success: function(data) {
        $("img").attr("src", data).animateCss('fadeIn');
        $(".panel-body").prepend("<div class='alert alert-success' role='alert'>Your Dream Button is ready &mdash; <a class='alert-link' download='dream-btn.jpg' href='" + data + "'>download it now!</a></div>").animateCss('fadeIn');
      }
    });
    return false;
  });
});

$.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $(this).addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});