<?php
    $BarModel = model("Bar");
    $total = 0;
?>
<div class="introduction">
    <h1>Bar</h1>
    <a class="stripped" href="<?php echo site_url("/members/bar"); ?>">Back to Bar</a>
</div>
<div class="product_view" id="product_view" style="color: var(--primary-white)">
    <?php if (count($BarModel->GetBasketItemsForUser()) == 0 ) { ?>
        There are no items in your basket.
    <?php } else { ?>
        <?php foreach ($BarModel->GetBasketItemsForUser() as $basketItem) { ?>
            <?php $productDetails = $BarModel->GetProductFromId($basketItem['ProductId']); ?>
            <div class="basketitems flexrow" id="prod_<?php echo $productDetails['ProductId'] ?>">
                <div class="flexcol">
                    <p class="item_title">Product:</p>
                    <p class="title"><?php echo $productDetails['ProductName']; ?></p>
                </div>
                <div class="flexcol">
                    <p class="item_title">Price:</p>
                    <p class="price">
                        <?php
                            $number = $productDetails['Price'];
                            $currency = sprintf("%0.2f", number_format($number, 2, '.', ','));
                            echo '£' . $currency;

                            // Add to the total
                            $total += $productDetails['Price'] * $basketItem['Quantity'];
                        ?>
                    </p>
                </div>
                <div class="flexcol">
                    <p class="item_title">Quantity:</p>
                    <p class="quantity" id="prod_<?php echo $basketItem['ProductId'] ?>_quantity"><?php echo $basketItem['Quantity']; ?></p>
                </div>
                <div class="remove_from_basket">
                    <?php if ($basketItem['Quantity'] == 1) { ?>
                        <button onclick="removeItemWithQuantity('<?php echo $basketItem['ProductId']; ?>', '<?php echo $productDetails['ProductName']; ?>', '*', <?php echo $productDetails['Price']; ?>)">Remove</button>
                    <?php } else { ?>
                        <button onclick="removeItemWithQuantity('<?php echo $basketItem['ProductId']; ?>', '<?php echo $productDetails['ProductName']; ?>', '*', <?php echo $productDetails['Price']; ?>)">Remove all</button>
                        <button onclick="removeItemWithQuantity('<?php echo $basketItem['ProductId']; ?>', '<?php echo $productDetails['ProductName']; ?>', 1, <?php echo $productDetails['Price']; ?>)">Remove 1</button>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>


<div class="settlement" id="settlement" style="display: <?php echo ( count($BarModel->GetBasketItemsForUser()) >= 1 ? 'flex' : 'none' ); ?>">
    <?php if ($total > 0) { ?>
        <?php $currency = sprintf("%0.2f", number_format($total, 2, '.', ',')); ?>
        <p class="total">Total amount to pay: <span id="final_total"><?php echo '£' . $currency; ?></span></p>
        <button onclick="clearBasket()">Cancel Order</button>
        <button onclick="submitOrder()">Confirm Payment</button>
    <?php } ?>
</div>
<script>
    function submitOrder()
    {
        $.ajax({
            url: "<?php echo site_url('/api/bar/order'); ?>",
            method: "POST",
            headers: {'<?php echo csrf_header(); ?>': "<?php echo csrf_hash(); ?>"},
            success: function(response) {
                response = JSON.parse(response);
                if (response.success)
                {
                    alert(`Your order has been successfully submitted.`);
                    window.location.href = "<?php echo site_url('/members') ?>";
                }
                else
                {
                    alert('Your order could not be submitted. Please try again later.');
                }
            }
        });
    }

    function clearBasket()
    {
        $.ajax({
            url: "<?php echo site_url('/api/bar/basket/clear'); ?>",
            method: "POST",
            headers: {'<?php echo csrf_header(); ?>': "<?php echo csrf_hash(); ?>"},
            success: function(response) {
                response = JSON.parse(response);
                if (response.success)
                {
                    alert(`Your order has been successfully cancelled.`);
                    document.getElementById('product_view').innerHTML = 'There are no items in your basket.';
                    document.getElementById('settlement').style.display = 'none';
                }
                else
                {
                    alert('Your basket could not be cleared. Please try again later');
                }
            }
        });
    }
    var initial_total = <?php echo $total ?>;
    const num_format_set = new Intl.NumberFormat('en-GB', {
        style: 'currency',
        currency: 'GBP',
    });

    function removeItemWithQuantity(productId, productName, quantity, price)
    {
        $.ajax({
            url: "<?php echo site_url('/api/bar/basket/removeQuant/'); ?>",
            method: "POST",
            data: {productId: productId, quantity: quantity},
            headers: {'<?php echo csrf_header(); ?>': "<?php echo csrf_hash(); ?>"},
            success: function(response) {
                response = JSON.parse(response);
                if (response.success)
                {
                    var old_total = parseInt((document.getElementById('final_total').innerHTML).substring(1));
                    var initialQ = parseInt(document.getElementById('prod_'+productId + '_quantity').innerHTML);
                    if (quantity == '*')
                    {
                        initial_total -= (price*initialQ);
                        document.getElementById('prod_'+productId).remove();
                        document.getElementById('final_total').innerHTML = num_format_set.format(initial_total);
                    }
                    else
                    {
                        if (initialQ - 1 <= 0)
                        {
                            initial_total -= (price*initialQ);
                            document.getElementById('prod_'+productId).remove(); // NEXT SORT OUT ALL THE SERVER-SIDE
                            document.getElementById('final_total').innerHTML = num_format_set.format(initial_total);
                        }
                        else
                        {
                            initial_total -= (price);
                            document.getElementById('prod_'+productId + '_quantity').innerHTML = initialQ - 1;
                            document.getElementById('final_total').innerHTML = num_format_set.format(initial_total);
                        }
                    }
                    alert((quantity == '*' ? 'All \'' + productName + '\' were removed from your basket' : '1 \'' + productName + '\' was removed from your basket'));
                }
                else
                {
                    alert('The item could not be removed. Please try again later.');
                }
            }
        });
    }
</script>