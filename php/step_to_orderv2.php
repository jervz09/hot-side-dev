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
			<div class="col-11 col-sm-9 col-md-7
				col-lg-6 col-xl-12 text-center p-0 mt-3 mb-2">
				<div class="px-0 pt-4 pb-0 mt-3 mb-3">
					<form id="form">
						<ul id="progressbar">
							<li class="active" id="step1">
								<strong>Date and Time</strong>
							</li>
							<li id="step2"><strong>Available Tables</strong></li>
							<li id="step3"><strong>Menu</strong></li>
							<li id="step4"><strong>Review</strong></li>
						</ul>
						<div class="progress">
							<div class="progress-bar"></div>
						</div> <br>
						<fieldset>
							<h2>Select Date and Time</h2>
							<?php include('php/step-1.php')?>
							<input type="button" name="next-step"
								class="next-step" value="Next Step" />
						</fieldset>
						<fieldset>
							<h2>Select Available Tables</h2>
							<?php include('php/step-2.php')?>
							<input type="button" name="next-step"
								class="next-step" value="Next Step" />
							<input type="button" name="previous-step"
								class="previous-step"
								value="Previous Step" />
						</fieldset>
						<fieldset>
							<h2>Select Menu</h2>
							<?php include('php/step-3.php')?>
							<input type="button" name="next-step"
								class="next-step" value="Final Step" />
							<input type="button" name="previous-step"
								class="previous-step"
								value="Previous Step" />
						</fieldset>
						<fieldset>
							<h2>Review</h2>
							<input type="button" name="previous-step"
								class="previous-step"
								value="Previous Step" />
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>