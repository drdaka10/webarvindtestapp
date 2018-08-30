<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US"> 

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title> 
		Rafael, Arvind, and John's Car App
	</title>


	<style>
		.error {color: #FF0000;}
	</style>

	<!-- Include CSS for different screen sizes -->
	<link rel="stylesheet" type="text/css" href="defaultstyle.css">
</head>

<body>

<?php
	
	require 'connectToDatabase.php';

	// Connect to Azure SQL Database
	$conn = ConnectToDabase();

	// Get data for expense categories
	$tsql="SELECT CATEGORY FROM Expense_Categories ORDER BY CATEGORY ASC";
	$expenseCategories= sqlsrv_query($conn, $tsql);

	// Populate dropdown menu options 
	$options = '';
	while($row = sqlsrv_fetch_array($expenseCategories)) {
		$options .="<option>" . $row['CATEGORY'] . "</option>";
	}

	// Close SQL database connection
	sqlsrv_close ($conn);

	// Get the session data from the previously selected Expense Month, if it exists
	session_start();
	if ( !empty( $_SESSION['prevSelections'] ))
	{ 
		$prevSelections = $_SESSION['prevSelections'];
		unset ( $_SESSION['prevSelections'] );
	}

	// Extract previously-selected Month and Year
	$prevstartDate= $prevSelections['prevstartDate'];
	$prevendDate= $prevSelections['prevendDate'];
?>

<div class="intro">

	<h2> Rafael, Arvind, and John's Car App </h2>

	<!-- Display redundant error message on top of webpage if there is an error -->
	<h3> <span class="error"> <?php echo $prevSelections['errorMessage'] ?> </span> </h3>

</div>

<!-- Define web form. 
The array $_POST is populated after the HTTP POST method.
The PHP script insertToDb.php will be executed after the user clicks "Submit"-->
<div class="container">
	<form action="insertToDb.php" method="post">

		<label>Employee Name:</label>
		<input type="text" name="employee_name" required>

		<label>Start Date (MM/DD/YYYY):</label>
		<input type="text" name="start_date" required>

		<label>End Date (MM/DD/YYYY):</label>
		<input type="text" name="end_date" required>

		<label>Vehicle Make:</label>
		<input type="text" name="vehicle_make" required>

		<label>Vehicle Model:</label>
		<input type="text" name="vehicle_model" required>

		<button type="submit">Submit</button>
	</form>
</div>

<h3> Previous Input (if any) - for verification purposes:</h3>
<p> Employee Name: <?php echo $prevSelections['prevemployeeName'] ?> </p>
<p> Start Date: <?php echo $prevSelections['prevstartDate'] ?> </p>
<p> End Date: <?php echo $prevSelections['prevendDate'] ?> </p>
<p> Vehicle Make: <?php echo $prevSelections['prevvehicleMake'] ?> </p>
<p> Vehicle Model: <?php echo $prevSelections['prevvehicleModel'] ?> </p>
<p> <span class="error"> <?php echo $prevSelections['errorMessage'] ?> </span> </p>

</body>
</html>
