<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" if="logout_session" href="../logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reservation_modal" tabindex="-1" role="dialog" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationModalLabel">Reservation</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            <form>

                <div class="form-outline mb-4">
                    <input type="text" id="yournameForm" class="form-control form-control-lg"
                        value="<?=$_SESSION['first_name'].$_SESSION['last_name']?>" readonly />
                    <label class="form-label" for="yournameForm" style="margin-left: 0px;">
                        Your Name
                    </label>
                    <div class="form-notch">
                        <div class="form-notch-leading" style="width: 9px;"></div>
                        <div class="form-notch-middle" style="width: 71.2px;"></div>
                        <div class="form-notch-trailing"></div>
                    </div>
                </div>

                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="text" id="emailForm" class="form-control form-control-lg"
                        value="<?=$_SESSION['email']?>" readonly />
                    <label class="form-label" for="emailForm" style="margin-left: 0px;">
                        Email Address
                    </label>
                    <div class="form-notch">
                        <div class="form-notch-leading" style="width: 9px;"></div>
                        <div class="form-notch-middle" style="width: 71.2px;"></div>
                        <div class="form-notch-trailing"></div>
                    </div>
                </div>

                <!-- Contact input -->
                <div class="form-outline mb-4">
                    <input type="text" id="contactNoForm" class="form-control form-control-lg"
                        value="<?=$_SESSION['contact_no']?>" />
                    <label class="form-label" for="contactNoForm" style="margin-left: 0px;">
                        Contact No
                    </label>
                    <div class="form-notch">
                        <div class="form-notch-leading" style="width: 9px;"></div>
                        <div class="form-notch-middle" style="width: 71.2px;"></div>
                        <div class="form-notch-trailing"></div>
                    </div>
                </div>

                <!-- Address input -->
                <div class="form-outline mb-4">
                    <input type="text" id="addressForm" class="form-control form-control-lg"
                        value="<?=$_SESSION['address']?>" />
                    <label class="form-label" for="addressForm" style="margin-left: 0px;">
                        Address
                    </label>
                    <div class="form-notch">
                        <div class="form-notch-leading" style="width: 9px;"></div>
                        <div class="form-notch-middle" style="width: 71.2px;"></div>
                        <div class="form-notch-trailing"></div>
                    </div>
                </div>

                <!-- Landmark input -->
                <div class="form-outline mb-4">
                    <input type="text" id="landmarkForm" class="form-control form-control-lg"
                        value="<?=$_SESSION['landmark']?>" />
                    <label class="form-label" for="landmarkForm" style="margin-left: 0px;">
                        Landmark
                    </label>
                    <div class="form-notch">
                        <div class="form-notch-leading" style="width: 9px;"></div>
                        <div class="form-notch-middle" style="width: 71.2px;"></div>
                        <div class="form-notch-trailing"></div>
                    </div>
                </div>

                <!-- Landmark input -->
                <div class="form-outline mb-4">
                    <textarea id="adtlForm" class="form-control form-control-lg" id="note" rows="3"></textarea>
                    <label class="form-label" for="landmarkForm" style="margin-left: 0px;">
                        Additional information
                    </label>
                    <div class="form-notch">
                        <div class="form-notch-leading" style="width: 9px;"></div>
                        <div class="form-notch-middle" style="width: 71.2px;"></div>
                        <div class="form-notch-trailing"></div>
                    </div>
                </div>

            <hr>
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block ">Reserve</button>
        </form>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary cancel-modal-reserve" type="button" data-dismiss="modal">Cancel</button>
                <!-- <a class="btn btn-primary" if="logout_session" href="../logout.php">Logout</a> -->
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal fade" id="universal_modal" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer py-1">
        <button type="button" class="btn btn-sm btn-primary" id='submit' onclick="$('#universal_modal form').submit()">Save</button>
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->

<div class="modal fade" id="universal_modal" tabindex="-1" role="dialog" aria-labelledby="universalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="universalModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-primary" id='submit' onclick="$('#universal_modal form').submit()">Save</button>
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="universal_modal_secondary" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer py-1">
        <button type="button" class="btn btn-sm btn-primary" id='submit' onclick="$('#universal_modal form').submit()">Save</button>
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <div id="delete_content"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger" id='confirm' onclick="">Yes</button>
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">No</button>
          </div>
        </div>
    </div>
</div>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" if="logout_session" href="../logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>