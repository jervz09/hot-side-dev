<script>
// if ($(':target').offset()) {
//   var offset = $(':target').offset();
//   var scrollto = offset.top - 140; // minus fixed header height
//   $('html, body').animate({
//     scrollTop: scrollto
//   }, 0);
// }

var tbl = $.parseJSON('<?=json_encode($tbl)?>')

// checking avaialability
let checked_availability = false
let party_size = ""
let reserved_date = ""
let reserved_time = ""

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


  var _date = new Date()
  var today = _date.toISOString().split('T')[0];
  var currentTime = _date.getHours() + ':' + _date.getMinutes();
  currentTime = _date.toTimeString().substring(0, 5);
  // document.getElementsByName("reserved_date")[0].setAttribute('min', today);
  // $('#reserved_date').val(today)
  $('#reserved_time').val(currentTime)
  $('.category-list a').click(function(e) {
    $('.category-list a.active').removeClass('active');
    // var $parent = $(this).parent();
    $(this).addClass('active');
    e.preventDefault();
  });



  // $(".head-step").sticky({topSpacing:105});
  // $(".booking-form").sticky({topSpacing:140});
  // $(".category-list-container").sticky({topSpacing:105});
  // $(".summary_order").sticky({topSpacing:105});
  // $.stickysidebarscroll(".head-step",{offset: {top: 105, bottom: 200}});
  // $.stickysidebarscroll(".booking-form",{offset: {top: 140, bottom: 10}});
  // var stickyPanelOptions = {
  // 	topPadding: 105,
  // 	afterDetachCSSClass: "",
  // 	savePanelSpace: false,
  // 	onDetached: function (detachedPanel, spacerPanel) {
  // 		detachedPanel.html(detachedPanel.html() + " has been detached!");
  // 		// spacerPanel.css("background-color", "#1000ff");
  // 	},
  // 	onReAttached: function (detachedPanel) {
  // 		detachedPanel.html(detachedPanel.html().replace(" has been reAttached!", ""));
  // 	},
  // 	parentSelector: null
  // };

  // // multiple panel example (you could also use the class ".stickypanel" to select both)
  // $(".category-list-container,.summary_order").stickyPanel(stickyPanelOptions);

  // var $sticky = $('.category-list-container');
  // var $stickyrStopper = $('.footer-area');
  // if ($sticky.offset()) { // make sure ".sticky" element exists

  // 	var generalSidebarHeight = $sticky.innerHeight();
  // 	// var stickyTop = $('.category-list-container').offset().top;
  // 	var stickyTop = 362.25;
  // 	var stickOffset = 104;
  // 	var stickyStopperPosition = $stickyrStopper.offset().top;
  // 	var stopPoint = stickyStopperPosition - generalSidebarHeight - stickOffset;
  // 	var diff = stopPoint + stickOffset;

  // 	$(window).scroll(function(){ // scroll event
  // 	var windowTop = $(window).scrollTop(); // returns number

  // 		if (stickyTop < windowTop+stickOffset) {
  // 			console.log(stickyTop)
  // 			console.log(windowTop)
  // 			console.log(stickOffset)
  // 			$sticky.css({ position: 'fixed', top: stickOffset });
  // 			$sticky.addClass('content_fixed');
  // 		} else {
  // 			$sticky.css({position: 'absolute', top: 'initial'});
  // 		}
  // 	});
  // }


});

function map_tbls(tbl) {
    if (Object.keys(tbl).length > 0) {
      $('#fp-map').html('')
      Object.keys(tbl).map(k => {
        var data = tbl[k]
        var area = $("<area shape='rect'>")
        area.attr('href', "javascript:void(0)")
        area.attr('data-id', data.id)
        var perc = data.coordinates
				console.log(perc)
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
					s_table_name = data.name
          $("#next_step_2").css({"display":"block"})
        })
      })
    }
  }
  map_tbls(tbl)
  $(window).on('resize', function() {
    map_tbls(tbl)
  })
  window.dispatchEvent(new Event('resize'));

$('#check_availability').click(function() {
  party_size = $("[data-id='party_size']").val()
  reserved_date = $("#reserved_date").val()
  reserved_time = $("#reserved_time").val()
  console.log(reserved_time)
  $.ajax({
    url: 'php/available_tables.php',
    type: "post",
    data: {
      party_size,
      reserved_date,
      reserved_time
    },
    success: function(data) {
      console.log(data)
      checked_availability = true
      $("[data-id='available_tables']").html(data);
      $("[data-id='tr_available_tables']").show("slow");
      if($("#tables_count").text() != 0 || $("#tables_count").text() != '0'){
        $("#next_step_1").css({"display":"block"})
      }else{
        alertify.error("<b>No Available tables</b>,<br /> Please select another date and time.");
      }
    }
  });

	$.ajax({
    url: 'php/fetch_tbl.php',
    type: "post",
    data: {
      party_size,
      reserved_date,
      reserved_time
    },
    success: function(response) {
      tbl = $.parseJSON(response)
			console.log(tbl)
			map_tbls(tbl)
    }
  });

});

// Validate if selected table is exist

// $('#next_step_2').click(function() {
//   if (!s_table) {
//       alertify.error("Please select a table");
//   }
// })


// Ordering and adding on cart

let list_orders = []

let data_menu = $.parseJSON('<?=json_encode($data_menu)?>')

