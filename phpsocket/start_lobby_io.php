<?php
use PHPSocketIO\SocketIO;
use Workerman\Lib\Timer;
use Workerman\Worker;

include dirname(__DIR__) . '/vendor/autoload.php';
$io = new SocketIO(2020);

$io->on('workerStart', function () {
    $web            = new Worker('http://0.0.0.0:9191');
    $web->onMessage = function ($conn, $data) {
        global $io;
        $_POST = $_POST ? $_POST : $_GET;
        if (!isset($_GET['msg'])) {
            return $conn->send('fail, $_GET["msg"] not found');
        }
        $io->emit('new message', array(
            'username' => 'httppush',
            'message'  => $_GET['msg'],
        ));;
        $conn->send('httppush ok');
    };
    $web->listen();
    // timer
    // first parameter in the unit of (s)
    Timer::add(1, function () {
        global $io;

    });
});

$io->on('connection', function ($socket) {
    global $io;
    $param = $socket->handshake['query'];
    if (!isset($param['token'])) {
        $socket->disconnect();
        return;
    }
    // $headers = $socket->handshake['headers'];
    echo "new connection coming..." . $socket->conn->remoteAddress . "\n";
    $socket->addedUser = false;

    // when the client emits 'new message', this listens and executes
    $socket->on('new message', function ($data) use ($socket) {
        echo $data . "\n";
        if ($data == 'exit') {
            $socket->disconnect();
            return;
        }
        // broadcast to everyone else except the current client
        $socket->broadcast->emit('new message', array(
            'username' => $socket->username,
            'message'  => $data,
        ));
        // reply to the current client
        $socket->emit('typing', array(
            'username' => '',
            'message'  => 'your last message: ' . date('Y-m-d H:i:s'),
        ));
    });

    // when the client emits 'add user', this listens and executes
    $socket->on('add user', function ($username) use ($socket) {
        global $usernames, $numUsers;
        // we store the username in the socket session for this client
        $socket->username = $username;
        // add the client's username to the global list
        $usernames[$username] = $username;
        
        ++$numUsers;
        $socket->addedUser = true;
        $socket->emit('login', array(
            'numUsers' => $numUsers,
        ));
        // echo globally (all clients) that a person has connected
        $socket->broadcast->emit('user joined', array(
            'username' => $socket->username,
            'numUsers' => $numUsers,
        ));
    });

    // when the client emits 'typing', we broadcast it to others
    $socket->on('typing', function () use ($socket) {
        $socket->broadcast->emit('typing', array(
            'username' => $socket->username,
        ));
    });

    // when the client emits 'stop typing', we broadcast it to others
    $socket->on('stop typing', function () use ($socket) {
        $socket->broadcast->emit('stop typing', array(
            'username' => $socket->username,
        ));
    });

    // when the user disconnects.. perform this
    $socket->on('disconnect', function () use ($socket) {
        echo "disconnected\n";
        global $usernames, $numUsers;
        // remove the username from global usernames list
        if ($socket->addedUser) {
            unset($usernames[$socket->username]);
            --$numUsers;

            // echo globally that this client has left
            $socket->broadcast->emit('user left', array(
                'username' => $socket->username,
                'numUsers' => $numUsers,
            ));
        }
    });

});

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
