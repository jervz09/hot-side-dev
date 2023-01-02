<?php
include('../controllers/db_con.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT
                            rl.*, u.username, u.contact_no, u.email, tl.name as tbl_name, tl.party_size
                        FROM
                            reservation_list rl
                                INNER JOIN
                            users u ON u.user_id = rl.user_id
                                INNER JOIN
                            table_list tl ON tl.table_no = rl.table_id
                        WHERE
                            rl.reservation_id = '{$_GET['id']}';");

    }
    while($row = $qry->fetch_assoc()) {
      $username = $row['username'];
      $customer_no = $row['contact_no'];
      $customer_email = $row['email'];
      $party_size = $row['party_size'];
      $reservation_id = $row['reservation_id'];
      $reserved_time = $row['datetime'];
      $tbl_name = $row['tbl_name'];
      $status = $row['status'];
      $reason = $row['reason'];
    }
    $reason_qry = $conn->query("SELECT reason from reasons");

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
        <input type="hidden" id="reservation_id" name="reservation_id" value="<?=$reservation_id?>">
        <input type="hidden" id="status" name="status" value="3">
        <select name="reason" id="reason_cancelation" class="form-control form-select" required>
            <option value="">Select</option>
            <?php
              while($row = $reason_qry->fetch_assoc()) {
            ?>
              <option value="<?=$row['reason']?>"><?=$row['reason']?></option>
            <?php } ?>
            <option value="Others">Others</option>
        </select>

        <textarea rows="4" name="other_reason" id="other_reason" class="form-control mt-3" style="height: 71px; display:none"><?php echo isset($description)? $description : '' ?></textarea>
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
          console.log($('#reservation_id').val())
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
                      // setTimeout(function(){location.reload();}, 1500)
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
                      party_size: "<?=$party_size?>",
                      reservation_dt: "<?=$reserved_time?>",
                      restaurant_no: "(049) 536 4331",
                      customer_name: "<?=$username?>",
                      customer_number: "<?=$customer_no?>",
                      customer_email: "<?=$customer_email?>",
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