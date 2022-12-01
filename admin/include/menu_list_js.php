<script>
$('.delete_data').click(function(){
    _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from list?",'delete_data',[$(this).attr('data-id')])
})

$('.view_order').click(function(){
    universal_modal('Order Details',"view_ordered.php?id="+$(this).attr('data-id'))
})

$('.edit_data').click(function(){
    universal_modal('Order Details',"edit_reservation.php?id="+$(this).attr('data-id'))
})

let delete_data = ($id) => {
            $('#confirm_modal button').attr('disabled',true)
            $.ajax({
                url:'././helper/init.php?a=delete_reservation',
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


    </script>