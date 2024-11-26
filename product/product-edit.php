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
    category.category_name
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
WHERE 
    product.id = '$id' AND product.is_deleted = 0;
";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

// 獲取品牌列表
$sql_brands = "SELECT * FROM brand";
$brands_result = $conn->query($sql_brands);

// 獲取種類列表
$sql_categories = "SELECT * FROM category";
$categories_result = $conn->query($sql_categories);

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
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">確認刪除</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    確認刪除該帳號
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <a href="doDelete.php?id=<?= $row["id"] ?>" class="btn btn-danger">確認</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- <a href="product.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left fa-fw"></i></a> -->
        <h1>編輯商品</h1>

        <?php if ($result->num_rows > 0): ?>
            <h1><?= $row["name"] ?></h1>
            <form action="updateProduct.php" method="post">
                <table class="table table-bordered">
                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    <tr>
                        <th>id</th>
                        <td><?= $row["id"] ?></td>
                    </tr>
                    <tr>
                        <th>商品名稱</th>
                        <td>
                            <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>價格</th>
                        <td>
                            <input type="text" class="form-control" name="price" value="<?= $row["price"] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>品牌</th>
                        <td>
                            <select name="brand_id" class="form-select">
                                <?php while ($brand = $brands_result->fetch_assoc()): ?>
                                    <option value="<?= $brand['brand_id'] ?>" <?= $brand['brand_id'] == $row['brand_id'] ? 'selected' : '' ?>>
                                        <?= $brand['brand_name'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>種類</th>
                        <td>
                            <select name="category_id" class="form-select">
                                <?php while ($category = $categories_result->fetch_assoc()): ?>
                                    <option value=" <?= $category['category_id']?>" <?= $category['category_id'] == $row['category_id'] ? 'selected' : '' ?>>
                                        <?= $category['category_name'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>最後更新時間</th>
                        <td><?= htmlspecialchars($row["updated_at"]) ?></td>
                    </tr>
                    <tr>
                        <th>產品規格</th>
                        <td>
                            <textarea style="height: 250px;" type="text" class="form-control" name="spec" value="<?= $row["spec"] ?>"></textarea>
                        </td>
                    </tr>
                </table>
                <div class="d-flex justify-content-between">
                    <div>
                        <button class="btn btn-primary" type="submit">儲存</button>
                        <a href="product.php?id=<?= $row["id"] ?>" class="btn btn-primary">取消</a>
                    </div>
                    <div>
                        <a href="doDelete.php?id=<?= $row["id"] ?>" data-bs-toggle="modal" data-bs-target="#confirmModal" class="btn btn-danger" type="button">刪除</a>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <h1>找不到使用者</h1>
        <?php endif; ?>
        
    </div>


    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>