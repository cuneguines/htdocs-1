<!DOCTYPE html>
<html>
<head>
    <title>Material Preparation Data</title>
    <style>
        @page {
            size: landscape; /* Set the page orientation to landscape */
            margin: 20mm; /* Adjust margins as needed */
        }

        .container {
            width: 100%;
        }
        .table-container {
            float: left;
            width: 49%; /* Adjust width to fit both containers in a single line */
            margin-right: 1%; /* Add margin to create space between the containers */
            border: 1px solid black;
            padding: 5px; /* Reduce padding */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            overflow-x: auto; /* Handle overflow if content is too wide */
        }
        .table-container:last-child {
            margin-right: 0; /* Remove right margin for the last container */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px; /* Reduce padding for better fit */
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .clear {
            clear: both; /* Ensure the following elements start on a new line */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="table-container">
            <h2>Material Preparation</h2>
            <table>
                @foreach ($data1 as $row)
                    @foreach ($row as $key => $value)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        </div>
        <div class="table-container">
            <h2>Material Complete</h2>
            <table>
                @foreach ($data2 as $row)
                    @foreach ($row as $key => $value)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
