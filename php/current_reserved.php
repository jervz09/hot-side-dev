<?php
    $base_sql = 'SELECT
            rl.*, u.username, tl.name as tbl_name
        FROM
            reservation_list rl
                INNER JOIN
            users u ON u.user_id = rl.user_id
                INNER JOIN
            table_list tl ON tl.table_no = rl.table_id
            WHERE u.user_id = ?';

    $session_user = (int) ($_SESSION['id'] ?? 0);

    $run = function (string $sql) use ($conn, $session_user) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $session_user);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        return $res;
    };

    $result = $run($base_sql . ' ORDER BY date_created DESC');
    $ongoing_result = $run($base_sql . ' AND DATE(rl.datetime) = CURDATE() AND rl.status < 2 ORDER BY date_created DESC');
    $complete_result = $run($base_sql . ' AND DATE(rl.datetime) < CURDATE() AND rl.status = 1 ORDER BY date_created DESC');
    $cancelled_result = $run($base_sql . ' AND rl.status > 1 ORDER BY date_created DESC');


    $thead_contains = "
                        <thead>
                            <tr>
                                <th class='text-center'>Reservations Date and Time</th>
                                <th class='text-center'>Table Name</th>
                                <th class='text-center'>Menu</th>
                                <th class='text-center'>Status</th>
                                <th class='text-center'>Action</th>
                            </tr>
                        </thead>";

    $zero_result = "<tr><td colspan='8' class='text-center'>No records to show</td></tr>";

    function data_row($row,$is_cancelled_row=false){
        $cancelled_row = "";
        $status = status_cheker($row['status']);
        if ($row['status'] >= 2 && $is_cancelled_row){
            $_reason = ($row['reason'] == "Others") ? $row['other_reason'] : $row['reason'];
            $cancelled_row = "<td class ='text-center p-1'>" . htmlspecialchars((string) $_reason, ENT_QUOTES, 'UTF-8') . "</td>";
        }
        // <a class='btn btn-branding btn-block edit_data' data-id='". $row['reservation_id'] ."' href='reserve.php?update=".$row['reservation_id'] ."'><i class='fa fa-edit'></i> Update </a>
        $e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
        return "
            <tbody>
                <tr>
                    <td class ='text-center p-1'>" . $e($row["datetime"]) . "</td>
                    <td class ='text-center p-1'>" . $e($row["tbl_name"]) . "</td>
                    <td class ='text-center p-1'><a class='view_order' id='view_order' data-id='". (int) $row['reservation_id'] ."' href='#'>View Order</a></td>
                    <td class ='text-center p-1'>" . $e($status) . "</td>
                    $cancelled_row
                    <td class ='text-center p-1'>
                        <a class='btn btn-branding btn-block view_reservation' data-id='". (int) $row['reservation_id'] ."' href='javascript:void(0)'><i class='fa fa-list'></i> View </a>
                    </td>
                </tr>
            </tbody>";
    }

    function status_cheker($status){
        if($status == '0'){
            $_status = "Pending";
        }elseif($status == 1){
            $_status = "Reserved";
        }elseif($status == 2){
            $_status = "Declined";
        }else{
            $_status = "Cancelled";
        }
        return $_status;
    }
?>
<div class="tab-content">
    <div class="tab-pane containtainer active" id="all_reserved">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <?=$thead_contains?>
                    <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo data_row($row);
                            }
                        } else {
                            echo $zero_result;
                        }
                    ?>
            </table>
        </div>
    </div>

    <div class="tab-pane containtainer fade" id="ongoing_reservation">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <?=$thead_contains?>
                    <?php
                        if ($ongoing_result->num_rows > 0) {
                            while($row = $ongoing_result->fetch_assoc()) {
                                echo data_row($row);
                            }
                        } else {
                            echo $zero_result;
                        }
                    ?>
            </table>
        </div>
    </div>

    <div class="tab-pane containtainer fade" id="complete">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%">
                <?=$thead_contains?>
                    <?php
                        if ($complete_result->num_rows > 0) {
                            while($row = $complete_result->fetch_assoc()) {
                                echo data_row($row);
                            }
                        } else {
                            echo $zero_result;
                        }
                    ?>
            </table>
        </div>
    </div>

    <div class="tab-pane containtainer fade" id="complete">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%">
                <?=$thead_contains?>
                    <?php
                        if ($complete_result->num_rows > 0) {
                            while($row = $complete_result->fetch_assoc()) {
                                echo data_row($row);
                            }
                        } else {
                            echo $zero_result;
                        }
                    ?>
            </table>
        </div>
    </div>

    <div class="tab-pane containtainer fade" id="cancelled">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th class='text-center'>Reservations Date and Time</th>
                        <th class='text-center'>Table Name</th>
                        <th class='text-center'>Menu</th>
                        <th class='text-center'>Status</th>
                        <th class='text-center'>Reason</th>
                        <th class='text-center'>Action</th>
                    </tr>
                </thead>
                    <?php
                        if ($cancelled_result->num_rows > 0) {
                            while($row = $cancelled_result->fetch_assoc()) {
                                echo data_row($row,true);
                            }
                        } else {
                            echo $zero_result;
                        }
                    ?>
            </table>
        </div>
    </div>
</div>
