<!DOCTYPE html>
<html lang="en">
  <?php include('head.php')?>
  <style>
    #calendar_area {
      padding-top: 160px;
    }
    .calendar .days li {
      min-height: 0;
      cursor: pointer;
    }
  </style>
  <body>
    <!-- Preloader Start -->
    <!-- <?php include('php/preloader.php')?> -->
    <!-- Preloader End -->

    <!-- ##### Header Area Start ##### -->
    <?php include('php/header_nav.php')?>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Calendar Area Start ##### -->
    <?php include('php/floor.php')?>
    <!-- ##### Calendar Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <?php include('php/footer.php')?>
    <!-- ##### Footer Area End ##### -->

    <!-- ##### Modal Container Start ##### -->
    <?php include('php/modal_container.php')?>
    <!-- ##### Modal Container End ##### -->


    <?php include('js_import.php')?>

    <script>

      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
          });
        });
      });
    </script>

   <script type="text/javascript">
      $(function () {
          $('#datetimepicker12').datetimepicker({
              inline: true,
              sideBySide: true
          });

          $('#to_reserve').on("click", function(e){
            timepicker_hour = $('.timepicker-hour').text()
            timepicker_minute = $('.timepicker-minute').text()
            togglePeriod=$('[data-action="togglePeriod"]').text()
            if(!s_table){
              alert("Select table is required");
            }else{
              s_date = $('td.active').text()
              alert(`selected: table = ${s_table} , date = ${s_date}, time = ${timepicker_hour}:${timepicker_minute} ${togglePeriod}`)
            }
          });
      });
   </script>

  </body>
</html>