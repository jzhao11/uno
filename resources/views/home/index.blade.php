@extends("home.base")
@section("bodycontent")
<div class="text">
	<h2>Get rich playing UNO!</h2>
	<br>
	<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
	<?php
        if (session("user_id") && session("username")) {
    ?>
    	<div class="btn-group mr-2" role="group" aria-label="Second group">
			<a href="<?php echo asset("lobby"); ?>"><button type="button" class="btn btn-primary">Game Lobby</button></a>
		</div>
	<?php
        } else {
    ?>
		<div class="btn-group mr-2" role="group" aria-label="First group">
			<a href="<?php echo asset("registerdetail"); ?>"><button type="button" class="btn btn-primary">Register</button></a>
		</div>
		<div class="btn-group mr-2" role="group" aria-label="Second group">
			<a href="<?php echo asset("logindetail"); ?>"><button type="button" class="btn btn-primary">Log In</button></a>
		</div>
	<?php
        }
    ?>
	</div>
</div>
@endsection