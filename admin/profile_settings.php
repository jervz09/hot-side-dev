<style>
    *{
        font-size: 14px;
    },
    input.form-control.form-control-user.focus-brand {
        font-size: 14px;
    }
    .label {
      cursor: pointer;
    }

    .progress {
      display: none;
      margin-bottom: 1rem;
    }

    .alert {
      display: none;
    }

    .img-container img {
      max-width: 100%;
    }
</style>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">Profile Settings</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <label class="label" data-toggle="tooltip" title="Change your avatar">
                       <i class="fa fa-image"></i> Upload Image
                        <input type="file" class="sr-only" id="input" name="avatar_input" accept="image/*">
                        </label>
                        <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                        <div class="alert" role="alert"></div>
                        <div class="modal fade" id="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                    <img src="<?=$profile_img?>" id="avatar" width="100%" height="auto">
                </div>
                <div class="col-lg-9">
                    <div class="p-5">
                        <form method="post" id="update_user_form">
                            <!-- Display if exists error. or  other msg alert-->
                            <?php if (count($errors) > 0): ?>
                                <div class="alert alert-danger error-message">
                                <?php foreach ($errors as $error): ?>
                                <li>
                                    <?php echo $error; ?>
                                </li>
                                <?php endforeach;?>
                                </div>
                            <?php endif;?>

                            <input type="hidden" name="user_id" value="<?=$_SESSION['id']?>">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-user focus-brand"
                                        placeholder="Username" value="<?=$_SESSION['username']?>">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" name="first_name" class="form-control form-control-user focus-brand"
                                        placeholder="First Name" value="<?=$_SESSION['first_name']?>">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="last_name" class="form-control form-control-user focus-brand"
                                        placeholder="Last Name" value="<?=$_SESSION['last_name']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user focus-brand"
                                    placeholder="Email Address" value="<?=$_SESSION['email']?>">
                            </div>
                            <div class="form-group">
                                <input type="text" name="contact_no" class="form-control form-control-user focus-brand"
                                    placeholder="Contact No" value="<?=$_SESSION['contact_no']?>">
                            </div>
                            <div class="form-group">
                            <textarea  name="profile_img" id="profile_img" class="form-control d-none"><?=$profile_img?></textarea>
                                <!-- <input type="text" name="profile_img" id="profile_img" class="form-control form-control-user focus-brand"
                                    placeholder="profile img" value="?=$_SESSION['profile_img']?>"> -->
                            </div>
                            <button type="submit" name="signup-btn" class="btn btn-primary btn-user btn-block">Register Account</button>
                            <hr>
                        </form>
                        <hr>
                    </div>
                </div>
        </div>
    </div>

</div>
<script src="../js/cropper/cropper.js"></script>
  <script>
    window.addEventListener('DOMContentLoaded', function () {
      var avatar = document.getElementById('avatar');
      var image = document.getElementById('image');
      var input = document.getElementById('input');
      var $progress = $('.progress');
      var $progressBar = $('.progress-bar');
      var $alert = $('.alert');
      var $modal = $('#modal');
      var cropper;

      $('[data-toggle="tooltip"]').tooltip();

      input.addEventListener('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
          input.value = '';
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
          $('#profile_img').val(crop_src)
          $progress.show();
          $alert.removeClass('alert-success alert-warning');
        }
      });


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
    });


  </script>