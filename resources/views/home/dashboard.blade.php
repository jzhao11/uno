@extends("home.base")
@section("bodycontent")
<?php
$win = isset($win) ? $win : $win;
$loss = isset($loss) ? $loss : $loss;
$draw = isset($draw) ? $draw : $draw;
?>
<div class="row container-div" style="min-height:23em">
    <div class="column">
        <h4>Profile Details</h4>
        <hr>
        <img id="profile_image" src="https://bit.ly/fcc-relaxing-cat" alt="Profile Image" width="200" height="200"><br>
        <b><?php echo session("username"); ?></b><br>
        <!-- Rank #123 -->
    </div>
    <div class="column">
        <h4><?php echo session("username"); ?>'s Records</h4>
        <hr>
        <div for="win-count" class="text-success"><h5>Wins: <?php echo $win; ?></h5></div>
        <hr>
        <div for="draw-count" class="text-warning"><h5>Draws: <?php echo $draw; ?></h5></div>
        <hr>
        <div for="lose-count" class="text-danger"><h5>Losses: <?php echo $loss; ?></h5></div>
        <hr>
        <a href="<?php echo asset("readrecord?result=all"); ?>"><h5>View more details...</h5></a>
    </div>
</div>
@include('home.footer')
@endsection