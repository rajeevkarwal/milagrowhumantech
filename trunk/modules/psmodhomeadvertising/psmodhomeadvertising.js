function SCCImageSlider(secure_key)
{
	$(document).ready(function()
	{
		$("#sliderdata").tableDnD({
		onDragStart: function(table, row) {
			originalOrder = $.tableDnD.serialize();
			reOrder = ':even';
			if (table.tBodies[0].rows[1] && $('#' + table.tBodies[0].rows[1].id).hasClass('alt_row'))
				reOrder = ':odd';
		},
		dragHandle: 'dragHandle',
		onDragClass: 'myDragClass',
		onDrop: function(table, row) {
			if (originalOrder != $.tableDnD.serialize())
			{
				var tableDrag = $('#' + table.id);
				$.ajax({
					type: 'POST',
					async: false,
					url: '../modules/psmodhomeadvertising/ajax_psmodhomeadvertising.php?' + $.tableDnD.serialize(),
					data: 'action=dnd&secure_key='+secure_key,
					success: function(data) {
						tableDrag.find('tbody tr').removeClass('alt_row');
						tableDrag.find('tbody tr' + reOrder).addClass('alt_row');
						tableDrag.find('tbody td.positions').each(function(i) {
							$(this).html(i+1);
						});
						tableDrag.find('tbody td.dragHandle a:hidden').show();
						tableDrag.find('tbody td.dragHandle:last a:even').hide();
						tableDrag.find('tbody td.dragHandle:first a:odd').hide();
						var reg = /_[0-9]$/g;
						tableDrag.find('tbody tr').each(function(i) {
							$(this).attr('id', $(this).attr('id').replace(reg, '_' + i));
							
							// Update link position
							var up_reg  = new RegExp('position=[-]?[0-9]+&');
							
							// Up links
							$(this).find('td.dragHandle a:odd').attr('href', $(this).find('td.dragHandle a:odd').attr('href').replace(up_reg, 'position='+ (i - 1) +'&'));
							
							// Down links
							$(this).find('td.dragHandle a:even').attr('href', $(this).find('td.dragHandle a:even').attr('href').replace(up_reg, 'position='+ (i + 1) +'&'));
						});
					}
				});
			}
		}
		});
		
	});
}
