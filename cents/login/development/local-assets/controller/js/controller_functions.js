
/**
 * Function to Create a New User
 */

/**
 * @param
 */
function createUser() {
  var postURL = "local-assets/controller/ajaxcontrollercalls.php";
  var actionString = "action=createUser&";
  var dataString = "userID=4&userFirstName='Farah'&userSurname='Tahir'";
  alert("createUser Data -" + dataString);

  $.ajax({
    type: "POST",
    url: postURL,
    data: actionString + dataString,
    cache: false,
    success: function (data) {
      alert("Success");
      alert(data);
      //
    },
  });
  e.preventDefault();
}
