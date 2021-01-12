<?php session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
if (isset($_SESSION["email"])&&isset($_POST["button"])&&isset($_POST["isp"])&&isset($_POST["ip"])&&$_POST["isp"]&&$_POST["ip"]) {
  $database=new Database();
  $requestMethodStats=new RequestMethodStats();
  $responseStatusStats=new ResponseStatusStats();
  $requestUrl=new RequestUrls();
  $harFilesUploaded=0;
  if(isset($_FILES["filename"]["tmp_name"])){
    $numberOfFiles=count($_FILES["filename"]["tmp_name"]);

    $debug_externalRequestsPerformed=0;
    $ipDetailsCache=[];
    for($i=0;$i<$numberOfFiles;++$i) {
      if(!$_FILES["filename"]["error"][$i]){
        $jFile=json_decode((file_get_contents($_FILES["filename"]["tmp_name"][$i])),true);
        if (!json_last_error()) {
          $harFilesUploaded=$harFilesUploaded+1;
          for ($ii=0; $ii < count($jFile["log"]["entries"]); ++$ii) { 
            if(isset($jFile["log"]["entries"][$ii]["serverIPAddress"])&&$jFile["log"]["entries"][$ii]["serverIPAddress"]){//parse serverIPAddress to x,y
              if (isset($ipDetailsCache[$jFile["log"]["entries"][$ii]["serverIPAddress"]])) {
                $details=$ipDetailsCache[$jFile["log"]["entries"][$ii]["serverIPAddress"]];
              }else{
                $debug_externalRequestsPerformed=$debug_externalRequestsPerformed+1;
                $details=json_decode(file_get_contents("https://freegeoip.app/json/".$jFile["log"]["entries"][$ii]["serverIPAddress"]),true);//https://geo.wpforms.com/v2/geolocate/json/?address=1.1.1.1    http://free.ipwhois.io/json/1.1.1.1    //http://www.geoplugin.net/json.gp?ip=1.1.1.1
                $ipDetailsCache[$jFile["log"]["entries"][$ii]["serverIPAddress"]]=$details;
              }
              if (isset($details["latitude"])&&isset($details["longitude"])&&is_numeric($details["latitude"])&&is_numeric($details["longitude"])) {
                $database->insertHttp_request($_SESSION["email"],$details["latitude"],$details["longitude"]);
              }
            }
            if(isset($jFile["log"]["entries"][$ii]["request"]["method"])){//parse request method type
              $requestMethodStats->parse($jFile["log"]["entries"][$ii]["request"]["method"]);
            }
            if(isset($jFile["log"]["entries"][$ii]["response"]["status"])){//parse response status stats
              $responseStatusStats->parse($jFile["log"]["entries"][$ii]["response"]["status"]);
            }
            if(isset($jFile["log"]["entries"][$ii]["request"]["url"])){//parse response url
              $requestUrl->parseAndAddToDb($jFile["log"]["entries"][$ii]["request"]["url"]);
            }
          }
        }
        //todo more db stuff laterz
      }
    }
    //echo"<br>{$debug_externalRequestsPerformed}<br>";
  }
  if($harFilesUploaded>0){
    $database->insertUsers_footprint($_SESSION["email"],$_POST["isp"],$_POST["ip"]);
    $database->updateUserLastUploadDATETIME($_SESSION["email"]);
    $database->increaseUserNumber_of_uploadsBy($_SESSION["email"],$harFilesUploaded);
    $database->increaseRequestMethodStatsBy($requestMethodStats->get,$requestMethodStats->head,$requestMethodStats->post,$requestMethodStats->put,$requestMethodStats->delete_,$requestMethodStats->connect,$requestMethodStats->options,$requestMethodStats->trace);
    $database->increaseResponseStatusStatsBy($responseStatusStats->informational,$responseStatusStats->successful,$responseStatusStats->redirection,$responseStatusStats->client_error,$responseStatusStats->server_error);
  }
}
?>





<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="/css/style.css"/>
  <link rel="stylesheet" type="text/css" href="/css/sign.css"/>
  <script src="/js/bootstrap.bundle.js"></script>
  <script src="/jquery-3.5.1.js"></script>
  
  <?php if (!isset($_SESSION["email"])):?>
    <script>
    function fn(){location.replace("/login");}
      setTimeout(fn,750);
    </script>
  <?php endif?>
  <title>Har tool</title>
</head>
<body>
<?php if (isset($_SESSION["email"])):?>
  <?php echo"Welcome ".(isset($_SESSION["email"])?htmlspecialchars($_SESSION["email"]):"guest").".";?>
  <?php include ($_SERVER["DOCUMENT_ROOT"]."/../menu.php");?>
  <form class="form-sign" action="" method="POST" id="form1" enctype="multipart/form-data"><!-- https://stackoverflow.com/a/10164816/5941827 -->
    <h1 class="h4 mb-1 fw-normal text-center">ISP detected:</h1>
    <input class="form-control me-2" type="text" name="isp" placeholder="" value="" id="isp" readonly><br>
    <h1 class="h4 mb-1 fw-normal text-center">IP detected:</h1>
    <input class="form-control me-2" type="text" name="ip" placeholder="" value="" id="ip" readonly><br><br>
    <h1 class="h4 mb-1 fw-normal text-center">Choose har file(s)</h1>
    <input class="form-control mb-3" type="file" name="filename[]" multiple="true" id="harFiles">
    <h1 class="h4 mb-1 fw-normal text-center">Choose operation</h1>
    <button class="mb-1 w-100 btn btn-lg btn-success" type="button" value="Sanitize" name="button" id="sanitize">Sanitize</button>
    <button class="w-100 btn btn-lg btn-success" type="submit" value="Upload" name="button" form="form1" id="button">Upload</button>
    <script src="/SanitizeAndSave.js"></script>
  </form>
  <script>
    el=document.getElementById("harFiles");
    document.getElementById("sanitize").addEventListener("click", sanitize);
    function sanitize(){
      for (let index = 0; index < el.files.length; ++index) {
        const file = el.files[index]
        sanitizeAndSaveHar(file,"sanitized_"+file.name);
      }
    }
    $.getJSON('http://ip-api.com/json', function(data) {//  https://stackoverflow.com/a/12460434/5941827
      document.getElementById("isp").value=data["isp"];
      document.getElementById("ip").value=data["query"];
    });

  </script>
<?php else:?>
Log in first.
<?php endif?>
  <footer class="bd-footer bg-dark text-light fixed-bottom text-center">
    <div class="container">
      <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
    </div>
  </footer>
</body>
</html>

