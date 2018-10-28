<div class="col-sm-6">

<?php if ($this->session->flashdata('success') != null) {echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;}?>
<?php if ($this->session->flashdata('error') != null) {echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;}?>


<?= form_open() ?>
        <div class="form-group">
            <label class="sr-only" for="category">Category Name</label>
            <input type="text" class="form-control" id="category" name="category" placeholder="Category Name"
            value="<?= isset($category)?$category:set_value('category') ?>">
        </div>

        <div class="form-group">
            <label class="sr-only" for="icon">Icon</label>
            <input type="text" class="form-control" id="icon" name="icon" placeholder="Category icon" 
            value="<?= isset($icon)?$icon:set_value('icon') ?>">
        </div>


        <div class="form-group">
            <label for="parent_id" class="sr-only">Parent</label>
            <?= $catOptions ? $catOptions: '' ?>
        </div>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-primary">Save update</button>
            </div>
        </div>
<?= form_close() ?>
</div>
<div class="clearfix"></div>
