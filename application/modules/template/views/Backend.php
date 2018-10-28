<?= $this->load->view('components/backend/header') ?>
       <?= $this->load->view('components/backend/navigation') ?>
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?= isset($page_title) ? $page_title : "Dashboard" ?></h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active"><?= isset($page_title) ? $page_title : "" ?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                        <?php

                        if (!isset($view_file)) {
                            $view_file = "";
                        }

                        if (!isset($module)) {
                            $module = $this->uri->segment(1);
                        }

                        if ($view_file != "" && $module != "") {
                            $path = $module . '/' . $view_file;
                            $this->load->view($path);
                        } else {
                            echo nl2br($body);
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> <?=date('Y')?> &copy; <?=SITENAME?> </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
        <?= $this->load->view('components/backend/footer') ?>