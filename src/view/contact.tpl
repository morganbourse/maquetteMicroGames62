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
		$("#dialog").hide();
		
		$(".button").button();
		
		$("#showMap").click(
			function( event ) {
				event.preventDefault();
				$("#mapDialog").dialog({
					modal: true,
					open: function( event, ui ) {
						var address = $('#mapAddress').val();
						showMap(address);
					},					
					height:"600",
					width:"800"
				});
			}
		);
		
		function loadScript() {
			  var s = document.createElement("script");
			   s.type = "text/javascript";
			   s.src  = "http://maps.google.com/maps/api/js?key={$mapsKey}&v=3&sensor=true&callback=gmap_draw";
			   window.gmap_draw = function(){
			       initialize();
			   };
			   $("head").append(s);			   
		}
		
		loadScript();
	});	
</script>

<div class="content_box">
	<div id="mapDialog" title="Carte">
		<div id="map-canvas" style="border:1px outset black; margin:0 auto; display:none; width:100%; height:100%;"></div>
		<input id="mapAddress" type="hidden" value="70 Rue Maurice Bouchery 59480 La Bassee" />
    </div>
	<h1>Contact</h1>	
	<div class="cleaner_h30"></div>

	<h4>Coordonn&eacute;es</h4>
	<div class="col_w280">
		<h3>Adresse</h3>
		{$address}<br />
		{$codePostal} {$ville}
		<br /><br />
		<a href="#" id="showMap">Afficher sur la carte</a>
	</div>
	
	<div class="col_w280">
		<h3>T&eacute;l&eacute;phone</h3>
		{$tel}
	</div>
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
			<button class="button">Envoyer</button>
			<button class="button">Effacer le formulaire</button>				
		</form>		
	</div>
</div>