		<?php
		session_start();
		date_default_timezone_set('America/Denver');
		$myincrementor = '';	
		ini_set('display_errors', '1');
		//check for user session variable to test if valid login
		if(isset($_SESSION['user']))
		{
			//Check for username and hash
			if (
			((isset($_POST['duedate']))&& ($_POST['duedate']!=null)) ||
			((isset($_POST['duetime']))&& ($_POST['duetime']!=null)) ||
			((isset($_POST['shortdescription']))&& ($_POST['shortdescription']!=null)) ||
			((isset($_POST['longdescription']))&& ($_POST['longdescription']!=null)) ||
			((isset($_POST['priority']))&& ($_POST['priority']!=null)) ||
			((isset($_POST['category']))&& ($_POST['category']!=null)) ||
			((isset($_POST['subcategory']))&& ($_POST['subcategory']!=null)) ||
			((isset($_POST['status']))&& ($_POST['status']!=null)) ||
			((isset($_POST['estimatedtime']))&& ($_POST['estimatedtime']!=null)) ||
			((isset($_POST['tasktype']))&& ($_POST['tasktype']!=null)) 
			)
			{
				//db connect
				include('dbconnect.php');
				$myuserid = $_SESSION['userid'];
				$myusername = $_SESSION['user'];
				$mytaskid = $_POST['mytaskid'];
				$myduedate = date('Y-m-d', strtotime($_POST['duedate']));
				$myduetime = date("H:i", strtotime($_POST['duetime']));
				$myshortdescription = $_POST['shortdescription'];
				$mylongdescription = $_POST['longdescription'];
				$mycategory = $_POST['category'];
				$mysubcategory = $_POST['subcategory'];
				$mypriority = $_POST['priority'];
				$mystatus = $_POST['status'];
				$myestimatedtime = $_POST['estimatedtime'];
				//$mytasktype = $_POST['tasktype'];

				//Check for existing task
				try
				{
					//Update all parameters - ShortDescription, LongDescription, Type, Priority, Status, DueDate, update LastUpdate timestamp to now
					try
					{
						$sql = "UPDATE tblmaintasks SET ShortDescription = :myshortdescription, LongDescription = :mylongdescription, Category = :mycategory, Subcategory = :mysubcategory, Priority = :mypriority, Status = :mystatus, DueDate = :myduedate, EstimatedTime = :myestimatedtime WHERE pkId = :mytaskid";

						$stmt = $db->prepare($sql);

						$stmt->execute(array(':myshortdescription'=>$myshortdescription,':mylongdescription'=>$mylongdescription,':mycategory'=>$mycategory, ':mysubcategory'=>$mysubcategory, ':mypriority'=>$mypriority, ':mystatus'=>$mystatus, ':mypriority'=>$mypriority, ':myduedate'=>$myduedate . ' ' . $myduetime, ':myestimatedtime'=>$myestimatedtime,':mytaskid'=>$mytaskid));

						echo 'success';
					}
					catch(Exception $e)
					{
						echo 'fail tblmaintasks';
					}
				}
				catch(Exception $e)
				{
					echo 'missingexistingtask';
				}//end try existing event
				
				//update task to users join records
				//1 - fetch current records
				try
				{
					$sql="SELECT MAX(Incrementor) FROM tbluserstomaintasks WHERE fkMainTaskId = :mytaskid"; 
					$stmt = $db->prepare($sql);
					$stmt->execute(array(':mytaskid'=>$mytaskid));

					while($row = $stmt->fetch(PDO::FETCH_ASSOC))
					{
						$myincrementor = $row['MAX(Incrementor)'];
						echo $myincrementor;
					}
					//increment the incrementor by one
					$myincrementor++;
				}
				catch(Exception $e){
					echo 'failselectmaxincrementor';
				}

				//2 - insert new join records with incrementor + 1
				try
				{
					//loop through assignee array
					foreach ($_POST['assignees'] as $value)
					{
						$sql = "INSERT INTO tbluserstomaintasks (fkUserId, fkMainTaskId, Incrementor) VALUES (:assigneeuserid, :mynewtaskid, :myincrementor)";
					
						$stmt = $db->prepare($sql);
						$stmt->execute(array(':assigneeuserid'=>$value, ':mynewtaskid'=>$mytaskid, ':myincrementor'=>$myincrementor));
					}
				}
				catch(Exception $e)
				{
					echo 'failtbluserstomaintasks' . $e;
				}
			}//end valid POST values
			else
			{
				echo 'missingdata';
			}//end try post data
		}//end user logged in
		else
		{ //user not logged in
			return 'notloggedin';
		}