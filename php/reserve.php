<section id="calendar_area" class="about-us-area mb-10">
<div class="container">
  <div class="row">
    <div class="col-12 col-lg-12">
      <div class="about-text">
        <div class="section-heading m-0">
          <div class="line-"></div>
          <h2 class="text-secondary">Menu</h2>
          <!-- <button id="to_reserve" class="btn btn-branding btn-lg float-right">Reserve</button> -->
        </div>
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
        <!-- Modal gallery -->
  <div class="row justify-content-md-center p-2">
        <div class="col col-12 col-md-6 mt-3">
            <div class="row">
                <div class="row box-shadow">
                    <div class="col-md-6">
                        <img class="lib-img-show" src="./img/food-img/img-1.jpg">
                    </div>
                    <div class="col-md-6">
                        <div class="lib-row lib-header">
                            <h2>Pulutan Yarn</h2>
                            <div class="lib-header-seperator"></div>
                        </div>
                        <div class="lib-row lib-desc">
                            Pulutan na this. With Shot Puno
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col col-12 col-md-6 mt-3">
            <div class="row">
                <div class="col-md-12" id="floor-plan-container">
                    <div id="fp-canvas-container">
                        <img src="./admin/helper/uploads/floorplan.png" alt="Floor Plan" class='fp-img border p-1' id="fp-img" usemap="#fp-map">
                        <map name="fp-map" id="fp-map" class="">
                        </map>
                    </div>
                </div>
                <div class="col-12" id="date-picker-container">
                    <div id="datetime_picker_reserve"></div>
                </div>


                <div class="col-12" id="next_datepicker-container">
                    <button id="next_datepicker" class="btn btn-branding btn-lg float-right">Select For Date</button>
                </div>
            </div>
        </div>
    </div>
</div>
</section>