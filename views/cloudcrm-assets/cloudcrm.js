$(document).ready(function () {
	$('.data-table').dataTable({
		"bJQueryUI": true,
		"aLengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
		"aaSorting": [[0,'desc'], [1,'asc'], [2,'asc']]
	});
});