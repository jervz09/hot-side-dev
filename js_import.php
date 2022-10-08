
    <!-- ##### All Javascript Script ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>
    <!-- Moment js -->
    <script src="js/moment.js"></script>

    <script src="js/script.js"></script>

    <script src="vendor/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Add jQuery library (required) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script> -->

    <!-- Add the evo-calendar.js for.. obviously, functionality! -->
    <script src="vendor/event-calendar-evo/evo-calendar/js/evo-calendar.min.js"></script>

    <!-- Calendar Data js -->
    <script>

    let s_table = ""
    let s_date = ""
    let timepicker_hour = timepicker_minute = ""
    var tbl = $.parseJSON('<?php echo json_encode($tbl) ?>')
    function map_tbls(){
        if(Object.keys(tbl).length > 0){
            console.log("ewan")
            console.log(Object.keys(tbl))
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
    </script>
