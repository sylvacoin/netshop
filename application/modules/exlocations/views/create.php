<div class="col-sm-6">

<?php if ($this->session->flashdata('success') != null) {echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;}?>
<?php if ($this->session->flashdata('error') != null) {echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;}?>


<?= form_open() ?>
        <div class="form-group">
            <label class="sr-only" for="location">Location Name</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Location Name">
        </div>

        <div class="form-group">
            <label class="control-label">
            <input type="checkbox" class="" id="icon" name="status" value="true" <?= set_checkbox('status', true, (isset($status) ? $status : 'false') ) ?>> Publish Location<br></label>
        </div>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
<?= form_close() ?>
</div>
<div class="clearfix"></div>
