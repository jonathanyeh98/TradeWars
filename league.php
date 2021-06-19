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
        <h2><strong><?php echo $_SESSION['username']; ?></strong>'s Leagues</h2>
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
			<p><a href="create_league.php">Create League</a></p>
            <form method = "post">
                <select name = "league_dropdown" id = "league_dropdown">
                    <label for = "league_dropdown">Leagues: </label>
                    <option selected = "selected" > </option>
                    <?php
                    $sql = "select * from usertable where (username = '".$_SESSION['username']."')";
                    $result = mysqli_query($db,$sql);
                    $row_user = mysqli_fetch_row($result);
                    $user_id = $row_user[0];
                    $_SESSION['user_id'] = $user_id;
                    $sql1 = "select playertable.user_id, leaguetable.league_name from playertable inner join leaguetable on leaguetable.league_id = playertable.league_id where (playertable.user_id = '".$user_id."')";
                    $leagues = mysqli_query($db,$sql1);
                    $leagues_array = [];
                    if ($leagues){
                        while($row = mysqli_fetch_assoc($leagues)){
                            array_push($leagues_array, $row['league_name']);
                        }
                        foreach($leagues_array as $league){
                            echo"<option value = '$league'>$league</option>";
                        }
                    }
                    ?>
                </select>
                <input type = "submit" value = "Choose" formaction = "league_page.php">
            </form>
            
        <?php endif ?>
    </div>

</body>
</html>