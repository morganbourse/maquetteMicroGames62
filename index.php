<?php
$path = str_replace(DIRECTORY_SEPARATOR,'/',__DIR__);
define("ROOT_DIR", $path);
$showParts = ! (isset ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) && strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) == "xmlhttprequest");
if ($showParts) {
	require_once (ROOT_DIR . '/layout/header.php');
	?>
<div id="templatemo_wrapper">
	<div id="templatemo_content_top"></div>
	<div id="templatemo_content">
		<div id="templatemo_main_content">
    	
			<?php
}
// routing REST
require_once (ROOT_DIR . '/src/controller/FrontController.php');
$router = new FrontController ();
if ($showParts) {
	?>
		</div>
        
        <?php
	require_once (ROOT_DIR . '/layout/sidebar.php');
	?>
        
        <div class="cleaner"></div>
	</div>
	<?php
	require_once (ROOT_DIR . '/layout/footer.html');
	?>     
</div>
<!-- end of wrapper -->
</body>
</html>
<?php }?>