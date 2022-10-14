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

    <!-- ##### Book Now Area Start ##### -->
    <?php include('php/reserve_area.php')?>
    <!-- ##### Book Now Area End ##### -->

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
        theme: 'Midnight Blue',
        calendarEvents: [
          {
            id: 'bHay68s', // Event's ID (required)
            name: "New Year", // Event name (required)
            date: "January/1/2022", // Event date (required)
            type: "holiday", // Event type (required)
            everyYear: true // Same event every year (optional)
          },
          {
            id: 'bHa2y68s', // Event's ID (required)
            name: "Vacation Leave",
            badge: "02/13 - 02/15", // Event badge (optional)
            date: ["February/13/2022", "February/15/2022"], // Date range
            description: "Vacation leave for 3 days.", // Event description (optional)
            type: "event",
            color: "#63d867" // Event custom color (optional)
          }
        ]
      });
    </script>
  </body>
</html>