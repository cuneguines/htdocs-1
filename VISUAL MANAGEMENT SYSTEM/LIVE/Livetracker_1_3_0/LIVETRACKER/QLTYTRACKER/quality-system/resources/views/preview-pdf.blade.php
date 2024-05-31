<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview PDF</title>
</head>
<body>
    <h1>Preview PDF</h1>
    <div style="width: 100%; height: 800px;">
        <iframe src="{{ $pdf->output() }}" frameborder="0" width="100%" height="100%"></iframe>
    </div>
</body>
</html>
 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview PDF</title>
</head>
<body>
    <h1>Preview PDF</h1>
    <div style="width: 100%; height: 800px;">
        <iframe src="{{ url('/pdf-preview/') }}" frameborder="0" width="100%" height="100%"></iframe>
    </div>
</body>
</html>

