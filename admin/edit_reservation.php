<?php
include('../controllers/db_con.php');
$accepted = $no_action = $declined = "";
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT
                            rl.*, u.username, tl.name as tbl_name, tl.party_size
                        FROM
                            reservation_list rl
                                INNER JOIN
                            users u ON u.user_id = rl.user_id
                                INNER JOIN
                            table_list tl ON tl.table_no = rl.table_id
                            WHERE rl.reservation_id = '{$_GET['id']}'");
        foreach(mysqli_fetch_assoc($qry) as $k => $v){
            $$k = $v;
        }
    }

    if(isset($status)){
      if($status == '0'){
        $no_action = "selected";
      }elseif($status == 1){
        $accepted = "selected";
      }else{
        $declined = "selected";
      }
    }
?>

<div class="container-fluid">
  <form method="" style="width: 100%" id="update_reserve_form">

  <input type="hidden" name="reservation_id" value="<?php echo isset($reservation_id)? $reservation_id : '' ?>">
  <input type="hidden" name="reason" id="reason">
    <table class="table table-bordered table-hover">
      <tr>
        <td class="text-bold" style="width:40%">Username:</td>
        <td class="ps-4"><?php echo isset($username) ? $username : '' ?> </td>
      </tr>
      <tr>
        <td class="text-bold">Table Name:</td>
        <td class="ps-4"><?php echo isset($tbl_name) ? $tbl_name : '' ?> </td>
      </tr>
      <tr>
        <td class="text-bold">Party Size:</td>
        <td class="ps-4"><?php echo isset($party_size) ? $party_size : '' ?> </td>
      </tr>
      <tr>
        <td class="text-bold">Status:</td>
        <td class="ps-4">
          <select name="status" id="status" class="form-control form-select">
            <option value="0" <?= $no_action?>>No Action</option>
            <option value="1" <?= $accepted?>>Accepted</option>
            <option value="2" <?= $declined?>>Declined</option>
          </select>
        </td>
      </tr>
    </table>
  </form>
</div>
<script>
    $(function(){
        $('#update_reserve_form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#universal_modal button').attr('disabled',true)
            $('#universal_modal button[type="submit"]').text('submitting form...')
            if($('#status').val() == 2){
              $('#reason').val('Declined by Admin')
            }
            console.log(new FormData($(this)[0]))
            $.ajax({
                url:'./helper/init.php?a=update_reservation_status',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
                    console.log(new FormData($(this)[0]))
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
                        setTimeout(function(){location.reload();}, 1500)
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#universal_modal button').attr('disabled',false)
                     $('#universal_modal button[type="submit"]').text('Save')
                }
            })
        })
    })
</script>