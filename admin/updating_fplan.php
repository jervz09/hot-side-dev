<style>
    #img-fp{
        width:calc(100%);
        height:35vh
    }
</style>
<div class="container-fluid">
    <form action="" id="fp-form">
        <div class="form-group">
            <input type="file" name="fp" class="form-control form-control-sm p-1x" id="fp" onchange="readURL(this)" accept="image/png, image/jpeg, image/jpg" required>
        </div>
        <div class="form-group text-center">
            <img src="./helper/uploads/floorplan.png" alt="Floor Plan Image" id="img-fp">
        </div>
    </form>
</div>

<script>
     function readURL(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-fp').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }else{
            $('#img-fp').attr('src', '');
        }
    }
    $(function(){
        $('#fp-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#universal_modal button').attr('disabled',true)
            $('#universal_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'././helper/init.php?a=save_floorplan',
                data: new FormData($(this)[0]),
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
                        $('#universal_modal').on('hide.bs.modal',function(){
                            location.reload()
                        })
                        if("<?php echo isset($department_id) ?>" != 1)
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