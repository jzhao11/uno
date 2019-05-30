<?php
/*
 * this is the controller for back-end functions
 * each model is under the namespace of App/...
 * routes are defined in web.php
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Game;
use App\Channel;
use App\Card;
use App\Record;

class HomeController extends Controller {
    
    public function dashboard() {
        if (session("user_id") && session("username")) {
            $win = Record::where(["user_id" => session("user_id"), "result" => 1])->count();
            $loss = Record::where(["user_id" => session("user_id"), "result" => -1])->count();
            $draw = Record::where(["user_id" => session("user_id"), "result" => 0])->count();
            return view("Home/dashboard", compact("win", "loss", "draw"));
        } else {
            return redirect()->action("Home\\HomeController@lobby");
        }
    }
    
    public function readRecord() {
        $result = Input::get("result") ? Input::get("result") : "all";
        $record = Record::select("user.username", "record.*")
                ->join("game", "record.game_id", "=", "game.id")
                ->join("user", "game.host_user_id", "=", "user.id")
                ->where("record.user_id", session("user_id"))
                ->orderBy("created_at", "desc");
        if ($result == "win") {
            $r = 1;
        } else if ($result == "draw") {
            $r = 0;
        } else if ($result == "loss") {
            $r = -1;
        }
        if ($result != "all") {
            $record = $record->where("result", $r);
        }
        $record = $record->get();
        return view("Home/record", compact("record", "result"));
    }
    
    public function recordDetail() {
        $record = Record::select("user.username", "record.*")
                ->join("game", "record.game_id", "=", "game.id")
                ->join("user", "game.host_user_id", "=", "user.id")
                ->where("record.id", Input::get("record_id"))
                ->orderBy("created_at", "desc")
                ->first();
        // SELECT * FROM `record` WHERE abs(UNIX_TIMESTAMP(created_at) - UNIX_TIMESTAMP('2019-05-15 12:36:18')) <= 2
        $user = Record::select("user.username", "record.result")
                ->join("user", "record.user_id", "=", "user.id")
                ->whereRaw("abs(UNIX_TIMESTAMP(record.created_at) - UNIX_TIMESTAMP('".$record->created_at."')) <= 2")
                ->get();
        return view("Home/recorddetail", compact("record", "user"));
    }
    
    public function createRecord() {
        $record = Input::get();
        Record::create($record);
    }
    
    public function readCard() {
        if (Input::get("card_id")) {
            return Card::where("id", Input::get("card_id"))->first();
        } else {
            return Card::orderBy("id", "asc")->get();
        }
    }
    
    public function readPlayer() {
        $user = Channel::select("user.*")
                ->join("user", "channel.user_id", "=", "user.id")
                ->where(["game_id" => Input::get("game_id"), "turn" => abs(Input::get("turn"))])
                ->first();
        return $user->username;
    }
    
    // login detail page
    public function loginDetail() {
        if (session("user_id") && session("username")) {
            return redirect()->action("Home\\HomeController@lobby");
        } else {
            return view("Home/logindetail", compact("item"));
        }
    }
    
    // registration detail page
    public function registerDetail() {
        if (session("user_id") && session("username")) {
            return redirect()->action("Home\\HomeController@lobby");
        } else {
            return view("Home/registerdetail", compact("item"));
        }
    }
    
    // home page (landing page)
    public function index() {
        return view("Home/index");
    }
    
    // start a game
    // cannot start the game if less than 2 players
    public function startGame() {
        $game_id = Input::get("game_id");
        $channel = Channel::where("game_id", $game_id)->get();
        if (count($channel) <= 1) {
            return 0;
        } else {
            $cnt = 0;
            foreach ($channel as $i) {
                Channel::where(["game_id" => $game_id, "user_id" => $i->user_id])->update(["turn" => $cnt++]);
            }
            return Game::where("id", $game_id)->update(["status" => 1]);
        }
    }
    
    public function playCard() {
        return Channel::where(["game_id" => Input::get("game_id"), "user_id" => Input::get("user_id"), 
                "turn" => abs(Input::get("turn"))])->first() == null ? -1 : 0;
    }
    
    // game page (game room)
    // cannot read the game if it has started but the user is not in
    public function readGame() {
        $game_id = Input::get("game_id");
        if (!Channel::where("game_id", $game_id)->where("user_id", session("user_id"))->count() 
            && Game::where("id", $game_id)->where("status", 1)->count()) {
            return view("Home/error");
        } else {
            $game = Game::where("id", $game_id)->first();
            return view("Home/game", compact("game_id", "game"));
        }
    }
    
    // create a new game
    public function createGame() {
        $game = Game::create(Input::get());
        $channel["game_id"] = $game->id;
        $channel["user_id"] = session("user_id");
        $channel["is_host"] = 1;
        Channel::firstOrCreate($channel);
        return $game->id;
    }
    
    // add a user to a game channel
    public function createChannel() {
        return Channel::firstOrCreate(Input::get());
    }
    
    // remove a user from a game channel only if the game has not started
    public function deleteChannel() {
        $game_id = Input::get("game_id");
        if (!Game::where("id", $game_id)->where("status", 1)->first()) {
            Channel::where(["game_id" => $game_id, "user_id" => Input::get("user_id"), "is_host" => 0])->delete();
        }
    }
    
    //
    public function endGame() {
        $game_id = Input::get("game_id");
        return Game::where("id", $game_id)->update(["status" => 0]);
    }
    
    // lobby page
    public function lobby() {
        if (session("user_id") && session("username")) {
            $game = Game::select("game.*", "user.username")
                    ->join("user", "game.host_user_id", "=", "user.id")
                    ->join("channel", "channel.game_id", "=", "game.id")
                    ->where(["channel.user_id" => session("user_id")])
                    ->orWhere("game.status", 0)
                    ->groupBy("game.id")
                    ->get();
            return view("Home/lobby", compact("game"));
        } else {
            return redirect()->action("Home\\HomeController@loginDetail");
        }
    }
    
    // registration
    public function register() {
        $user["username"] = Input::get("username");
        $user["email"] = Input::get("email");
        $user["password"] = md5(Input::get("password"));
        if (User::where("username", $user["username"])->first()) {
            return -1;                      // username not valid (duplicate username)
        } else {
            $user = User::firstOrCreate($user);
            session()->put("user_id", $user->id);
            session()->put("username", $user->username);
            return 0;
        }
    }
    
    // login
    public function login() {
        $username = Input::get("username");
        $password = md5(Input::get("password"));
        $user = User::where("username", $username)->first();
        if (!$user) {                       // username not valid (not existing)
            return -1;
        } else if ($user->password != $password) {  // password not valid (not matching the username)
            return -2;
        } else {
            session()->put("user_id", $user->id);
            session()->put("username", $user->username);
            return 0;
        }
    }
    
    // logout
    public function logout() {
        session()->flush();                 // session clearance
        return redirect()->action("Home\\HomeController@loginDetail");
    }
}

?>