
<!-- <script src="../vendor/select2/js/select2.min.js"></script> -->
<!-- <script src="../vendor/summernote/summernote-lite.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

<script>
        var px1_perc=0,py1_perc=0,px2_perc=0,py2_perc=0;
        var cposX =0,cposY = 0;
        var posX =0,posY = 0;
        var nposX =0,nposY = 0;
        var ctx;
        var isDraw = false;
        var isOff = true;
        var tbl = $.parseJSON('<?php echo json_encode($tbl) ?>')

        var map_tables = {};
        function map_tbls(){
            if(Object.keys(tbl).length > 0){
                $('#fp-map').html('')

                Object.keys(tbl).map(k=>{
                    var data = tbl[k]
                    var area = $("<area class='draggable' shape='rect'>")
                        area.attr('href',"javascript:void(0)")
                        area.attr('data-id',data.id)
                    var perc = data.coordinates
                    perc = perc.replace(" ",'')
                    perc = perc.split(",")
                    var x = $('#fp-img').width() * perc[0];
                    var y = $('#fp-img').height() * perc[1];
                    var width = ($('#fp-img').width() * perc[2]) - x;
                    var height = ($('#fp-img').height() * perc[3]) - y;
                    area.attr('coords',x+", "+y+", "+width+", "+height)
                    area.text("#"+data.table_no)
                    area.addClass('fw-bolder text-muted')
                    area.css({
                        'position':'absolute',
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
                        universal_modal('Table Details',"view_table.php?id="+data.id)
                    })
                })
            }
        }
        $(function(){
            cposX = $('#fp-canvas')[0].getBoundingClientRect().x
            cposY = $('#fp-canvas')[0].getBoundingClientRect().y
            ctx = $('#fp-canvas')[0].getContext('2d');
            map_tbls()
            $(window).on('resize',function(){
                map_tbls()
            })
            $('.edit_data').click(function(){
                universal_modal('Edit Table Details',"manage_table.php?id="+$(this).attr('data-id'))
            })
            $('.delete_data').click(function(){
                _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from list?",'delete_data',[$(this).attr('data-id')])
            })
            $('table td,table th').addClass('align-middle')
            $('table').dataTable({
                columnDefs: [
                    { orderable: false, targets:2 }
                ]
            })

            $('.fp-canvas').on('mousedown',function(e){
                    px1_perc = (e.clientX - cposX)/$('#fp-canvas').width()
                    py1_perc = (e.clientY - cposY)/$('#fp-canvas').height()
                    posX = $('#fp-canvas')[0].width * ((e.clientX - cposX)/$('#fp-canvas').width());
                    posY = $('#fp-canvas')[0].height * ((e.clientY - cposY)/$('#fp-canvas').height());
                    isDraw = true
            })
            $('.fp-canvas').on('mousemove',function(e){
                if(isDraw == false)
                return false;
                nposX = $('#fp-canvas')[0].width * ((e.clientX - cposX)/$('#fp-canvas').width());
                nposY = $('#fp-canvas')[0].height *((e.clientY - cposY)/$('#fp-canvas').height());
                var height = nposY - posY;
                var width = nposX - posX;
                ctx.clearRect(0, 0,  $('.fp-canvas')[0].width, $('.fp-canvas')[0].height);
                ctx.beginPath();
                ctx.lineWidth = "1";
                ctx.strokeStyle = "2b898b";
                ctx.rect(posX, posY, width, height);
                ctx.stroke();
            })
            $('.fp-canvas').on('mouseup',function(e){
                px2_perc = (e.clientX - cposX)/$('#fp-canvas').width()
                py2_perc = (e.clientY - cposY)/$('#fp-canvas').height()
                nposX = $('#fp-canvas')[0].width * ((e.clientX - cposX)/$('#fp-canvas').width());
                nposY = $('#fp-canvas')[0].height *((e.clientY - cposY)/$('#fp-canvas').height());
                var height = nposY - posY;
                var width = nposX - posX;

                ctx.clearRect(0, 0,  $('.fp-canvas')[0].width, $('.fp-canvas')[0].height);
                ctx.beginPath();
                ctx.lineWidth = "1";
                ctx.strokeStyle = "#0f4748";
                ctx.rect(posX, posY, width, height);
                ctx.stroke();
                isDraw = false
                $('#create_table').addClass('vissible')
            })

            $('#draw').click(function(){
                // $(this).hide('slow')
                if(isOff){
                    $('#create_table,#fp-canvas').removeClass('d-none')
                    // $('#fp-map').addClass('d-none')
                    cposX = $('#fp-canvas')[0].getBoundingClientRect().x
                    cposY = $('#fp-canvas')[0].getBoundingClientRect().y
                    ctx = $('#fp-canvas')[0].getContext('2d');
                    isOff = false;
                }else{
                    // $(this).addClass('d-none')
                    $('#create_table,#fp-canvas').addClass('d-none')
                    ctx.clearRect(0, 0,  $('.fp-canvas')[0].width, $('.fp-canvas')[0].height);
                    isOff = true;
                }

            })
            $('#cancel').click(function(){
                $(this).addClass('d-none')
                $('#create_table,#fp-canvas').addClass('d-none')
                $('#draw').show('slow')
                // $('#fp-map').removeClass('d-none')
                ctx.clearRect(0, 0,  $('.fp-canvas')[0].width, $('.fp-canvas')[0].height);

            })
            $('#create_table').click(function(){
                if (!px1_perc && !py1_perc && !px2_perc && !py2_perc){
                    alert("Draw a table.")
                }else{
                    universal_modal("Map Table","manage_table.php?x="+px1_perc+"&y="+py1_perc+"&w="+px2_perc+"&h="+py2_perc)
                }
            })
            $(".draggable").draggable({
                stop: function(event, ui) {
                    console.log($(this).data("id"))
                    console.log($(event.target).width() + " x " + $(event.target).height());
                    console.log(ui.position.top + " x " + ui.position.left);
                }
            });

            //
            $("area").each(function() {
                map_tables[$(this).attr("data-id")] = $(this).val();
            });

            console.log(map_tables);

        })
        function delete_data($id){
            $('#confirm_modal button').attr('disabled',true)
            $.ajax({
                url:'././helper/init.php?a=delete_table',
                method:'POST',
                data:{id:$id},
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    alert("an error occurred.")
                    $('#confirm_modal button').attr('disabled',false)
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload()
                    }else{
                        alert("An error occurred.")
                        $('#confirm_modal button').attr('disabled',false)
                    }
                }
            })
        }

        // const canvas=document.querySelector('#fp-canvas');

        // //canvas on mobile
        // document.body.addEventListener("touchstart", function (e) {
        //     cposX = $('#fp-canvas')[0].getBoundingClientRect().x
        //     cposY = $('#fp-canvas')[0].getBoundingClientRect().y
        //     ctx = $('#fp-canvas')[0].getContext('2d');
        //     if (e.target == canvas) {
        //     e.preventDefault();
        //     clientX = e.touches[0].clientX;
        //     clientY = e.touches[0].clientY;
        //     isDrawing=true;
        //     draw(clientX, clientY)
        //     }
        //     }, false);
        // document.body.addEventListener("touchend", function (e) {
        //     cposX = $('#fp-canvas')[0].getBoundingClientRect().x
        //     cposY = $('#fp-canvas')[0].getBoundingClientRect().y
        //     ctx = $('#fp-canvas')[0].getContext('2d');
        //     if (e.target == canvas) {
        //         e.preventDefault();
        //         isDrawing=false;
        //     }
        //     }, false);
        // document.body.addEventListener("touchmove", function (e) {
        //     cposX = $('#fp-canvas')[0].getBoundingClientRect().x
        //     cposY = $('#fp-canvas')[0].getBoundingClientRect().y
        //     ctx = $('#fp-canvas')[0].getContext('2d');
        //     if (e.target == canvas) {
        //         e.preventDefault();
        //         clientX = e.touches[0].clientX;
        //         clientY = e.touches[0].clientY;
        //         draw(clientX, clientY)
        //     }
        //     }, false);

        //     function draw(clientX, clientY){

        //         ctx = $('#fp-canvas')[0].getContext('2d');
        //         ctx.strokeStyle= '#51c9bb';
        //         ctx.lineJoin='round';
        //         ctx.lineCap='round';
        //         ctx.lineWidth=30;

        //         //flag
        //         let isDrawing=false; //don't draw when mouse is just moving mouse w/o doing anything

        //         //where to start a line from and then where to end it
        //         let lastX=0;
        //         let lastY=0;
        //         let hue=0;
        //         let direction=true;

        //         if(!isDrawing)
        //         return; //only run in click and drag

        //         ctx.strokeStyle= `hsl(${hue},100%,50%)`;
        //         ctx.beginPath();
        //         ctx.moveTo(lastX,lastY); //start from
        //         ctx.lineTo(clientX,clientY); //go to
        //         ctx.stroke(); //to actually draw the path on canvas
        //         [lastX,lastY]=[clientX,clientY];
        //         // lastX=e.offsetX;
        //         // lastY=e.offsetY;

        //         hue++;
        //         if(hue>=360){
        //             hue=0;
        //         }
        //         if(ctx.lineWidth>=80 || ctx.lineWidth<=1){
        //             direction=!direction;
        //         }
        //         if(direction)
        //         ctx.lineWidth++;
        //         else
        //         ctx.lineWidth--;
        //     }
    </script>