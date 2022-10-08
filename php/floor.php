<div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
  <div class="toast" style="position: absolute; top: 0; right: 0;">
    <div class="toast-header">
      <img src="..." class="rounded mr-2" alt="...">
      <strong class="mr-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
  </div>
</div>

<section id="calendar_area" class="about-us-area">
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
        <div id="datetimepicker12"></div>
    </div>
    <div class="col-2 mt-3">
        <div class="row">
            <button id="to_reserve" class="btn palatin-btn">Reserve</button>
        </div>
    </div>
  </div>
</div>
</section>
