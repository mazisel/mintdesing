$(document).ready(function () {
  $('#devnanotek_table').DataTable({
    'paging'      : true,
    'searching'   : true,
    'ordering'    : true,
    'info'        : false,
    'autoWidth'   : false,  
    'responsive' : true,
    "order": [],
    "aaSorting": [],
    "lengthMenu": [25, 50, 100]
  });
});