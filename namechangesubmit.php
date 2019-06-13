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

if ($address === 'your_ip_here') {
 	//if you do not put your ip up there the script will not work

    $host = "localhost";
    $dbusername = "user";
    $dbpassword = "pass";
    $dbname = "db";
// Create connection
    $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
    } else {

        $oldusername = filter_input(INPUT_POST, 'oldusername');
        $newusername = filter_input(INPUT_POST, 'newusername');
        if (!empty($oldusername)) {
                if (!empty($newusername)) {
                    $sql = "SELECT `username` FROM `users` WHERE `username`='$newusername'";
                    $result = $conn->query($sql);
                    if ($result->num_rows >= 1) {

                        echo "The user with username '$newusername' is taken";

			if ($result->num_rows <= 0) {
			echo "No user with that username is registered";
}}
                     else {
                        $sql = "UPDATE users SET username = '$newusername' where username = '$oldusername'";
			$sql2 = "UPDATE users SET safe_username = LCASE('$newusername') where username = '$newusername'";
			
                        if ($conn->query($sql)) {
			if ($conn->query($sql2)) {
                            echo "You have changed your name to '$newusername'";
                        } else {
                            echo "Error: " . $sql . "" . $conn->error;
                        }
                        $conn->close();
}
                    }
                } else {
                    echo "OLDUSERNAME should not be empty";
                    die();
                }
            } else {
                echo "NEWUSERNAME should not be empty";
                die();
            }


        }

    }


?>
