<div class="row justify-content-center">
  <div class="col-md-12 col-sm-12 col-sx-12 col-lg-3 col-xl-3 desktop-view desktop-menu">
    <div class="card-header"> Category </div>
    <div class="card category-list-container booking-form p-2">
      <div class="list-group category-list">
        <?php
            $sql = "SELECT DISTINCT type FROM menu_list order by type";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <a href='#". decamelize($row["type"]) ."' class='btn list-group-item list-group-item-action'>". $row["type"] ."</a>
                    </tr>";
            }
            } else {
                echo "0 results";
            }
        ?>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-sx-12 col-lg-9 col-xl-9" id="order_list_container">
    <?php
            $sql = "SELECT
                      m.menu_id,m.name,m.price,m.type,items.items
                    FROM
                        menu_list m
                    INNER JOIN
                        (select count(*) as items, type from menu_list group by type) items on items.type = m.type
                    where m.is_delete = 0
                    ORDER BY m.type";
            $result = $conn->query($sql);
            // echo($conn->errno . ' ' . $conn->error);
            $data_menu = array();
            if ($result->num_rows > 0) {
            $last_m_type = "";
            while($row = $result->fetch_assoc()) {
              $formated_price = number_format((float)$row['price'], 2, '.', '');
              $data_menu[$row['menu_id']] = array(
                "id"=>$row['menu_id'],
                "type"=>$row['type'],
                "name"=>$row['name'],
                "price"=>$formated_price
              );
              if(!$last_m_type || $last_m_type != $row['type']){
                if($last_m_type){
                  echo '</div>';
                }

                echo '<div id="'.decamelize($row["type"]).'" class="card booking-form p-1">
                <div class="card-body border-bottom-dashed pb-0 mb-0">
                  <h1 class="category-title text-left pb-0 mb-0">'.$row["type"].'</h1>
                  <p class="category-para text-left">'.$row["items"].' Items</p>
                </div>';
              }
                echo '
                <div class="card-body bb-1 pb-3">
                  <div class="row">
                    <div class="col-md-9 col-7">
                      <h2 class="item-name text-left">'.$row["name"].'</h2>
                      <p class="item-para mb-2 text-left"></p>
                      <h3 class="item-price text-left">₱ '.$formated_price.'</h3>
                    </div>
                    <div class="col-md-3 col-5 price-area mb-2">
                      <div class="row  align-items-center">
                        <div class="col-md-12 text-center">
                        </div>
                        <div class="col-md-12 text-center">
                          <button data-name="'.$row["name"].'" data-id="'.$row["menu_id"].'" class="add-item btn btn-branding">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
                // if(!$last_m_type || $last_m_type != $row['type']){
                //   echo '</div>';
                // }
                $last_m_type = $row['type'];
            }
            echo '</div>';
            }
        ?>

  </div>

  <div class="col-md-12 col-sm-12 col-sx-12 col-lg-3 col-xl-3" id="summary_order_container" style="display:none">
    <div class="card-header py-3">
      <h5 class="mb-0">Summary</h5>
    </div>
    <div id="summary_order" class="summary_order card booking-form p-1">

      <!-- start summary body -->
      <!-- <div class="card-body summary-body temp-body">
      </div> -->
      <!-- end summary body -->

      <div class="card-footer">
        <!-- <div class="my-3">
          <input type="text" class="w-100 form-control text-center" placeholder="Gift Card or Promo Card">
        </div> -->
        <!-- <div class="d-flex align-items-center">
          <div class="display-5">Subtotal</div>
          <div class="ml-auto font-weight-bold">₱80.9</div>
        </div> -->
        <!-- <div class="d-flex align-items-center py-2 border-bottom">
          <div class="display-5">Extra Fee</div>
          <div class="ml-auto font-weight-bold">₱12.9</div>
        </div> -->
        <div class="d-flex align-items-center py-2">
          <div class="display-5">Total</div>
          <div class="ml-auto d-flex">
            <div class="text-primary text-uppercase px-3">PHP</div>
            <div class="font-weight-bold" id="total_price">₱00.00</div>
          </div>
        </div>
        <button type="button" class="btn btn-branding btn-lg btn-block" id="alt_next_step_3"> Next Step </button>
      </div>
    </div>
  </div>
</div>