<!-- 
SEED Lab: SQL Injection Education Web plateform
Author: Kailiang Ying
Email: kying@syr.edu
-->

<!DOCTYPE html>
<html>
<body>


<?php
   session_start(); 
   $input_email = $_GET['Email'];
   $input_nickname = $_GET['NickName'];
   $input_address= $_GET['Address'];
   $input_pwd = $_GET['Password']; 
   $input_phonenumber = $_GET['PhoneNumber']; 
   $input_id = $_SESSION['id'];
   $conn = getDB();
  
   // Don't do this, this is not safe against SQL injection attack
   $sql="";
   if($input_pwd!=''){
   	$input_pwd = sha1($input_pwd);
   	$sql = "UPDATE credential SET nickname= ? ,email= ?,address= ?,Password= ?,PhoneNumber= ? where ID= ?;";
   	$stmt = $conn->prepare( $sql );
   	// Bind parameters to the query
  	$stmt->bind_param("ssssss", $input_nickname, $input_email, $input_address, $input_pwd, $input_phonenumber, $input_id);
   	$stmt->execute();
   	$stmt->fetch();
   }else{
   	$sql = "UPDATE credential SET nickname= ?,email= ?,address= ?,PhoneNumber= ?  where ID= ?;";
 	$stmt = $conn->prepare( $sql );
        // Bind parameters to the query
 	$stmt->bind_param("sssss", $input_nickname, $input_email, $input_address, $input_phonenumber, $input_id);
	$stmt->execute();
	$stmt->bind_result($id, $name, $eid, $salary, $birth, $ssn, $phoneNumber, $address, $email, $nickname, $pwd);
	$stmt->fetch();
   }
   $conn->query($sql);
   $conn->close();	
   header("Location: unsafe_credential.php");
   exit();

function getDB() {
   $dbhost="localhost";
   $dbuser="root";
   $dbpass="seedubuntu";
   $dbname="Users";


   // Create a DB connection
   $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
   if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error . "\n");
   }
return $conn;
}
 
?>

</body>
</html> 
