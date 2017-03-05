
$().ready(function() {

	genParentSelector();

});

function genParentSelector()
{
	$('.parent-selector').each(function(){

		var $this = $(this);

		$.get( $this.data('srcurl'), function( result ) {
		  	//console.log(data);
		  	var treedata = result.data;
		  	var objnames = result.objnames;

		  	$this.treeview({data: treedata });
		  	$this.treeview('collapseAll', { silent: true });
		  	//$('.pagetree').treeview('disableNode', [ 1, { silent: true } ]);

		  	var selected_value = $this.data('selected-value');
		  	//console.log(nodemap[selected_value]);
		  	$this.parent().find('.selected-text').val(objnames[selected_value]);

		  	$this.on('nodeSelected', function(event, data) {
			  	//console.log(data.id);
			  	$this.parent().find('.selected-value').val(data.id);
			  	$this.parent().find('.selected-text').val(data.text);
			});
		});
	})
}