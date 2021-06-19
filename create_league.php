<?php include('server.php'); 

?>
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
    <div class = "header">
        <h2>Create League</h2>
    </div>
    
    <form method = "post" >
        <div class="input-group">
            <label>Name</label>
            <input type="text" name="league_name">
        </div>
        <div class="input-group">
            <label>Starting Balance</label>
            <input type="integer" name="league_starting_balance">
        </div>
        <div class="input-group">
            <button type="submit" name="create_league_final" class="btn">Create League</button>
        </div>
        <?php
        if (isset($_POST['create_league_final'])){
            $league_name = $db->real_escape_string($_POST['league_name']);
            $league_starting_balance = $db->real_escape_string($_POST['league_starting_balance']);
        
            //ensure that form fields are filled properly
            if(empty($league_name)){
                array_push($errors,"Name is required");
            }
            if(empty($league_starting_balance)){
                array_push($errors,"Starting Balance is required");
            }
            //if no errors, save league settings to database
            if (count($errors) == 0){
                
                $sql = "select * from usertable where (username = '".$_SESSION['username']."')";
                $result = mysqli_query($db,$sql);
                $row_user = mysqli_fetch_row($result);
                $user_id = $row_user[0];
                $sql1 = "insert into leaguetable (user_id,league_name,league_starting_balance) values ('$user_id','$league_name','$league_starting_balance')";
                $query = mysqli_query($db,$sql1);
                $sql2 = "select * from leaguetable where (league_name = '.$league_name.')";
                $query2 = mysqli_query($db,$sql2);
                $row_league = mysqli_fetch_row($query2);
                $league_id = $row_league[0];
                
                $sql3 = "insert into playertable (user_id, league_id) values ('$user_id','$league_id')";
                $query3 = mysqli_query($db,$sql3);
                if ($query and $query3){
                    $_SESSION['success'] = 'You have created a league!!';
                    header('location: index.php'); //redirects to logged in page
                    exit();
                }else{
                    array_push($errors, "Something terrible happened.");
                }
                }
        
            }
        ?>
    </form>
</body>
</html>
    