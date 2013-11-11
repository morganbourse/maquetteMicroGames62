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
		
		/**
		 * Display an error notification at the top right of the screen
		 */
		$.fn.displayErrorNotification = function(message, autoclose)
		{
			noty({
				layout: 'topRight',
				type: 'error',
				timeout: autoclose,
				text: message,
				closeWith: ['button']
			});
		}
		
		/**
		 * Display an success notification at the top right of the screen
		 */
		$.fn.displaySuccessNotification = function(message, autoclose)
		{
			noty({
				layout: 'topRight',
				type: 'success',
				timeout: autoclose,
				text: message,
				closeWith: ['button']
			});
		}
		
		/**
		 * Display an information notification at the top right of the screen
		 */
		$.fn.displayInfoNotification = function(message, autoclose)
		{	    
			noty({
				layout: 'topRight',
				type: 'information',
				timeout: 8000,
				text: autoclose,
				closeWith: ['button']
			});
		}
		
		/**
		 * Display an warning notification at the top right of the screen
		 */
		$.fn.displayWarnNotification = function(message, autoclose)
		{	    
			noty({
				layout: 'topRight',
				type: 'warning',
				timeout: autoclose,
				text: message,
				closeWith: ['button']
			});
		}
	}
);