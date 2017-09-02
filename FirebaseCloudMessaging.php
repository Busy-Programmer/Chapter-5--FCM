<?php
/**
 * Created by PhpStorm.
 * User: Isuru
 * Date: 02/09/2017
 * Time: 20:53
 */
class FirebaseCloudMessaging {

    // this methods send messages to a single device
    public function send($to, $message){
        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    // Send message to topic subscribers
    public function sendToTopic($to, $message){
        $fields = array(
            'to' => '/topics/'. $to,
            'data' => $message,
        );

        return $this->sendPushNotification($fields);
    }

    // Send push message to multiple devices
    public function sendToMultipleDevices($registrationIds, $message){
        $fields = array(
            'to' => $registrationIds,
            'data' => $message,
        );

        return $this->sendPushNotification($fields);
    }

    // CURL request to Firebase Platform
    private function sendPushNotification($fields){

        require_once __DIR__ . '/config.php';

        // POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the URL, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

        // Disable SSL Certificate Support temporary
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }else{
            json_decode($result);
        }

        // Close connection
        curl_close($ch);

        return $result;
    }
}
