<?php
include('../controllers/db_con.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `table_list` where table_id = '{$_GET['id']}'");
        foreach(mysqli_fetch_assoc($qry) as $k => $v){
            $$k = $v;
        }
    }
?>
<div class="container-fluid">
<form action="" id="table-form">
    <input type="hidden" name="id" value="<?php echo isset($table_id)? $table_id : '' ?>">
    <input type="hidden" name="coordinates" value="<?php echo isset($coordinates)? $coordinates : "{$_GET['x']}, {$_GET['y']}, {$_GET['w']}, {$_GET['h']}" ?>">
    <div class="form-group">
        <label for="table_no" class="control-label">Table Number</label>
        <input type="Number" name="table_no" id="table_no" required class="form-control form-control-sm" value="<?php echo isset($table_no)? $table_no : '' ?>">
    </div>
    <div class="form-group">
        <label for="name" class="control-label">Name</label>
        <input type="text" name="name" id="name" required class="form-control form-control-sm" value="<?php echo isset($name)? $name : '' ?>">
    </div>
    <div class="form-group">
        <label for="description" class="control-label">Description</label>
        <textarea rows="2" name="description" id="description" required class="form-control form-control-sm"><?php echo isset($description)? $description : '' ?></textarea>
    </div>
    <?php if(isset($status)): ?>
    <div class="form-group">
        <label for="status" class="control-label">Status</label>
        <select name="status" id="status" class="form-control form-select form-select-sm">
            <option value="1" <?php echo (isset($status) && $status == 1 ) ? 'selected' : '' ?>>Available</option>
            <option value="0" <?php echo (isset($status) && $status == 0 ) ? 'selected' : '' ?>>Unavailable</option>
        </select>
    </div>
    <?php endif; ?>
</form>
</div>

<script>
    $(function(){
        $('#table-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#universal_modal button').attr('disabled',true)
            $('#universal_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'./helper/init.php?a=save_table',
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
                        // $('#universal_modal').on('hide.bs.modal',function(){
                            location.reload()
                        // })
                        if("<?php echo isset($table_id) ?>" != 1)
                        _this.get(0).reset();
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