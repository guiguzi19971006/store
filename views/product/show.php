<html lang="zh-TW">

<head>
    <title>產品資訊 - <?php echo $product['name']; ?></title>
    <?php view('components.header'); ?>
</head>

<body>
    <?php view('components.navbar'); ?>

    <main class="m-5">
        <div class="main-title text-center">
            <h1>產品資訊</h1>
        </div>

        <table class="table table-hover">
            <tr>
                <th class="table-dark">圖片</th>
                <td>
                    <img src="<?php echo PUBLIC_PATH . '/' . $product['photo']; ?>" alt="<?php echo $product['name']; ?>">
                </td>
            </tr>

            <tr>
                <th class="table-dark">名稱</th>
                <td>
                    <?php echo $product['name']; ?>
                </td>
            </tr>

            <tr>
                <th class="table-dark">價格</th>
                <td>
                    <?php echo $product['price']; ?>
                </td>
            </tr>

            <tr>
                <th class="table-dark">類別</th>
                <td>
                    <?php echo $product['product_category_name']; ?>
                </td>
            </tr>

            <tr>
                <th class="table-dark">剩餘數量</th>
                <td>
                    <?php echo $product['remaining_qty']; ?>
                </td>
            </tr>

            <tr>
                <th class="table-dark">是否可銷售</th>
                <td>
                    <?php echo $product['is_sellable'] === 0 ? '否' : '是'; ?>
                </td>
            </tr>
        </table>
    </main>

    <?php view('components.footer'); ?>
</body>

</html>