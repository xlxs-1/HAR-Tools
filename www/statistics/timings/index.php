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
        console.log(dataa)
        if(chart)chart.destroy();
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
        //updateChart(aa);
        $.ajax({/*data:xy,*/cache:false,method:"POST", url: "/timingsAPI.php",data:{contentFilter:document.getElementById("contentTypes").value,Monday:document.getElementById("Monday").checked,Tuesday:document.getElementById("Tuesday").checked,Wednesday:document.getElementById("Wednesday").checked,Thursday:document.getElementById("Thursday").checked,Friday:document.getElementById("Friday").checked,Saturday:document.getElementById("Saturday").checked,Sunday:document.getElementById("Sunday").checked}, success: function(result){
        console.log(result);
        var labels=[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
        basic.labels=labels;
        basic.datasets[0].data=JSON.parse(result);
        updateChart(basic);
      }});
      }
      var basic={
        labels: ['Red','Redd', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: 'Average Time per hour',
            data: [12,12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(0, 0, 0, .3)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
            ],
            borderColor: [
                'rgba(0, 0, 0, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)',
            ],
            borderWidth: 2,hoverBorderWidth:18,cubicInterpolationMode:'monotone'
        }]
    };
    //basic=JSON.stringify(basic);
    </script>
  </div>
  <button class="w-100 btn btn-lg btn-success" type="submit" value="updateData" name="button"  onclick="updateChartOnSubmit()">Update</button><br><br><br>

  <label>Filters:</label><br><br>
  <form class="form-sign" action="" method="post" id="form1">
    <input type="text" class="form-control" aria-describedby="contentTypesHelp" placeholder="Filter based on Content Type" value="" id="contentTypes">
    <small id="contentTypesHelp" class="form-text text-muted">Leave empty for all.</small>
    <br><br>
    <input class="form-check-input" type="checkbox" value="Monday" id="Monday" checked>
    <label class="form-check-label" for="Monday">Monday</label>                               <br>
    <input class="form-check-input" type="checkbox" value="Tuesday" id="Tuesday" checked>
    <label class="form-check-label" for="Tuesday">Tuesday</label>                               <br>
    <input class="form-check-input" type="checkbox" value="Wednesday" id="Wednesday" checked>
    <label class="form-check-label" for="Wednesday">Wednesday</label>                               <br>
    <input class="form-check-input" type="checkbox" value="Thursday" id="Thursday" checked>
    <label class="form-check-label" for="Thursday">Thursday</label>                               <br>
    <input class="form-check-input" type="checkbox" value="Friday" id="Friday" checked>
    <label class="form-check-label" for="Friday">Friday</label>                               <br>
    <input class="form-check-input" type="checkbox" value="Saturday" id="Saturday" checked>
    <label class="form-check-label" for="Saturday">Saturday</label>                               <br>
    <input class="form-check-input" type="checkbox" value="Sunday" id="Sunday" checked>
    <label class="form-check-label" for="Sunday">Sunday</label>
  </form>
  <br>
<?php endif?>








<footer class="bd-footer bg-dark text-light fixed-bottom text-center">
  <div class="container">
    <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
  </div>
</footer>
</body>
</html>


