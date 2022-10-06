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
      // $("#calendar").evoCalendar({
      //   theme: 'Midnight Blue',
      //   calendarEvents: [
      //     {
      //       id: 'bHay68s', // Event's ID (required)
      //       name: "New Year", // Event name (required)
      //       date: "Octover/3/2022", // Event date (required)
      //       type: "holiday", // Event type (required)
      //       everyYear: true // Same event every year (optional)
      //     },
      //     {
      //       name: "Vacation Leave",
      //       badge: "02/13 - 02/15", // Event badge (optional)
      //       date: ["Octover/4/2022", "Octover/7/2022"], // Date range
      //       description: "Vacation leave for 3 days.", // Event description (optional)
      //       type: "event",
      //       color: "#63d867" // Event custom color (optional)
      //     }
      //   ]
      // });
    </script>
  </body>
</html>