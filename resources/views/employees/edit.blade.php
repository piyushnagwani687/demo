<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<title>Edit Employee</title>
<div class="container mt-5 w-25">
    <h3>Edit Employee</h3>
    <form method="POST" id="employee-form">
        @method('Put')
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input value="{{$user->name}}" type="text" class="form-control" name="name">
            <div class="text-danger name-error-msg">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" value="{{$user->email}}" class="form-control" name="email">
            <div class="text-danger email-error-msg">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone No</label>
            <input type="text" name="phone_number" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="button" class="btn btn-primary" id="employee-submit">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script>
    $('#employee-submit').click(function(){
        var url = "{{ route('employees.update', $user->id) }}";
        var data = $('#employee-form').serialize()
        $.ajax({
            url:url,
            type:'POST',
            data:data,
            success:function(response){
                window.location.href = response.redirectUrl
            },
            error: function(response){
                var name = response.responseJSON.errors.name[0];
                $('#employee-form').find(".name-error-msg").html(name);
                var email = response.responseJSON.errors.email[0];
                $('#employee-form').find(".email-error-msg").html(email);
            }
        })
    });
</script>
