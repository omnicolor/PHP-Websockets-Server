<?php
/**
 * Web socket daemon file.
 */

require_once "lib/wsutil.php";
require_once "lib/websocket.class.php";
require_once "lib/wsuser.class.php";

$log = '/tmp/websockets.log';
$port = '8088';
$address = "127.0.0.1";

/**
 * Method for displaying the help and default variables
 */
function displayUsage() {
    global $log, $port, $address;

    echo "\n";
    echo "PHP Web Sockets Server\n";
    echo "\n";
    echo "Usage:\n";
    echo "\tWSdaemon.php [options\n]";
    echo "\n";
    echo "\toptions:\n";
    echo "\t\t--help display this help message\n";
    echo "\t\t--log=<filename> The location of the log file (default '$log')\n";
    echo "\t\t--port=<port> The port on which the server should listen (default '$port')\n";
    echo "\t\t--address=<IP Address> The local address on which to listen (default '$address')\n";
    echo "\n";
} //end display usage

//configure command line arguments
if($argc > 0) {
    foreach($argv as $arg) {
        $args = explode('=', $arg);
        switch($args[0]) {
            case '--help' :
                return displayUsage();
            case '--log' :
                $log = $args[1];
                break;
            case '--port' :
                $port = $args[1];
                break;
            case '--address' :
                $address = $args[1];
                break;
        }
    }
}

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

$master = GetSocket($address, $port, $log);
$sockets = array($master);
$users = array();

// The main process
while(true) {
    $changed = $sockets;
    socket_select($changed, $write = NULL, $except = NULL, NULL);
    foreach ($changed as $socket) {
        if ($socket == $master) {
            // New client has connected.
            $client = socket_accept($master);
            if ($client < 0) {
                logToFile("socket_accept() failed");
                continue;
            }
            WsConnect($client, $sockets, $users);
            logToFile($client." CONNECTED\n");
        } else {
            // Existing client sent something.
            $user = WsGetUserBySocket($socket, $users);
            $ws = new WebSocket($user, $log);
            $ws->handleRequest($socket);
        }
    }
}
