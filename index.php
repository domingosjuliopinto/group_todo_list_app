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
			 $number = $row['task_id'];
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
	
	$choice = 0;
	//sort by choice
	if (isset($_POST['default'])){
		$choice = 0;
	}
	
	if (isset($_POST['priority_asc'])){
		$choice = 1;
	}
	
	if (isset($_POST['priority_desc'])){
		$choice = 2;
	}
	
	if (isset($_POST['deadline_asc'])){
		$choice = 3;
	}
	
	if (isset($_POST['deadline_desc'])){
		$choice = 4;
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
	<form method="post" action="index.php" class="input_form">
		<label for="choice">View Task by</label><br>
		<button type="submit" name="default" id="default_btn" class="add_btn">Default view</button>
		<button type="submit" name="priority_asc" id="priority_asc_btn" class="add_btn">Priority Asc view</button>
		<button type="submit" name="priority_desc" id="priority_desc_btn" class="add_btn">Priority Desc view</button>
		<button type="submit" name="deadline_asc" id="deadline_asc_btn" class="add_btn">Deadline Asc view</button>
		<button type="submit" name="deadline_desc" id="deadline_desc_btn" class="add_btn">Deadline Desc view</button>
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
		$tasks = "";
		if($choice==0){
			$tasks = mysqli_query($db, "SELECT * FROM tasks");
		}elseif($choice==1){
			$tasks = mysqli_query($db, "SELECT * FROM tasks ORDER BY priority ASC");
		}elseif($choice==2){
			$tasks = mysqli_query($db, "SELECT * FROM tasks ORDER BY priority DESC");
		}elseif($choice==3){
			$tasks = mysqli_query($db, "SELECT * FROM tasks ORDER BY deadline ASC");
		}elseif($choice==4){
			$tasks = mysqli_query($db, "SELECT * FROM tasks ORDER BY deadline DESC");
		}else{
			$tasks = mysqli_query($db, "SELECT * FROM tasks");
		}

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