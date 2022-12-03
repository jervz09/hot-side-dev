<?php
include('../controllers/db_con.php');
$disabled = $enabled = $is_admin = $is_user = "";
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * from users where `user_id` = '{$_GET['id']}'");
        foreach(mysqli_fetch_assoc($qry) as $k => $v){
            $$k = $v;
        }
    }

    if(isset($is_delete)){
      if($is_delete == '0'){
        $enabled = "selected";
      }elseif($is_delete == 1){
        $disabled = "selected";
      }
    }
    if(isset($role_id)){
      if($role_id == '0'){
        $is_user = "selected";
      }elseif($role_id == 1){
        $is_admin = "selected";
      }
    }
?>
<div class="container-fluid">
  <form method="" style="width: 100%" id="update_user_form">
<?php
if(isset($_GET['id'])){ ?>
    <input type="hidden" name="user_id" value="<?php echo isset($user_id)? $user_id : '' ?>">
<?php } ?>
    <table class="table table-bordered">
      <tr>
        <td class="text-bold" style="width:40%">Username:</td>
        <td class="ps-4"><input class="form-control" type="text" name="username"
          value="<?php echo isset($username) ? $username : '' ?>"></td>
      </tr>
      <tr>
        <td class="text-bold">Email:</td>
        <td class="ps-4"><input class="form-control" type="email" name="email"
          value="<?php echo isset($email) ? $email : '' ?>"></td>
      </tr>
      <?php if(!isset($_GET['id'])) {?>
      <tr>
        <td class="text-bold">Password:</td>
        <td class="ps-4"><input class="form-control" type="password" name="password"></td>
      </tr>
      <?php } ?>
      <tr>
        <td class="text-bold">Contact Number:</td>
        <td class="ps-4"><input class="form-control" type="number" name="contact_no"
          value="<?php echo isset($contact_no) ? "0".$contact_no : '' ?>"></td>
      </tr>
      <tr>
        <td class="text-bold">Role:</td>
        <td class="ps-4">
          <select name="role_id" id="status" class="form-control form-select">
            <option value="0" <?= $is_user?>>User</option>
            <option value="1" <?= $is_admin?>>Admin</option>
          </select>
        </td>
      </tr>
      <!-- <tr>
        <td class="text-bold">Status:</td>
        <td class="ps-4">
          <select name="is_delete" id="status" class="form-control form-select">
            <option value="0" $enabled?>>Enabled</option>
            <option value="1" $disabled?>>Disabled</option>
          </select>
        </td>
      </tr> -->
    </table>
  </form>
</div>
<script>
    $(function(){
        $('#update_user_form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#universal_modal button').attr('disabled',true)
            $('#universal_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'./helper/init.php?a=update_user',
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