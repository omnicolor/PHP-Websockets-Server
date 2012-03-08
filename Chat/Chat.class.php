<?php
/**
 * Sample Application that implements a simple chat but shows
 * how to add services through a simple class definition.
 */
require_once "./lib/wsapp.interface.php";


class Chat implements WSApp {
    /**
     * @var string Name of the application.
     */
    public static $app_name = 'chat';

    /**
     * @var WSProtocol
     */
    private $protocol;

    /**
     * Handle a message sent by the user.
     * @param array $msg Message array.
     * @param array $users Array of users.
     */
    function onMessage($msg, $users = array()) {
        $size = $msg['size'];
        $data = $msg['frame'];
        echo "In Chat Class onMessage: just received ".$data." \n";
        foreach ($users as $user) {
            $protocol = $user->protocol();
            $protocol->setSocket($user->socket());
            $protocol->send($msg);
        }
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
