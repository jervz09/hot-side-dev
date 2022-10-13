<script>
     $(function () {
          $('#datetime_picker_reserve').datetimepicker({
              inline: true,
              sideBySide: true
          });

          $('#to_reserve').on("click", function(e){
            timepicker_hour = $('.timepicker-hour').text()
            timepicker_minute = $('.timepicker-minute').text()
            togglePeriod=$('[data-action="togglePeriod"]').text()
            if(!s_table){
                alertify.error("Please select a table");
            }else{
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

    var tbl = $.parseJSON('<?php echo json_encode($tbl) ?>')
    function map_tbls(){
        if(Object.keys(tbl).length > 0){

            $('#fp-map').html('')

            Object.keys(tbl).map(k=>{
                var data = tbl[k]
                var area = $("<area shape='rect'>")
                    area.attr('href',"javascript:void(0)")
                var perc = data.coordinates
                perc = perc.replace(" ",'')
                perc = perc.split(",")
                var x = $('#fp-img').width() * perc[0];
                var y = $('#fp-img').height() * perc[1];
                var width = ($('#fp-img').width() * perc[2]) - x;
                var height = ($('#fp-img').height() * perc[3]) - y;
                area.attr('area-id',data.table_no)
                area.attr('coords',x+", "+y+", "+width+", "+height)
                area.text("#"+data.table_no)
                area.addClass('fw-bolder text-muted')
                area.css({
                    'position':'absolute',
                    // 'border':"1px solid blue",
                    'height':height+'px',
                    'width':width+'px',
                    'top':y+'px',
                    'left':x+'px',
                    'display':'flex',
                    'text-align':'center',
                    'justify-content':'center',
                    'align-items':'center',
                })
                $('#fp-map').append(area)
                area.click(function(){
                    console.log(this)
                    // universal_modal('Table Reservation',"./php/manage_reservation.php?table_id="+data.id)
                    $("[shape='rect']").removeClass("selected-table")
                    $(`[area-id="${data.table_no}"]`).addClass("selected-table");
                    s_table = data.table_no
                })
            })
        }
    }
    $(function(){
        map_tbls()
        $(window).on('resize',function(){
            map_tbls()
        })
    })

    $('#date-picker-container').hide();
    $('#reserved_confirm').hide();
    $('#back_datepicker').hide();

    $('#next_datepicker').click(function(){
        if(!s_table){
            alertify.error("Please select Table.")
        }else{
            $('#floor-plan-container').hide();
            $('#next_datepicker').hide();
            $('#date-picker-container').show();
            $('#reserved_confirm').show();
            $('#back_datepicker').show();
        }
    })

    $('#back_datepicker').click(function(){
        $('#floor-plan-container').show();
        $('#next_datepicker').show();
        $('#date-picker-container').hide();
        $('#reserved_confirm').hide();
        $('#back_datepicker').hide();
    })

    $('#reserved_confirm').click(function(){
        $('#reserve_confirm_modal').modal('show');
    })
    // reserve_confirm_modal

</script>