<?php 
 try{
$word = new \COM("Word.Application") or die ("Could not initialise Object.");
// set it to 1 to see the MS Word window (the actual opening of the document)
$word->Visible = 1;
// recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
$word->DisplayAlerts = 0;
// open the word 2007-2013 document 
$word->Documents->Open('c:\xampp\htdocs\VISUAL MANAGEMENT SYSTEM\LIVE\Livetracker_1_3_0\LIVETRACKER\QUALITY1\non_conformance\57 (5).docx');//这个是绝对文件地址，如c:\www\1.txt这样的地址才通过
// save it as word 2003
$word->ActiveDocument->SaveAs('c:\xampp\htdocs\VISUAL MANAGEMENT SYSTEM\LIVE\Livetracker_1_3_0\LIVETRACKER\QUALITY1\non_conformance\newdocument.doc');//转换成doc格式
// convert word 2007-2013 to PDF
$word->ActiveDocument->ExportAsFixedFormat('yourdocument.pdf', 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);//转换为pdf模式
// quit the Word process
$word->Quit(false);
// clean up
unset($word);
 }
catch(Exception $e){
    echo $e;
}