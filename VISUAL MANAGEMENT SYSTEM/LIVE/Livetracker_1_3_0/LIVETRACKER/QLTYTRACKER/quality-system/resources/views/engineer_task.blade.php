<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Your Page Title</title>

    <!-- Your additional head content here -->

    <style>
        /* Your styles here */
    </style>
</head>

<body>
    <div id="background" style="background-color:#E8E8E8">
        <!-- Your navigation menu and other content here -->

        <!-- Form for both sets of files -->
        <form id="yourForm" enctype="multipart/form-data" action="/handleFileUpload" method="post">
            @csrf
            <div>
                <input type="file" name="uploaded_files_1" multiple onchange="displaySelectedFiles(this, 'uploaded_files_1')">
                <ul id="selectedFilesList_1"></ul>
            </div>
            <div>
                <input type="file" name="uploaded_files_2" multiple onchange="displaySelectedFiles(this, 'uploaded_files_2')">
                <ul id="selectedFilesList_2"></ul>
            </div>
            <button type="submit">Submit Files</button>
        </form>

        <!-- Other content here -->

    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function displaySelectedFiles(input, listId) {
            var filesList = $('#' + listId);

            // Clear previous content if needed
            filesList.empty();

            if (input.files && input.files.length > 0) {
                for (var i = 0; i < input.files.length; i++) {
                    var fileName = input.files[i].name;
                    var listItem = $('<li>' + fileName + ' <button type="button" onclick="removeFile(this, \'' + listId + '\')">Delete</button></li>');
                    filesList.append(listItem);
                }
            }
        }

        function removeFile(button, listId) {
            // Get the list item containing the file and remove it
            $(button).closest('li').remove();

            // Clear the associated file input to allow re-selection of the same file
            var fileInput = $('#yourForm [name="' + listId + '"]');
            fileInput.val('');
        }
    </script>
</body>

</html>
