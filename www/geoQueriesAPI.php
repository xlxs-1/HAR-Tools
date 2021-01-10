<?php session_start();
if (isset($_SESSION["email"])) {
  include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
  $database=new database();
  $user=$database->getAccount_($_SESSION["email"]);
  
  if ($user["is_admin"]) {
    $arr=$database->getHttp_requestsAsJsonPoints_();
  }else{
    $arr=$database->getHttp_requestsAsJsonPoints($_SESSION["email"]);
  }
  echo($arr);
}
?>