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
      case 'DELETE_':
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
