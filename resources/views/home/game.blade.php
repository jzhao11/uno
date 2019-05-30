@extends("home.base")
@section("bodycontent")
<?php
$game_id = isset($game_id) ? $game_id : 0;
$game = isset($game) ? $game : $game;
?>
<link href="<?php echo asset('css/board.css'); ?>" rel="stylesheet" type="text/css" />
<div class="container-div gradient-bg-color">
    <div class="col-sm-13 table-responsive" style="max-height: 20.5em;overflow-y: scroll;">
    	<div class="col-sm-6 float-left">
    		<table class="table" style="background-color: #cce2ff;">
    		  <thead>
    		    <tr>
    		      <th scope="col">Player ID</th>
    		      <th scope="col">Player Name</th>
    		    </tr>
    		  </thead>
    		  <tbody id="players">
    		  </tbody>
    		</table>
    	</div>
    	<div class="col-sm-3 float-right">
    		<div class="text-center font-weight-bold">Current Card<br>
    			<span id="curr"></span>
    		</div>
    	</div>
    	<div class="col-sm-3 float-right">
    		<div class="text-center font-weight-bold">Current Player<br>
    			<span id="player" class="font-weight-bold" style="line-height: 100px"></span>
    			&nbsp;
    			<span id="txt"></span>
    		</div>
    	</div>
    	
    	<div class="col-sm-6 text-center" style="margin-bottom: 0.5em">
    	<?php
    	if ($game->host_user_id == session("user_id")) {
        ?>
        	<a href="#" onclick="startGame()" class="btn btn-success">Start</a>
    	<?php
    	}
    	?>
    		<a href="#" onclick="drawCard()" class="btn btn-warning">Draw Card</a>
    	</div>
    	<div class="col-sm-12 float-left" style="background-color: #cce2ff;">
    		My Cards:
            <div id="my" style="height: 200px"></div>
        </div>
    
    	<div class="clearfix"></div>
    </div>
    <div class="panel-body">
    	<input id="inputMessage" style="height: 3em; width:100%; border: 7px solid #000;" placeholder="Type here..." />
    </div>
    <div class="panel-body" style="height: 11.5em; flex: 1 1 auto;">
        <ul class="h-100 messages" style="overflow-y: scroll;" id="messageArea">
        </ul>
    </div>
</div>

<script src="<?php echo asset('js/jquery.min.js'); ?>"></script>
<script src="<?php echo asset('socket.io/1.4.3/socket.io.min.js'); ?>"></script>
<script>
// socket, game_id, username, and user_id will be used in game.socket.js
var socket = io('http://' + document.domain + ':2019/?token=');
var game_id = '<?php echo $game_id; ?>';
var username = '<?php echo session("username"); ?>';
var user_id = '<?php echo session("user_id"); ?>';
var started;
var turn;
var num_users;
var my_cards;
var num_draws;
var curr;

function createChannel() {
	$.ajax ({
    	url: "<?php echo url("createchannel")?>",
        type: "POST",
        data: {
            "game_id": game_id,
			"user_id": user_id
		},
        success: function (rst) {
        }
    });
}

function countCard(my_cards) {
	var cnt = 0;
	for (var index in cards) {
		cnt++;
	}
	return cnt;
}

function startGame() {
	if (started) {
		alert("Game already started!");
	} else {
    	$.ajax ({
        	url: "<?php echo url("startgame")?>",
            type: "POST",
            data: {
                "game_id": game_id,
    		},
            success: function (rst) {
            	if (rst == 0) {
                    alert("To start a game, you need 2 players at least!");
                } else {
                    socket.emit("start game", game_id, username);
                    showCard();
                }
            }
        });
	}
}

function dealCard(cards) {
	for (var index in cards) {
		if (index == username) {
			my_cards = cards[index];
		}
	}
}

function showCard() {
	var cnt = 0;
    var html = "";
    for (var index in my_cards) {
        html += "<div class='cd' id='card" + my_cards[index].id + "' onclick='playCard(`" + my_cards[index].id + "`,`" + my_cards[index].number
        		+ "`,`" + my_cards[index].color + "`)'><img height='100' src='img/" + my_cards[index].img + "'></div>";
		cnt++;
    }
    document.getElementById("my").innerHTML = html;
    return cnt;
}

function isValid(card_number, card_color) {
	if (!started) {
		return false;
	} else if (curr == undefined) {
		return true;
	} else if (curr.number == 14 && card_number != 14 && num_draws != 1) {
		return false;
	} else if (curr.number == 10 && (card_number != 10 && card_number != 14) && num_draws != 1) {
		return false;
	} else if (card_number > 12 || card_number == curr.number || card_color == curr.color) {
		return true;
	} else {
		return false;
	}
}

function playCard(card_id, card_number, card_color) {
	$.ajax ({
		url: "<?php echo url("playcard")?>",
        type: "POST",
        data: {
            "game_id": game_id,
            "user_id": user_id,
            "turn": turn % num_users,
		},
        success: function (rst) {
        	if (rst == -1) {
                alert("It is not your turn!");
            } else {
            	if (isValid(card_number, card_color)) {
            		//$("#card" + card_id).remove();
	            	socket.emit("play card", game_id, card_id, username);
	            	if (card_number > 12) {
	            		var new_color = chooseColor();
	            		socket.emit("change color", game_id, new_color);
	            	}
            	} else {
            		alert("Sorry, you cannot play this card now.");
            	}
            }
        }
    });
}

function drawCard() {
	if (!started) {
		alert("Game has not started!");
	} else {
    	$.ajax ({
        	url: "<?php echo url("playcard")?>",
            type: "POST",
            data: {
                "game_id": game_id,
                "user_id": user_id,
                "turn": turn % num_users,
    		},
            success: function (rst) {
            	if (rst == -1) {
                    alert("It is not your turn!");
                } else {
                	socket.emit("draw card", game_id, username);
                }
            }
        });
	}
}

function moveOn() {
	$.ajax ({
		url: "<?php echo url("playcard")?>",
        type: "POST",
        data: {
            "game_id": game_id,
            "user_id": user_id,
            "turn": turn % num_users,
		},
        success: function (rst) {
        	if (rst == -1) {
                //alert("It is not your turn!");
            } else {
                alert("Time is up!");
            	socket.emit("draw card", game_id, username);
            }
        }
    });
}

function updatePlayer() {
	$.ajax ({
    	url: "<?php echo url("readplayer")?>",
        type: "POST",
        data: {
            "game_id": game_id,
            "turn": turn % num_users,
		},
        success: function (rst) {
        	document.getElementById("player").innerHTML = rst;
        }
    });
}

function updateBoard(card) {
	var html = "<img height='150' src='img/" + card.img + "'>";
    document.getElementById("curr").innerHTML = html;
}

function clearBoard() {
	document.getElementById("curr").innerHTML = "";
}

function chooseColor() {
	var word;
    while (true) {
    	word = prompt("choose the color you want: yellow / green / red / blue");
    	if (word != "yellow" && word != "green" && word != "red" && word != "blue") {
        	alert("Please choose a valid color.");
        } else {
            break;
        }
    }
    return word;
}

// var c = 20;
// var t;
// function countDown() {
//     document.getElementById('txt').innerHTML = (c > 0) ? c : 0;
//     c--;
// 	t = setTimeout("countDown()", 1000);
// 	if (c < -1) {
// 		clearTimeout(t);
// 		//alert("time out!");
// 		c = 20;
// 		moveOn();
// 	}
// }
</script>
<script src="<?php echo asset('js/game.socket.js'); ?>"></script>
@endsection