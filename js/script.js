window.universal_modal = function($title = '', $url = '', $size = "") {
    $.ajax({
        url: $url,
        error: err => {
            console.log()
            alert("An error occured")
        },
        success: function(resp) {
            if (resp) {
                $('#universal_modal .modal-title').html($title)
                $('#universal_modal .modal-body').html(resp)
                $('#universal_modal .modal-dialog').removeClass('large')
                $('#universal_modal .modal-dialog').removeClass('mid-large')
                $('#universal_modal .modal-dialog').removeClass('modal-md')
                if ($size == '') {
                    $('#universal_modal .modal-dialog').addClass('modal-md')
                } else {
                    $('#universal_modal .modal-dialog').addClass($size)
                }
                $('#universal_modal').modal({
                    backdrop: 'static',
                    keyboard: true,
                    focus: true
                })
                $('#universal_modal').modal('show')
            }
        }
    })
}
window.universal_modal_secondary = function($title = '', $url = '', $size = "") {
    $.ajax({
        url: $url,
        error: err => {
            console.log()
            alert("An error occured")
        },
        success: function(resp) {
            if (resp) {
                $('#universal_modal_secondary .modal-title').html($title)
                $('#universal_modal_secondary .modal-body').html(resp)
                $('#universal_modal_secondary .modal-dialog').removeClass('large')
                $('#universal_modal_secondary .modal-dialog').removeClass('mid-large')
                $('#universal_modal_secondary .modal-dialog').removeClass('modal-md')
                if ($size == '') {
                    $('#universal_modal_secondary .modal-dialog').addClass('modal-md')
                } else {
                    $('#universal_modal_secondary .modal-dialog').addClass($size)
                }
                $('#universal_modal_secondary').modal({
                    backdrop: 'static',
                    keyboard: true,
                    focus: true
                })
                $('#universal_modal_secondary').modal('show')
            }
        }
    })
}
window._conf = function($msg = '', $func = '', $params = []) {
    $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")")
    $('#confirm_modal .modal-body').html($msg)
    $('#confirm_modal').modal('show')
}
$(function() {
    if(jQuery.fn.select2){
            $('.select2').select2({
                width:'resolve'
            })
        $('#universal_modal').on('shown.bs.modal',function(){
            $('.select2').select2({
                width:'resolve',
                dropdownParent:'#universal_modal'
            })
        })
    }
    if(jQuery.fn.summernote){
        $('.summernote').each(function(){
            var height = $(this).attr('data-height') || '25vh'
            var placeholder = $(this).attr('data-placeholder') || 'Write Here'
            $(this).summernote({
                placeholder:placeholder,
                height:height,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['codeview', 'help']]
                  ]
            })
        })
        $('#universal_modal').on('shown.bs.modal',function(){
            $('.summernote').each(function(){
                var height = $(this).attr('data-height') || '25vh'
                var placeholder = $(this).attr('data-placeholder') || 'Write Here'
                $(this).summernote({
                    placeholder:placeholder,
                    height:height,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['codeview', 'help']]
                      ]
                })
            })
        })
    }

})