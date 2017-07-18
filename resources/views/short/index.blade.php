{{ $name }}
{{ $age }}

<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<link href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css" rel="stylesheet"/>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>

<table border="1" id="myTable">
    <thead>
    <tr>
        <th>#</th>
        <th>Short URL</th>
        <th>Long URL</th>
    </tr>
    </thead>

    <tbody>
    @foreach($short as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ url('/').'/'.$item->short_url }}</td>
            <td>{{ $item->long_url }}</td>

        </tr>
    @endforeach
    </tbody>

</table>

<script>

    $('#myTable').DataTable({
        'bSort': false,
        "scrollCollapse": false,
        "info":           true,
        "paging":         true
    } );

</script>