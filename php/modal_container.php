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
            <div class="row ">
                <div class="col">
                <div class="form-outline">
                    <input type="text" id="first_name" class="form-control" />
                    <label class="form-label" for="first_name">First name</label>
                </div>
                </div>
                <div class="col">
                <div class="form-outline">
                    <input type="text" id="last_name" class="form-control" />
                    <label class="form-label" for="last_name">Last name</label>
                </div>
                </div>
            </div>

            <!-- Text input -->
            <div class="form-outline ">
                <input type="email" id="email" class="form-control" />
                <label class="form-label" for="email">Company name</label>
            </div>

            <!-- Text input -->
            <div class="form-outline ">
                <input type="text" id="form6Example4" class="form-control" />
                <label class="form-label" for="form6Example4">Address</label>
            </div>

            <!-- Email input -->
            <div class="form-outline ">
                <input type="email" id="form6Example5" class="form-control" />
                <label class="form-label" for="form6Example5">Email</label>
            </div>

            <!-- Number input -->
            <div class="form-outline ">
                <input type="number" id="form6Example6" class="form-control" />
                <label class="form-label" for="form6Example6">Phone</label>
            </div>

            <!-- Message input -->
            <div class="form-outline ">
                <textarea class="form-control" id="note" rows="4"></textarea>
                <label class="form-label" for="note">Additional information</label>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block ">Place order</button>
        </form>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" if="logout_session" href="../logout.php">Logout</a>
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