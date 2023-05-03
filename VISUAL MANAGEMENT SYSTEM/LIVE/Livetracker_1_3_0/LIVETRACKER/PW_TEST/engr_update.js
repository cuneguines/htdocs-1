$(document).ready(function () {

});
function myFunction(event) {
    var CurrentRow = $(event.target).closest("tr");
    var engr_name = $("td:eq(0)", $(CurrentRow)).html();
    console.log(engr_name);
    $('#name').val(engr_name);
}
function submitt()
{
    alert('submitted');
}