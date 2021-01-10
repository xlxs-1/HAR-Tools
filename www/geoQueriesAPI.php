<?php session_start();
if (isset($_SESSION["email"])) {
  include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
  $database=new database();
  //var_dump(123);
  
  //$subdivisions=12;
  
  // $points = {
  //   "data": [{lat: Math.random(), lng:Math.random(), count: 3}]
  // };

  // echo($points);



  $arr=$database->getHttp_requestsAsJsonPoints($_SESSION["email"]);
  //$jArr=json_encode('{'.$arr.'}');
  echo($arr);
}
?>