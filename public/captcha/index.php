<?php
ob_start();
session_start();
$form=isset($_GET['form'])?$_GET['form']:'unknow';
$_SESSION['session_on']=1;
$str='qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
$RandomStr = '';// md5 to generate the random string
for($i=0;$i<4;$i++)
{
    $randPosition=rand(0,50);
    $RandomStr.=$str[$randPosition].' ';
}
$ResultStr = $RandomStr;
$NewImage =imagecreatefromjpeg("img.jpg");//image create by existing image and as back ground 
$LineColor = imagecolorallocate($NewImage,255,255,255);//line color 
$TextColor = imagecolorallocate($NewImage, 255, 255, 255);//text color-white
imageline($NewImage,1,4,40,40,$LineColor);//create line 1 on image 
imageline($NewImage,1,100,60,0,$LineColor);//create line 2 on image 
imagestring($NewImage, 100, 10, 7, $ResultStr, $TextColor);// Draw a random string horizontally 
$_SESSION["security_code"][$form] = strtolower(str_replace(' ','',$ResultStr));// carry the data through session
header("Content-type: image/jpeg");// out out the image 
imagejpeg($NewImage);//Output image to browser 
?>