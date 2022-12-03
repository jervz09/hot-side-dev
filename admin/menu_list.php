<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-2 text-gray-800">Tables</h1> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">Menu List</h6>
        </div>
        <button class="btn btn-lg btn-primary m-3" id="add_menu" style="width:20%">
            <i class="fa fa-plus"></i> Add Menu
        </button>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th style="width: 15%">Action</th>
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
                            $sql = "SELECT * FROM menu_list";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {

                                $is_delete = $row["is_delete"];
                                if($is_delete == '0'){
                                    $status = "Enabled";
                                }elseif($is_delete == 1){
                                    $status = "Disabled";
                                }

                                echo "<tr>
                                        <td class ='align-center p-1'>" . $row["type"] . "</td>
                                        <td class ='align-center p-1'>" . $row["name"] . "</td>
                                        <td class ='align-center p-1'>" . $row["price"] . "</td>
                                        <td class ='align-center p-1'>" . $status . "</td>
                                        <td class ='text-center p-1'>
                                            <div class='dropdown'>
                                                <button class='btn btn-primary btn-block dropdown-toggle' type='button' id='btnGroupDrop1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    Action
                                                </button>
                                                <div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>
                                                    <a class='dropdown-item edit_data' data-id='". $row['menu_id'] ."' href='javascript:void(0)'><i class='fa fa-edit'></i> Update </a>
                                                    <a class='dropdown-item delete_data' data-id='". $row['menu_id'] ."' data-name='
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