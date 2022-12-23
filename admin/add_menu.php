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

  <div class="alert" role="alert"></div>
  <div class="modal fade" id="modal_avatar" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Crop the image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="img-container">
            <img id="image" src="">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="crop">Crop</button>
        </div>
        </div>
    </div>
  </div>

  <form method="" style="width: 100%" id="update_menu_form">
    <input type="hidden" name="menu_id" value="<?php echo isset($menu_id) ? $menu_id : '' ?>">
    <table class="table table-bordered table-hover">
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
            <option value="0">Enabled</option>
            <option value="1">Disabled</option>
          </select>
        </td>
      </tr>
      <tr>
        <td class="text-bold">
          <label class="label btn btn-primary btn-icon-split" data-toggle="tooltip" title="Menu Image">
            <span class="icon text-white-50">
                <i class="fas fa-file-image"></i>
            </span>
            <span class="text">Upload Image</span>
            <input type="file" class="sr-only" id="menu_image" accept="image/*">
            <input type="hidden" name="base_menu_image" id="base_menu_image">
          </label>
        </td>
        <td>
          <img src="<?php echo isset($base_menu_image) ? $base_menu_image : '' ?>" id="avatar" width="100%" height="auto">
        </td>
      </tr>

    </table>
  </form>
</div>

<script src="../js/cropper/cropper.js"></script>
  <script>

    $(function(){
      console.log(123)
      var avatar = document.getElementById('avatar');
      var image = document.getElementById('image');
      var input = document.getElementById('menu_image');
      var $progress = $('.progress');
      var $progressBar = $('.progress-bar');
      var $alert = $('.alert');
      var $modal = $('#modal_avatar');
      var cropper;

      $('[data-toggle="tooltip"]').tooltip();
      input.addEventListener('click', function (e) {
        console.log('eun123')
        input.value = null;
      })
      input.addEventListener('change', function (e) {
        console.log('eun')
        var files = e.target.files;
        var done = function (url) {
          input.value = null;
          image.src = url;
          $alert.hide();
          $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
          file = files[0];

          if (URL) {
            done(URL.createObjectURL(file));
          } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
              done(reader.result);
            };
            reader.readAsDataURL(file);
          }
        }
      });

      $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
          aspectRatio: 1,
          viewMode: 3,
        });
      }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
      });

      document.getElementById('crop').addEventListener('click', function () {
        var initialAvatarURL;
        var canvas;
        var crop_src;

        $modal.modal('hide');

        if (cropper) {
          canvas = cropper.getCroppedCanvas({
            width: 500,
            height: 500,
          });
          initialAvatarURL = avatar.src;
          crop_src = canvas.toDataURL();
          $('#avatar').attr("src", crop_src)
          console.log(crop_src)
          $('#base_menu_image').val(crop_src)
          $progress.show();
          $alert.removeClass('alert-success alert-warning');
        }
      });
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