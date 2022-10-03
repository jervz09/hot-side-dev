<!DOCTYPE html>
<html lang="en">
  <?php include('head.php')?>
  <style>
    #calendar_area {
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

    <!-- ##### Calendar Area Start ##### -->
    <?php include('php/evo_calendar.php')?>
    <!-- ##### Calendar Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <?php include('php/footer.php')?>
    <!-- ##### Footer Area End ##### -->
    <!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" if="logout_session" href="../logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

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