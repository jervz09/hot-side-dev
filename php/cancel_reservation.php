<?php

declare(strict_types=1);

require_once __DIR__ . '/../controllers/db_con.php';

$reservation_id = 0;
$username = '';
$customer_no = '';
$customer_email = '';
$party_size = '';
$reserved_time = '';
$tbl_name = '';
$status = '';
$reason = '';
$found = false;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $reservation_id = (int) $_GET['id'];

    $qry = $conn->prepare('SELECT
            rl.*, u.username, u.contact_no, u.email, tl.name AS tbl_name, tl.party_size
        FROM
            reservation_list rl
                INNER JOIN
            users u ON u.user_id = rl.user_id
                INNER JOIN
            table_list tl ON tl.table_no = rl.table_id
        WHERE
            rl.reservation_id = ?
        LIMIT 1');
    $qry->bind_param('i', $reservation_id);
    $qry->execute();
    $row = $qry->get_result()->fetch_assoc();
    $qry->close();

    if ($row !== null) {
        $found = true;
        $username = (string) $row['username'];
        $customer_no = (string) $row['contact_no'];
        $customer_email = (string) $row['email'];
        $party_size = (string) $row['party_size'];
        $reserved_time = (string) $row['datetime'];
        $tbl_name = (string) $row['tbl_name'];
        $status = (string) $row['status'];
        $reason = (string) $row['reason'];
    }
}

if (!$found) {
    echo '<div class="alert alert-danger m-3">Reservation not found.</div>';
    return;
}

$reason_qry = $conn->query('SELECT reason FROM reasons');

/** Safely embed a PHP value inside inline JS. */
function js(string $value): string
{
    return json_encode($value, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
}
?>
<style>
  #universal_modal .modal-footer {
    display: none;
  }
</style>
<div class="container-fluid">
  <div class="col-12">
    <div class="row">
      <form method="" style="width: 100%" id="cancel_form" class="mb-3">
        <label class="form-label" for="reason">Reason</label>
        <input type="hidden" id="reservation_id" name="reservation_id" value="<?= (int) $reservation_id ?>">
        <input type="hidden" id="status" name="status" value="3">
        <select name="reason" id="reason_cancelation" class="form-control form-select" required>
            <option value="">Select</option>
            <?php while ($rrow = $reason_qry->fetch_assoc()): ?>
              <option value="<?= htmlspecialchars((string) $rrow['reason'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $rrow['reason'], ENT_QUOTES, 'UTF-8') ?></option>
            <?php endwhile; ?>
            <option value="Others">Others</option>
        </select>

        <textarea rows="4" name="other_reason" id="other_reason" class="form-control mt-3" style="height: 71px; display:none"></textarea>
      </form>
    </div>
    <div class="row justify-content-end">
        <button class="btn btn btn-danger mr-2 cancel_reason" type="button">Cancel Reservation</button>
        <button class="btn btn btn-dark" type="button" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
<script>
  $(function(){

    $('#reason_cancelation').on('change', function () {
      let _reason = $(this).val();
      if(_reason == "Others"){
        $('#other_reason').show("slow");
      }else{
        $('#other_reason').val("")
        $('#other_reason').hide("hide");
      }
    })

    $('.cancel_reason').click(function(e){
        e.preventDefault();
        $('.pop_msg').remove()
        var _this = $('#cancel_form')
        var _el = $('<div>')
            _el.addClass('pop_msg')
        if(!$('#reason_cancelation').val()){
          _el.addClass('alert alert-danger')
          _el.text("Reason is required.")
          _this.prepend(_el)
          _el.show('slow')
        }else{
          $('#universal_modal button').attr('disabled',true)
          $('#universal_modal button[type="submit"]').text('submitting form...')
          $.ajax({
              url:'./admin/helper/init.php?a=update_reservation_status',
              data: new FormData($('#cancel_form')[0]),
              cache: false,
              contentType: false,
              processData: false,
              method: 'POST',
              type: 'POST',
              dataType: 'json',
              error:err=>{
                  console.log(err)
                  _el.addClass('alert alert-danger')
                  _el.text("An error occurred.")
                  _this.prepend(_el)
                  _el.show('slow')
                    $('#universal_modal button').attr('disabled',false)
                    $('#universal_modal button[type="submit"]').text('Save')
              },
              success:function(resp){
                  if(resp.status == 'success'){
                      _el.addClass('alert alert-success')
                  }else{
                      _el.addClass('alert alert-danger')
                  }
                  _el.text(resp.msg)

                  _el.hide()
                  _this.prepend(_el)
                  _el.show('slow')
                    $('#universal_modal button').attr('disabled',false)
                    $('#universal_modal button[type="submit"]').text('Save')
                  $.ajax({
                    url: 'controllers/send_email_notification.php',
                    type: "post",
                    data: {
                      party_size: <?= js($party_size) ?>,
                      reservation_dt: <?= js($reserved_time) ?>,
                      restaurant_no: "(049) 536 4331",
                      customer_name: <?= js($username) ?>,
                      customer_number: <?= js($customer_no) ?>,
                      customer_email: <?= js($customer_email) ?>,
                      reservation_status: "Cancelled",
                      reason_cancellation: $('#reason_cancelation').val()
                    },
                    success: function(response) {
                      console.log(response)
                      setTimeout(function(){location.reload();}, 1500)
                    },
                    error:err=>{
                      console.log(err)
                    }
                  });
              }
          })
        }
    })
  })
</script>
