<section id="calendar_area" class="about-us-area mb-10">
<div class="container">
  <div class="row">
    <div class="col-12 col-lg-12">
      <div class="about-text">
        <div class="section-heading m-0">
          <div class="line-"></div>
          <h2>Reservation</h2>

          <button id="to_reserve" class="btn btn-branding btn-lg float-right">Reserve</button>
        </div>
      </div>
    </div>
<?php
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
    endwhile;
?>
    <div class="col-6 mt-3">
        <div class="row">
            <div id="fp-canvas-container">
                <img src="./admin/uploads/floorplan.png" alt="Floor Plan" class='fp-img border p-1' id="fp-img" usemap="#fp-map">
                <map name="fp-map" id="fp-map" class="">
                </map>
            </div>
        </div>
    </div>
    <div class="col-6 mt-3">
        <div id="datetime_picker_reserve"></div>
    </div>
  </div>
  <!-- <div class="row">
    <div class="col-2 mt-3">
        <div class="row">
            <button id="to_reserve" class="btn btn-branding btn-lg">Reserve</button>
        </div>
    </div>
  </div> -->
</div>
</section>
