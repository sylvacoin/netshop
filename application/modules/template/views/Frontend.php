<?=$this->load->view('components/frontend/header.php')?>
<?=$this->load->view('components/frontend/navigation')?>
<?=$this->load->view('components/frontend/hero')?>
		<!-- content-starts-here -->
		<div class="content">
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
<?=$this->load->view('components/frontend/footer')?>