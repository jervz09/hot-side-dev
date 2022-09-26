<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);

    if(! $conn ) {
        die('Could not connect: ' . mysql_error());
    }

    $query_file = '../database/dump.sql';

    $fp = fopen($query_file, 'r');
    $sql = fread($fp, filesize($query_file));
    fclose($fp); 

    mysqli_select_db($conn, 'hot-side');
    $result = mysqli_multi_query( $conn, $sql );

    if ($result) {
        do {
            // grab the result of the next query
            if (($result = mysqli_store_result($conn)) === false && mysqli_error($conn) != '') {
                echo "Query failed: " . mysqli_error($conn);
            }
        } while (mysqli_more_results($conn) && mysqli_next_result($conn)); // while there are more results
        
        echo "Success";
    } else {
        echo "First query failed..." . mysqli_error($conn);
    }
    mysqli_close($conn);
    ?>