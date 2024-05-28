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

<h3 style="margin-left: 45px">우수 고객 top5</h3>
<?php
    $conn->query("SET @rank := 0;");

    $sql = "SELECT @rank := @rank + 1 AS ranking, customer_name, points
        FROM customer
        ORDER BY points DESC
        LIMIT 5;";

    $result = $conn->query($sql);

    echo '<table border="1" style="margin-left: 45px">
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
<br>
<h3 style="margin-left: 45px">우수 리뷰어 top5</h3>
<?php
    $conn->query("SET @rank := 0;");
    $sql = "SELECT @rank := @rank + 1 AS ranking, customer_name, recommendation
    from review, customer
    where review.customer_id = customer.customer_id
    order by recommendation desc
    limit 5;";

    $result = $conn->query($sql);

    echo '<table border="1" style="margin-left: 45px">
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

  <h2 style="margin-left: 45px">고객 유형별 인기메뉴</h2>
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

<h3 style="margin-left: 45px">성별/연령별 주간 인기메뉴 순위 top5</h3>

<h4 style="margin-left: 45px">20대 여성</h4>
<?php

    $query = "SELECT M.menu_name, SUM(OM.quantity) AS sales
    FROM menu M
    JOIN ordered_menu OM ON M.menu_id = OM.menu_id
    JOIN order_info O ON OM.order_num = O.order_num
    JOIN customer C ON O.customer_id = C.customer_id
    WHERE SUBSTRING(C.residence_registration_number, 1, 2) BETWEEN 96 AND 99 or SUBSTRING(C.residence_registration_number, 1, 2) between 00 and 05
    AND SUBSTRING(C.residence_registration_number, 8, 1) = '2' or SUBSTRING(C.residence_registration_number, 8, 1) = '4'
    GROUP BY M.menu_name
    ORDER BY SUM(OM.quantity) DESC
    LIMIT 5;";
    $result = mysqli_query($conn, $query);

    echo '<table border="1" style="margin-left: 45px">
    <tr>
        <th>메뉴</th> 
        <th>판매량</th>
    </tr>
    '; 

    while($row = mysqli_fetch_array($result)) 
    {
        echo "<tr>";
        echo "<td>".$row['menu_name']."</td>";
        echo "<td>".$row["sales"]."</td>";
        echo "</tr>";
    }

    echo '</table>'
    
?>
<br>
<h4 style="margin-left: 45px">40대 여성</h4>
<?php

    $query = "SELECT M.menu_name, SUM(OM.quantity) AS sales
    FROM menu M
    JOIN ordered_menu OM ON M.menu_id = OM.menu_id
    JOIN order_info O ON OM.order_num = O.order_num
    JOIN customer C ON O.customer_id = C.customer_id
    WHERE SUBSTRING(C.residence_registration_number, 1, 2) BETWEEN 76 AND 85
    AND SUBSTRING(C.residence_registration_number, 8, 1) = '2'
    GROUP BY M.menu_name
    ORDER BY SUM(OM.quantity) DESC
    LIMIT 5;";
    $result = mysqli_query($conn, $query);

    echo '<table border="1" style="margin-left: 45px">
    <tr>
        <th>메뉴</th> 
        <th>판매량</th>
    </tr>
    '; 

    while($row = mysqli_fetch_array($result)) 
    {
        echo "<tr>";
        echo "<td>".$row['menu_name']."</td>";
        echo "<td>".$row["sales"]."</td>";
        echo "</tr>";
    }

    echo '</table>'
    
?>
<br>
<h4 style="margin-left: 45px">30대 남성</h4>
<?php

    $query = "SELECT M.menu_name, SUM(OM.quantity) AS sales
    FROM menu M
    JOIN ordered_menu OM ON M.menu_id = OM.menu_id
    JOIN order_info O ON OM.order_num = O.order_num
    JOIN customer C ON O.customer_id = C.customer_id
    WHERE SUBSTRING(C.residence_registration_number, 1, 2) BETWEEN 86 AND 95
    AND SUBSTRING(C.residence_registration_number, 8, 1) = '1'
    GROUP BY M.menu_name
    ORDER BY SUM(OM.quantity) DESC
    LIMIT 5;";
    $result = mysqli_query($conn, $query);

    echo '<table border="1" style="margin-left: 45px">
    <tr>
        <th>메뉴</th> 
        <th>판매량</th>
    </tr>
    '; 

    while($row = mysqli_fetch_array($result)) 
    {
        echo "<tr>";
        echo "<td>".$row['menu_name']."</td>";
        echo "<td>".$row["sales"]."</td>";
        echo "</tr>";
    }

    echo '</table>'
    
?>
<?php
mysqli_free_result($result);
mysqli_close($conn);
?>



<?php
mysqli_free_result($result);
mysqli_close($conn);
?>


</body>
</html>
