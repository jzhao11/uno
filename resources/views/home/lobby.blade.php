@extends("home.base")
@section("bodycontent")
<?php
$game = isset($game) ? $game : array();
?>
<div class="container-div gradient-bg-color">
    <div class="panel panel-primary">
    	<div class="panel-body" style="max-height: 20em;overflow-y: scroll;background-color: #cce2ff;">
        	<table>
    		    <tr>
    		        <th>Game ID</th>
    		        <th>Host User</th>
    		        <th>Game Status</th>
    		        <th>Operation</th>
    		    </tr>
    		    <?php
    		    foreach ($game as $i) {
    		    ?>
    		    <tr>
    		        <td><?php echo $i->id; ?></td>
    		        <td><?php echo $i->username; ?></td>
    		        
    		        <?php
    		        if ($i->status == 0) {
    		        ?>
    		        <td>Pending</td>
    		        <td>
    		        	<a href="<?php echo asset("readgame?game_id=".$i->id); ?>" target="game<?php echo $i->id; ?>" class="btn btn-success">Join This Game</a>
    		        </td>
    		        <?php
                    } else {
                    ?>
                    <td>In-Game</td>
    		        <td>
                    	<a href="<?php echo asset("readgame?game_id=".$i->id); ?>" target="game<?php echo $i->id; ?>" class="btn btn-warning">You're In, Rejoin</a>
                	</td>
                    <?php
                    }
    		        ?>
    		    </tr>
    		    <?php
    		    }
    		    ?>
    		</table>
        </div>
    </div>
    <div class="panel-body">
    	<input id="inputMessage" style="height: 3em; width:100%; border: 7px solid #000;" placeholder="Type here..." />
    </div>
    <div class="panel-body" style="height: 11.5em; flex: 1 1 auto;">
        <ul class="h-100 messages" style="overflow-y: scroll;" id="messageArea">
        </ul>
    </div>
</div>

<script>
// username and user_id will be used in lobby.socket.js
var username = '<?php echo session("username"); ?>';
var user_id = '<?php echo session("user_id"); ?>';
</script>
<script src="<?php echo asset('js/jquery.min.js'); ?>"></script>
<script src="<?php echo asset('socket.io/1.4.3/socket.io.min.js'); ?>"></script>
<script src="<?php echo asset('js/lobby.socket.js'); ?>"></script>
@endsection