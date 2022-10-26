<script>
  $(function() {
    $('#datetime_picker_reserve').datetimepicker({
      inline: true,
      sideBySide: true
    });
    $('#to_reserve').on("click", function(e) {
      timepicker_hour = $('.timepicker-hour').text()
      timepicker_minute = $('.timepicker-minute').text()
      togglePeriod = $('[data-action="togglePeriod"]').text()
      if (!s_table) {
        alertify.error("Please select a table");
      } else {
        s_date = $('td.active').text()
        // selected_msg = `selected: table = ${s_table} , date = ${s_date}, time = ${timepicker_hour}:${timepicker_minute} ${togglePeriod}`
        $('#reservation_modal').modal('show');
        // alertify.success(selected_msg)
      }
    });
  });
  $('.cancel-modal-reserve').click(function() {
    $('#reservation_modal').modal('hide');
  })
  $('button.success').click(function() {
    alertify.success('Submitted. Wait for approval.');
  });
  var currentGfgStep, nextGfgStep, previousGfgStep;
  var opacity;
  var current = 1;
  var steps = $("fieldset").length;
  setProgressBar(current);
  $(".next-step").click(function() {
    currentGfgStep = $(this).parent();
    nextGfgStep = $(this).parent().next();
    $("#progressbar li").eq($("fieldset").index(nextGfgStep)).addClass("active");
    nextGfgStep.show();
    currentGfgStep.animate({
      opacity: 0
    }, {
      step: function(now) {
        opacity = 1 - now;
        currentGfgStep.css({
          'display': 'none',
          'position': 'relative'
        });
        nextGfgStep.css({
          'opacity': opacity
        });
      },
      duration: 500
    });
    setProgressBar(++current);
    window.dispatchEvent(new Event('resize'));
    console.log(s_table)
  });
  $(".previous-step").click(function() {
    currentGfgStep = $(this).parent();
    previousGfgStep = $(this).parent().prev();
    $("#progressbar li").eq($("fieldset").index(currentGfgStep)).removeClass("active");
    console.log(previousGfgStep)
    previousGfgStep.show();
    currentGfgStep.animate({
      opacity: 0
    }, {
      step: function(now) {
        opacity = 1 - now;
        currentGfgStep.css({
          'display': 'none',
          'position': 'relative'
        });
        previousGfgStep.css({
          'opacity': opacity
        });
      },
      duration: 500
    });
    setProgressBar(--current);
    window.dispatchEvent(new Event('resize'));
    console.log(s_table)
  });

  function setProgressBar(currentStep) {
    var percent = parseFloat(100 / steps) * current;
    percent = percent.toFixed();
    $(".progress-bar").css("width", percent + "%")
  }
  $(".submit").click(function() {
    return false;
  })
  var tbl = $.parseJSON('<?=json_encode($tbl)?>')
  function map_tbls() {
        if (Object.keys(tbl).length > 0) {
          $('#fp-map').html('')
          Object.keys(tbl).map(k => {
              var data = tbl[k]
              var area = $("<area shape='rect'>")
                area.attr('href', "javascript:void(0)")
				area.attr('data-id', data.id)
				var perc = data.coordinates
                perc = perc.replace(" ", '')
				perc = perc.split(",")
				var x = $('#fp-img').width() * perc[0];
                var y = $('#fp-img').height() * perc[1];
                var width = ($('#fp-img').width() * perc[2]) - x;
                var height = ($('#fp-img').height() * perc[3]) - y;
				area.attr('area-id', data.table_no)
				area.attr('coords', x + ", " + y + ", " + width + ", " + height)
				area.text("#" + data.table_no)
				area.addClass('fw-bolder text-muted')
				area.css({
                  'position': 'absolute',
                  // 'border':"1px solid blue",
                  'height': height + 'px',
                  'width': width + 'px',
                  'top': y + 'px',
                  'left': x + 'px',
                  'display': 'flex',
                  'text-align': 'center',
                  'justify-content': 'center',
                  'align-items': 'center',
                })
				$('#fp-map').append(area)
				area.click(function() {
                  // universal_modal('Table Reservation',"./php/manage_reservation.php?table_id="+data.id)
                  $("[shape='rect']").removeClass("selected-table")
                  $(`[area-id="${data.table_no}"]`).addClass("selected-table");
                  s_table = data.table_no
                })
              })
          }
        }
        map_tbls()
        $(window).on('resize', function() {
          map_tbls()
        })
        window.dispatchEvent(new Event('resize'));
        var _date = new Date()
        var today = _date.toISOString().split('T')[0];
        var currentTime = _date.getHours() + ':' + _date.getMinutes();
        currentTime = _date.toTimeString().substring(0, 5);
        // document.getElementsByName("reserved_date")[0].setAttribute('min', today);
        $('#reserved_date').val(today)
        $('#reserved_time').val(currentTime)
        $('.category-list a').click(function(e) {
          $('.category-list a.active').removeClass('active');
          // var $parent = $(this).parent();
          $(this).addClass('active');
          e.preventDefault();
        });
        // $(".head-step").sticky({topSpacing:105});
        // $(".booking-form").sticky({topSpacing:140});
        // $.stickysidebarscroll(".head-step",{offset: {top: 105, bottom: 200}});
        // $.stickysidebarscroll(".booking-form",{offset: {top: 140, bottom: 10}});
        $('.close-icon').on('click', function() {
          $(this).closest('.card-body').fadeOut();
        })
</script>