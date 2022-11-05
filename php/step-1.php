<div class="row">
  <div class="col col-md-6">
    <div class="booking-form">
      <!-- <form> -->
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <span class="form-label">Party Size</span>
            <select class="form-control" data-id="party_size">
              <option>1 person</option>
              <option>2 people</option>
              <option>3 people</option>
              <option>4 people</option>
              <option>5 people</option>
              <option>6 people</option>
            </select>
            <span class="select-arrow"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <span class="form-label">Date</span>
            <input class="form-control" name="reserved_date" id="reserved_date" type="date" min="2022-10-01" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <span class="form-label">Time</span>
            <input class="form-control" name="reserved_time" id="reserved_time" type="time" required>
          </div>
        </div>
      </div>
      <div class="form-btn">
        <button class="submit-btn btn-branding" id="check_availability">Check availability</button>
      </div>
      <!-- </form> -->
    </div>
  </div>
  <div class="col col-md-6 float-right">
    <div class="booking-form">
      <div class="row">
        <div class="col-sm-12">
          <!-- <span class="form-label">Available Tables</span> -->
          <table class="table">
            <tbody data-id="available_tables">

              <!-- <tr><td>Available Tables</td><td>4</td></tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>