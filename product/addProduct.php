

<!DOCTYPE html>
<html lang="en">

<head>
    <title>新增商品</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css.php") ?>
</head>

<body>
    <div class="container">
        <div class="py-2">
            <a href="product.php" class="btn btn-primary" title="回商品管理"><i class="fa-solid fa-left-long"></i></a>
        </div>
        <h1>新增商品</h1>
        <form action="doaddProduct.php" method="post" enctype="multipart/form-data">
            <div class="mb-2">
                <label for="name" class="form-label">商品名稱</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-2">
                <a href="up_image.php" class="btn btn-dark">選擇圖片</a>
            </div>
            <div class="mb-2">
                <label for="price" class="form-label">價格</label>
                <input type="number" class="form-control" name="price" required>
            </div>
            <div class="mb-2">
                <label for="brand_id" class="form-label">品牌</label>
                <select name="brand_id" id="brand_id" class="form-select">
                    <option value="1">Leica</option>
                    <option value="2">Nikon</option>
                    <option value="3">Sony</option>
                    <option value="4">Hasselblad</option>
                    <option value="5">Canon</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="category_id" class="form-label">種類</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="1">相機</option>
                    <option value="2">鏡頭</option>
                    <option value="3">配件</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="stock" class="form-label">庫存</label>
                <input type="number" class="form-control" name="stock" min="0" required>
            </div>
            <div class="mb-2">
                <label for="spec" class="form-label">規格</label>
                <textarea type="text" class="form-control" name="spec"></textarea>
            </div>
            <div class="mb-2">
                <label for="state" class="form-label">狀態</label>
                <input type="text" class="form-control" name="state">
            </div>
            <button class="btn btn-primary" type="submit">送出</button>
        </form>
    </div>
</body>

</html>