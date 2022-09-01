<script>
function DataTable() {
    var tabledata = $('#mytable').DataTable({
        paging: true,
        scrollY: 500,
        scrollCollapse: false,
        ordering: true,
        searching: true,
        select: true,
        autoFill: true,
        colReorder: true,
        keys: true,
        processing: true,
        serverSide: true,

        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "ajax": {
            "url": "{{ route('user.loadall') }}",
            "type": "GET",
        },
        columns: [{
                data: 'name',
                name: 'name',
            },
            {
                data: 'email',
                name: 'email',
            },
            {
                data: 'status',
                name: 'status',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
    });
    /*   $('.dataTables_length').addClass('bs-select'); */
}
window.onload = DataTable();
$(document).on('click', '#dataedit', function() {
    var id = $(this).data("id");
    url = "{{ url('User/edit')}}" + '/' + id,
        window.location = url;
});
$(document).on('click', "#datadelete", function() {
    var logingid = "{{ Auth::user()->id }}"
    var id = $(this).data("id");
    if (logingid == id) {
        swal("Opps! Faild", "Sorry, You Can't Delete it, This is Login User", "error");
    } else {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this  data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        type: "post",
                        url: "{{ url('User/delete')}}" + '/' + id,
                        success: function() {
                            $('#mytable').DataTable().ajax.reload()
                        },
                        error: function(data) {
                            console.log(data);
                            swal("Opps! Faild", "Data Fail to Delete", "error");
                        }
                    });
                    swal("Ok! Your file has been deleted!", {
                        icon: "success",
                    });
                } else {
                    swal("Your file is safe!");
                }
            });
    }


});
</script>