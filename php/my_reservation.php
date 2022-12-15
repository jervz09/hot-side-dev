<?php
  $current_reserved = $security_page = "";
  switch(@$_GET['page']){
    case 'my_reservation':
      $current_reserved = "active";
    break;
    case 'history':
      $history_reserved = "active";
    break;
    default:
      $current_reserved = "active";
    break;
  }

?>
<section id="profile_top_title" class="about-us-area">
<div class="container">
  <div class="row align-items-center">
    <div class="col-12 col-lg-12">
      <div class="about-text mb-100">
        <div class="section-heading">
          <div class="line-"></div>
          <h2>Reservation</h2>
        </div>
        <!-- Form Start -->
        <div class="row">
          <!-- <div class="col col-sm-4 col-md-3">
            <div class="card category-list-container booking-form p-2">
              <div class="list-group category-list">
                <tr>
                  <a href='my_reservation.php?page=current' class='btn list-group-item list-group-item-action <?=$current_reserved?>'>
                    <i class="fa fa-user"></i> My Reservation</a>
                  <a href='my_reservation.php?page=security' class='btn list-group-item list-group-item-action <?=$security_page?>'>
                    <i class="fa fa-lock"></i> History</a>
                </tr>
              </div>
            </div>
          </div> -->
          <div class="col col-sm-12 col-md-12">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#all_reserved">All reservation
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#ongoing_reservation">Ongoing
                </a>
            </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#complete">Complete
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#cancelled">Cancelled/Declined
                </a>
              </li>
            </ul>
            <?php
               switch(@$_GET['page']){
                case 'my_reservation':
                  include('./php/current_reserved.php');
                break;
                case 'history':
                  include('./php/history_reserved.php');
                break;
                default:
                  include('./php/current_reserved.php');
                break;
              }
          ?>
          <!-- Form End -->
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<script>

window.addEventListener('DOMContentLoaded', function (){
  $('#update_profile').submit(function(e){
    e.preventDefault();
    $('.pop_msg').remove()
    var _this = $(this)
    var _el = $('<div>')
        _el.addClass('pop_msg')
    $('#universal_modal button').attr('disabled',true)
    $('#universal_modal button[type="submit"]').text('submitting form...')

    $.ajax({
        url:'./admin/helper/init.php?a=update_user',
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

window.addEventListener('DOMContentLoaded', function (){
  $('#update_security').submit(function(e){
      e.preventDefault();
      $('.pop_msg').remove()
      var _this = $(this)
      var _el = $('<div>')
          _el.addClass('pop_msg')
      $('#universal_modal button').attr('disabled',true)
      $('#universal_modal button[type="submit"]').text('submitting form...')

      $.ajax({
          url:'./admin/helper/init.php?a=validate_update_password',
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