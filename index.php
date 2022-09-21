<!DOCTYPE html>
<html lang="en">
  <?php include('head.php')?>
  <body>
    <!-- Preloader Start -->
    <?php include('php/preloader.php')?>
    <!-- Preloader End -->

    <!-- ##### Header Area Start ##### -->
    <?php include('php/header_nav.php')?>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Hero Area Start ##### -->
    <?php include('php/hero_carousel.php')?>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Calendar Area Start ##### -->
    <?php include('php/evo_calendar.php')?>
    <!-- ##### Calendar Area End ##### -->

    <!-- ##### About Us Area Start ##### -->
    <?php include('php/about_us.php')?>
    <!-- ##### About Us Area End ##### -->

    <!-- ##### Extra About Us Area Start ##### -->
    <?php include('php/extra_about_us.php')?>
    <!-- ##### Extra About Us Area End ##### -->

    <!-- ##### Contact Area Start ##### -->
    <?php 
      // include('php/contact_map.php')
    ?>
    <!-- ##### Contact Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <?php include('php/footer.php')?>
    <!-- ##### Footer Area End ##### -->
    
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