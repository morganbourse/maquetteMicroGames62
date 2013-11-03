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
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			$('#map-canvas').animate({marginTop: "0", opacity: 'show'}, 700, function() {
				initialize();
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location
				});
			});
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
		   s.src  = "http://maps.google.com/maps/api/js?v=3&sensor=true&callback=gmap_draw";
		   window.gmap_draw = function(){
		       initialize();
		   };
		   $("head").append(s);			   
	}
	
	loadScript();
});