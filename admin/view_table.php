<?php
include('../controllers/db_con.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `table_list` where table_id = '{$_GET['id']}'");
        foreach(mysqli_fetch_assoc($qry) as $k => $v){
            $$k = $v;
        }
    }
?>
<style>
  #universal_modal .modal-footer {
    display: none;
  }
</style>
<div class="container-fluid">
  <div class="col-12">
    <div class="row">
      <table class="table table-bordered">
        <tr>
          <td class="text-bold">Table No:</td>
          <td class="ps-4"># <?php echo isset($table_no) ? $table_no : '' ?> </td>
        </tr>
        <tr>
          <td class="text-bold">Name:</td>
          <td class="ps-4"><?php echo isset($name) ? $name : '' ?> </td>
        </tr>
        <tr>
          <td class="text-bold">Description:</td>
          <td class="ps-4"><?php echo isset($description) ? $description : '' ?> </td>
        </tr>
        <tr>
          <td class="text-bold">Status:</td>
          <td class="ps-4">
            <span id="status">
              <?php if($status == 0): ?>

              <a href="#" class="btn btn-warning btn-sm">
                <i class="fas fa-exclamation-circle"></i> Unavailable
              </a>
              <?php else: ?>
              <a href="#" class="btn btn-success btn-sm">
                <i class="fas fa-check"></i> Available
              </a>
              <?php endif; ?>
            </span>
          </td>
        </tr>
      </table>

    </div>
    <div class="row justify-content-end mx-3">
      <div class="col-1">
        <div class="btn btn btn-dark btn-sm" type="button" data-dismiss="modal">Close</div>
      </div>
    </div>
  </div>
</div>
<script>
  $(function() {})
</script>