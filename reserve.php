<!DOCTYPE html>
<html lang="en">
  <?php include('head.php')?>

  <style>
    #calendar_area {
    padding: 120px 0;
  }
  #fp-canvas-container{
      height:50vh;
      width:calc(100%);
      position:relative;
  }
  .fp-img,.fp-canvas,.fp-canvas-2{
      position:absolute;
      width:calc(100%);
      height:calc(100%);
      top:0;
      left:0;
      z-index: 1;
  }
  #fp-map{
      position:absolute;
      top:0;
      left:0;
      z-index: 1;
      width:calc(100%);
      height:calc(100%);
  }
  .fp-canvas {
      z-index: 2;
      background: #0000000d;
      cursor: crosshair;
  }
  #fp-map{
      z-index: 1;
  }
  area:hover {
      background: #0000004d;
      color: #fff !important;
  }
  </style>
  <body>
    <!-- Preloader Start -->
    <?php include('php/preloader.php')?>
    <!-- Preloader End -->

    <!-- ##### Header Area Start ##### -->
    <?php include('php/header_nav.php')?>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Calendar Area Start ##### -->
    <?php include('php/reserve.php')?>
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
          document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
          });
        });
      });
    </script>
  </body>
</html>