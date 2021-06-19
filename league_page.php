<?php include('server.php'); 
if (isset($_POST['league_dropdown'])){
    $_SESSION['league_name'] = $_POST['league_dropdown'];
    $sql = "select leaguetable.user_id, leaguetable.league_id, leaguetable.league_starting_balance from playertable inner join leaguetable on leaguetable.league_id = playertable.league_id where (playertable.user_id = '{$_SESSION['user_id']}' and leaguetable.league_name = '{$_SESSION['league_name']}')";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_row($result);
    $league_admin_id = $row[0];
    $_SESSION['league_id'] = $row[1];
    
}
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
    <div class="header">
        <h2><strong><?php echo $_SESSION['league_name']; ?></strong></h2>
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
		<a href='stock.php'>Search and buy stocks</a><br>
            <h2>Leaderboard</h2>
        <?php
            $sql3 = "select usertable.username, playertable.balance, playertable.stock from playertable inner join usertable on playertable.user_id = usertable.user_id where(playertable.league_id = '{$_SESSION['league_id']}');";
            $result3 = mysqli_query($db,$sql3);
            if($result3){
                while($row = mysqli_fetch_assoc($result3)){
                    $portfolio = json_decode($row['stock'], true);
                    $total_funds = $row['balance'];
                    if (is_array($portfolio)){
                        foreach ($portfolio as $stockticker => $stockamount){
                            $url = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=$stockticker&apikey=COVQFJNJ0JN5RZQY";
                            $returnedjson = file_get_contents($url);
                            $result = json_decode($returnedjson);
                            
                            $metadata = $result->{"Meta Data"};
                            $actualsymbol = $metadata->{"2. Symbol"};
                            $actualsymbol = strtoupper($actualsymbol);
                            $latestrefreshdate = $metadata->{"3. Last Refreshed"};
                            
                            $dataForALLDays = $result->{"Time Series (Daily)"};
                            $dataForToday = $dataForALLDays->{$latestrefreshdate};
                            $latestprice = $dataForToday->{"1. open"};
                            $funds = $latestprice*$stockamount;
                            $total_funds += $funds;
                        } 
                    }
                    echo $row['username'] . ": $" . $total_funds."<br>";
                }
            }
        ?>
        <h2>Your Portfolio</h2>
        <?php
        $sql4 = "select stock from playertable where (league_id = '{$_SESSION['league_id']}' and user_id = '{$_SESSION['user_id']}');";
        $result4 = mysqli_query($db,$sql4);
        $row = mysqli_fetch_row($result4);
        
        if($row){
            $portfolio = json_decode($row[0], true);
            if(is_array($portfolio)){
                foreach($portfolio as $stockticker => $stockamount){
                    echo $stockticker. ": " .$stockamount."<br>";
                }
            }
                
            
        }
        ?>
    </div>
    <?php
    if ($league_admin_id == $_SESSION['user_id']){
        echo "<form method = 'post'>";
        echo "<div>";
        echo "<label>Username</label>";
        echo "<input type = 'text' name = 'player_username'>";
        echo "<button type = 'submit' name = 'add_player' class = 'btn'>Add Player</button>";
        echo "</div>";
        echo "</form>";
    }
    //adding friend to league 
    if (isset($_POST['add_player'])){
        $a = "alsdkfja";
        $username = $db->real_escape_string($_POST['player_username']);
        $sql = "select * from usertable where username = '$username';";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_row($result);
        $sql2 = "select league_starting_balance from leaguetable where league_id = '{$_SESSION['league_id']}';";
        $result2 = mysqli_query($db,$sql2);
        $row2 = mysqli_fetch_row($result2);
        $sql1 = "insert into playertable (user_id,league_id,balance) values('$row[0]','{$_SESSION['league_id']}','$row2[0]');";
        $result1 = mysqli_query($db,$sql1);
        if ($result1){
            $_SESSION['success'] = 'You have added player!!';
            
            header('location: league.php'); //redirects to league page
            exit();
        }else{
            array_push($errors, "Something terrible happened.");
        }
    }
?>
        
    
    

        
    