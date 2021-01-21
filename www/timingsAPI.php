<?php session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
$database=new Database();
if (isset($_SESSION["email"])&&(new Database)->getAccount_($_SESSION["email"])["is_admin"]) {
  
  $arr=$database->getEntryTimingsAveragedPerDatePerHourJSON(1);
  echo($arr);
}
?>