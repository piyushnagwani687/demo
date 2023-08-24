<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<html>
    <head>
        <title>Employees</title>
    </head>
    <body class="mt-5 p-5" >
        @if (Auth::user()->role != 'employee')
            <a class="btn btn-primary mb-4" href="{{route('employees.create')}}">Add Employee</a>
        @endif
        <table id="myapp" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    @if (Auth::user()->role != 'employee')
                        <th>Status</th>
                    @endif
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{isset($user->employee) ? $user->employee->phone_number : '' }}</td>
                        @if (Auth::user()->role != 'employee')
                            <td>
                                <select class="form-select w-50 change-status" data-user-id="{{$user->id}}" aria-label="Default select example">
                                    <option>select status</option>
                                    <option value="active" {{$user->status == 'active' ? 'selected' : ''}}>Active</option>
                                    <option value="inactive" {{$user->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                                </select>
                            </td>
                        @endif
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  Action
                                </button>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="{{route('employees.edit', $user->id)}}">Edit</a></li>
                                  @if (Auth::user()->role != 'employee')
                                    <li><a class="dropdown-item delete-row" data-id="{{$user->id}}">Delete</a></li>
                                  @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>


<script>
    new DataTable('#myapp');
    $('.delete-row').click(function(){
        let id = $(this).data('id');
        // alert(id);
        var url = "{{ route('employees.destroy', ':id') }}";
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
        var url = "{{ route('employees.change-status') }}";
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
