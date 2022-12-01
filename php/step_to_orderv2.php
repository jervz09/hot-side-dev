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
<style>
  .modal-confirm {
		color: #434e65;
		margin: 30px auto;
	}
	.modal-confirm .modal-content {
		padding: 20px;
		font-size: 16px;
		border-radius: 5px;
		border: none;
	}
	.modal-confirm .modal-header {
		background: #2b898b;
		border-bottom: none;
        position: relative;
		text-align: center;
		margin: -20px -20px 0;
		border-radius: 5px 5px 0 0;
		padding: 35px;
	}
	.modal-confirm h4 {
		text-align: center;
		font-size: 36px;
		margin: 10px 0;
	}
	.modal-confirm .form-control, .modal-confirm .btn {
		min-height: 40px;
		border-radius: 3px;
	}
	.modal-confirm .close {
        position: absolute;
		top: 15px;
		right: 15px;
		color: #fff;
		text-shadow: none;
		opacity: 0.5;
	}
	.modal-confirm .close:hover {
		opacity: 0.8;
	}
	.modal-confirm .icon-box {
		color: #fff;
		width: 95px;
		height: 95px;
		display: inline-block;
		border-radius: 50%;
		z-index: 9;
		border: 5px solid #fff;
		padding: 15px;
		text-align: center;
    margin: auto;
	}
	.modal-confirm .icon-box i {
		font-size: 64px;
		margin: -4px 0 0 -4px;
	}
    .modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
		background: #33B7B9;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
		border-radius: 30px;
		margin-top: 10px;
		padding: 6px 20px;
        border: none;
    }
	.modal-confirm .btn:hover, .modal-confirm .btn:focus {
		background: #349091;
		outline: none;
	}
	.modal-confirm .btn span {
		margin: 1px 3px 0;
		float: left;
	}
	.modal-confirm .btn i {
		margin-left: 1px;
		font-size: 20px;
		float: right;
	}
	.trigger-btn {
		display: inline-block;
		margin: 100px auto;
	}
</style>
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
              <input type="button" id="next_step_1" name="next-step" class="next-step" value="Next Step" style="display: none"/>
            </fieldset>
            <fieldset>
              <h2 class="head-step">Select Available Tables</h2>
              <?php include('php/step-2.php')?>
              <input type="button" id="next_step_2" name="next-step" class="next-step" value="Next Step" style="display: none"/>
              <input type="button" name="previous-step" class="previous-step" value="Previous Step" />
            </fieldset>
            <fieldset>
              <h2 class="head-step">Select Menu</h2>
              <?php include('php/step-3.php')?>
              <input type="button" id="next_step_3" name="next-step" class="next-step" value="Next Step" />
              <input type="button" name="previous-step" class="previous-step" value="Previous Step" />
            </fieldset>
            <fieldset>
              <h2 class="head-step">Review</h2>
              <?php include('php/step-review.php')?>
              <input type="button" name="previous-step" class="previous-step" value="Previous Step" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>