<!-- this is the page for registration and login -->
<!-- registration and login tabs are both included here -->
<!-- success of registration/login will redirect to different pages 
according to different user behaviors -->
<!-- failure of registration/login will stay on this page -->

@extends("home.base")
@section("bodycontent")
<div class="container">
    <h1>Registration</h1>
    <p>Required fields are marked with *</p>
    <hr>

    <form id="register" data-toggle="validator" role="form">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
        </div>

        <div class="form-group">
            <label for="usr">Username*</label>
            <input type="text" class="form-control" name="username" id="username" data-minlength="4" placeholder="Enter Username" data-error="Minimum of 4 characters" required>
        	<div class="help-block with-errors"></div>
        </div>

        <div class="form-group">
            <label for="pwd">Password*</label>
            <input type="password" class="form-control" id="password" name="password" data-minlength="6" placeholder="Enter Password" required>
        	<div class="help-block">Minimum of 6 characters</div>
        </div>

        <div class="form-group">
            <label for="pwd-confirm">Confirm Password*</label>
            <input type="password" class="form-control" id="passwordconfirmation" name="pwd-confirm" data-match="#password" 
             data-match-error="This confirmation does not match the passord." placeholder="Confirm Password" required>
            <div class="help-block with-errors"></div>
        </div>

        <!-- google captcha -->
        <div class="g-recaptcha" data-sitekey="6Lf3134UAAAAAGrFfs9oykBzz905ou1kbSPwAxR4">
        </div>
        <hr>

        <div class="form-group">
            <input type="checkbox" id="terms" data-error="You need to agree to the terms." required>
            <label for="inputPassword" class="control-label">Agree to Terms *</label>
            <div class="help-block with-errors"></div>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
        <br><br>
		Already have an account? <a href="<?php echo asset("logindetail"); ?>">Log in</a>
    </form>
</div>
<script>
$("#register").validator().on("submit", function (e) {
    if (!e.isDefaultPrevented()) {
    	e.preventDefault();
    	register();
    }
});

function register(){
    $.ajax ({
    	url: "<?php echo url("register")?>",
        type: "POST",
        data: {
            "username":$("#username").val(),
			"password":$("#password").val(),
			"email":$("#email").val()
		},
        success: function (rst) {
            if (rst == -1) {
				alert("This username already existed!");
            } else {
            	alert("You have successfully registered!");
            	location.href = "lobby";
            }
        }
    });
}
</script>
@include('home.footer')
@endsection