<?php
/**
 * Sample Application that implements a simple echo but shows
 * how to add services through a simple class definition.
 */
require_once "./lib/wsapp.interface.php";


class WsEcho implements WSApp {
    public static $app_name = 'wsecho';

    private $protocol;

    function onMessage($msg, $users = array()) {
        $size = $msg['size'];
        $data = $msg['frame'];
        echo "In WsEcho Class onMessage: just received ".$data." \n";
        // Just echo it back
        $this->protocol->send($msg);
    }

    function onClose() {
        echo "In WsEcho Class onClose: closing connection \n";
    }

    function onError($err) {
        echo "In WsEcho Class onError: closing connection \n";
    }

    function setProtocol(WSProtocol $protocol) {
        $this->protocol = $protocol;
    }
}
