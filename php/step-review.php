<div class="row">
  <div class="col col-md-6">
    <div class="booking-form">
      <!-- <form> -->
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <span class="form-label">Party Size</span>
              <input class="form-control" name="selected_party_size" id="selected_party_size" type="text" readonly>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <span class="form-label">Table No.</span>
              <input class="form-control" name="selected_table_no" id="selected_table_no" type="text" readonly>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <span class="form-label">Date</span>
            <input class="form-control" name="selected_reserved_date" id="selected_reserved_date" type="date" min="2022-10-01" readonly>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <span class="form-label">Time</span>
            <input class="form-control" name="selected_reserved_time" id="selected_reserved_time" type="time" readonly>
          </div>
        </div>
      </div>
      <!-- </form> -->
    </div>
  </div>
  <div class="col col-md-6 float-right">
    <div class="booking-form">
      <div class="row">
        <div class="col-sm-12">
          <!-- <span class="form-label">Available Tables</span> -->
          <table class="table table-summary-orders" style="display:none">
            <thead>
              <tr data-id="tr_ordered">
                  <td class="col top-border-brand text-left text-bold" style="width:70%">Menu </th>
                  <td class="col top-border-brand text-center">Qty</td>
                  <td class="col top-border-brand text-center">Price</td>
              </tr>
            </thead>
            <tfoot data-review="review_order_footer">
              <!-- if order is true -->
            </tfoot>
            <tbody data-review="review_order">
              <!-- if order is true -->
            </tbody>
          </table>
          <br>
              <div class="form-btn">
                <button class="submit-btn btn-branding" id="submit_reserved">Reserve</button>
              </div>
        </div>
      </div>
    </div>
  </div>
</div>