<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Table Settings</h1>
  </div>
      <div class="row align-items-center">
        <div class="col-12 col-lg-12">
          <div class="calendar_container mb-80">
            <div class="row">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-12">
                    <label class="toggle">
                        <input type="checkbox">
                        <span class="slider"></span>
                        <span class="labels" data-on="ON" data-off="OFF" id="draw"></span>
                    </label>
                    <!-- <button class="btn btn-primary rounded-0" id="draw"> Draw to Map Table</button> -->
                    <button class="btn btn-primary rounded-0 d-none" id="create_table"> Create Table</button>
                    <button class="btn btn-dark rounded-0 d-none" id="cancel"> Cancel</button>
                  </div>
                </div>
                <div id="fp-canvas-container">
                  <img src="./uploads/floorplan.png" alt="Floor Plan" class='fp-img' id="fp-img" usemap="#fp-map">
                  <map name="fp-map" id="fp-map" class=""></map>
                  <canvas class="fp-canvas d-none" id="fp-canvas"></canvas>
                </div>
              </div>
              <div class="col-md-5">
                <table class="table table-hover table-striped table-bordered">
                  <colgroup>
                    <col width="10%">
                    <col width="75%">
                  </colgroup>
                  <thead>
                    <tr>
                      <th class="text-center pl-0 pr-30 p-2">#</th>
                      <th class="text-center pl-0 pr-30 p-2">Name</th>
                      <th class="text-center pl-0 pr-30 p-2">Action</th>
                    </tr>
                  </thead>
                  <tbody> <?php 
                    $sql = "SELECT * FROM `table_list` order by table_no asc";
                    $qry = $conn->query($sql);
                    $tbl = array();
                        while($row = $qry->fetch_assoc()):
                            $tbl[$row['table_id']] = array(
                                                        "id"=>$row['table_id'],
                                                        "table_no"=>$row['table_no'],
                                                        "coordinates"=>$row['coordinates'],
                                                        "name"=>$row['name']
                                                            );
                    ?> <tr>
                      <td class="text-center p-0"> <?php echo $row['table_no'] ?> </td>
                      <td class="py-0 px-1"> <?php echo $row['name'] ?> </td>
                      <th class="text-center py-0 px-1">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item edit_data" data-id='
                                    <?php echo $row['table_id'] ?>' href="javascript:void(0)">Edit </a>
                                <a class="dropdown-item delete_data" data-id='
                                    <?php echo $row['table_id'] ?>' data-name='
                                    <?php echo $row['table_no']." - ".$row['name'] ?>' href="javascript:void(0)">Delete </a>
                            </div>
                        </div>
                      </th>
                    </tr> <?php endwhile; ?> </tbody>
                </table>
              </div>
              <!-- <a href="reservation.html" class="btn palatin-btn">Make a Reservation</a> -->
            </div>
          </div>
        </div>
      </div>
</div>

    <!-- <a href="reservation.html" class="btn palatin-btn">Make a Reservation</a> -->
    