<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-2 text-gray-800">Tables</h1> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">Menu List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Role</th>
                            <th>Action</th>
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
                            $b->select("users","*","NOT role_id = 1");
                            $result = $b->sql;
                            if ($result->num_rows > 0) {
                            // output data of each row
                            while ($row = mysqli_fetch_assoc($result)) { 
                                $role = ($row['role_id'] == '1') ? "Admin" : "User";
                                echo "<tr>
                                        <td class ='align-center p-1'>" . $row["username"] . "</td>
                                        <td class ='align-center p-1'>" . $row["email"] . "</td>
                                        <td class ='align-center p-1'>" . $row["contact_no"] . "</td>
                                        <td class ='align-center p-1'>" . $role . "</td>
                                        <td class ='align-center p-1'>
                                            <a class='btn btn-block btn-success edit_data' data-id='". $row['menu_id'] . "' href='javascript:void(0)'>
                                                Edit
                                            </a>
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