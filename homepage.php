<?php include ('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>TradeWars</title>
    <link rel="stylesheet" type="text/css" href="style.css?version=51">
</head>
<body>
	<div class = "navbar">
        <a class="active" href="homepage.php"><b>TradeWars</b></a>
        <a class="active" href="register.php">Sign Up</a>
        <a class="active" href="login.php">Log In</a>
    </div>
    <div class="header">
        <h2><script type="text/javascript">

            var dayNames = new Array("Sunday", "Monday", "Tuesday", "Wednesday",
                "Thursday", "Friday", "Saturday");

            // Array of month Names
            var monthNames = new Array(
                "January", "February", "March", "April", "May", "June", "July",
                "August", "September", "October", "November", "December");

            var now = new Date();
            document.write(dayNames[now.getDay()] + ", " +
                monthNames[now.getMonth()] + " " +
                now.getDate());
        </script></h2>
    </div>
	<div class="content">
		<iframe width="100%" height="600" src="https://rss.app/embed/v1/IdphRCmRpK7Ncvbg" frameBorder="0"></iframe>
    </div>
</body>
</html>