<?php session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
$database=new Database();
if (isset($_SESSION["email"])&&(new Database)->getAccount_($_SESSION["email"])["is_admin"]&&isset($_POST["contentFilter"])) {

  //var_dump(isset($_POST["contentFilter"]));

  $arr=$database->getEntryTimingsAveragedPerDatePerHourJSON($_POST["contentFilter"]);
  echo($arr);
}
?>