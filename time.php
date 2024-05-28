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
  <li><a href="customer.php">고객별 분석</a></li>
  <li><a href="time.php" class="active">시간별 분석</a></li>
</ul>
</nav>

<h2 style="margin-left: 45px">시간별 매출 분석</h2>

<div class="table">
    <?php
    $conn = mysqli_connect("localhost", "web", "web_admin", "ewha_food_court");
    if (!$conn) {
        echo "Database Connection Error!!";
    }

    $conn->query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");

    $sql = "SELECT 
    CASE
      WHEN DAYOFWEEK(order_time) = 1 THEN 'Sunday'
      WHEN DAYOFWEEK(order_time) = 2 THEN 'Monday'
      WHEN DAYOFWEEK(order_time) = 3 THEN 'Tuesday'
      WHEN DAYOFWEEK(order_time) = 4 THEN 'Wednesday'
      WHEN DAYOFWEEK(order_time) = 5 THEN 'Thursday'
      WHEN DAYOFWEEK(order_time) = 6 THEN 'Friday'
      WHEN DAYOFWEEK(order_time) = 7 THEN 'Saturday'
    END AS Weekday,
    HOUR(order_time) AS Hour,
    SUM(menu.price * ordered_menu.quantity) AS Sales
  FROM 
    order_info
  JOIN 
    ordered_menu ON order_info.order_num = ordered_menu.order_num
  JOIN 
    menu ON ordered_menu.menu_id = menu.menu_id
  WHERE 
    order_info.order_time BETWEEN '2024-05-06' AND '2024-05-13'
  GROUP BY 
    DAYOFWEEK(order_time), HOUR(order_time)
  ORDER BY 
    FIELD(DAYOFWEEK(order_time), 2, 3, 4, 5, 6, 7, 1), HOUR(order_time);
  ";

    $result = $conn->query($sql);

    ?>
    <h3>시간대별 판매량</h3>
    <table border="1">
        <tr>
            <th>요일</th>
            <th>시간</th>
            <th>판매량</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?php echo $row['Weekday']; ?></td>
                <td><?php echo $row['Hour']; ?></td>
                <td><?php echo number_format($row['Sales']); ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

    <?php
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</div>
<div class="table">
    <?php
    $conn = mysqli_connect("localhost", "web", "web_admin", "ewha_food_court");
    if (!$conn) {
        echo "Database Connection Error!!";
    }

    $conn->query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");

    $sql = "SELECT 
    DAYNAME(order_time) AS Weekday,
    SUM(menu.price * ordered_menu.quantity) AS Sales
FROM 
    order_info
JOIN 
    ordered_menu ON order_info.order_num = ordered_menu.order_num
JOIN 
    menu ON ordered_menu.menu_id = menu.menu_id
WHERE 
    order_time BETWEEN '2024-05-06' AND '2024-05-13'
GROUP BY 
    DAYOFWEEK(order_time)
ORDER BY 
    CASE WHEN DAYOFWEEK(order_time) = 1 THEN 7 ELSE DAYOFWEEK(order_time) - 1 END;
";

    $result = $conn->query($sql);

    ?>
<h3>주간 판매량</h3>
    <table border="1">
        <tr>
            <th>요일</th>
            <th>판매량</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?php echo $row['Weekday']; ?></td>
                <td><?php echo number_format($row['Sales']); ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

    <?php
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</div>

</body>
</html>





