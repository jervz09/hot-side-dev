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
    <div class="row justify-content-center">
      <div class="col-12 col-sm-11 col-md-11
				col-lg-12 col-xl-12 text-center p-0 mt-3 mb-2">
        <div class="px-0 pt-4 pb-0 mt-3 mb-3">
          <form id="form" action="#" onsubmit="return preventSubmit(event)">
            <ul id="progressbar">
              <li class="active" id="step1">
                <strong>Date and Time</strong>
              </li>
              <li id="step2"><strong>Available Tables</strong></li>
              <li id="step3"><strong>Menu</strong></li>
              <li id="step4"><strong>Review</strong></li>
            </ul>
            <div class="progress">
              <div class="progress-bar progress-bar-animated progress-bar-striped bg-info" role="progressbar"></div>
            </div> <br>
            <fieldset>
              <h2 class="head-step">Select Date and Time</h2>
              <?php include('php/step-1.php')?>
              <input type="button" name="next-step" class="next-step" value="Next Step" />
            </fieldset>
            <fieldset>
              <h2 class="head-step">Select Available Tables</h2>
              <?php include('php/step-2.php')?>
              <input type="button" name="next-step" class="next-step" value="Next Step" />
              <input type="button" name="previous-step" class="previous-step" value="Previous Step" />
            </fieldset>
            <fieldset>
              <h2 class="head-step">Select Menu</h2>
              <?php include('php/step-3.php')?>
              <input type="button" name="next-step" class="next-step" value="Next Step" />
              <input type="button" name="previous-step" class="previous-step" value="Previous Step" />
            </fieldset>
            <fieldset>
              <h2 class="head-step">Review</h2>
              <input type="button" name="previous-step" class="previous-step" value="Previous Step" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>