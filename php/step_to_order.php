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
 <div class="row">
  <div class="process">
   <div class="process-row nav nav-tabs">
    <div class="process-step">
     <button type="button" class="btn btn-info btn-circle" data-toggle="tab" data-click-id="menu1" href="#menu1"><i class="fa fa-calendar-alt fa-3x"></i></button>
     <p class="text-dark lh-1"><small>Select<br />Date and Time</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" data-click-id="menu2" href="#menu2"><i class="fa fa-image fa-3x"></i></button>
     <p class="text-dark lh-1"><small>Select<br />Available Tables</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" data-click-id="menu3" href="#menu3"><i class="fa fa-utensils fa-3x"></i></button>
     <p class="text-dark lh-1"><small>Select<br />Menu</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" data-click-id="menu4" href="#menu4"><i class="fa fa-info fa-3x"></i></button>
     <p class="text-dark lh-1"><small>Review<br />Information</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" data-click-id="menu5" href="#menu5"><i class="fa fa-check fa-3x"></i></button>
     <p class="text-dark lh-1"><small>Reserve</small></p>
    </div>
   </div>
  </div>
  </div>
  <div class="tab-content col-12">

  <div id="menu1" class="col col-12 tab-pane fade active in">
    <?php include('php/step-1.php')?>
  </div>
  <div id="menu2" class="col col-12 tab-pane fade active in">
    <?php include('php/step-2.php')?>
  </div>

   <div id="menu3" class="tab-pane fade">
    <h3>Menu </h3>
    <p>Some content in menu .</p>
   </div>
   <div id="menu4" class="tab-pane fade">
    <h3>Review</h3>
    <p>Some content in Review.</p>
   </div>
   <div id="menu5" class="tab-pane fade">
    <h3>Reserve</h3>
    <p>Some content in reserve.</p>
   </div>
  </div>
 </div>
</div>
</section>