// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();

  $('#reserveDataTable').DataTable({
    order: [[0, 'desc']]
  });
});
