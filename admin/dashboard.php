<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>
  <!-- Content Row -->
<?php include('./include/cards.php')?>
  <div class="row">
    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Monthly Sales Overview</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-area">
            <canvas id="salesLineChart"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Variation of Menu</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-pie pt-4 pb-2">
            <canvas id="myPieChart"></canvas>
          </div>
          <div class="mt-4 text-center small">
            <?php
                $db->select_raw("SELECT COUNT(type) as count, type FROM `menu_list` GROUP by type");
                $db_category = $db->sql;
                $db_categories = array();
                while($row = $db_category->fetch_assoc()) {
                    $rand_colors = '#' . dechex(rand(256,16777215));
                    $db_categories[$row['type']] = $row['count'].'-'.$rand_colors;
            ?>
            <span class="mr-2">
              <i class="fas fa-circle" style="color: <?=$rand_colors?>;"></i> <?=$row['type']?> </span>
              <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-6 col-lg-6">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Floor Plan</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <img src="./helper/uploads/floorplan.png?v=<?php echo time() ?>" alt="Floor Plan" id="fp-img-main" class="w-100">
        </div>
      </div>
    </div>
  </div>
</div>