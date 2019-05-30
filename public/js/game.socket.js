$(function() {
    var FADE_TIME = 150; // ms
    var TYPING_TIMER_LENGTH = 400; // ms
    var COLORS = [
        '#e21400', '#91580f', '#f8a700', '#f78b00',
        '#58dc00', '#287b00', '#a8f07a', '#4ae8c4',
        '#3b88eb', '#3824aa', '#a700ff', '#d300e7'
    ];

    // Initialize varibles
    var $window = $(window);
    var $usernameInput = $('.usernameInput'); // Input for username
    var $messages = $('#messageArea'); // Messages area
    var $inputMessage = $('#inputMessage'); // Input message input box

    var $loginPage = $('.login.page'); // The login page
    var $chatPage = $('.chat.page'); // The chatroom page

    // Prompt for setting a username
    var connected = true;
    var typing = false;
    var lastTypingTime;
    var $currentInput = $usernameInput.focus();

    // var socket = io('http://' + document.domain + ':2019/?token=');

    function addParticipantsMessage(data) {
        var message = '';
        if (data.numUsers === 1) {
            message += "there's 1 participant";
        } else {
            message += "there are " + data.numUsers + " participants";
        }
        log(message);
    }

    // Sets the client's username
    function setUsername() {
        //username = $usernameInput.val().trim();
        if (username) {
            $loginPage.fadeOut();
            $chatPage.show();
            $loginPage.off('click');
            $currentInput = $inputMessage.focus();

            var user = new Object();
            user.username = username;
            user.user_id = user_id;
            user.cards = my_cards;
            socket.emit('add user', user, game_id);
            createChannel();
        }
    }

    // Sends a chat message
    function sendMessage() {
        var message = $inputMessage.val();
        // Prevent markup from being injected into the message
        message = cleanInput(message);
        // if there is a non-empty message and a socket connection
        if (message && connected) {
            $inputMessage.val('');
            addChatMessage({
                username: username,
                message: message
            });
            // tell server to execute 'new message' and send along one parameter
            socket.emit('new message', message);
        }
    }

    // Log a message
    function log(message, options) {
        var $el = $('<li>').addClass('log').text(message);
        addMessageElement($el, options);
    }

    // Adds the visual chat message to the message list
    function addChatMessage(data, options) {
        // Don't fade the message in if there is an 'X was typing'
        var $typingMessages = getTypingMessages(data);
        options = options || {};
        if ($typingMessages.length !== 0) {
            options.fade = false;
            $typingMessages.remove();
        }

        var $usernameDiv = $('<span class="username"/>')
            .text(data.username)
            .css('color', getUsernameColor(data.username));
        var $messageBodyDiv = $('<span class="messageBody">')
            .text(data.message);

        var typingClass = data.typing ? 'typing' : '';
        var $messageDiv = $('<li class="message"/>')
            .data('username', data.username)
            .addClass(typingClass)
            .append($usernameDiv, $messageBodyDiv);

        addMessageElement($messageDiv, options);
    }

    // Adds the visual chat typing message
    function addChatTyping(data) {
        data.typing = true;
        // data.message = 'is typing';
        addChatMessage(data);
    }
    
    // Removes the visual chat typing message
    function removeChatTyping(data) {
        getTypingMessages(data).fadeOut(function() {
            $(this).remove();
        });
    }

    // Adds a message element to the messages and scrolls to the bottom
    // el - The element to add as a message
    // options.fade - If the element should fade-in (default = true)
    // options.prepend - If the element should prepend
    //   all other messages (default = false)
    function addMessageElement(el, options) {
        var $el = $(el);

        // Setup default options
        if (!options) {
            options = {};
        }
        if (typeof options.fade === 'undefined') {
            options.fade = true;
        }
        if (typeof options.prepend === 'undefined') {
            options.prepend = false;
        }

        // Apply options
        if (options.fade) {
            $el.hide().fadeIn(FADE_TIME);
        }
        if (options.prepend) {
            $messages.prepend($el);
        } else {
            $messages.append($el);
        }
        $messages[0].scrollTop = $messages[0].scrollHeight;
    }

    // Prevents input from having injected markup
    function cleanInput(input) {
        return $('<div/>').text(input).text();
    }

    // Updates the typing event
    function updateTyping() {
        if (connected) {
            if (!typing) {
                typing = true;
                socket.emit('typing');
            }
            lastTypingTime = (new Date()).getTime();

            setTimeout(function() {
                var typingTimer = (new Date()).getTime();
                var timeDiff = typingTimer - lastTypingTime;
                if (timeDiff >= TYPING_TIMER_LENGTH && typing) {
                    socket.emit('stop typing');
                    typing = false;
                }
            }, TYPING_TIMER_LENGTH);
        }
    }

    // Gets the 'X is typing' messages of a user
    function getTypingMessages(data) {
        return $('.typing.message').filter(function(i) {
            return $(this).data('username') === data.username;
        });
    }

    // Gets the color of a username through our hash function
    function getUsernameColor(username) {
        // Compute hash code
        var hash = 7;
        for (var i = 0; i < username.length; i++) {
            hash = username.charCodeAt(i) + (hash << 5) - hash;
        }
        // Calculate color
        var index = Math.abs(hash % COLORS.length);
        return COLORS[index];
    }
    
    function addUserToTable(users) {
    	$("#players").html("");
    	for (var index in users) {
    		$("#players").append(
				'<tr class="table-warning row-height"><td>' 
				+ users[index].user_id + '</td><td>' + users[index].username 
				+ '</td></tr>'
			);
        }
    }
    
    function removeUserFromTable(username) {
    	$("#players").find("tr").each(function(){
	        var tdArray = $(this).children();
	        if (tdArray.eq(1).text() == username) {
	        	$(this).remove();
	        }
	    });
    }

    // Keyboard events
    $currentInput.focus();
    setUsername();
    
    $window.keydown(function(event) {
        // Auto-focus the current input when a key is typed
        if (!(event.ctrlKey || event.metaKey || event.altKey)) {
            $currentInput.focus();
        }
        // When the client hits ENTER on their keyboard
        if (event.which === 13) {
            if (username) {
                sendMessage();
                socket.emit('stop typing');
                typing = false;
            } else {
                setUsername();
            }
        }
    });

    $inputMessage.on('input', function() {
        updateTyping();
    });

    // Click events

    // Focus input when clicking anywhere on login page
    $loginPage.click(function() {
        $currentInput.focus();
    });

    // Focus input when clicking on the message input's border
    $inputMessage.click(function() {
        $inputMessage.focus();
    });
    
    var t;
    function countDown(c) {
    	t = setTimeout(function() {
	    		document.getElementById('txt').innerHTML = c--;
	    	    countDown(c);
	    	}, 1000);
    	if (c < 0) {
    		c = 20;
    		clearTimeout(t);
    		//alert("time up");
    		moveOn();
    	}
    }
    
    function moveOn() {
    	$.ajax ({
        	url: "playcard",
            type: "POST",
            data: {
                "game_id": game_id,
                "user_id": user_id,
                "turn": turn % num_users,
    		},
            success: function (rst) {
            	var flag;
            	if (rst == -1) {
                    //alert("It is not your turn!");
                } else {
                	flag = socket.emit("draw card", game_id, username);
            	}
            }
        });
    }

    /*
     *****************
     * Socket events *
     *****************
     */

    // Whenever the server emits 'user connected', log the login message
    socket.on('user connected', function(data) {
        connected = true;
        // Display the welcome message
        var message = "Welcome to Socket.IO Chat – ";
        log(message, {
            prepend: true
        });
        
        //addParticipantsMessage(data);
        addUserToTable(data.users);
    });

    // Whenever the server emits 'new message', update the chat body
    socket.on('new message', function(data) {
        addChatMessage(data);
    });

    // Whenever the server emits 'user joined', log it in the chat body
    socket.on('add user', function(data) {
        log(data.username + ' joined');
        //addParticipantsMessage(data);
        addUserToTable(data.users);
        
        started = data.started;
        num_users = data.num_users;
        num_draws = data.num_draws;
        curr = data.curr;
        turn = data.turn;
        updatePlayer();
        dealCard(data.cards);
    	showCard();
    	if (curr) {
    		updateBoard(curr);
    	}
    });

    // Whenever the server emits 'remove user', log it in the chat body
    socket.on('remove user', function(data) {
        log(data.username + ' left');
        addParticipantsMessage(data);
        removeChatTyping(data);
        removeUserFromTable(data.username);
    });

    // Whenever the server emits 'typing', show the typing message
    socket.on('typing', function(data) {
        addChatTyping(data);
    });

    // Whenever the server emits 'stop typing', kill the typing message
    socket.on('stop typing', function(data) {
        removeChatTyping(data);
    });


    
    socket.on('start game', function(data) {
    	dealCard(data.cards);
    	showCard();
    	started = true;
    	num_users = data.num_users;
    	num_draws = data.num_draws;
    	turn = data.turn;
    	curr = undefined;
    	clearBoard();
    	updatePlayer();
    	alert('Game start!');
//    	for (var index in my_cards) {
//    		console.log(my_cards[index]);
//    	}
    });
    
    socket.on('play card', function(data) {
    	num_draws = data.num_draws;
    	curr = data.curr;
    	turn = data.turn;
    	updatePlayer();
    	
    	if (data.cards != undefined) {
			my_cards = data.cards;
			var num_cards = showCard();
			//alert(num_cards + '?');
			if (num_cards == 0) {
            	alert("You win!");
            	socket.emit("win game", game_id, user_id, username);
            	started = false;
        	} else if (num_cards == 1) {
        		socket.emit("uno", game_id, username);
        	}
		}
    	updateBoard(curr);
    });
    
    socket.on('uno', function(data) {
    	alert(data.username + ' UNO!');
    });
    
    socket.on('draw card', function(data) {
    	if (data.nocard == 1) {
    		alert('No more cards! A draw in this game.');
    		started = false;
    	} else {
    		num_draws = data.num_draws;
    		turn = data.turn;
    		updatePlayer();
    		if (data.cards != undefined) {
    			my_cards = data.cards;
    			showCard();
    		}
    	}
    });
    
    socket.on('change color', function(data) {
    	curr = data.curr;
    	alert('Color is changed into ' + data.color + "!");
    });
    
    socket.on('win game', function(data) {
    	curr = undefined;
    	alert('Sorry, you lose. ' + data.username + ' is the winner!');
    	started = false;
    });
});