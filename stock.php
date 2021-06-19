<?php include ('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>TradeWars</title>
    <link rel="stylesheet" type="text/css" href="style.css?version=51">
</head>
<body>
<div class = "navbar">
        <a class="active" href="index.php"><b>TradeWars</b></a>
        <a class="active" href="account.php">Your Account</a>
        <a class="active" href="league.php">Leagues</a>
		<a class="active" href="homepage.php?logout='1" style="color: red;">Logout</a></p>
    </div>
    <div class="header">
        <h2>Stock</h2>
    </div>

    <form method="post" action="stock.php">
	
    <!-- display validation errors here -->
    <?php include ('errors.php'); 
      $query = "select * from "
    ?>
        
        <div class="input-group">
            <label>Ticker Symbol</label>
            <input type="text" name="ticker">
        </div>
        <div class="input-group">
            <button type="submit" name="findstock" class="btn">Search Stock</button>
        </div>
		
		<?php 
		if (isset($_POST['findstock'])){
		$ch = curl_init();
		$_SESSION['tickersymbol'] = $db->real_escape_string($_POST['ticker']);
    $tickersymbol = $db->real_escape_string($_POST['ticker']);                                  
		$url = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=$tickersymbol&apikey=COVQFJNJ0JN5RZQY";
		
		
		
		$returnedjson = file_get_contents($url);
		$result = json_decode($returnedjson);
		
		$metadata = $result->{"Meta Data"};
		$actualsymbol = $metadata->{"2. Symbol"};
		$actualsymbol = strtoupper($actualsymbol);
		$latestrefreshdate = $metadata->{"3. Last Refreshed"};
		
		$dataForALLDays = $result->{"Time Series (Daily)"};
		$dataForToday = $dataForALLDays->{$latestrefreshdate};
		$latestprice = $dataForToday->{"1. open"};
    $_SESSION['latest_price'] = $latestprice;
		
		
		echo $actualsymbol . ": $" . $latestprice;
		
		echo "<div class='input-group'>";
        echo    "<label>Quantity</label>";
        echo    "<input type='text' name='stockamount'>";
        echo"</div>";
		
		echo"<div class='input-group'>";
        echo    "<button type='submit' name='buystock' class='btn'>Buy</button>";
		echo	"<button type='submit' name='sellstock' class='btn'>Sell</button>";
        echo"</div>";
		
		}
        
		?>
    <?php
    if (isset($_POST['buystock'])){
      //$ticker = $db -> real_escape_string($_POST['ticker']);
      $stock_amount = $db->real_escape_string($_POST['stockamount']);
      if (empty($stock_amount)){
        array_push($errors, "Amount of stock is required");
      }
      if(count($errors) == 0){
        $sql = "select stock, balance from playertable where (user_id = '{$_SESSION['user_id']}' and league_id = '{$_SESSION['league_id']}');";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_row($result);
        $player_balance = $row[1];
        $new_player_balance = floatval($player_balance - ($_SESSION['latest_price']*$stock_amount));
        
        
        if ($new_player_balance >= 0){
          if($row[0]){
            $json_stock = $row[0];
            $stock_array = json_decode($json_stock, true);
            if (array_key_exists($_SESSION['tickersymbol'],$stock_array)){
              $new_amount_of_stock = $stock_array[$_SESSION['tickersymbol']] + $stock_amount;
              $stock_payload = array($_SESSION['tickersymbol']=> $new_amount_of_stock);
              $payload = array_merge($stock_array,$stock_payload);
              $final_payload = json_encode($payload);
              $sql2 = "update playertable set stock = '$final_payload', balance = '$new_player_balance' where (user_id = '{$_SESSION['user_id']}' and league_id = '{$_SESSION['league_id']}');";
              $result2 = mysqli_query($db,$sql2);
            }else{
              $stock_payload = array($_SESSION['tickersymbol']=> $stock_amount);
              $payload = array_merge($stock_array,$stock_payload);
              $final_payload = json_encode($payload);
              $sql3 = "update playertable set stock = '$final_payload', balance = '$new_player_balance' where (user_id = '{$_SESSION['user_id']}' and league_id = '{$_SESSION['league_id']}');";
              $result3 = mysqli_query($db,$sql3);
            }
      
          }else{
            $stock_payload = array($_SESSION['tickersymbol']=> $stock_amount);
            $final_payload = json_encode($stock_payload);
            $sql1= "update playertable set stock = '$final_payload', balance = '$new_player_balance' where (user_id = '{$_SESSION['user_id']}' and league_id = '{$_SESSION['league_id']}');";
            $result1 = mysqli_query($db,$sql1);
          }
        
        //print_r($final_payload);
        //echo $new_player_balance;
      }else{
        echo "Do not have sufficient funds!!";
      }
      }
    }
    if (isset($_POST['sellstock'])){
      $stock_amount = $db->real_escape_string($_POST['stockamount']);
      if (empty($stock_amount)){
        array_push($errors, "Amount of stock is required");
      }
      if(count($errors) == 0){
        $sql = "select stock, balance from playertable where (user_id = '{$_SESSION['user_id']}' and league_id = '{$_SESSION['league_id']}');";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_row($result);
        $player_balance = $row[1];
        $new_player_balance = floatval($player_balance + ($_SESSION['latest_price']*$stock_amount));
        if($row[0]){
          $json_stock = $row[0];
          $stock_array = json_decode($json_stock, true);
          if (array_key_exists($_SESSION['tickersymbol'], $stock_array)){
            $new_amount_of_stock = $stock_array[$_SESSION['tickersymbol']] - $stock_amount;
            if ($new_amount_of_stock >= 0){
              $stock_payload = array($_SESSION['tickersymbol'] => $new_amount_of_stock);
              $payload = array_merge($stock_array, $stock_payload);
              $final_payload = json_encode($payload);
              $sql4 = "update playertable set stock = '$final_payload', balance = '$new_player_balance' where (user_id = '{$_SESSION['user_id']}' and league_id = '{$_SESSION['league_id']}');";
              $result4 = mysqli_query($db,$sql4);
            }else{
              echo "Not sufficient stock in portfolio.";
            }
          }else{
            echo "Do not have specified stock in portfolio";
          }
        }else{
          echo "Portfolio empty.";
        }
      }
    }
        
    ?>
    </form>
</body>
</html>
 