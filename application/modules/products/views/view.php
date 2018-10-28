<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>S/N</th>
                <th></th>
                <th>Product</th>
                <th>Cost</th>
                <th>Status</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php if (isset($products) && !empty($products)): foreach ($products as $product):?>
            <tr>
                <td><?= $i++ ?></td>
                <td width="40px"><img src="<?= $i++ ?>" class="img-responsive img-thumbnail" /></td>
                <td><?= $product->product ?></td>
                <td><?= $product->price ?></td>
                <td><?= $product->is_sold ? "Sold":"Not Sold" ?></td>
                <td></td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td colspan="6"></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
