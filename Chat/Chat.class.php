<?php
/**
 * Sample Application that implements a simple chat but shows
 * how to add services through a simple class definition.
 */
require_once "./lib/wsapp.interface.php";


/**
 * Simple chat client.
 */
class Chat implements WSApp {
    /**
     * @var string Name of the application.
     */
    public static $app_name = 'chat';

    /**
     * @var WSProtocol Protocol this instance of the chat client is using.
     */
    private $protocol;


    /**
     * Handle a message sent by the user.
     * @param array $msg Message array.
     * @param array $users Array of users.
     */
    public function onMessage($msg, $users = array()) {
        $size = $msg['size'];
        $data = $msg['frame'];
        echo "In Chat Class onMessage: just received ".$data." \n";
        foreach ($users as $user) {
            $protocol = $user->protocol();
            $protocol->setSocket($user->socket());
            $protocol->send($msg);
        }
    }

    /**
     * Called when the client quits.
     */
    public function onClose() {
        echo "In Chat Class onClose: closing connection \n";
    }

    /**
     * Called if there is an error communicating with the chat client.
     * @param string $err Error message.
     */
    public function onError($err) {
        echo "In Chat Class onError: closing connection \n";
    }

    /**
     * Set the protocol the app should use with the user.
     * @param WSProtocol $protocol Protocol to use when communicating.
     */
    public function setProtocol(WSProtocol $protocol) {
        $this->protocol = $protocol;
    }
}
