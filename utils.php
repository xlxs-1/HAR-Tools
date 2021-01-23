<?php
/**
 * https://stackoverflow.com/a/60496/5941827 
 * */
class Database
{
  private $IP = "localhost";
  private $user = "root";
  private $password = "";
  private $name = "webproject";
  private $databaseHandle;
  public function __construct()
  {
    $this->databaseHandle = new mysqli($this->IP, $this->user, $this->password, $this->name);
    //$this->databaseHandle->set_charset()// TODO
    /*if ($this->databaseHandle->connect_error) {
      exit("Connection failed: " . $this->databaseHandle->connect_error);
    }*/
  }
  /*public function __destruct() {//optional may delete 
    unset($this->databaseHandle);
  }*/
  public function echoAccounts()
  {
    $sql = "SELECT * FROM users";
    //$ass="105 OR 1=1";

    $stmt = $this->databaseHandle->prepare($sql);
    //$stmt->bind_param("s", $ass);
    $stmt->execute();
    $result = $stmt->get_result();
    for ($ar = ""; $row = $result->fetch_assoc(); $ar = $ar . implode(", ", $row) . "<br>");
    var_dump($ar);
  }
  public function getAccount($email, $password)
  {
    $sql = "SELECT * FROM users WHERE email=? AND password=?";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }
  public function getAccount_($email)
  {
    $sql = "SELECT * FROM users WHERE email=?";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }
  public function insertAccount($email, $password)
  {
    $sql = "INSERT INTO users (email,password) VALUES (?,?)";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $ok = $stmt->execute();
    return $ok;
  }
  public function updateUser($withEmail, $newName,$newLastName,$newPassword)
  {
    $sql = "UPDATE users SET name = ?, last_name = ?, password = ? WHERE email = ?";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("ssss",$newName,$newLastName,$newPassword,$withEmail);
    $ok = $stmt->execute();
    return $ok;
  }
  public function updateUserLastUploadDATETIME($withEmail)
  {
    $sql = "UPDATE users SET last_upload =NOW() WHERE email = ?";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("s",$withEmail);
    $ok = $stmt->execute();
    return $ok;
  }
  public function increaseUserNumber_of_uploadsBy($withEmail,$increaseBy)
  {
    $sql = "UPDATE users SET number_of_uploads = number_of_uploads + ? WHERE email = ?";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("is",$increaseBy,$withEmail);
    $ok = $stmt->execute();
    return $ok;
  }
  public function countUsers()
  {
    $sql = "SELECT COUNT(*) FROM users";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_array()[0];
    return $result;
  }
  
  public function insertUsers_footprint($email, $isp,$ip){
    $sql = "INSERT INTO users_footprint (email,isp,ip) VALUES (?,?,?)";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("sss", $email, $isp,$ip);
    $ok = $stmt->execute();
    return $ok;
  }
  public function getUniqueIsps(){
    $sql = "SELECT COUNT(DISTINCT(isp)) FROM users_footprint";//  https://www.w3resource.com/sql/aggregate-functions/count-with-distinct.php

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_array()[0];
    return $result;
  }

  public function insertHttp_request($email, $latitude,$longitude){
    $sql = "INSERT INTO http_requests (email,latitude,longitude) VALUES (?,?,?)";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("sdd", $email, $latitude,$longitude);
    $ok = $stmt->execute();
    return $ok;
  }
  public function getHttp_requestsAsJsonPoints($email){
    $sql = "SELECT * FROM http_requests WHERE email=?";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    for ($ar = ""; $row = $result->fetch_assoc(); $ar = $ar .'{"x":'.$row["longitude"].",".'"y":'.$row["latitude"].',"count":1},');

    return rtrim($ar,",");//[{y: 24.6408, x:46.7728, count: 3},{y: 50.75, x:-1.55, count: 1},{y: 39.73, x:-104.99, count: 1},{y: 42.33, x:-104.39, count: 2}]
  }
  public function getHttp_requestsAsJsonPoints_(){
    $sql = "SELECT * FROM http_requests";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    for ($ar = ""; $row = $result->fetch_assoc(); $ar = $ar .'{"x":'.$row["longitude"].",".'"y":'.$row["latitude"].',"count":1},');

    return rtrim($ar,",");//[{y: 24.6408, x:46.7728, count: 3},{y: 50.75, x:-1.55, count: 1},{y: 39.73, x:-104.99, count: 1},{y: 42.33, x:-104.39, count: 2}]
  }

