var table;

function setTable() {
    table = $('.datatable-config').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "columnDefs": [{
            "targets": [0],
            "visible": false,
            "searchable": false
        }],
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            "url": `${base_url}/user-datatable`,
            "dataType": "json",
            "type": "POST",
            "data": {
                _token: token,
            },
            error: function (err) {
                console.log(err);
            }
        },
        "columns": [{
                "data": "id"
            },
            {
                "data": "name"
            },
            {
                "data": "nik"
            },
            {
                "data": "created_at"
            },
            {
                "data": "action",
                "name": "id",
            },
        ],
        "drawCallback": function (settings) {
            feather.replace();
        },
    });
}
