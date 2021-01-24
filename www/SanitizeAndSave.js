function sanitizeAndSaveHar(harFile,name){
  //let har;
  Promise.resolve(harFile.text()).then(function(value) {
    try {
      let har=JSON.parse(value);
      for(entry in har["log"]["entries"]){
        for(element2 in har["log"]["entries"][entry]){
          if (har["log"]["entries"][entry][element2]["postData"]) {//remove sensitive
            console.log("Sensitive info found:\npostData:\n"+JSON.stringify(har["log"]["entries"][entry][element2]["postData"]));
            har["log"]["entries"][entry][element2]["postData"]=undefined;
          }
          if (har["log"]["entries"][entry][element2]["cookies"]) {//remove sensitive
            console.log("Sensitive info found:\ncookies:\n"+JSON.stringify(har["log"]["entries"][entry][element2]["cookies"]));
            har["log"]["entries"][entry][element2]["cookies"]=undefined;
          }
          if(har["log"]["entries"][entry][element2]["headers"]){//removes "name": "Cookie"  (in headers)
            for(i=0;i<har["log"]["entries"][entry][element2]["headers"].length;++i){
              if (har["log"]["entries"][entry][element2]["headers"][i]["name"].toLowerCase().includes("cookie")) {
                har["log"]["entries"][entry][element2]["headers"][i]=undefined;
              }
            }
          }
        }
      }

      downloadToFile(JSON.stringify(har),name,'text/plain');

    } catch (error) {
      console.log("File with contents:\n"+value+"\nisnt a har file correctly formatted.");
      console.log(error);
    }
  }, function(value) {
    console.log("Resolve failed:\n"+value);
  });
}

//    https://robkendal.co.uk/blog/2020-04-17-saving-text-to-client-side-file-using-vanilla-js
const downloadToFile = (content, filename, contentType) => {
  const a = document.createElement('a');
  const file = new Blob([content], {type: contentType});
  
  a.href= URL.createObjectURL(file);
  a.download = filename;
  a.click();

	URL.revokeObjectURL(a.href);
};

// document.getElementById("sanitize").addEventListener('click', () => {
//   const textArea = document.querySelector('textarea');
  
//   downloadToFile(textArea.value, 'my-new-file.txt', 'text/plain');
// });