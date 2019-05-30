<!-- this is the common header for all other pages -->
<!-- top navigation bar is defined here -->
<!-- user priority to be checked after login -->
<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="collapsingNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo asset("index"); ?>">UNO</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php
            if (session("user_id")) {
            ?>
            <li class="nav-item active">
                <a class="nav-link" href="#" onclick="createGame()">New Game</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo asset("lobby"); ?>">Lobby</a>
            </li>
            <li class="nav-item active">
            	<a class="nav-link" href="<?php echo asset("dashboard"); ?>">Dashboard</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo asset("logout"); ?>">Log Out</a>
            </li>
            <?php
            } else {
            ?>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo asset("registerdetail"); ?>">Register</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo asset("logindetail"); ?>">Log In</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>
<script>
function createGame() {
    $.ajax ({
    	url: "<?php echo url("creategame")?>",
        type: "POST",
        data: {
            "host_user_id": '<?php echo session('user_id'); ?>',
            "status": 0
        },
        success: function (rst) {
        	if (rst > 0) {
        		window.open("<?php echo asset('readgame?game_id='); ?>" + rst, "game" + rst);
        	}
        }
    });
}
</script>