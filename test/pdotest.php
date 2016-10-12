<?php
//My PDO Test
//db connect - PDO
//$host = 'localhost';
//$database = 'doccontrol';
//$user = 'doccontrol';
//$pw = '5A%uu!3#l!';
try{
	$db = new PDO('mysql:host=localhost;dbname=gda;charset=utf8', 'gdaadmin', '3E4eXod3Q4DI');
	
	$sql = "SELECT * FROM tblcustomers WHERE Username=:myemail";
	//$result = $db->query($sql);
	
	$stmt = $db->prepare($sql);
	$stmt->execute(array('myemail'=>'test@test.com'));

	//$result = $db->query('SELECT * FROM tblDocuments');
	
		//foreach($result as $row)
		//while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		//{
			//echo 'Ownerid: ' . $row['fkdocOwner'];
			//echo 'Deptid: ' . $row['fkdocRegDept'];
		//}
		
		echo $stmt->rowCount();
		
		
		
		//simple string
		/*$string = "Not \' so\' nice";
		echo "Unquoted string: $string\n";
		echo "Quoted string: " . $db->quote($string) . "\n";
		
		//simple insert using exec
		$result = $db->exec("INSERT INTO tblTest(FirstName, LastName) VALUES ('John', 'Doe')");
		$insertId =  $db->lastInsertId();
		echo $insertId;
		
		$insert = $db->exec("UPDATE tblTest SET LastName='Rose'");
		echo $insert . ' were affected';
		*/
}
catch (PDOException $ex) {
	echo 'An db connection error occurred';
	echo $ex;
}




?>