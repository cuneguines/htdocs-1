// IF A BUTTIN WITH CLASS comment_button IS CLICKED
// ALERT A MESSAGE FROM THE comments ATTRIBTE
$(document).ready(function(){
    $(".comment_button").click(function(){
        alert($(this).attr('comments'));
    });
});