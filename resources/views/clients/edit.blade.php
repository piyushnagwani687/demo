<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Edit Client</title>
    <div class="container mt-5 w-25">
    <h3>Edit Client</h3>
    <form method="POST" id="client-form">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" value="{{$user->name}}" class="form-control" name="name">
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
            <label class="form-label">City</label>
            <input type="text" value="{{$user->client->city}}" name="city" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address">{{$user->client->address}}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea class="form-control" name="notes">{{$user->client->notes}}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="button" class="btn btn-primary" id="client-submit">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script>
    $('#client-submit').click(function(){
        var url = "{{route('clients.update', $user->id)}}";
        var data = $('#client-form').serialize();
        $.ajax({
            url:url,
            type:'POST',
            data:data,
            success:function(response){
                window.location.href = response.redirectUrl
            },
            error: function(response){
                var name = response.responseJSON.errors.name[0];
                $('#client-form').find(".name-error-msg").html(name);
                var email = response.responseJSON.errors.email[0];
                $('#client-form').find(".email-error-msg").html(email);
            }
        })
    });
</script>
