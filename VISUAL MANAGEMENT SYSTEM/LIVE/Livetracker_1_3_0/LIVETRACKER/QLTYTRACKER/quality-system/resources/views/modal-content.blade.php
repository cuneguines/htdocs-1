<div>
    <h2>Material Preparation Form Data</h2>
    <table class="table table-bordered">
        @foreach ($data1 as $row)
            @foreach ($row as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        @endforeach
    </table>

    <h2>Material Preparation Form Complete Data</h2>
    <table class="table table-bordered">
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
