function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}

$(
	function()
	{
		var divContent = $("#templatemo_main_content");
		var pageNotFound = "./layout/404.html";
		var menuSelectedClass = "current";
		$("#templatemo_menu * a").click(
			function(event)
			{
				clearSelectedMenu();
				
				event.preventDefault();
				var url = $(this).attr("href");
				
				$.get(url).done(
					function(html)
					{
						divContent.hide().html(html).effect("slide", 300);
					}						
				).fail(
					function()
					{
						$.get(pageNotFound).done(
								function(html)
								{
									divContent.hide().html(html).effect("slide", 300);
								}						
						);
					}
				);
				
				$(this).addClass(menuSelectedClass)
			}
		);
		
		/**
		 * clear menu selection
		 */
		function clearSelectedMenu()
		{
			$("#templatemo_menu * a").each(function() {
				$(this).removeClass(menuSelectedClass);
			});
		}
	}
);