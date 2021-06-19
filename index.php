<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>TradeWars</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class = "navbar">
        <a class="active" href="index.php"><b>TradeWars</b></a>
        <a class="active" href="account.php">Your Account</a>
        <a class="active" href="league.php">Leagues</a>
		<a class="active" href="homepage.php?logout='1" style="color: red;">Logout</a></p>
    </div>
    <div class="header">
        <h2>Welcome <strong><?php echo $_SESSION['username']; ?></strong></h2>
    </div>
    <div class="content">
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
        
        <?php if (isset($_SESSION["username"])): ?>
			<p><a href="account.php">Account Settings</a></p>
			<p><a href="league.php">Leagues</a></p>
            <p><a href="homepage.php?logout='1" style="color: red;">Logout</a></p>
			<hr>
			<iframe width="100%" height="500" src="https://rss.app/embed/v1/IdphRCmRpK7Ncvbg" frameBorder="0"></iframe>
        <?php endif ?>
    </div>

</body>
</html>