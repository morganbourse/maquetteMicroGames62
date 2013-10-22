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
		$("#templatemo_menu * a").click(
			function(event)
			{
				event.preventDefault();
				var url = $(this).attr("href");
				
				$.get(url).done(
					function(html)
					{
						divContent.hide().html(html).fadeIn();
					}						
				).fail(
					function()
					{
						$.get(pageNotFound).done(
								function(html)
								{
									divContent.hide().html(html).fadeIn();
								}						
						);
					}
				);
			}
		);
	}
);