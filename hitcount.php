<?php

    //********************************/
    // This PHP file was made by n3o_ /
    //                                /
    // recruitment@denzqree.com       /
    // https://www.denzqree.com       /
    //                                /
    // https://www.github.com/denzqree/
    //********************************/
    /********************************/


    // Connecting to the database
    //-------------------------------------------------------------
    $servername = "localhost";
    $username = "YOUR_DB_USERNAME";
    $password = "YOUR_DB_PASSWORD";
    $dbname = "YOUR_DATABASE";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("error");
    }

    //-------------------------------------------------------------

    // Here we explode the IP of the visitor, then we will pass it into the algorithm below
    $ip_parts = explode (".", $_SERVER['REMOTE_ADDR']);
    // (this one :)
    $ip_calculation = ($ip_parts[0] * 16777216) + ($ip_parts[1] * 65536 ) + ($ip_parts[2] * 256) + $ip_parts[3];


    // Now here is our counter persistence logic
    /*****************************************************************************************************************/
    
    // Here we are verifying if the IP has already been logged (only once every 12 hours !)
    //-------------------------------------------------------------------------------------

    $sql = "SELECT ip FROM visitors_count WHERE ip = ".$ip_calculation;
    $result = $conn->query($sql);

    // If the IP has never been logged,
    // we simply add the IP with the initial first visit and the current time

    if($result->num_rows <= 0){

        $sql = "INSERT INTO visitors_count (ip, visit, timestamp) VALUES (".$ip_calculation.",1,CURRENT_TIME())";
        $conn->query($sql);
    }
    //-------------------------------------------------------------------------------------


    // Here stands the whole logic for the 12-hour visit counting limit.
    // This means that your visit will be persisted for 12 hours.
    //-------------------------------------------------------------------------------------
    $sql = "SELECT timestamp FROM visitors_count WHERE ip = ".$ip_calculation;
    $result = $conn->query($sql);

    if($result){

        $timestampResult = $result->fetch_row();
        $timestampResultValue = $timestampResult[0];
        $timestampResultExplode = explode(':',$timestampResultValue);
        $timeDifference = $timestampResultExplode[0]-date("H");

        if($timeDifference > -12 && $timeDifference < 12){     

            $sql = "UPDATE visitors_count SET visit = visit+1, timestamp = CURRENT_TIME() WHERE ip = ".$ip_calculation;
            $conn->query($sql);
        }
    }
    //-------------------------------------------------------------------------------------

    // Last but not least we simply count all the visits ! Enjoy !

    $sql = "SELECT visit FROM visitors_count";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $visits += $row["visit"];
        }
    }    

    
    $conn->close();

    /*****************************************************************************************************************/

    // Finally we return the number of visits with an echo for including purposes (displaying in a website);
    echo $visits;
?>