<script language="javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script language="javascript">
	var geocoder;
	var map;
	function initialize() {
	  geocoder = new google.maps.Geocoder();
	  var latlng = new google.maps.LatLng(50.530848, 2.808443);
	  var mapOptions = {
		zoom: 13,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	  }
	  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	}

	function showMap(address) {
		$('#map-canvas').show();
		initialize();
		
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {	  
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location
				});

				$('#map-canvas').show();
			} else {
				alert("Impossible d'afficher l'adresse sur la carte.");
			}
		});
	}

	$(function() {
		$("#showMap").click(
			function( event ) {
				event.preventDefault();
				if($('#map-canvas').css('display') == "none")
				{
					$(this).text("Masquer la carte");
					var address = $('#mapAddress').val();
					showMap(address);
				}
				else
				{
					$(this).text("Afficher sur la carte");					
					$('#map-canvas').hide();
				}
			}
		);
	});	
</script>

<div class="content_box">
	<h1>Contact</h1>	
	<div class="cleaner_h30"></div>

	<h4>Coordonn&eacute;es</h4>
	<div class="col_w280">
		<h3>Adresse</h3>
		{$address}<br />
		{$codePostal} {$ville}
		<br /><br />
		<a href="#" id="showMap">Afficher sur la carte</a>
		<input id="mapAddress" type="hidden" value="70 Rue Maurice Bouchery 59480 La Bassee" />
	</div>
	
	<div class="col_w280">
		<h3>T&eacute;l&eacute;phone</h3>
		{$tel}
	</div>
	<div id="map-canvas" style="border:1px outset black; margin:0 auto; display:none; width:80%; height:200px;"></div>
	<div class="cleaner"></div>
</div>

<div class="content_box last_box">
	<div id="contact_form">
		<h4>Me contacter par E-Mail</h4>
		<form method="post" name="contact" action="#">

			<label for="author">Nom:</label> <input type="text" id="author" name="author" class="required input_field" /><br />
			<label for="email">Adresse email:</label> <input type="text" id="email" name="email" class="validate-email required input_field" /><br />
			
			<label for="phone">T&eacute;l&eacute;phone:</label> <input type="text" name="phone" id="phone" class="input_field" /><br />
			<label for="subject">Sujet:</label> <input type="text" name="subject" id="subject" class="input_field" /><br />
			<label for="message">Message:</label> <textarea id="message" name="message" rows="0" cols="0" class="required"></textarea>

			<br /><br />
			<input type="submit" class="submit_btn" name="submit" id="submit" value="Envoyer" />
			<input type="reset" class="submit_btn" name="reset" id="reset" value="Effacer le formulaire" />				
		</form>		
	</div>
</div>