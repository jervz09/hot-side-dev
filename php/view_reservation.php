<?php
include('../controllers/db_con.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT
                            rl.*, u.username, tl.name as tbl_name
                        FROM
                            reservation_list rl
                                INNER JOIN
                            users u ON u.user_id = rl.user_id
                                INNER JOIN
                            table_list tl ON tl.table_id = rl.table_id
                        WHERE
                            rl.reservation_id = '{$_GET['id']}';");

    }
    while($row = $qry->fetch_assoc()) {
      $reservation_id = $row['reservation_id'];
      $reserved_time = $row['datetime'];
      $tbl_name = $row['tbl_name'];
      $status = $row['status'];
      $reason = $row['reason'];
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
<style>
  #universal_modal .modal-footer {
    display: none;
  }
</style>
<div class="container-fluid">
  <div class="col-12">
    <div class="row">
      <table class="table table-bordered table-hover">
        <thead>
          <tbody>
            <tr>
              <td class="text-center">Table No.</td>
              <td class="text-center"><?= $tbl_name?></td>
            </tr>
            <tr>
              <td class="text-center">Reserved Time.</td>
              <td class="text-center"><?= $reserved_time?></td>
            </tr>
            <tr>
              <td class="text-center">Reserved Time.</td>
              <td class="text-center"><?=status_cheker($status)?></td>
            </tr>
          </tbody>
      </table>

    </div>
    <div class="row justify-content-end">
        <?php if($status < 1){?>
          <button class="btn btn btn-danger mr-2 cancel_reservation" data-id="<?=$reservation_id?> type="button">Cancel Reservation</button>
        <?php } ?>
        <div class="btn btn btn-dark" type="button" data-dismiss="modal">Close</div>
    </div>
  </div>
</div>
<script>
  $(function() {})

  $('.cancel_reservation').click(function(){
      universal_modal('Cancellation Details',"php/cancel_reservation.php?id="+$(this).attr('data-id'))
  })
</script>