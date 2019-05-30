@extends("Home.base")
@section("bodycontent")
<?php
$game = isset($game) ? $game : $game;
$pile = isset($game->pile) ? $game->pile : "[]";
?>
<link href="<?php echo asset('css/board.css'); ?>" rel="stylesheet" type="text/css" />

<!-- <div class="boom"></div>-->
<input type="button" value="shuffle" onclick="shuffle()" />
<input type="button" value="draw" onclick="draw()" />

<br/>
pile:<div id="pile" style="display:none;"></div>
<div style="clear:both"></div>
my cards:<div id="my"></div>

<input type="button" value="count down" onClick="countDown()">
<span id="txt"></span>
<div onclick=""><img src="<?php echo asset("img/blue_0.png"); ?>"></div>

<script type="text/javascript">
var randomCards = [];	//array to store randomized cards
var myCards = [];		//array to store my cards

/* factory pattern to instantiate cards
 * number: the number on card
 * type: spade, club, diamond, heart
 */
var Cards = (function () {
    var Card = function (number, color) {
        this.number = number;
        this.color = color;
    }
    return function (number, color) {
        return new Card(number, color);
    }

})()

// color: 0-spade, 1-club, 2-diamond, 3-heart, 4-black joker, 5-red joker
// number: 0-joker, 11-jack, 12-queen, 13-king
function shuffle() {
    var index = 2;
    var arr = [];
    for (var i = 0; i <= 13; i++) {
        if (i == 0) {
            arr[0] = new Cards(i, 4);
            arr[1] = new Cards(i, 5);
        } else {
            for (var j = 0; j <= 3; j++) {
                arr[index] = new Cards(i, j);
                index++;
            }
        }
    }
    //randomCards = sortCards(arr);
    //createCard(randomCards);
    randomCards = JSON.parse('<?php echo $pile; ?>');
    for (var i = 0; i < randomCards.length; ++i) {
        console.log(randomCards[i].color + ' ' + randomCards[i].number);
    }
    show();
}

function createCard(randomCards) {
	$.ajax ({
    	url: "<?php echo url("createcard")?>",
        type: "POST",
        data: {
            "game_id":1,
			"pile":JSON.stringify(randomCards)
		},
        success: function (rst) {
            //alert(rst);
        }
    });
}

//shuffle
function sortCards(arr) {
    arr.sort(function (a, b) {
        return 0.5 - Math.random();
    })
    return arr;
}

//get cards
function getCards(CardObj) {
    var k = inCardsIndex(myCards, CardObj);	// k: the index to be inserted
    myCards.splice(k, 0, CardObj);			// insert the card at index k
}

/*
 * calculate the index to be inserted the new card
 * arr: current cards in hand
 * obj: newly picked card
 */
function inCardsIndex(arr, obj) {
    var len = arr && arr.length || 0;
    if (len == 0) {
        return 0;
    }else if (len == 1) {
        if (obj.number >= arr[0].number) {
            return 1;
        } else {
            return 0;
        }
    } else {
        var backi = -1;
        for (var i = 0; i < len; i++) {
           
            if (obj.number <= arr[i].number) {
                backi = i;
                break;
            } 
        }
        if (backi == -1) {
            backi = len;
        }
        return backi;
    }
}

function draw() {
    if (randomCards.length > 0) {
        getCards(randomCards.shift());
        show();
    } else {
        alert("no cards to draw!");
    }
}

function show() {
    var lenPile = randomCards.length;
    var lenMy = myCards.length;
    var html = "";
    for (var i = 0; i < lenPile; i++) {
        html += "<div class='cd'><b>" + randomCards[i].color + "</b>*<div class='num'>" + randomCards[i].number + "</div></div>";
    }
    document.getElementById("pile").innerHTML=html;
    html = "";
    for (var i = 0; i < lenMy; i++) {
        html += "<div class='cd my' onclick='alert(`???`)'><b>" + myCards[i].color + "</b>*<div class='num'>" + myCards[i].number + "</div></div>";
    }
    document.getElementById("my").innerHTML=html;
}
show();



function chooseColor() {
	var word;
    while (true) {
    	word = prompt("choose the color you want: yellow / green / red / blue");
    	if (word == "yellow") {
        	alert(word);
        	break;
        } else if (word == "green") {
        	alert(word);
        	break;
        } else if (word == "red") {
        	alert(word);
        	break;
        } else if (word == "blue") {
        	alert(word);
        	break;
        } else {
        	alert("please choose a valid color");
        }
    }
    return word;
}

// shuffle();
// for (var i = 0; i < 6; ++i) {
// 	draw();
// }
// countDown();

var c = 10;
var t;
function countDown() {
    document.getElementById('txt').innerHTML = (c > 0) ? c : 0;
    c--;
	t = setTimeout("countDown()", 1000);
	if (c < -1) {
		clearTimeout(t);
		alert("time out!");
	}
}
</script>
@endsection