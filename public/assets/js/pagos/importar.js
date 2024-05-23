$(document).ready(function () {

    //selecciionar archivo de excel
    $(document).on('change', '.myFile', function () {
        var resp = false;
        //var data = $(this).attr('data');
        var _size = $(this).attr('data2');
        var _ext = $(this).attr('data');
        var file = $(this)[0].files[0].name;
        if (fileExtValidate(this, _ext)) { // file extension validation function
            if (fileSizeValidate(this, _size)) { // file size validation function
                resp = true;
                $(this).siblings("label").text('Archivo: ' + file).css("color", "green");
            } else {
                resp = false;
            }
        } else {
            resp = false;
        }
        if (resp === false) {
            this.value = '';
            $(this).siblings("label").text('Seleccionar archivo de Rar .rar ').css("color", "black");
        }
        return resp;
    });

    //boton importar
    $('#btnImportar').on('click', function () {
        importarArchivo();
    });

});

function importarArchivo()
{
    if($('#file-xml').val()==""){
        var msg = "No se ha seleccionado un archivo a importar.";
        Swal.fire({
            icon: 'error',
            title: 'Error...',
            text: msg,
        });

    }else{
            
        //----------------
        var formData = new FormData(); 
        var c=0;
        var file_data;
        $('input[type="file"]').each(function()
        {
            var id = "1";//$(this).attr('data3'); //tipo
            file_data =  $('input[type="file"]')[c].files; // for multiple files
            for(var i= 0; i<file_data.length; i++){
                formData.append("file_" + id, file_data[i]);
            }
            c++;
        }); 
        var other_data = $('form').serializeArray(); //other fileds form
        $.each(other_data,function(key,input){
            formData.append(input.name,input.value);
        });

        $.ajax({
            type: "POST",
            url: base_url + 'procesarpagos',
            data: formData,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            cache: false,
            success: function(response){
                //alert(response);
                //document.getElementById('tablaDrive').innerHTML = response;
                /*if(response==''){
                    alert("Se ha eliminado correctamente")            ;
                    window.location.href = '<?php //echo base_url();?>';
                }*/
            }
        });

    }
}

function fileExtValidate(fdata, _ext, msg) {
    if (msg === undefined) {
        msg = "La extensión del archivo no es válida";
    }else{
        msg = "La extensión valida del archivo es: " + msg;
    }
    var validExt = '.' + _ext; //".pdf, .xml";
    var filePath = fdata.value;
    var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
    var pos = validExt.indexOf(getFileExt);
    if(pos < 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error...',
            text: msg,
        });
        return false;
    } else {
        return true;
    }
}

//function for validate file size 
var maxSize = '1024';
function fileSizeValidate(fdata, size) {
    if (fdata.files && fdata.files[0]) {
        var fsize = fdata.files[0].size/1024;
        if(fsize > size) {
            swal({
                title: "Aviso",
                text: "El tamaño máximo permitido del archivo es de " + (size/1024) +"  MB",
                type: "error",
                showCancelButton: false, //true
                closeOnConfirm: false,
                showLoaderOnConfirm: false, //true
                html: true
            });
            return false;
        } else {
            return true;
        }
    }
}