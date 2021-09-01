<?php
    include_once("db.php");

    function is_valid_email($email) {
        // Should match e-mail filter in validation.js, but can be stricter
        // Error message from server will be displayed to user if server-side verification fails
        $emailreg = "/^\S+@\S+\.\S+$/";
        return preg_match($emailreg, $email) == 1;
    }

    function get_email_provider($email) {
        $atpos = strpos($email,'@');
        return substr($email, $atpos+1);
    }

    $email = $_POST["email"] ?? null;
    $tos = $_POST["agreetos"] ?? null;

    $subscribed = false;
    $error = "";

    if($email == null) {
        $error = "";
    } elseif($tos != "on") {
        $error = "You must accept the terms and conditions";
    } elseif($email == "") {
        $error = "Email address is required";
    } elseif(!is_valid_email($email)) {
        $error = "Please provide a valid e-mail address";
    } elseif(preg_match("/\.co$/i",$email)) {
        $error = "We are not accepting subscriptions from Colombia emails";
    } else {
        $conn = new mysqli($servername, $username, $password, $databasename);
        if($conn->connect_error) {
            $error = "Internal server error (100), try again later.";
        } else {
            // Strip HTML tags from email for safety
            $email = strip_tags($email);
            $provider = get_email_provider($email);
            $sql = "INSERT INTO $tablename (email, email_provider, timestamp) VALUES(?,?,NOW());";
            $conn_statement = $conn->prepare($sql);
            $conn_statement->bind_param('ss',$email, $provider);

            if($conn_statement->execute()) {
                // E-mail saved in DB
                $subscribed = true;
            } else {
                if(mysqli_errno($conn) == 1062) {
                    $error = "This e-mail is already on subscriber list.";
                } else {
                    $error = "Internal server error (101), try again later.";
                }
            }
            $conn_statement->close();
            $conn->close();
        }
    }
    echo $subscribed ? "true" : $error;
