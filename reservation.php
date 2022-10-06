<!DOCTYPE html>
<html lang="en">
  <?php include('head.php')?>
  <style>
    #calendar_area, #reservation_area {
      padding-top: 160px;
    }
  </style>
  <body>
    <!-- Preloader Start -->
    <?php include('php/preloader.php')?>
    <!-- Preloader End -->

    <!-- ##### Header Area Start ##### -->
    <?php include('php/header_nav.php')?>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Reservation Form Area Start ##### -->
    <?php include('php/reservation_form.php')?>
    <!-- ##### Reservation Form Area End ##### -->

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
      $("#calendar").evoCalendar({
        theme: 'Midnight Blue'
      });
    </script>
  </body>
</html>