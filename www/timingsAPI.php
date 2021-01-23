<?php session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');

function is_true($val, $return_null=false){//  https://www.php.net/manual/en/function.boolval.php#116547
  $boolval = ( is_string($val) ? filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : (bool) $val );
  return ( $boolval===null && !$return_null ? false : $boolval );
}

$database=new Database();
if (isset($_SESSION["email"])&&(new Database)->getAccount_($_SESSION["email"])["is_admin"]&&isset($_POST["contentFilter"])&&isset($_POST["Monday"])&&isset($_POST["Tuesday"])&&isset($_POST["Wednesday"])&&isset($_POST["Thursday"])&&isset($_POST["Friday"])&&isset($_POST["Saturday"])&&isset($_POST["Sunday"])) {
  $days["Monday"]=is_true($_POST["Monday"]);
  $days["Tuesday"]=is_true($_POST["Tuesday"]);
  $days["Wednesday"]=is_true($_POST["Wednesday"]);
  $days["Thursday"]=is_true($_POST["Thursday"]);
  $days["Friday"]=is_true($_POST["Friday"]);
  $days["Saturday"]=is_true($_POST["Saturday"]);
  $days["Sunday"]=is_true($_POST["Sunday"]);



  //var_dump($days);

  $arr=$database->getEntryTimingsAveragedPerDatePerHourJSON($_POST["contentFilter"],$days["Monday"],$days["Tuesday"],$days["Wednesday"],$days["Thursday"],$days["Friday"],$days["Saturday"],$days["Sunday"]);
  echo($arr);
}
?>