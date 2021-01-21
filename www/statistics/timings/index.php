<?php session_start();//todoooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo
include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
$isAdmin=false;
if (isset($_SESSION["email"])) {
  $database=new Database();
  if($isAdmin=($database->getAccount_($_SESSION["email"]))["is_admin"]){
    $uniqueContentTypesAgesAverage=$database->getUniqueContentTypesAgesAverage();
    $size=count($uniqueContentTypesAgesAverage);
  }
}
?>


















<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="/css/style.css"/>
  <link rel="stylesheet" type="text/css" href="/css/sign.css"/>
  <script src="/js/bootstrap.bundle.js"></script>
  <script src="/chartjs/Chart.bundle.js"></script>
  <script src="/jquery-3.5.1.js"></script>
  <?php if (!$isAdmin):?>
    <script>
    function fn(){ location.replace("/");}
    setTimeout(fn,750);
    </script>
  <?php endif?>
  <title>Statistics</title>
</head>
<body class="text-center">
<?php if ($isAdmin):?>
  <?php include ($_SERVER["DOCUMENT_ROOT"]."/../menu.php");?>
  <h1 class="h3 mb-3 fw-normal">Average date per Content-Type:</h1>
  <div class="container-fluid">
    <canvas id="myChart" width="32" height="9"></canvas>
    <script>
      var ctx = document.getElementById('myChart').getContext('2d');
      var chart=undefined;
      function updateChart(dataa){
        dataa=JSON.parse(dataa);
        console.log(dataa)
        //if (chart)chart.destroy();
        
        chart = new Chart(ctx, {
          type: 'line',
          data:dataa,
          options: {
            scales: {
              yAxes: [{
                ticks:{
                  beginAtZero: true
                }
              }]
            }
          }
        });
      }
      function updateChartOnSubmit(){
        updateChart(aa);
      //   $.ajax({/*data:xy,*/cache:false,method:"POST", url: "/geoQueriesAPI.php", success: function(result){
        
      //   console.log(result);
      //   let arr=JSON.parse("["+result+"]");
      //   var testData = {
      //     max: 10,
      //     data: arr
      //   };
      //   console.log(arr);
      //   heatmapLayer.setData(testData);
      // }});
      }
      var aa={
        labels: ['Red','Redd', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12,12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(0, 0, 0, .3)',
                'rgba(0, 0, 0, .5)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2,hoverBorderWidth:18,cubicInterpolationMode:'monotone'
        }]
    };
    aa=JSON.stringify(aa);
    </script>
  </div>
  <button class="w-100 btn btn-lg btn-success" type="submit" value="updateData" name="button" form="form1" onclick="updateChartOnSubmit()">Update</button>
<?php endif?>








<footer class="bd-footer bg-dark text-light fixed-bottom text-center">
  <div class="container">
    <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
  </div>
</footer>
</body>
</html>


