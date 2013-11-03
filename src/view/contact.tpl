<script language="javascript" type="text/javascript" charset="UTF-8" src="js/contact.js" />

<div class="content_box">
	<div id="mapDialog" title="Carte">
		<div id="map-canvas" style="border:1px outset black; margin:0 auto; display:none; width:100%; height:100%;"></div>
		<input id="mapAddress" type="hidden" value="70 Rue Maurice Bouchery 59480 La Bassee" />
    </div>
	<h1>Contact</h1>
</div>

<div class="content_box">
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
			<input type="reset" class="button" value="Effacer le formulaire" />				
		</form>		
	</div>
</div>