$('.add-item').click(function() {
  let idx = $(this).attr("data-id")
  let item_name = $(this).attr("data-name")
  let _content = $("#summary_order").find(`[menu-id='${idx}']`)
  if (!_content.length) {
    $.ajax({
      url: 'php/summary-content.php',
      type: "post",
      data: {
        data: data_menu[idx]
      },
      success: function(data) {
        $("#summary_order").prepend(data);
        $("#order_list_container").removeClass("col-lg-9 col-xl-9").addClass("col-lg-6 col-xl-6");
        $("#summary_order_container").show("slow");
        $(".summary-body").show("slow");
        update_menu_price(idx, item_name ,1)
      }
    });
  } else {
    let qty = parseInt(_content.find('.order-qty').text())
    _content.find('.order-qty').text(qty+1)
    update_menu_price(idx,item_name,qty+1)
  }

  // hide_temp_class()

});

const add_order_list = (id, name, qty, price) => {
  let data = {
    id,
    name,
    qty,
    price:qty*price
  }
  objIndex = list_orders.findIndex((obj => obj.id == id))
  if(list_orders[objIndex]){
    list_orders[objIndex].name = name
    list_orders[objIndex].qty = qty
    list_orders[objIndex].price = qty*price
  }else{
    list_orders.push(data)
  }
  $("#total_price").text()
  console.log(list_orders)
  calculate_total_amount(list_orders)
}

const remove_order_list = (id) => {
  objIndex = list_orders.findIndex((obj => obj.id == id))

  if(objIndex == -1){
    return false
  }
  list_orders.splice(objIndex,1)
  calculate_total_amount(list_orders)
}

const calculate_total_amount = (_list) => {
  let sum = _list.reduce((n,{price}) => n + price, 0)
  $("#total_price").text(`₱${sum.toFixed(2)}`)
  console.log(sum)
}
const close_summary_item = (e) => {
    console.log(e.closest('.card-body'))
    remove_order_list($(e).attr("data-id"))
    $(e).closest('.card-body').hide('slow')
    setTimeout(function() {
      $(e).closest('.card-body').remove()
    }, 1000);
    if(list_orders.length === 0){
      $("#order_list_container").removeClass("col-lg-6 col-xl-6").addClass("col-lg-9 col-xl-9");
      $("#summary_order_container").hide("slow");
    }
  }

const dec_qty = (e) => {
    let idx = $(e).attr("dec-id")
    let data_name = $(e).attr("data-name")
    let qty = parseInt($(`[order-qty-id='${idx}']`).text())
    if((qty-1)>=1){
      $(`[order-qty-id='${idx}']`).text(qty-1)
      update_menu_price(idx,data_name,qty-1)
    }else{
      close_summary_item(e)
    }
  }
const inc_qty = (e) => {
    let idx = $(e).attr("inc-id")
    let data_name = $(e).attr("data-name")
    let qty = parseInt($(`[order-qty-id='${idx}']`).text())
    $(`[order-qty-id='${idx}']`).text(qty+1)
      update_menu_price(idx,data_name,qty+1)
  }

const update_menu_price = (id, name, qty) => {
  let orig_price = $(`.orig_price_${id}`)
  let price = $(`.price_${id}`)
  let _o_price = parseInt(orig_price.text().replace("₱", ''))
  let final_price = _o_price*qty
  price.text(`₱${final_price.toFixed(2)}`)
  add_order_list(id, name, qty, _o_price)
}

// const hide_temp_class = () => {
//   $(".temp-body").hide("slow")
// }

// Setting up review

$("#alt_next_step_3").click(function () {
  $("#next_step_3").click()
})


$("#next_step_3").click(function () {
  let is_order = false
  let total = ""
  let order_body = ""
  let order_footer = ""
	$("#selected_party_size").val(party_size)
	$("#selected_reserved_date").val(reserved_date)
	$("#selected_reserved_time").val(reserved_time)
	$("#selected_table_no").val(s_table_name)

  for (let i = 0; i < list_orders.length; i++) {
    is_order = true
    order_body +=`<tr>
                    <td class='text-left'>${list_orders[i].name}</td>
                    <td>${list_orders[i].qty}</td>
                    <td>₱${list_orders[i].price}</td>
                  </tr>`
  }

  if (is_order == true){
    total = list_orders.reduce((n,{price}) => n + price, 0).toFixed(2)
    order_footer = `<tr data-id="tr_ordered">
                  <td class="col top-border-brand text-left text-bold" style="width:70%"> </th>
                  <td class="col top-border-brand text-center text-bold">Total :</td>
                  <td class="col top-border-brand text-center text-bold">₱${total}</td>
              </tr>`
    $("[data-review='review_order_footer']").html(order_footer);
    $(".table-summary-orders").show("fast")
  }

  $("[data-review='review_order']").html(order_body);
  if(list_orders.length == 0){
    $(".table-summary-orders").hide("fast")
  }

})

// Reservation

$("#submit_reserved").click(function () {
    $.ajax({
        url:'./admin/helper/init.php?a=user_reservation',
        method:'POST',
        data:{
          user_id : <?= $_SESSION['id'] ?>,
          datetime : `${reserved_date} ${reserved_time}`,
          table_id : s_table
        },
        dataType:'JSON',
        error:err=>{
          console.log(err)
        },
        success:function(resp){
          if(resp.status == 'success' && list_orders.length){
            // $('#success_modal').modal('show');
            for (let i = 0; i < list_orders.length; i++) {

              $.ajax({
                url:'./admin/helper/init.php?a=order_menu',
                method:'POST',
                data:{
                  menu_id : list_orders[i].id,
                  qty : list_orders[i].qty,
                  reservation_id: resp.reservation_id,
                },
                success:function(response){
                  $('.preloader').fadeOut('slow', function () {
                      $(this).remove();
                  });
                  let r = JSON.parse(response)
                  if(r.status == 'success'){
                    $('#success_modal').modal('show');
                  }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                  console.log("Status: " + textStatus); alert("Error: " + errorThrown);
                }
              })
            }

          }
          // console.log(resp)
        }
    })
})



// Success process

$("#start_explore").click(function () {
	window.location.href = "index.php"
})
</script>