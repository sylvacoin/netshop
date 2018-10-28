<div class="col-sm-6">

    <?php
    if ($this->session->flashdata('success') != null) {
        echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;
    }
    ?>
    <?php
    if ($this->session->flashdata('error') != null) {
        echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;
    }
    ?>
    <?= validation_errors(DIV_ERR, DIV_CLOSE); ?>
    <?= form_open_multipart(null, ['method' => "POST", 'class' => "form-horizontal", 'role' => "form", 'enctype' => "multipart/form-data"]) ?>
    <div class="form-group">
        <label class="sr-only" for="name">Product Name</label>
        <input type="text" class="form-control" name="product" id="product" placeholder="Product Name" value="<?= isset($product) ? $product : set_value('product') ?>">
    </div>

    <div class="form-group">
        <label class="sr-only" for="price">Price</label>
        <input type="text" class="form-control" name="price" id="price" placeholder="Product Price" value="<?= isset($product) ? $product : set_value('price') ?>">
    </div>


    <div class="form-group">
        <label for="category" class="sr-only">Category</label>
        <select name="category" id="inputcategory" class="form-control" required="required">
            <option value=""> --Select category--</option>
            <option value="1"> Category 1 </option>
            <option value="2"> Categroy 2 </option>
        </select>
    </div>


    <div class="form-group">
        <label for="description" class="sr-only">Description:</label>
        <textarea name="description" id="description" class="form-control" rows="3" required="required" placeholder="Description"><?= isset($description) ? $description : set_value('description') ?></textarea>
    </div>

    <div class="form-group">
        <label for="preview" class="control-label">Product Image:</label>
        <input type="file" name="preview" id="preview" value="" required="required" multiple>
    </div>




    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    <?= form_close(); ?>
</div>
<div class="clearfix"></div>