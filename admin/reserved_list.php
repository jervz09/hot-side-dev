<style>
    *{
        font-size: 14px;
    }
</style>
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-2 text-gray-800">Tables</h1> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">Reservation List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="reserveDataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">Datetime</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Table Name</th>
                            <th class="text-center">Menu</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </tfoot> -->
                    <tbody>
                        <?php
                            $sql = "SELECT
                                        rl.*, u.username, tl.name as tbl_name
                                    FROM
                                        reservation_list rl
                                            INNER JOIN
                                        users u ON u.user_id = rl.user_id
                                            INNER JOIN
                                        table_list tl ON tl.table_no = rl.table_id;
                                    ";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                if($row['status'] == '0'){
                                    $status = "No Action";
                                }elseif($row['status'] == 1){
                                    $status = "Accepted";
                                }else{
                                    $status = "Declined";
                                }

                                echo "<tr>
                                        <td data-sort='". date('d-m-Y',strtotime($row["datetime"]))."' class ='text-center p-1'>" . $row["datetime"] . "</td>
                                        <td class ='text-center p-1'>" . $row["username"] . "</td>
                                        <td class ='text-center p-1'>" . $row["tbl_name"] . "</td>
                                        <td class ='text-center p-1'><a class='view_order' id='view_order' data-id='". $row['reservation_id'] ."' href='#'>View Order</a></td>
                                        <td class ='text-center p-1'>" . $status . "</td>
                                        <td class ='text-center p-1'>

                                            <div class='dropdown'>
                                                <button class='btn btn-primary btn-block dropdown-toggle' type='button' id='btnGroupDrop1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    Action
                                                </button>
                                                <div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>
                                                    <a class='dropdown-item edit_data' data-id='". $row['reservation_id'] ."' href='javascript:void(0)'><i class='fa fa-edit'></i> Update </a>
                                                    <a class='dropdown-item delete_data' data-id='". $row['reservation_id'] ."' data-name='
                                                        ". $row['name'] ."' href='javascript:void(0)'><i class='fa fa-trash'></i> Delete </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>";
                            }
                            } else {
                                echo "0 results";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>