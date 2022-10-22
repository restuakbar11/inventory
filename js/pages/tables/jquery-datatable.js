$(function () {
    $('.js-basic-example').DataTable({
        responsive: true,
        "aLengthMenu": [[2, 10], [2, 10]],
        "iDisplayLength": 2
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    $('.dataTable').DataTable({
         "aLengthMenu": [[2, 10], [2, 10]],
        "iDisplayLength": 2
    });
});