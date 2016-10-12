<?php

$db = new PDO('mysql:host=localhost;dbname=phonebook', 'php-pb', 'hyper');
$query = "SELECT emp_id, lname, fname, number, dept.name as d_name, loc.name as l_name
          FROM emp
          LEFT JOIN dept
            ON emp.dept_id = dept.dept_id
          LEFT JOIN loc
            ON emp.loc_id = loc.loc_id
          WHERE emp.deleted IS NULL
		  ORDER BY lname, fname";

foreach($db->query($query) as $row) {
  $employees[$row['emp_id']] = array(
    'lname' => $row["lname"],
    'fname' => $row["fname"],
    'phone' => $row["number"],
    'loc'   => $row["l_name"],
    'dept'  => $row["d_name"]);
}

echo 'BI, Inc<br/>Phone Book<br/>Updated: ' .  date('F d, Y') . '<br/>';

foreach($employees as $item)
{
	echo $item['lname'];
	echo ', ';
	echo $item['fname'];
	echo ' ';
	echo $item['phone'];
	echo ' ';
	echo $item['loc'];
	echo ' ';
	echo $item['dept'];
	echo "<br/>";

}

//var_dump($item);


?>