  public function increaseRequestMethodStatsBy($get,$head,$post,$put,$delete_,$connect,$options,$trace)
  {
    $sql = "UPDATE request_method_stats SET get = get + ?, head = head + ?, post = post + ?, put = put + ?, delete_ = delete_ + ?, connect = connect + ?, options = options + ?, trace = trace + ?";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("iiiiiiii",$get,$head,$post,$put,$delete_,$connect,$options,$trace);
    $ok = $stmt->execute();
    return $ok;
  }
  public function getRequestMethodStats()
  {
    $sql = "SELECT * FROM request_method_stats";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
  }

  public function increaseResponseStatusStatsBy($informational,$successful,$redirection,$clientError,$serverError)
  {
    $sql = "UPDATE response_status_stats SET informational = informational + ?, successful = successful + ?, redirection = redirection + ?, client_error = client_error + ?, server_error = server_error + ?";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("iiiii",$informational,$successful,$redirection,$clientError,$serverError);
    $ok = $stmt->execute();
    return $ok;
  }
  public function getResponseStatusStats()
  {
    $sql = "SELECT * FROM response_status_stats";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
  }

  public function insertRequestUrl($host){
    $sql = "INSERT INTO request_urls (url) VALUES (?)";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("s", $host);
    $ok = $stmt->execute();
    return $ok;
  }
  public function getUniqueRequestUrls(){
    $sql = "SELECT COUNT(DISTINCT(url)) FROM request_urls";//  https://www.w3resource.com/sql/aggregate-functions/count-with-distinct.php

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_array()[0];
    return $result;
  }

  public function insertContentTypesAges($type,$age){
    $sql = "INSERT INTO content_types_ages (type,age) VALUES (?,?)";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("ss",$type,$age);
    $ok = $stmt->execute();
    return $ok;
  }
  public function getUniqueContentTypesAgesAverage(){//https://stackoverflow.com/a/25414507/5941827
    $sql = "SELECT type,FROM_UNIXTIME(AVG(UNIX_TIMESTAMP(age))) FROM content_types_ages GROUP BY type ";//  https://www.w3resource.com/sql/aggregate-functions/count-with-distinct.php

    $stmt = $this->databaseHandle->prepare($sql);
    //var_dump(mysqli_error($this->databaseHandle));
    $stmt->execute();
    $result = $stmt->get_result();
    $ar=[];
    for ($i=0;$row = $result->fetch_assoc();++$i) {
      $ar[$i]["type"]=$row["type"];
      $ar[$i]["age"]=$row["FROM_UNIXTIME(AVG(UNIX_TIMESTAMP(age)))"];
    }
    return $ar;
  }

