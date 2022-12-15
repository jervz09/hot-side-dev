<style>
  area.fw-bolder.text-muted {
    background-color: #1383854d;
  }
  area.fw-bolder.text-muted:hover {
    color: #256e6e !important;
    box-shadow: 1px 1px 3px 0px #032e2e;
    -webkit-transition-duration: 500ms;
	  transition-duration: 500ms;
  }
</style>
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Reason Settings</h1>
  </div>
      <div class="row align-items-center">
        <div class="col-12 col-lg-12">

          <div class="calendar_container mb-80">
            <div class="row justify-content-center">
              <div class="col-md-9  box-shadow-hover">
              <button class="btn btn-primary mb-3 add_data"><i class="fa fa-plus"></i> Add Reason</button>
                <table class="table table-hover table-striped table-bordered">
                  <colgroup>
                    <col width="10%">
                    <col width="75%">
                  </colgroup>
                  <thead>
                    <tr>
                      <th class="text-center pl-0 pr-30 p-2">#</th>
                      <th class="text-center pl-0 pr-30 p-2">Reason</th>
                      <th class="text-center pl-0 pr-30 p-2">Action</th>
                    </tr>
                  </thead>
                  <tbody> <?php
                    $sql = "SELECT * FROM `reasons` order by date_created asc";
                    $qry = $conn->query($sql);
                    $tbl = array();
                    $count = 0;
                        while($row = $qry->fetch_assoc()):
                          $count += 1;
                    ?> <tr>
                      <td class="text-center p-0"> <?php echo $count ?> </td>
                      <td class="py-0 px-1"> <?php echo $row['reason'] ?> </td>
                      <th class="text-center py-0 px-1">
                        <div class="dropdown">
                          <button class="btn btn-primary btn-block dropdown-toggle" type="button" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Action
                          </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item edit_data" data-id='<?php echo $row['reason_id'] ?>' href="javascript:void(0)">Edit </a>
                                <a class="dropdown-item delete_data" data-id='<?php echo $row['reason_id'] ?>' data-name='
                                    <?php echo $row['name'] ?>' href="javascript:void(0)">Delete </a>
                            </div>
                        </div>
                      </th>
                    </tr> <?php endwhile; ?> </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

