@extends("home.base")
@section("bodycontent")
<?php
$record = isset($record) ? $record : $record;
$result = isset($result) ? $result : $result;
?>
<div class="container-div" style="min-height:23em">
    <table>
    	<tr>
    		<th scope="row">Conditional Search</th>
    		<td>
    			<div class="row justify-content-md-center">
                    <div class="col-sm-6">
    					<select class="form-control" id="result" onchange="search()">
                        	<option value="all" <?php if ($result == "all") { echo "selected"; } ?>>All</option>
                        	<option value="win" <?php if ($result == "win") { echo "selected"; } ?>>Win</option>
                        	<option value="loss" <?php if ($result == "loss") { echo "selected"; } ?>>Loss</option>
                        	<option value="draw" <?php if ($result == "draw") { echo "selected"; } ?>>Draw</option>
                    	</select>
                	</div>
            	</div>
    		</td>
    	</tr>
    </table>
    <table class="table table-striped">
    	<thead>
    		<tr>
    			<th scope="col">Record ID</th>
    			<th scope="col">Host User</th>
    			<th scope="col">Result</th>
    			<th scope="col">Time</th>
    			<th scope="col">Operation</th>
    		</tr>
    	</thead>
    	<tbody>
        	<?php
            foreach ($record as $i) {
            ?>
    		<tr>
    			<td><?php echo $i->id; ?></td>
    			<td><?php echo $i->username; ?></td>
    			<td>
    			<?php
    			if ($i->result == 1) {
    			    echo "Win";
    			} else if ($i->result == -1) {
    			    echo "Loss";
    			} else {
    			    echo "Draw";
    			}
                ?>
    			</td>
    			<td><?php echo $i->created_at; ?></td>
    			<td>
    				<a href="<?php echo asset("recorddetail?record_id=".$i->id); ?>" target="record_id<?php echo $i->id; ?>" class="btn btn-info" role="button">
    					Detail
    				</a>
    			</td>
    		</tr>
    		<?php
            }
            ?>
    	</tbody>
    </table>
	<div class="text-center">Showing <?php echo count($record); ?> Result(s)</div>
</div>

<script>
function search() {
	location.href = "readrecord?result=" + $("#result").val();
}
</script>
@include('home.footer')
@endsection