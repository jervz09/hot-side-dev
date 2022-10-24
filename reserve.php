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
  * {
	margin: 0;
	padding: 0
}

html {
	height: 100%
}

h2{
	color: #2b898b;
}
#form {
	text-align: center;
	position: relative;
	margin-top: 20px
}

#form fieldset {
	background: white;
	border: 0 none;
	border-radius: 0.5rem;
	box-sizing: border-box;
	width: 100%;
	margin: 0;
	padding-bottom: 20px;
	position: relative
}

.finish {
	text-align: center
}

#form fieldset:not(:first-of-type) {
	display: none
}

#form .previous-step, .next-step {
	width: 100px;
	font-weight: bold;
	color: white;
	border: 0 none;
	border-radius: 0px;
	cursor: pointer;
	padding: 10px 5px;
	margin: 10px 5px 10px 0px;
	float: right
}

.form, .previous-step {
	background: #616161;
}

.form, .next-step {
	background: #2b898b;
}

#form .previous-step:hover,
#form .previous-step:focus {
	background-color: #000000
}

#form .next-step:hover,
#form .next-step:focus {
	background-color: #2b898b
}

.text {
	color: #2b898b;
	font-weight: normal
}

#progressbar {
	margin-bottom: 30px;
	overflow: hidden;
	color: lightgrey
}

#progressbar .active {
	color: #2b898b
}

#progressbar li {
	list-style-type: none;
	font-size: 15px;
	width: 25%;
	float: left;
	position: relative;
	font-weight: 400
}

#progressbar #step1:before {
	content: "1"
}

#progressbar #step2:before {
	content: "2"
}

#progressbar #step3:before {
	content: "3"
}

#progressbar #step4:before {
	content: "4"
}

#progressbar li:before {
	width: 50px;
	height: 50px;
	line-height: 45px;
	display: block;
	font-size: 20px;
	color: #ffffff;
	background: lightgray;
	border-radius: 50%;
	margin: 0 auto 10px auto;
	padding: 2px
}

#progressbar li:after {
	content: '';
	width: 100%;
	height: 2px;
	background: lightgray;
	position: absolute;
	left: 0;
	top: 25px;
	z-index: -1
}

#progressbar li.active:before,
#progressbar li.active:after {
	background: #2b898b
}

.progress {
	height: 20px
}

.progress-bar {
	background-color: #2b898b
}
.section {
	position: relative;
	height: 100vh;
}

.section .section-center {
	position: absolute;
	top: 50%;
	left: 0;
	right: 0;
	-webkit-transform: translateY(-50%);
	transform: translateY(-50%);
}

#booking {
	font-family: 'Montserrat', sans-serif;
	background-image: url('../img/background.jpg');
	background-size: cover;
	background-position: center;
}

#booking::before {
	content: '';
	position: absolute;
	left: 0;
	right: 0;
	bottom: 0;
	top: 0;
	background: rgba(47, 103, 177, 0.6);
}

.booking-form {
	background-color: #fff;
	padding: 50px 20px;
	-webkit-box-shadow: 0px 5px 20px -5px rgba(0, 0, 0, 0.3);
	box-shadow: 0px 5px 20px -5px rgba(0, 0, 0, 0.3);
	border-radius: 4px;
}

.booking-form .form-group {
	position: relative;
	margin-bottom: 30px;
}

.booking-form .form-control {
	background-color: #ebecee;
	border-radius: 4px;
	border: none;
	height: 40px;
	-webkit-box-shadow: none;
	box-shadow: none;
	color: #3e485c;
	font-size: 14px;
}

.booking-form .form-control::-webkit-input-placeholder {
	color: rgba(62, 72, 92, 0.3);
}

.booking-form .form-control:-ms-input-placeholder {
	color: rgba(62, 72, 92, 0.3);
}

.booking-form .form-control::placeholder {
	color: rgba(62, 72, 92, 0.3);
}

.booking-form input[type="date"].form-control:invalid {
	color: rgba(62, 72, 92, 0.3);
}

.booking-form select.form-control {
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
}

.booking-form select.form-control+.select-arrow {
	position: absolute;
	right: 0px;
	bottom: 4px;
	width: 32px;
	line-height: 32px;
	height: 32px;
	text-align: center;
	pointer-events: none;
	color: rgba(62, 72, 92, 0.3);
	font-size: 14px;
}

.booking-form select.form-control+.select-arrow:after {
	content: '\279C';
	display: block;
	-webkit-transform: rotate(90deg);
	transform: rotate(90deg);
}

.booking-form .form-label {
	display: inline-block;
	color: #3e485c;
	font-weight: 700;
	margin-bottom: 6px;
	margin-left: 7px;
}

.booking-form .submit-btn {
	display: inline-block;
	color: #fff;
	background-color: #2b898b;
	font-weight: 700;
	padding: 14px 30px;
	border-radius: 4px;
	border: none;
	-webkit-transition: 0.2s all;
	transition: 0.2s all;
}

.booking-form .submit-btn:hover,
.booking-form .submit-btn:focus {
	opacity: 0.9;
}

.booking-cta {
	margin-top: 80px;
	margin-bottom: 30px;
}

.booking-cta h1 {
	font-size: 52px;
	text-transform: uppercase;
	color: #fff;
	font-weight: 700;
}

.booking-cta p {
	font-size: 16px;
	color: rgba(255, 255, 255, 0.8);
}
.nice-select{
  float: none;
}

ul.list {
    width: -webkit-fill-available;
}
.top-border-brand{
  border-top: 1px solid #2b888a !important;
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
          document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
          });
        });
      });
    </script>
  </body>
</html>