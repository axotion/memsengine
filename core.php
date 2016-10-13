<?php
class cms{
private $db;
function __construct($name){
$this->db = $name;
}
public function login($nick,$pass){
           	$db = new PDO("sqlite:".$this->db."");
                $qur = $db->query("SELECT * FROM users WHERE nick = '$nick'");
				$pass = md5($pass);
                foreach($qur as $res){
		if($res['nick'].$res['pass'] == $nick.$pass) echo "Logged in";
                else echo "Bad, bad thing";
                 }
				 }
public function add_article($title, $content){
	$db = new PDO("sqlite:".$this->db);
	$dat = date("Y-F-l g:i a"); 
	//$content = str_replace(' ', '-', $content);
	$content = str_replace("'", "", $content);
	$content = str_replace("<script>", " ", $content);
	$content = str_replace("<?php>", " ", $content);
	$content = str_replace("<?", " ", $content);
	$content = str_replace("<script", " ", $content);
	$content = str_replace("alert", "alertt", $content);
	$content = str_replace("prompt", "promptt", $content);
	//$content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
	$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
	$content =  strip_tags($content, '<img><b><u><br>');
//	$content = str_replace(",", " ", $content);
	//$content = str_replace(".", " ", $content);
	if($db->query("INSERT INTO art (title, content, date) VALUES ('$title', '$content', '$dat' )")){
		Header("Refresh: 3");
	}
}
public function show_all_art(){
	$db = new PDO("sqlite:".$this->db."");
	 $sql = $db->query("SELECT * FROM art");
	 echo "<table>";
	 foreach($sql as $res){
		 echo "<tr><td>".$res['title']."</td> <td>".$res['content']."</td><td>".$res['date']."</td></tr>";
	 }
	 echo "</table>";
}
public function register($nick,$pass){
$db = new PDO("sqlite:".$this->db);
$pass = md5($pass);
$sql = $db->query("SELECT nick FROM users WHERE nick = '$nick'");
$con = count($sql->fetchAll());
if($con  > 0){
	echo "User exists";
	exit(0);
}
$sql_insert = "INSERT INTO users VALUES ('$nick', '$pass')";
$db->query($sql_insert);
echo "Done";
}
public function upload($file, $dir){
	$fil = $_FILES[$file]['tmp_name'];
	if(getimagesize($fil) != 0){
	 move_uploaded_file($_FILES[$file]["tmp_name"], $dir."/".$_FILES[$file]["name"]);
	}
	}
public function art_form(){
	echo " 
	<center><form method='POST' enctype='multipart/form-data'>
	<input type='text' name='title' placeholder='Title' required><br><br>
	<textarea rows='4' cols='50' name='content' placeholder='Write desc...' required></textarea>
	<br>
	<input type='file' name='file' value='Add photo'>
	<input type='submit' name='Send' value='Post'>
	</form></center>
	";
	if(isset($_POST['Send'])){
	//	$path = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
   $fil = $_FILES['file']['name'];
   if(!empty($_FILES['file']['tmp_name'])){
   $if_image = getimagesize($_FILES['file']['tmp_name']);
   }
   //echo " <br> <img src='photos/".$fil."' alt=' '>";
   if(!empty($_FILES['file']['name']) AND $if_image != 0 AND !file_exists("photos/".$_FILES['file']['name'])){
	$this->upload("file", "photos");
  	$con = $_POST['content']." <br> <img src='photos/".$fil."' alt=' '>";
	$this->add_article($_POST['title'], $con);   
   }
		}
}
public function art_del($title){
	$db = new PDO("sqlite:".$this->db);
	if($sql = $db->query("DELETE FROM art WHERE title='$title'")){
		echo "<script>alert(' ".$title." deleted')</script>";
	}
}
public function show_per_page(){
if(!isset($_GET['page'])){
	$page = 1;
}
else{
$page = $_GET['page'];
}
try{
$start_from = ((int)$page-1) * 5;
}
catch(Exception $e){
	echo "Something gone wrong... :(";
}
$db = new PDO("sqlite:".$this->db);
$nRows = $db->query('select count(*) from art')->fetchColumn(); 
$sql = $db->query("SELECT * FROM art ORDER BY ID DESC LIMIT '$start_from', 5");
$z = "";
echo "<div>";
foreach($sql as $res){
echo "<center><h3>".$res['title']."</h1>".$res['content']."<br>".$res['date']."<hr>";
$z = $res['date'];
		}
echo "</div>";
//if($sql->fetchColumn() == 0 ){
	//Header("Location: 404.php");
//}
if($z == ""){
	Header("Location: 404.php");
}
if($nRows >= $start_from){
echo "<z><a style='padding-left:25%;color:white;    text-decoration:none;
' href='?page=".((int)$page+1)."'>Next</a></z>";
}
if($start_from > 0)
	echo "<z><a style='padding-left:39%;color:white;    text-decoration:none;
' href='?page=".((int)$page-1)."'>Previous</a></z>";
//if($sql->fetchAll() == 0)
//echo "Puste";
}
public function del_art_form(){
echo "
<form method='POST'>
<input type='text' name='del' placeholder='title' >
<input type='submit' name='delete' value='delete'>
</form>";
if(isset($_POST['delete']))
	$this->art_del($_POST['del']);
}
public function show_art_blog(){
	$db = new PDO("sqlite:".$this->db."");
	 $sql = $db->query("SELECT * FROM art ORDER BY ID DESC");
	 echo "<div>";
	foreach($sql as $res){
		 echo "<center><h3>".$res['title']."</h1>".$res['content']."<br>".$res['date']."<hr>";
	 } echo "</div>";
}
}
?>