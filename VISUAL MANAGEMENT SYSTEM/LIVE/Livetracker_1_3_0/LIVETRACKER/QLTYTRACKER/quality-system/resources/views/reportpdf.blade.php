<!DOCTYPE html>
<html>

<head>
    <title>Material Preparation Data</title>
    <style>
    @page {
        size: landscape;
        /* Set the page orientation to landscape */
        margin: 20mm;
        /* Adjust margins as needed */
    }
    body
    {
        font-size:small;
    }

    .container {
        width: 100%;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 5px;
        /* Add margin to separate the rows */
    }

    .table-container {
        flex: 1;
        min-width: 50%;
        /* Ensure each container takes up at least half the row */
        margin-right: 1%;
        /* Add margin to create space between the containers */
        border: 1px solid black;
        padding: 2px;
        /* Reduce padding */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        overflow-x: auto;
        /* Handle overflow if content is too wide */
    }

    .table-container:last-child {
        margin-right: 0;
        /* Remove right margin for the last container */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        /* Ensure equal column width */
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 4px;
        /* Reduce padding for better fit */
        text-align: left;
        word-wrap: break-word;
        /* Ensure long text breaks into multiple lines */
    }

    th {
        background-color: #f2f2f2;
    }
    </style>


    <div class="row

</head>
<body>
    <div class=" container">
        <div class="row">
            <div class="table-container">
                <h3>Material Preparation</h3>
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
                       // print_r($data_1);
                        ?>
                        @foreach ($data1 as $row1)
                        @foreach ($row1 as $key => $value1)
                        @if(!empty($value1))
                        <tr>
                            <th>{{ $key }}</th>
                            <td> @php
                                $value1_tick = ($value1 === '1' || $value1 === 'true' || $value1 === 'on' || $value1 ===
                                'yes') ? '✔' : $value1;
                                @endphp
                                {{ $value1_tick }}</td>
                            <td>
                                @foreach ($data_1 as $row_2)
                                @if(isset($row_2->$key) && !empty($row_2->$key))
                                @php
                                $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                                $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                                @endphp
                                {{ $tick }}
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
                <h3>Welding</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Value (Welding)</th>
                            <th>Value (Welding Complete)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                     //print_r($data2);
                        //print_r($data_2);
                        ?>
                        @foreach ($data2 as $row2)
                        @foreach ($row2 as $key => $value2)
                        @if(!empty($value2))

                        <tr>
                            <th>{{ $key }}</th>
                            <td>@php
                                $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                                'yes') ? '✔' : $value2;
                                @endphp
                                {{ $value2_tick }}</td>
                            <td>
                                @foreach ($data_2 as $row_2)

                                @if(isset($row_2->$key) && !empty($row_2->$key))
                                @php
                                $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                                $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                                @endphp
                                {{ $tick }}
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
            <h3>Documentation</h3>
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
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                        <td>
                            @foreach ($data_3 as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            @endphp
                            {{ $tick }}
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
            <h3>Packing Transport</h3>
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
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                        <td>
                            @foreach ($data_6 as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            @endphp
                            {{ $tick }}
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
            <h3>Kitting</h3>
            <table>
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Kitting</th>
                        <th>Kitting Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data5 as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if(!empty($value2))

                    <tr>
                        <th>{{ $key }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                        <td>
                            @foreach ($data_5 as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            @endphp
                            {{ $tick }}
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
            <h3>Testing</h3>
            <table>
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Testing</th>
                        <th>Testing Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data4 as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if(!empty($value2))

                    <tr>
                        <th>{{ $key }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                        <td>
                            @foreach ($data_4 as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            @endphp
                            {{ $tick }}
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
            <h3>Quality</h3>
            <table>
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Quality</th>
                        <th>Quality Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data4 as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if(!empty($value2))

                    <tr>
                        <th>{{ $key }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                        <td>
                            @foreach ($data_4 as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            @endphp
                            {{ $tick }}
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
            <h3>Finishing</h3>
            <table>
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Finishing</th>
                        <th> Finishing Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_finishing as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if(!empty($value2))

                    <tr>
                        <th>{{ $key }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                        <td>
                            @foreach ($data_finishing_c as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            @endphp
                            {{ $tick }}
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
            <h3>Fab FitUp</h3>
            <table>
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Fab FitUp</th>
                        <th> Fab FitUp Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_fabfit as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if(!empty($value2))

                    <tr>
                        <th>{{ $key }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                        <td>
                            @foreach ($data_fabfit_c as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            @endphp
                            {{ $tick }}
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
            <h3>Subcontract</h3>
            <table>
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Subcontract</th>
                        <th> Subcontract Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_subcontract as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if(!empty($value2))

                    <tr>
                        <th>{{ $key }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                        <td>
                            @foreach ($data_subcontract_c as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            @endphp
                            {{ $tick }}
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
            <h3>Planning</h3>
            <table>
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Planning</th>
                        <!-- <th>Testing Complete</th> -->
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_planning as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if(!empty($value2))

                    <tr>
                        <th>{{ $key }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>



                        @endif
                        @endforeach
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="table-container">
            <h3>Engineering</h3>
            <table>
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Planning</th>
                        <!-- <th>Testing Complete</th> -->
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_engineering as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if(!empty($value2))

                    <tr>
                        <th>{{ $key }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>



                        @endif
                        @endforeach
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="table-container">
            <h3>Manufacturing</h3>
            <table>
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Manufacturing</th>
                        <!-- <th>Testing Complete</th> -->
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_manufacturing as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if(!empty($value2))

                    <tr>
                        <th>{{ $key }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>



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