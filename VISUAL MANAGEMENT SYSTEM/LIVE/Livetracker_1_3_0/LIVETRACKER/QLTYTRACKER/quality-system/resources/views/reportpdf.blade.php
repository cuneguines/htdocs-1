<!DOCTYPE html>
<html>

<head>
    <title>Quality Data</title>
    <style>
    @page {
        size: landscape;
        /* Set the page orientation to landscape */
        margin: 20mm;
        /* Adjust margins as needed */
    }

    body {
        font-size: small;
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

    .sales-data {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .sales-item {
        flex: 1 1 calc(33.333% - 10px);
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        font-family: Arial, sans-serif;
    }

    .grey-background {
        background-color: #f2f2f2;
    }
    </style>


    <div class="row
   

</head>
<body>
   
   
   <div class=" container">
        <div style="text-align:center;width:100%">
            <h1>QUALITY REPORT</h1>
        </div>
        <div class="sales-item"><strong>Sales Order:</strong>
            <?php echo isset($data_sales->SalesOrder) ? $data_sales->SalesOrder : '-'; ?></div>
        <div class="sales-item"><strong>Customer:</strong>
            <?php echo isset($data_sales->Customer) ? $data_sales->Customer : '-'; ?></div>
        <div class="sales-item"><strong>Process Order:</strong>
            <?php echo isset($data_sales->ProcessOrder) ? $data_sales->ProcessOrder : '-'; ?></div>
        <div class="sales-item"><strong>Engineer:</strong>
            <?php echo isset($data_sales->Engineer) ? $data_sales->Engineer : '-'; ?></div>
        <div class="sales-item"><strong>Item Name:</strong>
            <?php echo isset($data_sales->ItemName) ? $data_sales->ItemName : '-'; ?></div>
        <div class="sales-item">
            <strong>Endproduct:</strong> <?php echo isset($data_sales->EndProduct) ? $data_sales->EndProduct : '-'; ?>
            | <strong>Quantity:</strong> <?php echo isset($data_sales->Quantity) ? $data_sales->Quantity : '-'; ?>
        </div>
    </div>



    </div>
    <div class="row pl">
        <div class="table-container">
            <h3>Planning</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <!-- <th>Testing Complete</th> -->
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_planning as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'id'&&$key != 'KittingID')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
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
    <div class="row eng">
        <div class="table-container">
            <h3>Engineering</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th>Completed By</th>
                        <!-- <th>Testing Complete</th> -->
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_engineering as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'id' && $key != 'KittingID')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                            <td>
                            @php
                            $foundNonEmptyValue = false;
                            @endphp

                            @foreach ($data_engineering_c as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            $foundNonEmptyValue = true;
                            @endphp
                            {{ $tick }}
                            @break
                            @endif
                            @endforeach

                            @if (!$foundNonEmptyValue)
                            <div class="grey-background">-</div>
                            @endif
                        </td>

</tr>
                        @endif
                        @endforeach
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row man">
        <div class="table-container">
            <h3>Manufacturing</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <!-- <th>Testing Complete</th> -->
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_manufacturing as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && trim($key) != 'id' && $key != 'KittingID')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
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
    <div class="row mat">
        <div class="table-container">
            <h3>Material Preparation</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th>Complete</th>
                        <th>Completed By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                       //print_r($data_11);
                        ?>
                    @foreach ($data1 as $row1)
                    @foreach ($row1 as $key => $value1)

                    @if (!empty($value2) && $key != 'ID' && $key != 'Id' && $key != 'KittingID' && $key != 'id')
                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
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
                        <td>
                            @php
                            $foundNonEmptyValue = false;
                            @endphp

                            @foreach ($data_11 as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            $foundNonEmptyValue = true;
                            @endphp
                            {{ $tick }}
                            @break
                            @endif
                            @endforeach

                            @if (!$foundNonEmptyValue)
                            <div class="grey-background">-</div>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row k">
        <div class="table-container">
            <h3>Kitting</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th>Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data5 as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'id' && $key != 'KittingID' && $key !=
                    'ProcessOrderID')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
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
    <div class="row fab">
        <div class="table-container">
            <h3>Fabrication FitUp</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th>Complete</th>
                        <th> Completed By</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_fabfit as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'id'&&$key != 'KittingID')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
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
                        <td>
                            @php
                            $foundNonEmptyValue = false;
                            @endphp

                            @foreach ($data_fabfit_cc as $row_2)
                            @if (isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            $foundNonEmptyValue = true;
                            @endphp
                            {{ $tick }}
                            @break
                            @endif
                            @endforeach

                            @if (!$foundNonEmptyValue)
                            <div class="grey-background">-</div>
                            @endif
                        </td>

                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row wel">
        <div class="table-container">
            <h3>Welding</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th>Complete</th>
                        <th>Completed By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                     //print_r($data2);
                       // print_r($data_2);
                        ?>
                    @foreach ($data2 as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'Id'&&$key != 'KittingID'&&$key != 'ProcessOrderID'&&$key != 'submission_date')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
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
                        <td>
                        
                            @php
                            $foundNonEmptyValue = false;
                            @endphp
                            @foreach ($data_2_c as $row_2)
                            @if(isset($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            $isEmpty = empty($row_2->$key);
                            @endphp

                            @if (!$isEmpty)
                            <div>{{ $tick }}</div>
                            @php
                            $foundNonEmptyValue = true;
                            break;
                            @endphp
                            @endif
                            @endif
                            @endforeach

                            @if (!$foundNonEmptyValue)
                            <div class="grey-background">-</div>
                            @endif
                        
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row tes">
        <div class="table-container">
            <h3>Testing</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th>Complete</th>
                        <th>Completed By</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                     //print_r($data4);
                      // print_r($data_4);
                        ?>
                    @foreach ($data4 as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'id'&&$key != 'KittingID')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
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
                        <td>
                            @php
                            $foundNonEmptyValue = false;
                            @endphp
                            @foreach ($data_4_c as $row_2)
                            @if(isset($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            $isEmpty = empty($row_2->$key);
                            @endphp

                            @if (!$isEmpty)
                            <div>{{ $tick }}</div>
                            @php
                            $foundNonEmptyValue = true;
                            break;
                            @endphp
                            @endif
                            @endif
                            @endforeach

                            @if (!$foundNonEmptyValue)
                            <div class="grey-background">-</div>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row fin">
        <div class="table-container">
            <h3>Finishing</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th> Complete</th>
                        <th> Competed By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
               // print_r($data_finishing_c);
                ?>
                    @foreach ($data_finishing as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'id'&&$key != 'KittingID')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
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
                        <td>
                            @php
                            $foundNonEmptyValue = false;
                            @endphp
                            @foreach ($data_finishing_cc as $row_2)
                            @if(isset($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'yes') ? '✔' : $row_2->$key;
                            $isEmpty = empty($row_2->$key);
                            @endphp

                            @if (!$isEmpty)
                            <div>{{ $tick }}</div>
                            @php
                            $foundNonEmptyValue = true;
                            break;
                            @endphp
                            @endif
                            @endif
                            @endforeach

                            @if (!$foundNonEmptyValue)
                            <div class="grey-background">-</div>
                            @endif
                        </td>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
     
    <div class="row sub">
        <div class="table-container">
            <h3>Subcontract</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th> Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_subcontract as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'id'&&$key != 'KittingID')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
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
    <div class="row fina">
        <div class="table-container">
            <h3>Final Assembly</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th>Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_final as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'id'&&$key != 'KittingID')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                        <td>
                            @foreach ($data_final_c as $row_2)
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
    <div class="row q">
        <div class="table-container">
            <h3>Quality</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th>Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_qlty as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'id'&&$key != 'KittingID'&&$key != 'uuid')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                        <td>
                            @foreach ($data_qlty_c as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' ||
                            $row_2->$key === 'Yes') ? '✔' :  ($row_2->$key === 'No' ? '✘' : $row_2->$key);
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
    <div class="row d">
        <div class="table-container">
            <h3>Documentation</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th>Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data3 as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'id'&&$key != 'KittingID')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
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
    <div class="row packing">
        <div class="table-container">
            <h3>Packing Transport</h3>
            <table>
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Required</th>
                        <th> Complete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data6 as $row2)
                    @foreach ($row2 as $key => $value2)
                    @if (!empty($value2) && $key != 'ID' && $key != 'id'&&$key != 'KittingID')

                    <tr>
                        <th> @php
                            $formattedKey = ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            {{ $formattedKey }}</th>
                        <td>@php
                            $value2_tick = ($value2 === '1' || $value2 === 'true' || $value2 === 'on' || $value2 ===
                            'Yes') ? '✔' : $value2;
                            @endphp
                            {{ $value2_tick }}</td>
                        <td>
                            @foreach ($data_6 as $row_2)
                            @if(isset($row_2->$key) && !empty($row_2->$key))
                            @php
                            $tick = ($row_2->$key === '1' || $row_2->$key === 'true' || $row_2->$key === 'on' || trim($row_2->$key) === 'Yes') ? '✔' : $row_2->$key;
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


    </div>

    </div>

    </div>




    </div>



</body>

</html>