  public function insertEntryTimings($timing,$content_type,$dateTime,$http_method,$isp){
    $sql = "INSERT INTO entries_timings (timing,content_type,date_time,http_method,isp) VALUES (?,?,?,?,?)";

    $stmt = $this->databaseHandle->prepare($sql);
    $stmt->bind_param("issis",$timing,$content_type,$dateTime,$http_method,$isp);
    $ok = $stmt->execute();
    return $ok;
  }
  public function getEntryTimingsAveragedPerDatePerHourJSON($contentTypeFilter,$Monday,$Tuesday,$Wednesday,$Thursday,$Friday,$Saturday,$Sunday,$get,$head,$post,$put,$delete,$connect,$options,$trace,$isp){// https://stackoverflow.com/a/45876902/5941827                 https://stackoverflow.com/a/25414507/5941827
    if (!$isp) {
      $isp="";
    }
    if ($contentTypeFilter) {
      $sql="SELECT * FROM (SELECT weekday(date_time),hour(date_time),(AVG(timing)),(COUNT(timing)) FROM entries_timings WHERE content_type LIKE ? AND (http_method=? OR http_method=? OR http_method=? OR http_method=? OR http_method=? OR http_method=? OR http_method=? OR http_method=?) AND isp LIKE ".($isp?"?":"'%'")." GROUP BY weekday(date_time),hour(date_time)) temp  ";
      $stmt = $this->databaseHandle->prepare($sql);
      $stmt->bind_param("siiiiiiii".($isp?"s":""),$contentTypeFilter,$get,$head,$post,$put,$delete,$connect,$options,$trace,...$isp?[$isp]:[]);
    }else {
      $sql="SELECT * FROM (SELECT weekday(date_time),hour(date_time),(AVG(timing)),(COUNT(timing)) FROM entries_timings WHERE (http_method=? OR http_method=? OR http_method=? OR http_method=? OR http_method=? OR http_method=? OR http_method=? OR http_method=?) AND isp LIKE ".($isp?'?':"'%'")." GROUP BY weekday(date_time),hour(date_time)) temp  ";
      $stmt = $this->databaseHandle->prepare($sql);
      $stmt->bind_param("iiiiiiii".($isp?"s":""),$get,$head,$post,$put,$delete,$connect,$options,$trace,...$isp?[$isp]:[]);
    }
    //var_dump(mysqli_error($this->databaseHandle));
    $stmt->execute();
    $result = $stmt->get_result(); 

    $ar=[];
    for (; $row = $result->fetch_assoc();){
      $ar[$row["weekday(date_time)"]][$row["hour(date_time)"]]["avg"]=intval($row["(AVG(timing))"]);
      $ar[$row["weekday(date_time)"]][$row["hour(date_time)"]]["count"]=$row["(COUNT(timing))"];
      //var_dump($row);
    }
    //var_dump($ar);
    $avgPerH=[];
    for($h=0;$h<24;++$h){
      $avgPerH[$h]=0;
      $count=0;
      if($Monday)
        if (isset($ar[0][$h])) {
          $avgPerH[$h]+=$ar[0][$h]["avg"]*$ar[0][$h]["count"];
          $count+=$ar[0][$h]["count"];
        }
      if($Tuesday)
        if (isset($ar[1][$h])) {
          $avgPerH[$h]+=$ar[1][$h]["avg"]*$ar[1][$h]["count"];
          $count+=$ar[1][$h]["count"];
        }
      if($Wednesday)
        if (isset($ar[2][$h])) {
          $avgPerH[$h]+=$ar[2][$h]["avg"]*$ar[2][$h]["count"];
          $count+=$ar[2][$h]["count"];
        }
      if($Thursday)
        if (isset($ar[3][$h])) {
          $avgPerH[$h]+=$ar[3][$h]["avg"]*$ar[3][$h]["count"];
          $count+=$ar[3][$h]["count"];
        }
      if($Friday)
        if (isset($ar[4][$h])) {
          $avgPerH[$h]+=$ar[4][$h]["avg"]*$ar[4][$h]["count"];
          $count+=$ar[4][$h]["count"];
        }
      if($Saturday)
        if (isset($ar[5][$h])) {
          $avgPerH[$h]+=$ar[5][$h]["avg"]*$ar[5][$h]["count"];
          $count+=$ar[5][$h]["count"];
        }
      if($Sunday)
        if (isset($ar[6][$h])) {
          $avgPerH[$h]+=$ar[6][$h]["avg"]*$ar[6][$h]["count"];
          $count+=$ar[6][$h]["count"];
        }

      
      if ($count) {
        $avgPerH[$h]/=$count;
      }
    }
    //var_dump($avgPerH);
    $jsonn="[";
    for($i=0;$i<count($avgPerH);++$i){
      $jsonn=$jsonn.$avgPerH[$i].",";
    }
    $jsonn[-1]="]";
    return $jsonn;
  }
}
class RequestMethodStats{
  public $get=0;
  public $head=0;
  public $post=0;
  public $put=0;
  public $delete_=0;
  public $connect=0;
  public $options=0;
  public $trace=0;
  public function parse($methodType){
    $methodType=strtoupper($methodType);
    switch ($methodType) {
      case 'GET':
        ++$this->get;
        break;
      //
      case 'HEAD':
        ++$this->head;
        break;
      //
      case 'POST':
        ++$this->post;
        break;
      //
      case 'PUT':
        ++$this->put;
        break;
      //
      case 'DELETE':
        ++$this->delete_;
        break;
      //
      case 'CONNECT':
        ++$this->connect;
        break;
      //
      case 'OPTIONS':
        ++$this->options;
        break;
      //
      case 'TRACE':
        ++$this->trace;
        break;
      //
      default:
        # Non common method type in 2021 no need to parse.
        break;
    }
  }
}
class ResponseStatusStats{
  public $informational=0;//0xx
  public $successful=0;//0xx
  public $redirection=0;//0xx
  public $client_error=0;//0xx
  public $server_error=0;//0xx
  public function parse($statusCode){//  https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
    //$methodType=strtoupper($methodType);
    $statusCode=substr($statusCode, 0, 1);
    switch ($statusCode) {
      case 1:
        ++$this->informational;
        break;
      //
      case 2:
        ++$this->successful;
        break;
      //
      case 3:
        ++$this->redirection;
        break;
      //
      case 4:
        ++$this->client_error;
        break;
      //
      case 5:
        ++$this->server_error;
        break;
      //
      default:
        break;
    }
  }
}

class RequestUrls{//urls here
  public function parseAndAddToDb($requestUrl){
    $parsed=parse_url($requestUrl);
    if ($parsed&&isset($parsed["host"])&&$parsed["host"]) {
      return (new Database)->insertRequestUrl($parsed["host"]);
    }
    return false;
  }
}

