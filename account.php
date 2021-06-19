<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Account Settings</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h2>Account Settings</h2>
    </div>
    <form method="post" action="account.php">
    <!-- display validation errors here -->
    <?php include ('errors.php'); ?>
		<?php
		$currusername = $_SESSION['username'];
		$emailquery = "SELECT email FROM usertable WHERE username='$currusername'";
		$result = mysqli_query($db,$emailquery);
		?>
		<?php if (isset($_SESSION['success'])): ?>
            <div class="error success">
                <h3>
                    <?php   
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
		<p>Current Email: 
			<?php 
				while ($row = $result->fetch_assoc()) {
				echo $row['email']."<br>";}
			?> 
		</p>
        <div class="input-group">
            <label>New Email</label>
            <input type="text" name="newemail" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
            <label>New Password</label>
            <input type="text" name="password_new_1">
        </div>
        <div class="input-group">
            <label>Confirm New Password</label>
            <input type="text" name="password_new_2">
        </div>
		<div class="input-group">
            <label>Old Password</label>
            <input type="text" name="password_old">
        </div>
        <div class="input-group">
            <button type="submit" name="updateaccount" class="btn">Update</button>
        </div>
		<p><a href="index.php">Back</a></p>
    </form>
	
</body>
</html>