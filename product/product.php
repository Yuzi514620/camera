<?php
require_once("db_connect.php");

$search = $_GET['search'] ?? '';

$sql = "SELECT 
            p.id, 
            p.name, 
            p.description, 
            b.brand_name, 
            i.image_url, 
            c.category_name, 
            p.stock, 
            p.price, 
            p.created_at, 
            p.updated_at, 
            p.state
        FROM 
            product p
        INNER JOIN 
            category c 
        ON 
            p.category_id = c.category_id
        INNER JOIN 
            brand b 
        ON 
            p.brand_id = b.brand_id
        LEFT JOIN 
            image i 
        ON 
            p.image_id = i.id
        WHERE 
            p.is_deleted = 0";

if (!empty($search)) {
    $search = $conn->real_escape_string($search); 
    $sql .= " AND p.name LIKE '%$search%'";
}

$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!doctype html>
<html lang="en">

<head>
    <title>商品管理</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        
    <?php include("../css.php") ?>
</head>

<body>
    <div class="container">
        <?php if (isset($_GET["search"])):  ?>
            <a class="btn btn-primary" href="product.php"><i class="fa-solid fa-left-long fa-fw"></i></a>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <h1>商品管理</h1>
                <div class="col-md-6">
                    <form action="" method="get">
                        <div class="input-group">
                            <input type="search" class="form-control" name="search" value="<?= $_GET["search"] ?? "" ?>">
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
                <div class="py-2 d-flex justify-content-between align-items-center">
                    <div class="btn-group ">
                        <a class="btn btn-dark <?php if ($order == 1) echo "active" ?>" href="users.php?p=<?= $p ?>&order=1"><i class="fa-solid fa-arrow-up-wide-short fa-fw"></i></i></a>
                        <a class="btn btn-dark <?php if ($order == 2) echo "active" ?>" href="users.php?p=<?= $p ?>&order=2"><i class="fa-solid fa-arrow-down-wide-short fa-fw"></i></a>
                        <a class="btn btn-dark <?php if ($order == 3) echo "active" ?>" href="users.php?p=<?= $p ?>&order=3"><i class="fa-solid fa-arrow-up-a-z fa-fw"></i></a>
                        <a class="btn btn-dark <?php if ($order == 4) echo "active" ?>" href="users.php?p=<?= $p ?>&order=4"><i class="fa-solid fa-arrow-up-z-a fa-fw"></i></a>
                    </div>
                    <a href="addProduct.php" class="btn btn-primary">
                        <i class="fa-solid fa-folder-plus fa-fw"></i>
                    </a>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>商品名稱</th>
                            <th>照片</th>
                            <th>價格</th>
                            <th>品牌</th>
                            <th>種類</th>
                            <th>創立時間</th>
                            <th>更新時間</th>
                            <th>庫存</th>
                            <th>狀態</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?= $product["id"] ?></td>
                                <td><a href="product-content.php?id=<?= $product["id"] ?>"><?= $product["name"] ?></a></td>
                                <td style="width: 100px;">
                                    <div class="ratio ratio-16x9">
                                        <img class="object-fit-cover" src="upload/<?= $product["image_url"] ?>" alt="">
                                    </div>
                                </td>
                                <td><?= number_format($product["price"]) ?></td>
                                <td><?= $product["brand_name"] ?></td>
                                <td><?= $product["category_name"] ?></td>
                                <td><?= $product["created_at"] ?></td>
                                <td><?= $product["updated_at"] ?></td>
                                <td><?= $product["stock"] ?></td>
                                <td><?= $product["state"] ?></td>
                                <td><a href="product-edit.php?id=<?= $product["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square fa-fw"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>