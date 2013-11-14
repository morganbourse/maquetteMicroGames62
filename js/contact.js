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
	var default_border_style = $("#author").css("border");
	var error_border_style = "2px solid red";
	var error_message_suffix = "_error_message";
	
	$("#dialog").hide();
	
	$(".button").button();
	
	$(".showMap").click(
		function( event ) {
			event.preventDefault();
			try
			{
				var address = $(this).attr("title");
				showMap(address);
				
				$("#mapDialog").dialog({
					modal: true,
					open: function( event, ui ) {
						
					},
					height:"600",
					width:"800"
				});
			}
			catch(e)
			{
				$().displayErrorNotification("Impossible d'afficher l'adresse sur la carte.", 10000);
			}
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
	
	function reinitUiState()
	{
		var fields = new Array("author", "email", "phone", "subject", "message");
		fields.forEach( 
				function(value, index)
				{
					$("#" + value).css( "border", default_border_style );
					$("#" + value + error_message_suffix).empty();
					$("#" + value + error_message_suffix).hide();
				}
		);
	}
	
	$("#contactForm").submit(
		function(event)
		{
			event.preventDefault();
			reinitUiState();
			$.post("?/contact/mail", $("#contactForm").serialize(), null, "json").always(
				function(data)
				{
					if(!data.success)
					{
						if (typeof data.fieldErrors != 'undefined' && data.fieldErrors != null) {
							$().displayWarnNotification("Veuillez verifier le formulaire de contact.<br /><br />Certaines donn&eacute;es envoy&eacute;es sont incorrectes, ou non renseign&eacute;es", 10000);
							
							for(var key in data.fieldErrors)
							{
								$("#" + key).css("border", error_border_style);
								$("#" + key + error_message_suffix).html(data.fieldErrors[key]);
								$("#" + key + error_message_suffix).show();
							}
						}
						
						if(data.error != null && data.error.length > 0)
						{
							//show an error gritter
							$().displayErrorNotification(data.error, 10000);
						}
					}
					else
					{
						$().displaySuccessNotification("Votre message a bien &eacute;t&eacute; envoy&eacute; avec succ&egrave;s.<br /><br />Il sera pris en compte dans les plus bref delais.", 10000);
						$("#reset").click();
					}
				}
			);			
		}
	);
	
	$("#reset").click(
			function()
			{
				reinitUiState();
			}
	);
	
	loadScript();
});