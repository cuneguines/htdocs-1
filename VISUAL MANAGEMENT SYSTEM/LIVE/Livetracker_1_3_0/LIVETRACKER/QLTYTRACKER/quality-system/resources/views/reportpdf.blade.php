

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
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px; /* Add margin to separate the rows */
        }
        .table-container {
            flex: 1;
            min-width: 50%; /* Ensure each container takes up at least half the row */
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="table-container">
                <h2>Material Preparation</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Value (Material Preparation)</th>
                            <th>Value (Material Complete)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        print_r($data_1);
                        ?>
                        @foreach ($data1 as $row1)
                            @foreach ($row1 as $key => $value1)
                                @if(!empty($value1))
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <td>{{ $value1 }}</td>
                                        <td>
                                            @foreach ($data_1 as $row2)
                                                @if(isset($row2->$key) && !empty($row2->$key))
                                                    {{ $row2->$key }}
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
       <div class="row">
            <div class="table-container">
                <h2>Welding</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Value (Welding)</th>
                            <th>Value (Welding Complete)</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($data2 as $row2)
                            @foreach ($row2 as $key => $value2)
                                @if(!empty($value2))
                                
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <td>{{ $value2 }}</td>
                                        <td>
                                            @foreach ($data_2 as $row_2)
                                                @if(isset($row_2->$key) && !empty($row_2->$key) && ($row_2->$key == 'true'||$row_2->$key == 'on' || $row_2->$key == 'yes'))
                                                    {{ $row_2->$key }}
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="table-container">
                <h2>Documentation</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Value (Documentation)</th>
                            <th>Value (Documentation Complete)</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($data3 as $row2)
                            @foreach ($row2 as $key => $value2)
                                @if(!empty($value2))
                                
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <td>{{ $value2 }}</td>
                                        <td>
                                            @foreach ($data_3 as $row_2)
                                                @if(isset($row_2->$key) && !empty($row_2->$key))
                                                    {{ $row_2->$key }}
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="table-container">
                <h2>Packing Transport</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Value (Transport)</th>
                            <th>Value ( Complete)</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($data6 as $row2)
                            @foreach ($row2 as $key => $value2)
                                @if(!empty($value2))
                                
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <td>{{ $value2 }}</td>
                                        <td>
                                            @foreach ($data_6 as $row_2)
                                                @if(isset($row_2->$key) && !empty($row_2->$key))
                                                    {{ $row_2->$key }}
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
