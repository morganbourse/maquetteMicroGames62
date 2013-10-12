<?php
	require_once('layout/header.html');
?>
<div id="templatemo_wrapper">
    <div id="templatemo_content_top"></div>
    <div id="templatemo_content">
    	<div id="templatemo_main_content">
			<?php				
				include_once("layout/404.php");
			?>
		</div>
        
        <?php
			require_once('layout/sidebar.php');
		?>
        
        <div class="cleaner"></div>
    </div>
	<?php
		require_once('layout/footer.html');
	?>     
</div> <!-- end of wrapper -->

<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js'></script>
<script type='text/javascript' src='js/logging.js'></script>
</body>
</html>

