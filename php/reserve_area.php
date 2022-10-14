<?php
$start = $month = strtotime('today');
$end = strtotime('9 months');
?>
    <div class="book-now-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="book-now-form">
                    <form action="#">
                        <!-- Form Group -->
                        <div class="form-group">
                            <label for="select_month">Month</label>
                            <select class="form-control" id="select_month">
                                <?php
                                while($month < $end)
                                {
                                    echo "<option>".date('F', $month)."</option>";
                                    $month = strtotime("+1 month", $month);
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label for="select2">Day</label>
                            <select class="form-control" id="select2">
                                <?php
                                for($i = 1; $i < 31; ++$i) {
                                    echo "<option>".$i."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label for="select3">Table Capacity</label>
                            <select class="form-control" id="select3">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                              <option>5</option>
                              <option>6</option>
                            </select>
                        </div>

                        <!-- Form Group -->
                        <!-- <div class="form-group">
                            <label for="select4">Childrens</label>
                            <select class="form-control" id="select4">
                              <option>01</option>
                              <option>02</option>
                              <option>03</option>
                              <option>04</option>
                              <option>05</option>
                            </select>
                        </div> -->

                        <!-- Button -->
                        <button onclick="location.href='reserve.php'" type="button">Reserve Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>