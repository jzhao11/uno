var color = ["Blue", "Red", "Green", "Yellow", "Black"] // uno card colors
var action = ["Skip", "Reverse", "Draw_Two"] // uno action cards
var wild = ["Wild", "Wild_Draw_Four"] // uno wild cards
var number = ["Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"] // uno number cards
var turn = 0 // player turn in game (player at index 0 by default)
var direction = true // direction of game (true == clockwise, false == counter-clockwise)
var deck // uno deck
var discardPile = new Array() // array of cards in discard pile
var players = new Array() // array of players
var canPlay = new Array() // array that holds cards from current player hand which can be played


/**
 * Creates deck
 */
function createDeck() {

    deck = new Array(); // initializes deck to empty array
    var priority; // priority of the card
    var card; // uno card

    for (var i = 0; i < color.length; ++i) {
        // initializes number cards
        for (var j = 0; j < number.length; ++j) {
            priority = j;
            card = {Color: color[i], Type: number[j], Priority: priority};

            if (card.Type == "Zero" && card.Color != "Black") {
                deck.push(card);
            } else if (card.Type != "Zero" && card.Color != "Black") {
                deck.push(card);
                deck.push(card);
            }
        }

        // initializes action cards
        for (var k = 0; k < action.length; ++k) {
            priority = 10;
            card = {Color: color[i], Type: action[k], Priority: priority};

            if (card.Color != "Black") {
                deck.push(card);
                deck.push(card);
            }
        }
    }

    // initializes wild cards
    for (var i = 0; i < color.length; ++i) {
        for (var j = 0; j < wild.length; ++j) {
            priority = 11;
            card = {Color: color[i], Type: wild[j], Priority: priority}

            if (card.Color == "Black") {
                deck.push(card);
                deck.push(card);
                deck.push(card);
                deck.push(card);
            }
        }
    }

}

/**
 * Adds new player to game room (used at start of game)
 */
function createPlayers(num) {

    players = new Array() // array of players in game room
    var hand
    var player

    for (var i = 0; i < num; i++) {
        hand = new Array(); // array holding cards in players hand
        player = {Name: 'Player ' + i, ID: i, Points: 0, Hand: hand};
        players.push(player);
    }

}

/**
 * Shuffles deck
 */
function shuffleDeck(deck) {

    for (var i = deck.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [deck[i], deck[j]] = [deck[j], deck[i]];
    }

    return deck;

}

/**
 * Start Uno game
 */
function startGame() {

    document.getElementById('btnStart').value = 'start';
    turn = 0; // start at player at index 0
    createDeck(); // creates deck
    shuffleDeck(deck); // shuffles deck
    createPlayers(2); // argument is between 2-10 (using 2 now for testing purposes)
    dealHands(); // deals cards in beginning of game
    gameLoop(); // loops through game (game logic)

}

/**
 * Passes cards in beginning of game (used once at start of game)
 */
function dealHands() {

    var card; // temporary card variable holding card at top of deck

    for (var i = 0; i < 7; i++) {
        for (var j = 0; j < players.length; j++) {
            card = deck.pop();
            players[j].Hand.push(card);
        }
    }

    updateDeck();

}

/**
 * Creates discard pile (used once at start of game)
 */
function createDiscardPile() {

    var card = deck.pop();
    discardPile.push(card)

}

/**
 * Checks cards that current player hand which he/she can play
 */
function checkPlayerHandOptions(currentPlayerHand) {

    for (var i = 0; i < currentPlayerHand.length; ++i) {
        // player can play if he/she has card that is of same color or number
        if (currentPlayerHand[i].Color == discardPile[0].Color ||
            currentPlayerHand[i].Type == discardPile[0].Type) {
            canPlay.push(currentPlayerHand[i])
        }

        // player can play if he/she has wild card
        if (currentPlayerHand[i].Type == "Wild") {
            canPlay.push(currentPlayerHand[i])
        }
    }

}

/**
 * Draws card
 */
function draw() {

    var card = deck.pop();

    players[turn].Hand.push(card);
    updateDeck();

}

/**
 * Game logic for Uno game
 */
function gameLoop() {

    //game logic here

}

/**
 * Check for winner of game
 */
function checkWinner() {

    if (players[currentPlayer].Hand.length < 1) {
        document.getElementById('status').innerHTML = 'Player: ' + players[currentPlayer].ID + ' WON';
    }

}

/**
 * Updates deck size on screen
 */
function updateDeck() {

    // document.getElementById('deckcount').innerHTML = deck.length;

}


function main() {

    var discardPilePeekIndex = 0; // index of top card on discard pile
    var discardPilePeek = discardPile[discardPilePeekIndex]; // top card on discard pile
    var currentPlayerHand;
    var drawOrPlay;
    var card;

    console.log("\nCreating Uno deck...")
    createDeck() // Creates deck
    console.log("Shuffling deck")
    shuffleDeck(deck) // Shuffles deck
    console.log("Adding players to game room...")
    createPlayers(2) // Adds n players to game (2 for testing purposes)
    console.log("Dealing cards to all players...")
    dealHands() // Deals 7 cards to all players
    console.log("\nCurrent Player Hand: \n", players[turn].Hand) // Displays current player hand
    console.log("\nCreating discard pile...")
    createDiscardPile() // Creates discard pile
    // console.log("\nDiscard Pile (Top): \n", discardPile[0]) // Show top of discard pile
    console.log("\nDiscard Pile (Top): \n", discardPile[discardPile.length - 1]) // Show top of discard pile
    console.log("\nPlayer Turn: ", turn) // Show turn of current player (player at index turn)

    currentPlayerHand = players[turn].Hand // Hand of current player
    checkPlayerHandOptions(currentPlayerHand) // Check options which current player can play
    drawOrPlay = false; // Boolean variable to check if player can play or have to draw

    do {
        if (canPlay.length == 0) { // Check if player can play with current hand
            console.log("\nPlayer cannot play with current cards in hand! Draw new card!")

            if (deck.length == 0) { // Check if deck as anymore cards
                break;
            } else {
                draw() // Draw new card
                checkPlayerHandOptions(currentPlayerHand) // Check if player can play after drawing new card
            }
        } else {
            console.log("\nPlayer can play these card(s): \n", canPlay)
            drawOrPlay = true
        }
    } while (!drawOrPlay);

    var cardPlayed = canPlay.pop() // Removes card from can play array
    discardPile.push(cardPlayed) // Adds cardPlayed to top of discard pile
    currentPlayerHand = currentPlayerHand.filter(currentPlayerHand = > currentPlayerHand !== cardPlayed
) // Updates current players hand
    console.log("\nDiscard Pile (Top): \n", discardPile[discardPile.length - 1]) // Show top of discard pile

    // Next players turn
    if (direction) {
        turn++;

        if (turn > players.length) {
            turn = 0;
        }
    } else {
        turn--;

        if (turn < 0) {
            turn = (players.length - 1);
        }
    }

    console.log("\nPlayer Turn: ", turn)

}

main()
