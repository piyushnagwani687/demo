<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<html>
    <head>
        <title>Clients</title>
    </head>
    <body class="mt-5 p-5" >
        @if (Auth::user()->role != 'client')
            <a class="btn btn-primary mb-4" href="{{route('clients.create')}}">Add Client</a>
        @endif
        <table id="clients-table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>Notes</th>
                    @if (Auth::user()->role != 'client')
                        <th>Status</th>
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->client->city}}</td>
                        <td>{{$user->client->address}}</td>
                        <td>{{$user->client->notes}}</td>
                        @if (Auth::user()->role != 'client')
                            <td>
                                <select class="form-select w-50 change-status" data-user-id="{{$user->id}}" aria-label="Default select example">
                                    <option>select status</option>
                                    <option value="active" {{$user->status == 'active' ? 'selected' : ''}}>Active</option>
                                    <option value="inactive" {{$user->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                                </select>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{route('clients.edit', $user->id)}}">Edit</a></li>
                                        <li><a class="dropdown-item delete-row" data-id="{{$user->id}}">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>


<script>
    new DataTable('#clients-table');
    $('.delete-row').click(function(){
        let id = $(this).data('id');
        var url = "{{ route('clients.destroy', ':id') }}";
        url = url.replace(':id', id);
        var token = "{{ csrf_token() }}";
            $.ajax({
                url:url,
                type: 'POST',
                data:{
                    '_token': token,
                    '_method': 'DELETE'
                },
                success: function(response){
                    window.location.href = response.redirectUrl
                }
            });
    });

    $('.change-status').change(function() {
        let id= $(this).data('user-id');
        let status = $(this).val();
        var url = "{{ route('clients.change-status') }}";
        url = url.replace(':id', id);
        var token = "{{ csrf_token() }}";
        $.ajax({
            url:url,
            type:'POST',
            data:{
                '_token': token,
                id:id,
                status:status,
            },
            success:function($response){
                window.location.reload();
            }
        })

    });

</script>
