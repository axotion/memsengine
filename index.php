<!--CMS by Axo 1.0-->
<!DOCTYPE html>
<head>
<link href='https://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
<style>
img{
    width:40%; 
    height: 60%;
}
z{
	font-family: 'Indie Flower', cursive;
}
div{
	margin-left: 25%;
	margin-right: 25%;
    border-style: solid;
	background: black;
	}
body{
background: -moz-radial-gradient(center, ellipse cover, rgba(0,0,255,1) 0%, rgba(0,0,0,1) 100%); ff3.6+
background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(0,0,255,1)), color-stop(100%, rgba(0,0,0,1))); safari4+,chrome
background:-webkit-radial-gradient(center, ellipse cover, rgba(0,0,255,1) 0%, rgba(0,0,0,1) 100%); safari5.1+,chrome10+
background: -o-radial-gradient(center, ellipse cover, rgba(0,0,255,1) 0%, rgba(0,0,0,1) 100%); opera 11.10+
background: -ms-radial-gradient(center, ellipse cover, rgba(0,0,255,1) 0%, rgba(0,0,0,1) 100%); /* ie10+ */
background:radial-gradient(ellipse at center, rgba(0,0,255,1) 0%, rgba(0,0,0,1) 100%); /* w3c */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0000ff', endColorstr='#000000',GradientType=1 ); /* ie6-9 */
    color:white;
    opacity:0.95;
}
a:link{
	color:red;
	 font-size:200%;
	 text-decoration:none;
}
a:visited{
	color:black;
    font-size:100%;
	}
a:hover{
	color:green;
}
</style>
<title>Mems engine by Axo</title>
<?php
session_start();
include('core.php');
if(!isset($_SESSION['lock'])){
	$_SESSION['lock'] = 1;
    $_SESSION['date'] = date("h:i");	
}
$_SESSION['lock']++;
if($_SESSION['date'] != date("h:i")){
	unset($_SESSION['lock']);
	unset($_SESSION['date']);
	session_destroy();
}
if(!isset($_SESSION['lock'])){
	$_SESSION['lock'] = 1;
    $_SESSION['date'] = date("h:i");	
}
echo "<z><center><h1>Site with not funny memes<h2></center></z>";
$a = new cms('test');
if($_SESSION['lock'] <= 5)
$a->art_form();
echo "<a href='/mems'><p style='margin-left:25%; margin-right:70%;  background: #5c6870;
  background-image: -webkit-linear-gradient(top, #5c6870, #324754);
  background-image: -moz-linear-gradient(top, #5c6870, #324754);
  background-image: -ms-linear-gradient(top, #5c6870, #324754);
  background-image: -o-linear-gradient(top, #5c6870, #324754);
  background-image: linear-gradient(to bottom, #5c6870, #324754);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  -webkit-box-shadow: 0px 1px 3px #666666;
  -moz-box-shadow: 0px 1px 3px #666666;
  box-shadow: 0px 1px 3px #666666;
  font-family: Arial;
  color: #ffffff;
  font-size: 20px;
  background: #3498db;
  padding: 10px 20px 10px 20px;
  text-decoration: none;'>Main</p></a>";
$a->show_per_page();
	 ?>
</head>
<body>
</body>