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
            <?php if (isset($products) && !empty($products)): foreach ($products as $product): ?>
                    <tr>
                        <td><?= $i++ ?></td>

                        <?php
                        $arr = unserialize(json_decode($product->preview));
                        $img = is_array($arr) ? $arr : array();
                        ?>
                        <td width="40px">
                            <img src="<?= count($img) > 0 ? base_url() . $img[0] : DEFAULT_IMG ?>" class="img-thumbnail" width="40" height="40"/></td>
                        <td><?= $product->product ?></td>
                        <td><?= $product->price ?></td>
                        <td><?= $product->is_sold ? "Sold" : "Not Sold" ?></td>
                        <td class="text-center">
                            <a href="<?= site_url('products/edit/' . $product->id) ?>" class="btn btn-circle"><i class="ti-pencil"></i></a>
                            <a href="<?= site_url('products/delete/' . $product->id) ?>" class="btn btn-circle text-danger"><i class="ti-close"></i></a>
                        </td>
                    </tr>
                    <?php
                endforeach;
            else:
                ?>
                <tr>
                    <td colspan="6"></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
