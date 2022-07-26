<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
</head>
<script>
function myFunction(sender)
{
  var CurrentRow=$(sender).closest("tr");

  var ItemId=$("td:eq(0)",$(CurrentRow)).html();  // Can Trim also if needed


}
</script>
<body>
    <table>
    <a href="#Modal" data-toggle="modal" class="btn btn-info-sm" onclick="myFunction()"><span class='glyphicon glyphicon-info-sign'></span></a>


    
<thead><td>jj</td><td>jklj</td></thead>
<tbody>
<tr>
    <td>1</td>
    <td>2</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
</tr>
</tbody>
</table>

    
    </div>
    <div id="Modal" class="modal fade">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Item Inventory</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Item ID</th>
                                <th class="text-center">Total Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <% iteminvents(); %>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
    </div>
    </div>
    </body>
    </html>