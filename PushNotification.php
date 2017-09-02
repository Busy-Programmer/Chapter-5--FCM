<?php
/**
 * Created by PhpStorm.
 * User: Isuru
 * Date: 02/09/2017
 * Time: 20:51
 */

class PushNotification{

    // push message title, message and image
    private $title;
    private $message;
    private $image;

    // data payload
    private $data;

    // flag indicating whether to
    // show the push notification
    private $is_background;

    function _construct(){

    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function setDataPayload($data){
        $this->data = $data;
    }

    public function setIsBackground($is_background){
        $this->is_background = $is_background;
    }

    public function getPushNotification(){
        $res = array();
        $res['data']['title'] = $this->title;
        $res['data']['is_background'] = $this->is_background;
        $res['data']['message'] = $this->message;
        $res['data']['payload'] = $this->data;
        $res['data']['timestamp'] = date('Y-m-d G:i:s');

        return $res;
    }
}
