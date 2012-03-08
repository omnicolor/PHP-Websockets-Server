<?php
/**
 * User connected to the application.
 */

require_once 'wsuser.class.php';
require_once 'handshaker.interface.php';
require_once "wsprotocol.interface.php";

/**
 * User connected to the application.
 */
class WsUser {
    /**
     * @var string Unique ID for the user.
     */
    private $id;

    /**
     * @var Resource Socket resource.
     */
    private $socket;

    /**
     * @var boolean Whether the handshake is complete.
     */
    private $handshake_done = false;

    /**
     * @var MessageTranscoder
     */
    private $transcoder;

    /**
     * @var string ID of the application the user connected to.
     */
    private $appId;

    /**
     * @var WSProtocol Protocol the user's browser connected with.
     */
    private $protocol;


    /**
     * Class Constructor for the WsUser Object
     */
    public function __construct() {
        $this->id = uniqid();
    }

    public function id() {
        return $this->id;
    }

    public function setSocket($socket) {
        $this->socket = $socket;
    }

    public function socket() {
        return $this->socket;
    }

    public function setHandshakeDone() {
        $this->handshake_done = true;
    }

    public function handshakeDone() {
        return $this->handshake_done;
    }

    public function setTranscoder(MessageTranscoder $transcoder) {
        $this->transcoder = $transcoder;
    }

    public function transcoder() {
        return $this->transcoder;
    }

    public function setProtocol(WSProtocol $protocol) {
        $this->protocol = $protocol;
    }

    public function protocol() {
        return $this->protocol;
    }

    public function setAppID($app) {
        $this->appId = $app;
    }

    public function appId() {
        return $this->appId;
    }
}
