<!DOCTYPE html>
<html lang="en">
<?php include('head.php')?>
<link rel="stylesheet" href="css/reserve.css">

<body>
  <!-- Preloader Start -->
  <?php include('php/preloader.php')?>
  <!-- Preloader End -->

  <!-- ##### Header Area Start ##### -->
  <?php include('php/header_nav.php')?>
  <!-- ##### Header Area End ##### -->

  <!-- ##### Calendar Area Start ##### -->
  <?php include('php/step_to_orderv2.php')?>
  <!-- ##### Calendar Area End ##### -->

  <!-- ##### Footer Area Start ##### -->
  <?php include('php/footer.php')?>
  <!-- ##### Footer Area End ##### -->

  <!-- ##### Modal Container Start ##### -->
  <?php include('php/modal_container.php')?>
  <!-- ##### Modal Container End ##### -->


  <?php include('js_import.php')?>

  <?php include('php/reserve_js.php')?>

  <script>
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      document.querySelector(this.getAttribute('href'))?.scrollIntoView({
        behavior: 'smooth'
      });
    });
  });
  if ($(window).height() > $("body").height()) {
    $(".footer-area").css("position", "fixed");
  } else {
    $(".footer-area").css("position", "static");
  }
  </script>
</body>

</html>