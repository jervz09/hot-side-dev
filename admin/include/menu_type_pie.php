<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

let _labels = []
let _datas = []
let pie_data_raw = <?=json_encode($db_categories)?>;
$.each( pie_data_raw, function (key, val) {
  _labels.push(key)
  _datas.push(val)
});
// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: _labels,
    datasets: [{
      data: _datas,
      backgroundColor: ['#2b898b', '#1cc88a', '#36b9cc', '#36b9c2'],
      hoverBackgroundColor: ['#0f4748', '#17a673', '#2c9faf', '#36b9c2'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

</script>