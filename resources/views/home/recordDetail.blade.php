@extends("home.base")
@section("bodycontent")
<?php
$record = isset($record) ? $record : $record;
$user = isset($user) ? $user : $user;
?>
<div class="container-div" style="min-height:23em">
    <p class="font-weight-light text-center" style="font-size: 2em">Playing Record Details</p>
    <table>
    	<tr>
    		<th scope="row">Game Room ID</th>
    		<td>
    			<?php echo $record->game_id; ?>
        	</td>
    	</tr>
    	<tr>
    		<th scope="row">Host User</th>
    		<td>
    			<?php echo $record->username; ?>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row">Your Result</th>
    		<td>
    		<?php
    		if ($record->result == 1) {
    		    echo "Win";
    		} else if ($record->result == -1) {
    		    echo "Loss";
    		} else {
    		    echo "Draw";
    		}
            ?>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row">Time</th>
    		<td>
    			<?php echo $record->created_at; ?>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row">Player(s)</th>
    		<td>
    			<?php
    			foreach ($user as $i) {
    			    echo $i->username;
    			    if ($i->result == 1) {
    			        echo " - Win<br>";
    			    } else if ($i->result == -1) {
    			        echo " - Loss<br>";
    			    } else {
    			        echo " - Draw<br>";
    			    }
    			}
    			?>
    		</td>
    	</tr>
    </table>
</div>
@include('home.footer')
@endsection