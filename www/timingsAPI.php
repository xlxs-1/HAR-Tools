<?php session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');

function is_true($val, $return_null=false){//  https://www.php.net/manual/en/function.boolval.php#116547
  $boolval = ( is_string($val) ? filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : (bool) $val );
  return ( $boolval===null && !$return_null ? false : $boolval );
}

$database=new Database();
if (isset($_SESSION["email"])&&(new Database)->getAccount_($_SESSION["email"])["is_admin"]&&isset($_POST["contentFilter"])&&isset($_POST["Monday"])&&isset($_POST["Tuesday"])&&isset($_POST["Wednesday"])&&isset($_POST["Thursday"])&&isset($_POST["Friday"])&&isset($_POST["Saturday"])&&isset($_POST["Sunday"])&&isset($_POST["get"])&&isset($_POST["head"])&&isset($_POST["post"])&&isset($_POST["put"])&&isset($_POST["delete"])&&isset($_POST["connect"])&&isset($_POST["options"])&&isset($_POST["trace"])) {
  $days["Monday"]=is_true($_POST["Monday"]);
  $days["Tuesday"]=is_true($_POST["Tuesday"]);
  $days["Wednesday"]=is_true($_POST["Wednesday"]);
  $days["Thursday"]=is_true($_POST["Thursday"]);
  $days["Friday"]=is_true($_POST["Friday"]);
  $days["Saturday"]=is_true($_POST["Saturday"]);
  $days["Sunday"]=is_true($_POST["Sunday"]);
  
  $requestMethods["get"]=is_true($_POST["get"])?0:-1;
  $requestMethods["head"]=is_true($_POST["head"])?1:-1;
  $requestMethods["post"]=is_true($_POST["post"])?2:-1;
  $requestMethods["put"]=is_true($_POST["put"])?3:-1;
  $requestMethods["delete"]=is_true($_POST["delete"])?4:-1;
  $requestMethods["connect"]=is_true($_POST["connect"])?5:-1;
  $requestMethods["options"]=is_true($_POST["options"])?6:-1;
  $requestMethods["trace"]=is_true($_POST["trace"])?7:-1;


  //var_dump($days);

  $arr=$database->getEntryTimingsAveragedPerDatePerHourJSON($_POST["contentFilter"],$days["Monday"],$days["Tuesday"],$days["Wednesday"],$days["Thursday"],$days["Friday"],$days["Saturday"],$days["Sunday"],$requestMethods["get"],$requestMethods["head"],$requestMethods["post"],$requestMethods["put"],$requestMethods["delete"],$requestMethods["connect"],$requestMethods["options"],$requestMethods["trace"]);
  echo($arr);
}
?>