<?php
include('../controllers/db_con.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT
                            mol.menu_id,
                            mol.qty,
                            mol.reservation_id,
                            ml.type,
                            ml.name,
                            ml.price
                        FROM
                            menu_order_list mol
                        INNER JOIN menu_list ml ON
                            mol.menu_id = ml.menu_id
                        WHERE
                            mol.reservation_id = '{$_GET['id']}';");

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
        <thead>
          <tr>
            <th class="text-center">Type</th>
            <th class="text-center">Name</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Price</th>
          </tr>
          </thead>
          <tbody>
            <?php
              // output data of each row
              while($row = $qry->fetch_assoc()) {
            ?>
            <tr>
              <td class="text-center"><?= $row["type"]?></td>
              <td class="text-center"><?= $row["name"]?></td>
              <td class="text-center"><?= $row["qty"]?></td>
              <td class="text-center">₱<?= number_format((float)$row["price"], 2, '.', '')?></td>
            </tr>
            <?php } ?>
          </tbody>
      </table>

    </div>
    <div class="row justify-content-end mx-3">
      <div class="col-1">
        <div class="btn btn btn-dark" type="button" data-dismiss="modal">Close</div>
      </div>
    </div>
  </div>
</div>
<script>
  $(function() {})
</script>