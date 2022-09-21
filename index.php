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
    <section class="section-padding-100 bg-img bg-fixed" style="background-image: url(img/bg-img/4.jpg);">
      <div class="container">
        <div class="row justify-content-end">
          <div class="col-12 col-lg-7">
            <div class="about-2-content text-center wow fadeInUp" data-wow-delay="300ms">
              <div class="section-heading text-center white">
                <div class="line-"></div>
                <h2>What Are You Waiting For?</h2>
                <p>Bring Out Your Family, LoveOnes, Barkada, Tropa, Work Mates At Kapitbahay Na Mga Ka - 𝖧𝗈𝗍𝗌𝗊𝗎𝖺𝖽.</p>
              </div>
              <div class="row">
                <div class="col-12 col-sm-3">
                  <div class="about-2-feature">
                    <img src="img/abt-img/beer.png">
                    <p>Beer</p>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="about-2-feature">
                    <img src="img/abt-img/billiard.png">
                    <p>Billiard</p>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="about-2-feature">
                    <img src="img/abt-img/music.png">
                    <p>Music Band</p>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="about-2-feature">
                    <img src="img/abt-img/dine.png">
                    <p>Dine</p>
                  </div>
                </div>
              </div>
              <!-- Button -->
              <a href="#" class="btn palatin-btn mt-50">Read More</a>
            </div>
          </div>
        </div>
      </div>
    </section>
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