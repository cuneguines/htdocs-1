// KEEPS TRACK OF ACTIVE AND HIDDEN 1 - 0 COMMENTS (INACTIVE BY DEFAULT)
$(document).ready(function(){
    console.log("TEST");
    $(".comment_button").click(function(){
        alert($(this).attr('comments'));
    });
});