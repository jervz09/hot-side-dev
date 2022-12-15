<?php
include('../controllers/db_con.php');
$accepted = $no_action = $declined = "";
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM reasons WHERE reason_id = '{$_GET['id']}'");
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
  <?php if(isset($reason_id)){?>
  <input type="hidden" name="reason_id" value="<?php echo isset($reason_id)? $reason_id : '' ?>">
  <?php } ?>
    <table class="table table-bordered table-hover">
      <tr>
        <td class="text-bold" style="width:40%">Reason:</td>
        <td class="ps-4"><textarea name="reason" class="form-control" style="height: 50px;width: 100%;" required><?php echo isset($reason)? $reason : '' ?></textarea></td>
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
            console.log(new FormData($(this)[0]))
            $.ajax({
                url:'./helper/init.php?a=update_reason',
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