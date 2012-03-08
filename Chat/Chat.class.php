<?php
/**
 * Sample Application that implements a simple chat but shows
 * how to add services through a simple class definition.
 */
require_once "./lib/wsapp.interface.php";


class Chat implements WSApp {
    public static $app_name = 'chat';

    private $protocol;

    function onMessage($msg) {
        $size = $msg['size'];
        $data = $msg['frame'];
        echo "In Chat Class onMessage: just received ".$data." \n";
        // Just echo it back
        $this->protocol->send($msg);
    }

    function onClose() {
        echo "In Chat Class onClose: closing connection \n";
    }

    function onError($err) {
        echo "In Chat Class onError: closing connection \n";
    }

    function setProtocol(WSProtocol $protocol) {
        $this->protocol = $protocol;
    }
}
