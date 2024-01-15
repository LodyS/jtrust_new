<style>
body {
    font-family: Georgia, times new roman, Times, Merriweather, Cambria, Times, serif;
    font-weight: 300;
    font-size: 16px;
    line-height: 2;
    /* color: #777; */
    color: #4d4b4b;
}
    
.centerDiv {
    height: 100vh;
    width: 100%;
}
    
.button {
    background-color:#059462;
    border: none;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}
    
form .error {
    color: #ff0000;
}
</style>
    
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=, initial-scale=1.0">
        <title>JTRUST</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('tema/assets/css/demo_1/style.css') }}">
    </head>
    
    <body>
        <div class="container-fluid">
            <div class="row centerDiv">
                <div class="col-sm-12 my-auto">
                    <div class="card border-0">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <img src="{{ asset('logo/Vector.svg')}}" class="img-fluid rounded-start shadow" alt="..." width="690" height="100">
                                </div>
                            </div>
    
                            <div class="col-md-4">
                                <div class="card-body">
                                    <div class="mb-5 text-left">
                                        <div style="height:120px"></div>
                                            <img src="{{ asset('logo/logo.png') }}" class="img-fluid" width="300" >
                                        </div>
    
                                        <form action="{{ route('login') }}" method="POST" name="form">@csrf
                                            <div class="mb-3">
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                            </div>
                                              
    
                                            @error('email')
                                                <div class="alert alert-danger">User tidak valid</div>
                                            @enderror
    
                                            <div class="mb-3">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                            </div>
    
                                            <input type="checkbox" onclick="myFunction()"><label style="font-size:12px">&nbsp;Show Password</label>

                                            @error('password')
                                                <div class="alert alert-danger">Password salah</div>
                                            @enderror

                                            <button type="submit" style="background-color:#2fa6dd; color:white;" class="btn btn w-100">Login</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
    
$("form[name='form']").validate({
    rules: {
        email : "required",
        password : "required",
    },
    messages: {
        email : "Wajib diisi",
        password : "Wajib diisi",
    },
    
    submitHandler: function(form) {
        form.submit();
    }
});

function myFunction() 
{
    var x = document.getElementById("password");
  
    if (x.type === "password")
        x.type = "text";
    else 
        x.type = "password";
    
}
</script>