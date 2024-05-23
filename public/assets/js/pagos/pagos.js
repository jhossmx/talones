$(document).ready(function () {


    $("#FrmReporte").validate({
        //hiden
        ignore: "input[type='text']:hidden",
        rules: {
            txt_monto: {
                required: true,
                number: true,
            },
            txt_monto_Compe_Ant: {
                required: true,
                number: true,
            },
            txt_monto_Compe_Act: {
                required: true,
                number: true,
            },
        },
        messages: {
            txt_monto: {
                required: "El campo es requerido",
                number: "El campo solo acepta numeros",
            },
            txt_monto_Compe_Ant: {
                required: "El campo es requerido",
                number: "El campo solo acepta numeros",
            },
            txt_monto_Compe_Act: {
                required: "El campo es requerido",
                number: "El campo solo acepta numeros",
            },
        } 
    });    


    //boton filtrar
    $('#btnFiltrar').on('click', function () {
        //alert("filtrar");
        fiiltrarDatos();
    });

    //boton Borrar Pagos del Anio Seleccionado
    $('#btnBorrar').on('click', function () {
        borrarPagos();
    });


    fiiltrarDatos();

    $('#btnReporte').on('click', function () {
        reporte();
        //let anio = $('#cboAnioFiltro').val();    
        //window.location = base_url + "reporte/" + anio;
    });

    const container = document.getElementById("ModalReporte");
    const modal = new bootstrap.Modal(container);
    
    document.getElementById("btnCerrar").addEventListener("click", function () {
        $('#txt_monto').val("0.00");  
        modal.hide();
        $("#FrmReporte").trigger("reset");
    });

});


function reporte()
{
    var form = $("#FrmReporte");
    //var myModal = new bootstrap.Modal(document.getElementById('ModalReporte'), {})
    form.validate();
    if (form.valid()) {
        let anio = $('#cboAnioReporte').val();    
        let montoCompe = $('#txt_monto').val();    
        let compeAnt = $('#txt_monto_Compe_Ant').val();    
        let compeAct = $('#txt_monto_Compe_Act').val();    
        /*$.ajax({
            type: "POST",
            url: base_url + "reporte",
            data: { anio:anio, montoCompe:montoCompe, compeAnt:compeAnt, compeAct:compeAct  },
            success: function (response) {
                document.getElementById('cboAnioReporte').selectedIndex = 0;
                $('#txt_monto').val("0.00");    
                $('#txt_monto_Compe_Ant').val("0.00");
                $('#txt_monto_Compe_Act').val("0.00");
                $("#FrmReporte").trigger("reset");
            }
        });    */
        window.location = base_url + "reporte/"+anio+'/'+montoCompe+'/'+compeAnt+'/'+compeAct;
        document.getElementById('cboAnioReporte').selectedIndex = 0;
        $('#txt_monto').val("0.00");    
        $('#txt_monto_Compe_Ant').val("0.00");
        $('#txt_monto_Compe_Act').val("0.00");
    }    
}


function fiiltrarDatos(){
    var form = $("#frmFiltrarDatos");
    var datos = form.serialize();
    var anio = $('#cboAnioFiltro').val();
    var quincena = $('#cboAnioFiltro').val();
    if( (anio==0) || (quincena==0) ){

        var msg = "No se ha indicado los parametros de busqueda.";
        Swal.fire({
            icon: 'error',
            title: 'Error...',
            text: msg,
        });

    }else{
        $('#ResultadoPagos').html('');
        $.ajax({
            type: "POST",
            url: base_url + 'filtrarpagos',
            data: datos,
            success: function(response){
                //alert(response);
                $('#ResultadoPagos').append(response);
                getTotales();
            }
        });
    }
}

function getTotales(){
    var form = $("#frmFiltrarDatos");
    var datos = form.serialize();
        $('#ResultadoTotales').html('');
    $.ajax({
        type: "POST",
        url: base_url + 'getTotalespagos',
        data: datos,
        success: function(response){
            //alert(response);
            $('#ResultadoTotales').append(response);

        }
    });
}

function borrarPagos()
{
    let anio =$('#cboAnioFiltro option:selected').text();
    let idAnio =$('#cboAnioFiltro').val();
    Swal.fire({
        title: 'Aviso',
        showCancelButton: true,
        text: 'Desea eliminar los Pagos del Año: '+anio+'?',
        icon: 'question',
        confirmButtonColor: '#5f61e6',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        cancelButtonColor: '#788393',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            $.ajax({
                type: 'POST',
                url: base_url + 'deletepagos',
                data: { id: idAnio },
                success: function (response) {
                    if (response == "OK") {
                        msg = "Se han eliminado los Pagos del año:"+anio+" Correctamente";
                        Swal.fire({
                            title: "Aviso",
                            text: msg,
                            icon: "success"
                        }).then(function() {
                            setTimeout(function () {
                                parent.location =  base_url + 'pagos';
                            }, 800);
                        });
                    } else {
                        Swal.fire({
                            title: 'Aviso',
                            text: "Ha ocurrido un error al eliminar los pagos del año: "+anio,
                            icon: 'error',
                        });
                    }
                },
                error: function (error) {
                    Swal.fire({
                        title: 'Aviso',
                        text: "Ha ocurrido un error al eliminar los pagos del año: "+anio,
                        icon: 'error'
                    });
                }
            });
       }
    });
}
   