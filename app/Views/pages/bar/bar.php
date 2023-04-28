<?php $BarModel = model("Bar"); ?>
<div class="introduction">
    <h1>Bar</h1>
    <a class="stripped" href="<?php echo site_url("/members/bar/basket"); ?>">Basket</a>
</div>
<div class="category_nav">
    <script>
        const categories = ["<?php echo implode('", "', $BarModel->GetCategories()); ?>"];
        function ViewProductsInCategory(categoryName)
        {
            for (let i = 0; i < categories.length; i++)
            {
                document.getElementById('prod_' + categories[i]).style.display = (categoryName == 'ALL' ? 'flex' : 'none');
            }
            if (categoryName != 'ALL')
            {
                document.getElementById('prod_' + categoryName).style.display = 'flex';
            }
        }
    </script>
    <button onclick="ViewProductsInCategory('ALL');">ALL</button>
    <?php foreach ($BarModel->GetCategories() as $category) { ?>
        <button onclick="ViewProductsInCategory('<?php echo $category; ?>')"><?php echo $category; ?></button>
    <?php } ?>
</div>



<script>
    function onBasketPressed(productId, name)
    {
        $.ajax({
            url: "<?php echo site_url('/api/bar/basket'); ?>",
            method: "POST",
            headers: {'<?php echo csrf_header(); ?>': "<?php echo csrf_hash(); ?>"},
            data: {operation: 'ADD', productId: productId},
            success: function(response) {
                response = JSON.parse(response);
                alert(`You have added 1 ${name} to your basket. There are now ${response.newQuantity} ${name} in your basket.`);
            }
        });
    }
</script>
<div class="product_view">
    <?php foreach ($BarModel->GetCategories() as $category) { ?>
        <div class="products <?php echo $category; ?>" id="prod_<?php echo $category; ?>">
            <?php foreach ($BarModel->GetProductsFromCategory($category) as $product) { ?>
                <div class="product" id="<?php echo $product['ProductId'] ?>">
                    <div class="square">
                        <img src="/assets/golf-ball.png">
                    </div>
                    <p class="title"><?php echo $product['ProductName']; ?></p>
                    <p class="price"><?php
                        $number = $product['Price'];
                        $currency = sprintf("%0.2f", number_format($number, 2, '.', ','));
                        echo '£' . $currency;
                    ?></p>
                    <div class="add_to_basket">
                        <button onclick="onBasketPressed(<?php echo $product['ProductId']; ?>, '<?php echo $product['ProductName']; ?>')">Add 1 to basket</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>