<?php
    include("../controllers/db_con.php");
    $tables_count = 0;
    $party_size_cond = "";

    $party_size = str_replace(' person', '', str_replace(' people', '', $_POST['party_size']));
    $reserved_date = $_POST['reserved_date'];
    $end_time = $_POST['reserved_time'];
    // $start_time = strtotime('- 45 minute', ($end_time));
    $start_time = date("H:i", strtotime('- 45 minute', strtotime(strval($end_time))));
    if($party_size){
        $party_size_cond = "party_size = $party_size OR";
    }
    $available_table = "SELECT
                table_id, table_no, coordinates, name, party_size
            FROM
                table_list
            WHERE
                table_id NOT IN (SELECT
                    table_id
                FROM
                    reservation_list
                WHERE
                    $party_size_cond
                    datetime BETWEEN '$reserved_date $start_time' AND '$reserved_date $end_time')";
    $qry_available_table = $conn->query($available_table);
    $tables_count = mysqli_num_rows($qry_available_table);
    $tbl = array();
    while($row = $qry_available_table->fetch_assoc()):
        $tbl[$row['table_id']] = array(
                                    "id"=>$row['table_id'],
                                    "table_no"=>$row['table_no'],
                                    "coordinates"=>$row['coordinates'],
                                    "name"=>$row['name']
                                        );
    endwhile;
    echo json_encode($tbl);
?>