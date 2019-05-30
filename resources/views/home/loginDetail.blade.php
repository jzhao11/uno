<!-- this is the page for registration and login -->
<!-- registration and login tabs are both included here -->
<!-- success of registration/login will redirect to different pages 
according to different user behaviors -->
<!-- failure of registration/login will stay on this page -->

@extends("home.base")
@section("bodycontent")
<div class="container">
    <h1>Login</h1>
    <hr>

    <form id="login" data-toggle="validator" role="form">
        <div class="form-group">
            <label for="usr">Username</label>
        	<input type="text" class="form-control" id="username" data-minlength="4" placeholder="Enter Username" data-error="Minimum of 4 characters" required>
        	<div class="help-block with-errors"></div>
        </div>

        <div class="form-group">
            <label for="pwd">Password</label>
            <input type="password" class="form-control" id="password" data-minlength="6" placeholder="Enter Password" data-error="Minimum of 6 characters" required>
        	<div class="help-block with-errors"></div>
        </div>
        <hr>

        <button type="submit" class="btn btn-primary">Log in</button>
        <br><br>
        Don't have an account? <a href="<?php echo asset("registerdetail"); ?>">Register</a>
    </form>
</div>
<script>
$("#login").validator().on("submit", function (e) {
    if (!e.isDefaultPrevented()) {
    	e.preventDefault();
    	login();
    }
});

function login(){
    $.ajax ({
    	url: "<?php echo url("login")?>",
        type: "POST",
        data: {
            "username":$("#username").val(),
			"password":$("#password").val()
		},
        success: function (rst) {
        	if (rst == -1) {
				alert("This username does not exist!");
            } else if (rst == -2) {
            	alert("This password is incorrect!");
            } else {
                location.href = "lobby";
            }
        }
    });
}
</script>
@include('home.footer')
@endsection