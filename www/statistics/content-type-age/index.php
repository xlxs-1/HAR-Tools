<?php session_start();
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
  <table class="table">
    <thead>
      <tr>
        <th scope="col">type</th>
        <th scope="col">age</th>
      </tr>
    </thead>
    <tbody>
      <?php for($i=0;$i<$size;++$i):?>
      <tr>
        <th scope="row"><?php echo($uniqueContentTypesAgesAverage[$i]["type"]);?></th>
        <td><?php $dates=$uniqueContentTypesAgesAverage[$i]["age"]/(3600.0*24);echo(number_format($dates,3)." dates");?></td>
      </tr>
      <?php endfor;?>
    </tbody>
  </table>
  </div>
<?php endif?>







<br><br>
<footer class="bd-footer bg-dark text-light fixed-bottom text-center">
  <div class="container">
    <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
  </div>
</footer>
</body>
</html>


