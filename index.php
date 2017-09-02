<!DOCTYPE html>
<html lang="en">
<head>
    <title>Firebase Cloud Messaging - Busy Programmer's Guide</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style type="text/css">
        /*Panel tabs*/
        .panel-tabs {
            position: relative;
            bottom: 30px;
            clear: both;
            border-bottom: 1px solid transparent;
        }

        .panel-tabs > li {
            float: left;
            margin-bottom: -1px;
        }

        .panel-tabs > li > a {
            margin-right: 2px;
            margin-top: 4px;
            line-height: .85;
            border: 1px solid transparent;
            border-radius: 4px 4px 0 0;
            color: #ffffff;
        }

        .panel-tabs > li > a:hover {
            border-color: transparent;
            color: #ffffff;
            background-color: transparent;
        }

        .panel-tabs > li.active > a,
        .panel-tabs > li.active > a:hover,
        .panel-tabs > li.active > a:focus {
            color: #fff;
            cursor: default;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            background-color: rgba(255, 255, 255, .23);
            border-bottom-color: transparent;
        }

        .input_width {
            width: 520px;
        }
    </style>

</head>
<body>

<br>
<div class="container">

    <?php

    // Enabling error reporting
    error_reporting(-1);
    ini_set('display_errors', 'On');

    require_once __DIR__ . '/FirebaseCloudMessaging.php';
    require_once __DIR__ . '/PushNotification.php';

    $firebaseCloudMessaging = new FirebaseCloudMessaging();
    $pushNotification = new PushNotification();

    // optional payload
    $payload = array();

    // notification title
    $title = isset($_GET['title']) ? $_GET['title'] : '';

    // notification message
    $message = isset($_GET['message']) ? $_GET['message'] : '';

    // push type - single user / topic
    $push_type = isset($_GET['push_type']) ? $_GET['push_type'] : '';

    $pushNotification->setTitle($title);
    $pushNotification->setMessage($message);
    $pushNotification->setIsBackground(FALSE);
    $pushNotification->setDataPayload($payload);

    $json = '';
    $response = '';

    if ($push_type == 'topic') {
        $json = $pushNotification->getPushNotification();
        $response = $firebaseCloudMessaging->sendToTopic('news', $json);
    } else if ($push_type == 'individual') {
        $json = $pushNotification->getPushNotification();
        $regId = isset($_GET['regId']) ? $_GET['regId'] : '';
        $response = $firebaseCloudMessaging->send($regId, $json);
    }

    ?>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">

                <div class="fl_window">
                    <br/>
                    <?php if ($json != '') { ?>
                        <label><b>Request:</b></label>
                        <div class="json_preview">
                            <pre><?php echo json_encode($json) ?></pre>
                        </div>
                    <?php } ?>
                    <br/>
                    <?php if ($response != '') { ?>
                        <label><b>Response:</b></label>
                        <div class="json_preview">
                            <pre><?php echo json_encode($response) ?></pre>
                        </div>
                    <?php } ?>

                </div>

                <div class="panel-heading">
                    <h3 class="panel-title">Firebase Cloud Messaging</h3>
                    <span class="pull-right">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">Single Device</a></li>
                            <li><a href="#tab2" data-toggle="tab">Send To Topic 'News'</a></li>
                        </ul>
                    </span>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <form class="pure-form pure-form-stacked" method="get">
                                <fieldset>
                                    <div class="form-group">
                                        <div class="input_width">
                                            <input
                                                class="form-control input-lg" type="text"
                                                placeholder="Enter Firebase Registration ID" id="redId" name="regId"
                                                placeholder="Enter Firebase Registration ID">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input_width">
                                            <input
                                                class="form-control input-lg" type="title"
                                                placeholder="Enter Title" id="title" name="title">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <textarea class="input_width input-lg" rows="5" name="message" id="message"
                                                      placeholder="Notification message!"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                <input type="hidden" name="push_type" value="individual"/>
                                <div class=" text-center">
                                    <input type="submit" class="btn btn-primary" value="SUBMIT"/>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <form class="pure-form pure-form-stacked" method="get">
                                <fieldset>
                                    <div class="form-group">
                                        <div class="input_width">
                                            <input
                                                class="form-control input-lg" type="text"
                                                placeholder="Enter Title" id="title1" name="title"
                                                placeholder="Enter Title">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <textarea class="input_width input-lg" rows="5" name="message" id="message"
                                                      placeholder="Notification message!"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                <input type="hidden" name="push_type" value="topic"/>
                                <div class=" text-center">
                                    <input type="submit" class="btn btn-primary" value="Send to Topic Subscribers"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>
