<div class="mtb70">
    <h2 class="title">Profile</h2>
    <div class="row">
        <div class="col-sm-8">
            <div class="contact-form">
                <?php
                if ($this->session->flashdata('error') != NULL) {
                    echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;
                }

                if ($this->session->flashdata('success') != NULL) {
                    echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;
                }
                ?>
                <?= validation_errors(DIV_ERR, DIV_CLOSE) ?>
                <form  method="post" action="">
                    <div class="form-group">
                        <input name="fname" class="form-control" placeholder="Name" required="required" type="text" value="<?= isset($fname) ? $fname : set_value('fname') ?>">
                        <br>
                        <input name="email" class="form-control" placeholder="Email" readonly type="email" value="<?= isset($email) ? $email : set_value('email') ?>">
                        <br>
                        <input name="phone" class="form-control" placeholder="phone number" required="required" type="text" value="<?= isset($phone) ? $phone : set_value('phone') ?>">
                        <br>
                        <?php
                        $n1 = rand(0, 9);
                        $n2 = rand(0, 9);
                        ?>
                        <input name="captcha_question" class="form-control" placeholder="<?= $n1 ?> + <?= $n2 ?> = ?" required="required" type="text" matches="ans">
                        <input name="ans" class="form-control" value="<?= $n1 + $n2 ?>" required="required" type="hidden">
                        <button type="submit" class="btn btn-success">Save profile</button>
                    </div>

                </form>
            </div>
        </div>
        <div class="col-sm-4">
            <h3>Office</h3> <br>  
            <p>
                828 L St NW #906, <br>
                Washington, DC 20036, United States <br>
                hello@domain.com <br>
                Tel.: +1234 567 8910 <br> <br>
            </p>
            <p>
                828 L St NW #906, <br>
                Washington, DC 20036, United States <br>
                hello@domain.com <br>
                Tel.: +1234 567 8910 <br>
            </p>
        </div>
    </div> <!-- //row -->
</div>