<?php
  $data_id = $_POST['data']["id"];
?>
<div class="card-body summary-body" menu-id="<?=$data_id?>" style="display: none;">
  <span class="float-right clickable close-icon" data-effect="fadeOut" onclick="close_summary_item(this)">
    <i class="fa fa-times"></i>
  </span>
  <div class="cart_container">
    <div id="cart" class="bg-white rounded">
      <div class="d-flex jusitfy-content-between align-items-center pb-2 border-bottom">
        <div class="d-flex flex-column px-3">
          <b data-name="" class="h5"><?=$_POST['data']["name"];?></b>
          <!-- <a href="#" class="h5 text-primary">C-770</a> -->
          <div class="d-flex justify-content-start">
            <span dec-id="<?=$data_id?>" class="fas fa-minus btn text-muted dec-qty" onclick="dec_qty(this)"></span>
            <span order-qty-id = "<?=$data_id?>"class="order-qty">1</span>
            <span inc-id="<?=$data_id?>"class="fas fa-plus btn text-muted inc-qty" onclick="inc_qty(this)"></span>
          </div>
        </div>
        <div class="ml-auto">
          <b class="orig_price_<?=$data_id?> h5 d-none">₱<?=$_POST['data']["price"]?></b>
          <b class="price_<?=$data_id?> h5">₱<?=$_POST['data']["price"]?></b>
        </div>
      </div>
    </div>
  </div>
</div>