<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
  <h1>이화 식당 주문 및 매출 분석 보고서</h1>
</header>

<nav>
<ul style="list-style-type:none;">
  <li><a href="corner.php">코너별 분석</a></li>
  <li><a href="customer.php" class="active">고객별 분석</a></li>
  <li><a href="time.php">시간별 분석</a></li>
</ul>
</nav>
<h2 style="margin-left:45px">고객 랭킹</h2>

<?php
    $conn = mysqli_connect("localhost", "web", "web_admin", "ewha_food_court");
    if(!$conn) {
        echo "Database Connection Error!!";
    }
    if(mysqli_connect_errno()) {
        echo "Could not connect: ".mysqli_connect_error();
        exit();
    }
?>

<div class=table>
<h3>우수 고객 top5</h3>
<?php
    $conn->query("SET @rank := 0;");

    $sql = "SELECT @rank := @rank + 1 AS ranking, customer_name, points
        FROM customer
        ORDER BY points DESC
        LIMIT 5;";

    $result = $conn->query($sql);

    echo '<table border="1">
    <tr>
        <th>순위</th> 
        <th>이름</th>
        <th>포인트</th>
    </tr>
    '; 

    while($row = mysqli_fetch_array($result)) 
    {
        echo "<tr>";
        echo "<td>".$row['ranking']."</td>";
        echo "<td>".$row["customer_name"]."</td>";
        echo "<td>".$row["points"].'p'."</td>";
        echo "</tr>";
    }

    echo '</table>'
?>
</div>
<br><br>
<div class=table>
<h3>우수 리뷰어 top5</h3>
<?php
    $conn->query("SET @rank := 0;");
    $sql = "SELECT @rank := @rank + 1 AS ranking, customer_name, recommendation
    from review, customer
    where review.customer_id = customer.customer_id
    order by recommendation desc
    limit 5;";

    $result = $conn->query($sql);

    echo '<table border="1">
    <tr>
        <th>순위</th> 
        <th>이름</th>
        <th>리뷰 추천수</th>
    </tr>
    '; 

    while($row = mysqli_fetch_array($result)) 
    {
        echo "<tr>";
        echo "<td>".$row['ranking']."</td>";
        echo "<td>".$row["customer_name"]."</td>";
        echo "<td>".$row["recommendation"]."</td>";
        echo "</tr>";
    }

    echo '</table>'
    
?>
</div>


<?php
mysqli_free_result($result);
mysqli_close($conn);
?>


</body>
</html>





