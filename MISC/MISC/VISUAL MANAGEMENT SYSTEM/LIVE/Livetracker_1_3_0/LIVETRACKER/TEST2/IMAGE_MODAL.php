<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>#
    <!-- <script type="text/javascript" src="../../JS/LIBS/jquery-3.4.1.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script>
        $('#btn').click(function() {

            $('#image_detail').html('hhh');


        });
    </script>

</head>


<body>


    <button id='btn' data-target="#dataModal" data-toggle="modal"> Click for images </button>
    <!-- <img class="myImages" id="myImg" src="./image1.jpg" alt="Midnight sun in Lofoten, Norway" width="300" height="200">
<img class="myImages" id="myImg" src="./image2.jpg" alt="Fishermen's cabins in Lofoten, Norway"
width="300" height="200">
<img class="myImages" id="myImg" src="./image3.jpg" alt="Gerirangerfjord, Norway" width="300" height="200"> -->
    <!-- Trigger/Open The Modal -->

    <div id="dataModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content" id="modal_content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Details</h4>
                </div>
                <div class="modal-body" id="image_detail">
                    <img class="myImages" id="myImg" src="./image1.jpg" alt="Midnight sun in Lofoten, Norway" width="300" height="200">
                    <img class="myImages" id="myImg" src="./image2.jpg" alt="Fishermen's cabins in Lofoten, Norway" width="300" height="200">
                    <img class="myImages" id="myImg" src="./image3.jpg" alt="Gerirangerfjord, Norway" width="300" height="200">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>