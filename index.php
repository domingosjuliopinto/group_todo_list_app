<?php 
    // initialize errors variable
	$errors = "";

	// connect to database
	$db = mysqli_connect("localhost", "root", "", "todo");

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
			$errors = "You must fill in the task";
		}elseif(empty($_POST['priority'])){
			$errors = "You must fill in the priority";
		}elseif(empty($_POST['deadline'])){
			$errors = "You must fill in the deadline";
		}else{
		
			// select all tasks if page is visited or refreshed
			$tasks_set = mysqli_query($db, "SELECT * FROM tasks");

			$number = 1; while ($row = mysqli_fetch_array($tasks_set)) { 
			 $number++; 
			}
			
			$task = $_POST['task'];
			$priority = $_POST['priority'];
			$deadline = $_POST['deadline'];
			$sql = "INSERT INTO tasks (task_id,task,priority,deadline) VALUES ('$number','$task','$priority','$deadline')";
			mysqli_query($db, $sql);
			header('location: index.php');
		}
	}
	
	// delete task
	if (isset($_GET['del_task'])) {
		$id = $_GET['del_task'];

		mysqli_query($db, "DELETE FROM tasks WHERE task_id=".$id);
		header('location: index.php');
	}
?>	

<!DOCTYPE html>
<html>
<head>
	<title>Group ToDo List Application</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background:#1E90FF;">
	<div class="heading">
		<h2 style="font-style: 'Hervetica';">Group ToDo List Application</h2>
	</div>
	<form method="post" action="index.php" class="input_form">
	<?php if (isset($errors)) { ?>
		<p><?php echo $errors; ?></p>
	<?php } ?>
		<label for="task">Task</label>
		<input type="text" name="task" class="task_input"><br>
		<label for="priority">Priority</label>
		<input type="number" name="priority" class="task_input2">
		<label for="deadline">Deadline</label>
		<input type="date" name="deadline" class="task_input2">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
	</form>
	<table>
	<thead>
		<tr>
			<th>N</th>
			<th>Tasks</th>
			<th style="width: 70px;">Priority</th>
			<th style="width: 120px;">Deadline</th>
			<th style="width: 60px;">Action</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		// select all tasks if page is visited or refreshed
		$tasks = mysqli_query($db, "SELECT * FROM tasks");

		$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="task"> <?php echo $row['task']; ?> </td>
				<td class="task"> <?php echo $row['priority']; ?> </td>
				<td class="task"> <?php echo $row['deadline']; ?> </td>
				<td class="delete"> 
					<a href="index.php?del_task=<?php echo $row['task_id'] ?>">x</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	</tbody>
	</table>
	
</body>
</html>