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
     <button type="button" class="btn btn-info btn-circle" data-toggle="tab" href="#menu1"><i class="fa fa-calendar-alt fa-3x"></i></button>
     <p><small>Select<br />Date and Time</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu2"><i class="fa fa-image fa-3x"></i></button>
     <p><small>Select<br />Available Tables</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu3"><i class="fa fa-utensils fa-3x"></i></button>
     <p><small>Select<br />Menu</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu4"><i class="fa fa-info fa-3x"></i></button>
     <p><small>Review<br />Information</small></p>
    </div>
    <div class="process-step">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu5"><i class="fa fa-check fa-3x"></i></button>
     <p><small>Reserve</small></p>
    </div>
   </div>
  </div>
  <div class="tab-content">
   <div id="menu1" class="tab-pane fade active in">
    <h3>Menu 1</h3>
    <p>Some content in menu 1.</p>
    <ul class="list-unstyled list-inline pull-right">
     <li><button type="button" class="btn btn-info next-step" next-id="menu2">Next <i class="fa fa-chevron-right"></i></button></li>
    </ul>
   </div>
   <div id="menu2" class="tab-pane fade">
    <h3>Menu 2</h3>
    <p>Some content in menu 2.</p>
    <ul class="list-unstyled list-inline pull-right">
     <li><button type="button" class="btn btn-default prev-step" prev-id="menu1"><i class="fa fa-chevron-left"></i> Back</button></li>
     <li><button type="button" class="btn btn-info next-step" next-id="menu3">Next <i class="fa fa-chevron-right"></i></button></li>
    </ul>
   </div>
   <div id="menu3" class="tab-pane fade">
    <h3>Menu 3</h3>
    <p>Some content in menu 3.</p>
    <ul class="list-unstyled list-inline pull-right">
     <li><button type="button" class="btn btn-default prev-step" prev-id="menu2"><i class="fa fa-chevron-left"></i> Back</button></li>
     <li><button type="button" class="btn btn-info next-step" next-id="menu4">Next <i class="fa fa-chevron-right"></i></button></li>
    </ul>
   </div>
   <div id="menu4" class="tab-pane fade">
    <h3>Menu 4</h3>
    <p>Some content in menu 4.</p>
    <ul class="list-unstyled list-inline pull-right">
     <li><button type="button" class="btn btn-default prev-step" prev-id="menu3"><i class="fa fa-chevron-left"></i> Back</button></li>
     <li><button type="button" class="btn btn-info next-step" next-id="menu5">Next <i class="fa fa-chevron-right"></i></button></li>
    </ul>
   </div>
   <div id="menu5" class="tab-pane fade">
    <h3>Menu 5</h3>
    <p>Some content in menu 5.</p>
    <ul class="list-unstyled list-inline pull-right">
     <li><button type="button" class="btn btn-default prev-step" prev-id="menu4"><i class="fa fa-chevron-left"></i> Back</button></li>
     <li><button type="button" class="btn btn-success"><i class="fa fa-check"></i> Done!</button></li>
    </ul>
   </div>
  </div>
 </div>
</div>