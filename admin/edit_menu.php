<?php
include('../controllers/db_con.php');
$disabled = $enabled = "";
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * from menu_list where menu_id = '{$_GET['id']}'");
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
?>

<div class="container-fluid">
  <form method="" style="width: 100%" id="update_menu_form">

  <input type="hidden" name="menu_id" value="<?php echo isset($menu_id)? $menu_id : '' ?>">
    <table class="table table-bordered">
      <tr>
        <td class="text-bold" style="width:40%">Name:</td>
        <td class="ps-4"><input class="form-control" type="text" name="name"
          value="<?php echo isset($name) ? $name : '' ?>"></td>
      </tr>
      <tr>
        <td class="text-bold">Type:</td>
        <td class="ps-4"><input class="form-control" type="text" name="type"
          value="<?php echo isset($type) ? $type : '' ?>"></td>
      </tr>
      <tr>
        <td class="text-bold">Price:</td>
        <td class="ps-4"><input class="form-control" type="number" name="price"
          value="<?php echo isset($price) ? $price : '' ?>"></td>
      </tr>
      <tr>
        <td class="text-bold">Status:</td>
        <td class="ps-4">
          <select name="is_delete" id="status" class="form-control form-select">
            <option value="0" <?= $enabled?>>Enabled</option>
            <option value="1" <?= $disabled?>>Disabled</option>
          </select>
        </td>
      </tr>
    </table>
  </form>
</div>
<script>
    $(function(){
        $('#update_menu_form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#universal_modal button').attr('disabled',true)
            $('#universal_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'./helper/init.php?a=update_menu',
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