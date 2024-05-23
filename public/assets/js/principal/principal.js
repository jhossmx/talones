$(document).ready(function() {
    $('#btnSalir').click(function () {
        
        Swal.fire({
            title: 'Desea Salir del Sistema?',
            //text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#5f61e6',
            cancelButtonColor: '#788393',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = base_url +"logout";
            }
        });

    });
});