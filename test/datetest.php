<?php
	require('../marketinghd/dbconnect.php');
	
	$sql = "SELECT * FROM tbluserstomaintasks WHERE fkUserId = :myuserid";
		
		$stmt = $db->prepare($sql);
		$stmt->execute(array(':myuserid'=>1));
		
		$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$sql = "SELECT * FROM tblmaintasks WHERE pkId = :mytaskid";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':mytaskid'=>$row['fkMainTaskId']));
		
			$result2= $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result2 as $row2)
			{
				echo $row2['ShortDescription'] . ' ';
				$oldduedate = $row2['DueDate'];
				$newdatestamp = strtotime($oldduedate);
				$newdate = date('m/d/Y h:m a' , $newdatestamp);

				//$olddate = '2015-01-15 09:00:00';
				//newdatestamp = strtotime($olddate);
				//$newdate = date('m/d/Y h:m a' , $newdatestamp);
				
				
				//echo 'due date: ' . $row2['DueDate'] . ' ';
				echo $newdatestamp. ' ';
				
				//echo 'duedatetimestamp: ' . $newdatestamp;
				$mynow = time();
				
				echo ' now: ' . $mynow;

				//$myjson.= '"opendate": "' . $newdate . '"' . $comma;
							
				if($newdatestamp <= $mynow)
				{
					echo 'red';
				}
				else
				{
					echo 'blue';
				}
				echo '<br/>';
			}
		}
		
		
		if(1421438400 < 1421428571)
		{
			echo 'overdue';
		}
		else
		{
			echo 'not overdue';
		}
?>