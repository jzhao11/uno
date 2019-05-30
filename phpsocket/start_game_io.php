<?php
use PHPSocketIO\SocketIO;
use Workerman\Lib\Timer;
use Workerman\Worker;

class GameRoom {
    public $game_id;
    public $users = array();
    public $started;
    public $cards = array();
    public $next = 1;
    public $turn = -1;
    public $curr;
    public $deck;
    public $num_draws;
}

include dirname(__DIR__) . "/vendor/autoload.php";
$io = new SocketIO(2019);

$io->on("workerStart", function () {
    $web = new Worker("http://0.0.0.0:9191");
    $web->onMessage = function ($conn, $data) {
        global $io;
        $_POST = $_POST ? $_POST : $_GET;
        if (!isset($_GET["msg"])) {
            return $conn->send("fail, ".$_GET["msg"]." not found");
        }
        $io->emit("new message", array(
            "username" => "httppush",
            "message"  => $_GET["msg"],
        ));;
        $conn->send("httppush ok");
    };
    $web->listen();
    
    // timer
    // parameter: time in seconds; function
    Timer::add(1, function () {
        global $io;

    });
});

$io->on("connection", function ($socket) {
    global $io;
    
    $param = $socket->handshake["query"];
    // if (!isset($param["token"])) {
    //     $socket->disconnect();
    //     return;
    // }
    // $headers = $socket->handshake["headers"];
    echo "new connection coming..." . $socket->conn->remoteAddress . "\n";
    $socket->addedUser = false;

    // when the client emits "new message", this listens and executes
    $socket->on("new message", function ($data) use ($socket) {
        echo $data . "\n";
        // if ($data == "exit") {
        //      $socket->disconnect();
        //      return;
        // }
        
        $socket->to("game".$socket->game_id)->broadcast->emit("new message", array(
            "username" => $socket->username,
            "message"  => $data,
        ));
        
        $socket->emit("typing", array(
            "username" => "",
            "message"  => "your last message: " . date("Y-m-d H:i:s"),
        ));
        // emit the event to the current client
        // $socket->emit("event name", $data);
    });

    // when the client emits "add user", this listens and executes
    $socket->on("add user", function ($user, $game_id) use ($socket) {
        // store the username in the socket session for this client
        global $gamerooms;
        $socket->username = $user["username"];
        $socket->game_id = $game_id;

        $key = "game".$socket->game_id;
        $socket->join($key);
        //var_dump("user".$user["user_id"]." ".$user["username"]);
        
        // add the client"s username to the global list
        if (isset($gamerooms[$key])) {
            $gamerooms[$key]->users[$socket->username] = $user;
        } else {
            $gameroom = new GameRoom();
            $gameroom->game_id = $game_id;
            $gameroom->users[$socket->username] = $user;
            $gameroom->started = false;
            $gameroom->num_draws = 1;
            $gamerooms[$key] = $gameroom;
        }
        
        $users = $gamerooms[$key]->users;
        $cards = $gamerooms[$key]->cards;
        $curr = $gamerooms[$key]->curr;
        $num_draws = $gamerooms[$key]->num_draws;
        $socket->addedUser = true;
        $socket->emit("add user", array(
            "username" => $socket->username,
            "users" => $users,
            "cards" => $cards,
            "curr" => $curr,
            "num_users" => count($gamerooms[$key]->users),
            "turn" => $gamerooms[$key]->turn,
            "num_draws" => $num_draws,
            "started" => $gamerooms[$key]->started,
        ));
        
        $socket->to("game".$socket->game_id)->broadcast->emit("add user", array(
            "username" => $socket->username,
            "users" => $users,
            "cards" => $cards,
            "curr" => $curr,
            "num_users" => count($gamerooms[$key]->users),
            "turn" => $gamerooms[$key]->turn,
            "num_draws" => $num_draws,
            "started" => $gamerooms[$key]->started,
        ));
    });
    
    $socket->on("start game", function ($game_id, $username) use ($socket) {
        global $gamerooms;
        $deck = json_decode(file_get_contents("http://localhost/uno/public/readcard"));
        $key = "game".$socket->game_id;
        $gamerooms[$key]->started = true;
        
        $cards = array();
        foreach ($gamerooms[$key]->users as $user) {
            $arr = array();
            for ($i = 0; $i < 7; ++$i) {
                $index = mt_rand(0, count($deck) - 1);  // 0 ~ (n-1)
                $arr[$deck[$index]->id] = $deck[$index];
                array_splice($deck, $index, 1);
            }
            $cards[$user["username"]] = $arr;
        }
        $gamerooms[$key]->deck = $deck;
        $turn = mt_rand(0, count($gamerooms[$key]->users) - 1);
        $gamerooms[$key]->turn = $turn;
        $gamerooms[$key]->cards = $cards;
        $gamerooms[$key]->started = true;
        $num_draws = ($gamerooms[$key]->num_draws = 1);
        
        $socket->emit("start game", array(
            "cards" => $cards,
            "num_users" => count($gamerooms[$key]->users),
            "turn" => $turn,
            "num_draws" => $num_draws,
        ));
        $socket->to("game".$socket->game_id)->broadcast->emit("start game", array(
            "cards" => $cards,
            "num_users" => count($gamerooms[$key]->users),
            "turn" => $turn,
            "num_draws" => $num_draws,
        ));
    });
    
    $socket->on("play card", function ($game_id, $card_id, $username) use ($socket) {
        global $gamerooms;
        $key = "game".$game_id;
        $curr = $gamerooms[$key]->cards[$username][$card_id];
        unset($gamerooms[$key]->cards[$username][$card_id]);
        if ($card_id % 25 == 23 || $card_id % 25 == 24) {   // reverse
            $gamerooms[$key]->next *= -1;
        }
        if ($card_id % 25 == 21 || $card_id % 25 == 22) {   // skip
            $turn = ($gamerooms[$key]->turn += (2 * $gamerooms[$key]->next));
        } else {
            $turn = ($gamerooms[$key]->turn += $gamerooms[$key]->next);
        }
        if ($card_id > 103) {   // draw 4
            if ($gamerooms[$key]->num_draws == 1) {
                $gamerooms[$key]->num_draws = 4;
            } else {
                $gamerooms[$key]->num_draws += 4;
            }
        } else if ($card_id % 25 == 19 || $card_id % 25 == 20) {    // draw 2
            if ($gamerooms[$key]->num_draws == 1) {
                $gamerooms[$key]->num_draws = 2;
            } else {
                $gamerooms[$key]->num_draws += 2;
            }
        } else {
            $gamerooms[$key]->num_draws = 1;
        }
        
        $gamerooms[$key]->curr = $curr;
        $socket->emit("play card", array(
            "cards" => $gamerooms[$key]->cards[$username],
            "curr" => $curr,
            "turn" => $turn,
            "num_draws" => $gamerooms[$key]->num_draws,
        ));
        $socket->to("game".$socket->game_id)->broadcast->emit("play card", array(
            "curr" => $curr,
            "turn" => $turn,
            "num_draws" => $gamerooms[$key]->num_draws,
        ));
    });
    
    $socket->on("draw card", function ($game_id, $username) use ($socket) {
        global $gamerooms;
        $key = "game".$socket->game_id;
        $draw = $gamerooms[$key]->num_draws;
        $nocard = 0;
        $arr = $gamerooms[$key]->cards[$username];
        $deck = $gamerooms[$key]->deck;
        for ($i = 0; $i < $draw; ++$i) {
            if (count($deck) == 0) {
                $nocard = 1;
                break;
            }
            $index = mt_rand(0, count($deck) - 1);  // 0 ~ (n-1)
            $arr[$deck[$index]->id] = $deck[$index];
            array_splice($deck, $index, 1);
        }
        
        if ($nocard == 1) {
            foreach ($gamerooms[$key]->users as $i) {
                file_get_contents("http://localhost/uno/public/createrecord?game_id=".$game_id."&user_id=".$i["user_id"]."&result=0");
            }
            $ret = file_get_contents("http://localhost/uno/public/endgame?game_id=".$game_id);
        }
        
        if ($gamerooms[$key]->num_draws > 1) {
            $gamerooms[$key]->num_draws = 1;
        }
        
        $gamerooms[$key]->deck = $deck;
        $gamerooms[$key]->cards[$username] = $arr;
        $turn = ($gamerooms[$key]->turn += $gamerooms[$key]->next);
        
        $socket->emit("draw card", array(
            "cards" => $arr,
            "turn" => $turn,
            "nocard" => $nocard,
            "num_draws" => 1,
        ));
        $socket->to("game".$socket->game_id)->broadcast->emit("draw card", array(
            "turn" => $turn,
            "nocard" => $nocard,
            "num_draws" => 1,
        ));
    });

    $socket->on("change color", function ($game_id, $color) use ($socket) {
        global $gamerooms;
        $key = "game".$game_id;
        $gamerooms[$key]->curr->color = $color;
        $curr = $gamerooms[$key]->curr;
        
        $socket->emit("change color", array(
            "curr" => $curr,
            "color" => $color,
        ));
        $socket->to("game".$socket->game_id)->broadcast->emit("change color", array(
            "curr" => $curr,
            "color" => $color,
        ));
    });
    
    $socket->on("uno", function ($game_id, $username) use ($socket) {
        $socket->to("game".$socket->game_id)->broadcast->emit("uno", array(
            "username" => $username,
        ));
    });
        
    $socket->on("win game", function ($game_id, $user_id, $username) use ($socket) {
        global $gamerooms;
        $key = "game".$game_id;
        $gamerooms[$key]->started = false;
        foreach ($gamerooms[$key]->users as $i) {
            $result = ($i["user_id"] == $user_id) ? 1 : -1;
            file_get_contents("http://localhost/uno/public/createrecord?game_id=".$game_id."&user_id=".$i["user_id"]."&result=".$result);
        }
        $ret = file_get_contents("http://localhost/uno/public/endgame?game_id=".$game_id);
        $socket->to("game".$socket->game_id)->broadcast->emit("win game", array(
            "username" => $username,
        ));
    });

    // when the client emits "typing", we broadcast it to others
    $socket->on("typing", function () use ($socket) {
        $socket->to("game".$socket->game_id)->broadcast->emit("typing", array(
            "username" => $socket->username,
        ));
    });

    // when the client emits "stop typing", we broadcast it to others
    $socket->on("stop typing", function () use ($socket) {
        $socket->to("game".$socket->game_id)->broadcast->emit("stop typing", array(
            "username" => $socket->username,
        ));
    });

    // when the user disconnects.. perform this
    $socket->on("disconnect", function () use ($socket) {
        // remove the username from global usernames list
        global $gamerooms;
        echo "disconnected\n";
        $key = "game".$socket->game_id;
        //var_dump($key);
        if (!$gamerooms[$key]->started) {
            $ret = file_get_contents("http://localhost/uno/public/deletechannel?game_id=".$socket->game_id."&user_id=".$gamerooms[$key]->users[$socket->username]["user_id"]);
            unset($gamerooms[$key]->users[$socket->username]);
            $socket->to("game".$socket->game_id)->broadcast->emit("remove user", array(
                "username" => $socket->username,
            ));
            
            $socket->leave($key);
        }
    });
});

if (!defined("GLOBAL_START")) {
    Worker::runAll();
}
?>