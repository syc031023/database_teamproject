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
  <li><a href="corner.php" class="active">코너별 분석</a></li>
  <li><a href="customer.php">고객별 분석</a></li>
  <li><a href="time.php">시간별 분석</a></li>
</ul>
</nav>

<h2 style="margin-left: 45px">코너별 메뉴의 주문 건수와 매출 & 각 코너별 판매량 인기 순위</h2>

<?php
$conn = mysqli_connect("localhost", "web", "web_admin", "ewha_food_court");
if (!$conn) {
    echo "Database Connection Error!!";
}
if (mysqli_connect_errno()) {
    echo "Could not connect: " . mysqli_connect_error();
    exit();
}

function showMenuOrderRanking($conn, $cornerId, $cornerName) {
    $conn->query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");

    $sql = "SELECT 
    M.menu_name AS 메뉴이름,
    SUM(OM.quantity) AS 주문건수,
    SUM(M.price * OM.quantity) AS 매출
FROM 
    menu M
JOIN 
    ordered_menu OM ON M.menu_id = OM.menu_id
WHERE 
    M.corner_id = $cornerId
GROUP BY 
    M.menu_name
ORDER BY
      주문건수 DESC";

    $result = $conn->query($sql);

    if (!$result) {
        echo "Query Error: " . mysqli_error($conn);
        exit();
    }
    ?>
    <!--테이블 생성-->
    <h1><?= $cornerName ?>의 판매량 인기 순위</h1>

    <table border="1">
        <tr>
            <th>메뉴이름</th>
            <th>주문건수</th>
            <th>매출</th>
        </tr>

    <?php
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <tr>
            <td><?= $row['메뉴이름'] ?></td>
            <td><?= $row['주문건수'] ?></td>
            <td><?= number_format($row['매출']) ?></td>
        </tr>
    <?php } ?>
    </table>

    <?php
    mysqli_free_result($result);
}

showMenuOrderRanking($conn, 1, "코너 1 한식");
showMenuOrderRanking($conn, 2, "코너 2 분식");
showMenuOrderRanking($conn, 3, "코너 3 중국음식");
showMenuOrderRanking($conn, 4, "코너 4 아시안음식");
showMenuOrderRanking($conn, 5, "코너 5 양식");

$conn->query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");

    $corner_menu_sales_query = "SELECT 
    M.corner_id AS 코너번호,
    M.menu_id AS 메뉴번호,
    M.menu_name AS 메뉴이름,
    SUM(OM.quantity) AS 주문건수,
    SUM(M.price * OM.quantity) AS 매출
FROM 
    menu M
JOIN 
    ordered_menu OM ON M.menu_id = OM.menu_id
GROUP BY 
    M.corner_id, M.menu_id, M.menu_name
ORDER BY 
    M.corner_id, M.menu_id";

    $corner_menu_sales_result = $conn->query($corner_menu_sales_query);

if (!$corner_menu_sales_result) {
    echo "Query Error: " . mysqli_error($conn);
    exit();
}
?>

<!--테이블 생성-->
<h1>코너별 메뉴의 주문 건수와 매출</h1>

<table border="1">
    <tr>
        <th>코너번호</th>
        <th>메뉴번호</th>
        <th>메뉴이름</th>
        <th>주문건수</th>
        <th>매출</th>
    </tr>

<?php
while ($row = mysqli_fetch_array($corner_menu_sales_result)) {
?>
    <tr>
        <td><?= $row['코너번호'] ?></td>
        <td><?= $row['메뉴번호'] ?></td>
        <td><?= $row['메뉴이름'] ?></td>
        <td><?= $row['주문건수'] ?></td>
        <td><?= number_format($row['매출']) ?></td>
    </tr>
<?php } ?>
</table>

<?php
mysqli_free_result($corner_menu_sales_result);
mysqli_close($conn);
?>

</body>
</html>





