<div class="row justify-content-center">
  <div class="col-md-12 col-sm-12 col-sx-12 col-lg-3 col-xl-3 desktop-view desktop-menu">
    <div class="card booking-form p-2">
      <div class="card-header"> Category </div>
      <div class="list-group category-list">
        <?php
            $sql = "SELECT * FROM menu_list";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <a href='#' class='btn list-group-item list-group-item-action'>Cras justo odio</a>
                    </tr>";
            }
            } else {
                echo "0 results";
            }
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-sm-12 col-sx-12 col-lg-5 col-xl-5">
    <div class="card booking-form p-1">
      <div class="card-body border-bottom-dashed pb-0 mb-0">
        <h1 class="category-title text-left pb-0 mb-0">Burger</h1>
        <p class="category-para text-left">6 Items</p>
      </div>
      <div class="card-body bb-1 pb-3">
        <div class="row">
          <div class="col-md-9 col-7">
            <h2 class="item-name text-left">Bombay Burger (with Fries)</h2>
            <p class="item-para mb-2 text-left"></p>
            <h3 class="item-price text-left">Pesos.139.00</h3>
          </div>
          <div class="col-md-3 col-5 price-area mb-2">
            <div class="row  align-items-center">
              <div class="col-md-12 text-center">
                <!-- ngIf: m.ItemImage.length >= 1 -->
              </div>
              <div class="col-md-12 text-center">
                <button class="add-item btn btn-branding">
                  <i class="fa fa-plus" aria-hidden="true"></i> Add </button>
              </div>
            </div>
          </div>
        </div>
        <!-- </div> -->
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-sm-12 col-sx-12 col-lg-4 col-xl-4">
    <div id="summary_order" class="summary_order card booking-form p-1">
      <div class="card-header py-3">
        <h5 class="mb-0">Summary</h5>
      </div>
      <div class="card-body summary-body">
        <span class="float-right clickable close-icon" data-effect="fadeOut">
          <i class="fa fa-times"></i>
        </span>
        <div class="cart_container">
          <div id="cart" class="bg-white rounded">
            <div class="d-flex jusitfy-content-between align-items-center pb-2 border-bottom">
              <div class="item pr-2">
                <img src="https://images.unsplash.com/photo-1569488859134-24b2d490f23f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60" alt="" width="80" height="80">
                <div class="number">2</div>
              </div>
              <div class="d-flex flex-column px-3">
                <b class="h5">BattleCreek Coffee</b>
                <a href="#" class="h5 text-primary">C-770</a>
                <div class="d-flex justify-content-around">
                  <span class="fas fa-minus btn text-muted"></span>
                  <span>2</span>
                  <span class="fas fa-plus btn text-muted"></span>
                </div>
              </div>
              <div class="ml-auto">
                <b class="h5">$80.9</b>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="my-3">
          <input type="text" class="w-100 form-control text-center" placeholder="Gift Card or Promo Card">
        </div>
        <div class="d-flex align-items-center">
          <div class="display-5">Subtotal</div>
          <div class="ml-auto font-weight-bold">$80.9</div>
        </div>
        <div class="d-flex align-items-center py-2 border-bottom">
          <div class="display-5">Shipping</div>
          <div class="ml-auto font-weight-bold">$12.9</div>
        </div>
        <div class="d-flex align-items-center py-2">
          <div class="display-5">Total</div>
          <div class="ml-auto d-flex">
            <div class="text-primary text-uppercase px-3">usd</div>
            <div class="font-weight-bold">$92.98</div>
          </div>
        </div>
        <button type="button" class="btn btn-primary btn-lg btn-block"> Go to checkout </button>
      </div>
    </div>
  </div>
</div>