class ContentTypeAges{
  public function parseHeadersAndAddToDb($searchInHeaders){
    $contentType=false;
    $age=false;
    for ($i=0; $i < count($searchInHeaders); $i++) { 
      
      if(isset($searchInHeaders[$i]["name"])&&$searchInHeaders[$i]["name"]=="Content-Type"&&isset($searchInHeaders[$i]["value"])&&$searchInHeaders[$i]["value"]){
        $contentType=$searchInHeaders[$i]["value"];
      }
      if(isset($searchInHeaders[$i]["name"])&&$searchInHeaders[$i]["name"]=="content-type"&&isset($searchInHeaders[$i]["value"])&&$searchInHeaders[$i]["value"]){
        $contentType=$searchInHeaders[$i]["value"];
      }
      if(isset($searchInHeaders[$i]["name"])&&$searchInHeaders[$i]["name"]=="date"&&isset($searchInHeaders[$i]["value"])&&$searchInHeaders[$i]["value"]){
        $age=$searchInHeaders[$i]["value"];
      }
      if(isset($searchInHeaders[$i]["name"])&&$searchInHeaders[$i]["name"]=="Date"&&isset($searchInHeaders[$i]["value"])&&$searchInHeaders[$i]["value"]){
        $age=$searchInHeaders[$i]["value"];
      }
    }
    if ($contentType&&$age) {
      $age = DateTime::createFromFormat('D, d M Y H:i:s *', $age);
      if ($age) (new Database())->insertContentTypesAges($contentType,$age->format('Y-m-d H:i:s'));//  https://www.php.net/manual/en/datetime.createfromformat.php#117462
    }
    return false;
  }
}

class TimingsWithExtraData{//todo todoooooooooooooooo
  public static function encode($method){
    $method=strtoupper($method);
    $encoded=false;
    switch ($method) {
      case 'GET':
        $encoded=0;
        break;
      //
      case 'HEAD':
        $encoded=1;
        break;
      //
      case 'POST':
        $encoded=2;
        break;
      //
      case 'PUT':
        $encoded=3;
        break;
      //
      case 'DELETE':
        $encoded=4;
        break;
      //
      case 'CONNECT':
        $encoded=5;
        break;
      //
      case 'OPTIONS':
        $encoded=6;
        break;
      //
      case 'TRACE':
        $encoded=7;
        break;
      //
      default:
        # Non common method type in 2021 no need to parse.
        break;
    }
    if ($encoded===false){
      return false;
    }else {
      return $encoded;
    }

  }
  public function parseEntryAndAddTimingsAndExtraInfoToDb($searchInEntry,$isp){
    if (isset($searchInEntry["timings"]["wait"])&&$searchInEntry["timings"]["wait"]&&isset($searchInEntry["request"]["headers"])&&isset($searchInEntry["startedDateTime"])&&isset($searchInEntry["request"]["method"])) {
      $timing=$searchInEntry["timings"]["wait"];
      $dateTime=$searchInEntry["startedDateTime"];//
      $method=$searchInEntry["request"]["method"];
      $contentType=false;
      for ($i=0; $i <count($searchInEntry["request"]["headers"]); $i++) { 
        if (isset($searchInEntry["request"]["headers"][$i]["name"])&&strtolower($searchInEntry["request"]["headers"][$i]["name"])=="content-type"&&isset($searchInEntry["request"]["headers"][$i]["value"])) {
          $contentType=$searchInEntry["request"]["headers"][$i]["value"];
        }
      }
      if(!$contentType)return false;
      if (($method=$this->encode($method))===false) return false;
      return (new Database())->insertEntryTimings($timing,$contentType,$dateTime,$method,$isp);
    }
  }
}

function isPasswordOK($string)
{
  if (strlen($string) < 8) {
    return "Password length must be more than 8 chars.";
  }
  if (!preg_match('~[A-Z]+~', $string)) { //https://stackoverflow.com/questions/18683444/how-to-detect-numbers-in-a-string-with-php
    return "Password must contain more than 1 capital letter.";
  }
  if (!preg_match('~[0-9]+~', $string)) { //https://stackoverflow.com/questions/18683444/how-to-detect-numbers-in-a-string-with-php
    return "Password must contain more than 1 number.";
  }
  if (!(str_contains($string, "#") || str_contains($string, "$") || str_contains($string, "*") || str_contains($string, "&") || str_contains($string, "@"))) { //π.χ. #$*&@
    return "Password must contain more than 1 special characters (example: #$*&@).";
  }
  return "";
}
