
var docxConverter = require('docx-pdf');

docxConverter('./word_file.docx','./output.pdf',function(err,result){
  if(err){
    console.log(err);
  }
  console.log('result'+result);
});