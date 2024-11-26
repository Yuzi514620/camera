<?php
require_once("db_connect.php");

if (!isset($_GET["id"])) {
    echo "請帶入 id 到此頁";
    exit;
}
$id = $_GET["id"];

$sql = "SELECT 
    product.*, 
    brand.brand_name, 
    category.category_name,
    image.image_url
FROM 
    product
INNER JOIN 
    brand 
ON 
    product.brand_id = brand.brand_id
INNER JOIN 
    category 
ON 
    product.category_id = category.category_id
LEFT JOIN
    image
ON
    product.image_id = image.id
WHERE 
    product.id = '$id' AND product.is_deleted = 0;
";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

// var_dump($row);

?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
</head>

<body>
    <div class="container">
        <a href="product.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
        <table class="table table-bordered">
            <?php if ($result->num_rows > 0): ?>
                <h1><?= $row["name"] ?></h1>
                <tr>
                    <th>id</th>
                    <td><?= $row["id"] ?></td>
                </tr>
                <tr>
                    <th>照片</th>
                    <td>
                        <div class="ratio ratio-4x3" style="width: 300px;">
                            <img class="object-fit-cover" src="upload/<?= $row["image_url"] ?>" alt="">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>價格</th>
                    <td><?=number_format($row["price"])?></td>
                </tr>
                <tr>
                    <th>品牌</th>
                    <td><?=$row["brand_name"]?></td>
                </tr>
                <tr>
                    <th>商品規格</th>
                    <td><?=nl2br($row["spec"])?></td>
                </tr>
        </table>
    <?php else: ?>
        <h1>查無資料</h1>
    <?php endif; ?>
    </div>
</body>

</html>