$(document).ready(function() {
 $("#username").keyup(function(e) {
   var username = $(this).val();

   $("#username_result").css("height","43px");

   if (username == "") {
     $(".available, .taken").fadeOut();
     $(".need_username").fadeIn();
   } else {
     $.ajax({
       url: "validation.php?new_username="+username,
       dataType: "text"}).done(function(available) {
         if (available == "valid") {
           $(".need_username, .taken").fadeOut();
           $("div.available").fadeIn();
         } else {
           $(".available, .need_username").fadeOut();
           $("div.taken").fadeIn();
         } //end else
     }); //end .done()
   } //end else
 }); //end keyup
}); //end document ready