<section id="calendar_area" class="about-us-area mb-10">
<div class="container">
  <div class="row">
    <div class="col-12 col-lg-12">
      <div class="about-text">
        <div class="section-heading m-0">
          <div class="line-"></div>
          <h2>Reservation</h2>
        </div>
      </div>
    </div>

<style>
    #fp-canvas-container{
        height:50vh;
        width:calc(100%);
        position:relative;
    }
    .fp-img,.fp-canvas,.fp-canvas-2{
        position:absolute;
        width:calc(100%);
        height:calc(100%);
        top:0;
        left:0;
        z-index: 1;
    }
    #fp-map{
        position:absolute;
        top:0;
        left:0;
        z-index: 1;
        width:calc(100%);
        height:calc(100%);
    }
    .fp-canvas {
        z-index: 2;
        background: #0000000d;
        cursor: crosshair;
    }
    #fp-map{
        z-index: 1;
    }
    area:hover {
        background: #0000004d;
        color: #fff !important;
    }
</style>
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
    <div class="col-4 mt-3">
        <div id="datetime_picker_reserve"></div>
    </div>
    <div class="col-2 mt-3">
        <div class="row">
            <button id="to_reserve" class="btn palatin-btn">Reserve</button>
            <!-- <div>
                <button class="button large round success">Success notification</button>
            </div>
            <div>
                <button class="button large round alert">Error notification</button>
            </div> -->
        </div>
    </div>
  </div>
</div>
</section>
