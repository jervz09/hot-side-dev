<?php
require_once("../controllers/db_con.php");
if(isset($_GET['table_id'])){
    $qry = $conn->query("SELECT * FROM `table_list` where table_id = '{$_GET['table_id']}'");
        foreach(mysqli_fetch_assoc($qry) as $k => $v){
            $$k = $v;
        }
    }
?>
<div class="container-fluid">
    <table class="table table-bordered">
        <tr>
          <td class="details_tbl text-bold">Table No:</td>
          <td class="details_tbl"># <?php echo isset($table_no) ? $table_no : '' ?> </td>
        </tr>
        <tr>
          <td class="details_tbl text-bold">Name:</td>
          <td class="details_tbl ps-4"><?php echo isset($name) ? $name : '' ?> </td>
        </tr>
        <tr>
          <td class="details_tbl text-bold">Description:</td>
          <td class="details_tbl ps-4"><?php echo isset($description) ? $description : '' ?> </td>
        </tr>
        <tr>
          <td class="details_tbl text-bold">Status:</td>
          <td class="details_tbl ps-4">
            <span id="status">
              <?php if($status == 0): ?>

              <button href="" class="btn btn-warning btn-xs">
                <i class="fas fa-exclamation-circle"></i> Unavailable
              </button>
              <?php else: ?>
              <button href="" class="btn btn-success btn-xs">
                <i class="fas fa-check"></i> Available
              </button>
              <?php endif; ?>
            </span>
          </td>
        </tr>
      </table>
        <dt class="text-info">Table No<dt>
        <dd class="ps-4">#<?php echo isset($table_no) ? $table_no : "" ?><dd>
        <dt class="text-info">Name<dt>
        <dd class="ps-4"><?php echo isset($name) ? $name : "" ?><dd>
        <dt class="text-info">Desctiption<dt>
        <dd class="ps-4"><?php echo isset($description) ? $description : "" ?><dd>
        <hr>
    <fieldset>
        <legend class="text-info">Reservation Form</legend>
        <form action="" id="reservation-form">
            <input type="hidden" name="id" value="">
            <input type="hidden" name="table_id" value="<?php echo isset($_GET['table_id']) ? $_GET['table_id'] : "" ?>">
            <div class="form-group">
                <label for="customer_name" class="control-label">Fullname</label>
                <input type="text" name="customer_name" autofocus id="customer_name" required class="form-control form-control-sm rounded-0" value="<?php echo isset($customer_name) ? $customer_name : '' ?>">
            </div>
            <div class="form-group">
                <label for="contact" class="control-label">Contact</label>
                <input type="text" name="contact" autofocus id="contact" required class="form-control form-control-sm rounded-0" value="<?php echo isset($contact) ? $contact : '' ?>">
            </div>
            <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input type="email" name="email" autofocus id="email" required class="form-control form-control-sm rounded-0" value="<?php echo isset($email) ? $email : '' ?>">
            </div>
            <div class="form-group">
                <label for="address" class="control-label">Address</label>
                <textarea rows="2" name="address" id="address" required class="form-control form-control-sm rounded-0"><?php echo isset($address)? $address : '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="datetime" class="control-label">Reservation Date and Time</label>
                <input type="datetime-local" name="datetime" autofocus id="datetime" required class="form-control form-control-sm rounded-0" value="<?php echo isset($datetime) ? $datetime : '' ?>">
            </div>
        </form>
    </fieldset>
</div>

<script>
    $(function(){
        $('#reservation-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#uni_modal button').attr('disabled',true)
            $('#uni_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'./Actions.php?a=save_reservation',
                method:'POST',
                data:$(this).serialize(),
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        _el.addClass('alert alert-success')
                            location.reload()
                        if("<?php echo isset($reservation_id) ?>" != 1)
                        _this.get(0).reset();
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                }
            })
        })
    })
</script>