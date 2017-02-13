$(function(){ /*menu handler*/
	var url = window.location.href;
	var activePage = stripTrailingSlash(url);

	$('.sidebar-menu li a').each(function(){  
		var currentPage = stripTrailingSlash($(this).attr('href'));
		
		if (activePage == currentPage) {
			$(this).parent().addClass('active');
		} 
	});
	
	$('.treeview-menu li a').each(function(){
		var currentPage = stripTrailingSlash($(this).attr('href'));

		if (activePage == currentPage) {
			$(this).parent().addClass('active');
			$(this).parent().parent().parent().addClass('active');
		} 
	});
});

function get_all_local_storage_to_html()
{
	if ($.jStorage.index().length > 0)
	{
		$.jStorage.index().forEach(function (value, i) {
			// console.log('%d: %s', i, value);
			var id = value;
			if ( $( '#'+id ).length ) {
				$( '#'+id ).val( $.jStorage.get(id) );
			}
		});
	}
}

function indexFormatter(value, row, index)
{
	return 1 + index;
}

function nl2br(str, is_xhtml)
{
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function number_format_bootstrap_table(value, row)
{
	return numeral(value).format('0,0');
}

function stripTrailingSlash(str)
{
	if (str.substr(-1) == '/')
	{
		return str.substr(0, str.length - 1);
	}
	return str;
}