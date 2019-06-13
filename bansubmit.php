<?php
$referer = isset($_SERVER['HTTP_REFERER']) ? _SERVER['HTTP_REFERER'] : 'undefined';
$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'undefined';

$address = 'undefined';

if (isset($_SERVER)) {
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$address = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$address = $_SERVER['HTTP_CLIENT_IP'];
	} else {
		$address = $_SERVER['REMOTE_ADDR'];
	}
}

if ($address === '47.39.46.24') {
	
	
$host       = "localhost";
$dbusername = "asta";
$dbpassword = "3children";
$dbname     = "asta";
// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
} else {

  $userid = filter_input(INPUT_POST, 'userid');
  $reason = filter_input(INPUT_POST, 'reason');
  $duration = filter_input(INPUT_POST, 'duration');
  if (!empty($userid)) {
    if (!empty($reason)) {
        $sql    = "SELECT `user_id` FROM `punishments` WHERE `user_id`='$userid'";
        $result = $conn->query($sql);
        if ($result->num_rows >= 1) {
            echo "The user with userid '$userid' is already banned.";
        } else {
            $sql = "INSERT INTO punishments (user_id, reason, duration, origin_id, type, time, active) values ('$userid','$reason', " . (empty($duration) ?  "NULL" : "'$duration'") . ",'10','2','1','1')";
            if ($conn->query($sql)) {
                echo "The user with userid '$userid' has been banned!";
            } else {
                echo "Error: " . $sql . "" . $conn->error;
            }
            $conn->close();
        }
    } else {
        echo "REASON should not be empty";
        die();
    }
  } else {
    echo "USERID should not be empty";
    die();
  }

}
	
}
?>
