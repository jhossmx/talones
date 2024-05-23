    //validacion de letras y numeros jquery validator
    $.validator.addMethod("loginRegex", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9ñÑ\_/\-\s]+$/i.test(value);
    }, "El campo solo acepta letras, números, ñ.");

    $.validator.addMethod("loginRegex2", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9ñÑ:.,\_/\-\s]+$/i.test(value);
    }, "El campo solo acepta letras, números, ñ.");

    $.validator.addMethod("loginRegex3", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\-\s]+$/i.test(value);
    }, "El campo solo acepta letras, números");

    /*
     * Lets you say "at least X inputs that match selector Y must be filled."
     *
     * The end result is that neither of these inputs:
     *
     *	<input class="productinfo" name="partnumber">
     *	<input class="productinfo" name="description">
     *
     *	...will validate unless at least one of them is filled.
     *
     * partnumber:	{require_from_group: [1,".productinfo"]},
     * description: {require_from_group: [1,".productinfo"]}
     *
     * options[0]: number of fields that must be filled in the group
     * options[1]: CSS selector that defines the group of conditionally required fields
     */
    //http://stackoverflow.com/questions/8137844/jquery-validation-two-fields-only-required-to-fill-in-one
    $.validator.addMethod( "require_from_group", function( value, element, options ) {
            var $fields = $( options[ 1 ], element.form ),
                    $fieldsFirst = $fields.eq( 0 ),
                    validator = $fieldsFirst.data( "valid_req_grp" ) ? $fieldsFirst.data( "valid_req_grp" ) : $.extend( {}, this ),
                    isValid = $fields.filter( function() {
                            return validator.elementValue( this );
                    } ).length >= options[ 0 ];

            // Store the cloned validator for future validation
            $fieldsFirst.data( "valid_req_grp", validator );

            // If element isn't being validated, run each require_from_group field's validation rules
            if ( !$( element ).data( "being_validated" ) ) {
                    $fields.data( "being_validated", true );
                    $fields.each( function() {
                            validator.element( this );
                    } );
                    $fields.data( "being_validated", false );
            }
            return isValid;
    }, $.validator.format( "Por favor llenar al menos {0} de esos campos." ) );//"Please fill at least {0} of these fields."

    //validar select jquery validator
    jQuery.validator.addMethod('selectcheck', function (value) {
        return (value !== '0');
    }, "year required");
    
    //validar Telefono jquery validator
    $.validator.addMethod("phone_number", function (value, element) {
        return this.optional(element) || /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/.test(value);
    }, "Formato inválido (000) 000 0000 o 000 000 0000");

    //validar Telefono jquery validator
    $.validator.addMethod("RFC", function (value, element) {
        return this.optional(element) || /^(([A-Z]|[a-z]){3,4})([0-9]{2})(1[0-2]|0[1-9])(3[0-1]|[0-2][1-9]|10|20)((([A-Z]|[a-z]|[0-9]){3}))/.test(value);
    }, "Formato de RFC inválido");
    
    $.validator.addMethod("mail", function (value, element) {
        return this.optional(element) || /^([a-zA-Z0-9_\-.]{3,18})([@])([a-zA-Z.]{3,25})([.com]|[.edu]|[.gov]|.[info]|[.mx]|[.edubc]|[.adm]|[.net]|[.org])/.test(value);        
    }, "Correo inválido");
    $.validator.addMethod("moneda", function (value, element) {
        return this.optional(element) || /^\d+(?:\.\d{0,2})$/.test(value);        
    }, "Formato de moneda inválido");
    
    $.validator.addMethod("currency", function (value, element) {
        return this.optional(element) || /^(\d{1,3}(\,\d{3})*|(\d+))(\.\d{2})?$/.test(value);
    }, "Please specify a valid amount");
    
     $.validator.addMethod("pass_confirm", function (value, element) {
        return this.optional(element) || /^\d+(?:\.\d{0,2})$/.test(value);        
    }, "No coincide la Clave ");

    //custom validation rule
    $.validator.addMethod("customemail", function(value, element) {
        return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
    }, "El formato de correo no es valido.");

    jQuery.validator.addMethod('checkDateFormat', function(value, element){
        var stringPattern = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/gm;
        if(stringPattern.test(value)){ return true; }
        else { return false; }
    },"Please enter correct date.");


    jQuery.validator.addMethod("validDate", function(value, element) {
        return this.optional(element) || /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/.test(value);
    }, "Please enter a valid date in the format DD/MM/YYYY");
    
    function trim(str) {
        return str.replace(/^\s+|\s+$/g, '');
    }

    function removeRows(ctrl) {
        while (ctrl.childNodes[0]) {
            ctrl.removeChild(ctrl.childNodes[0]);
        }
    }

    function PutImage(ctrl, ruta) {
        var cell = document.createElement("td");
        var oImg = document.createElement("img");
        oImg.setAttribute('src', ruta);
        cell.appendChild(oImg)
        ctrl.appendChild(cell);
    }

    function addHidden(theForm, key, value) {
        // Create a hidden input element, and append it to the form:
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        'name-as-seen-at-the-server';
        input.value = value;
        theForm.appendChild(input);
    }

    function validaAlfaNum(carac){
        var cadena=carac.value;
	cadena=cadena.replace(/[^a-zA-Z0-9 \ñ\Ñ]+/g,"");
	carac.value=cadena;
    }
    
    //Funcion para Validar la Cantidad de Caracteres que Acepta un TextArea
    function ValCajasTexto(elemento){
        var cadena = elemento.value;
        var largo = cadena.length;
        cadena = cadena.replace(/[^ ;,.a-zA-Z_0-9_ \t\n\x0B\f\r\ñ\Ñ]+/g,"");
        if(largo>253){
            cadena=cadena.substring(0,253);
        }
        elemento.value = cadena;
    }
    
    
    function validaNumero(cadena){
        var texto = cadena.value;
        texto = texto.replace(/[^0-9]+/g, '');
        cadena.value = texto;
    }
    
    function unformatNumber(num) {
       //return num.replace(/([^0-9\.\-])/g,"")*1;
       return num.replace(/([^0-9\.\-])/g,"");
    }
    
    function unformatNumber2(num) {
        if(num!=""){
            var n = num.toString(); 
            return n.replace(/([^0-9])/g,"");
        }else{
            return "0";
        }
    }
    
     function truncateDecimals(number, digits) {
        var multiplier = Math.pow(10, digits);
        var adjustedNum = number * multiplier;
        var truncatedNum = Math[adjustedNum < 0 ? 'ceil' : 'floor'](adjustedNum);
        return truncatedNum / multiplier;
    }
    
    function truncateDecimals2 (num, digits) {
        var numS = num.toString(),
        decPos = numS.indexOf('.'),
        substrLength = decPos == -1 ? numS.length : 1 + decPos + digits,
        trimmedResult = numS.substr(0, substrLength),
        finalResult = isNaN(trimmedResult) ? 0 : trimmedResult;
        return parseFloat(finalResult);
    }
    
    
    function MoneyFormat(amount) {
        var val = parseFloat(amount);
        if (isNaN(val)) {return "0.00";}
        if (val <= 0) {return "0.00";}
        val += "";
        // Next two lines remove anything beyond 2 decimal places
        if (val.indexOf('.') === -1) {return val+".00";}
        else { val = val.substring(0,val.indexOf('.')+3);}
        val = (val === Math.floor(val)) ? val + '.00' : ((val*10===Math.floor(val*10)) ? val + '0' : val);
        return val;
   }
   
    function formatNumber(num, prefix, simbol,position){
        if (typeof simbol === 'undefined') { simbol = '$'; }
        if (typeof position === 'undefined') { position = 'L'; }
        
        prefix = prefix || '';
        //num += '';
        var splitStr = num.split('.');
        var splitLeft = splitStr[0];
        var splitRight = splitStr.length > 1 ? '.' + splitStr[1] : '';
        var regx = /(\d+)(\d{3})/;
        while (regx.test(splitLeft)) {
            splitLeft = splitLeft.replace(regx, '$1' + ',' + '$2');
        }
        if(position==="L"){
            return simbol +" " + splitLeft + splitRight;
        }else{
            return splitLeft + splitRight + " " + simbol;
        }
        //return prefix + splitLeft + splitRight;
        //return simbol +" " + splitLeft + splitRight;
    }
    
    function formatNumber2(num, prefix, simbol,position){
        if (typeof simbol === 'undefined') { simbol = ''; }
        if (typeof position === 'undefined') { position = 'L'; }
        
        prefix = prefix || '';
        //num += '';
        var splitStr = num.split('.');
        var splitLeft = splitStr[0];
        var splitRight = splitStr.length > 1 ? '.' + splitStr[1] : '';
        var regx = /(\d+)(\d{3})/;
        while (regx.test(splitLeft)) {
            splitLeft = splitLeft.replace(regx, '$1' + ',' + '$2');
        }
        if(position==="L"){
            return simbol +" " + splitLeft + splitRight;
        }else{
            return splitLeft + splitRight + " " + simbol;
        }
        //return prefix + splitLeft + splitRight;
        //return simbol +" " + splitLeft + splitRight;
    }
    
    /**
     * Funcion que devuelve un numero separando los separadores de miles
     * Puede recibir valores negativos y con decimales
     */
    function formatoMiles(numero)
    {
        // Variable que contendra el resultado final
        var resultado = "";
        // Si el numero empieza por el valor "-" (numero negativo)
        if(numero[0]=="-")
        {
            // Cogemos el numero eliminando los posibles puntos que tenga, y sin
            // el signo negativo
            nuevoNumero=numero.replace(/\,/g,'').substring(1);
        }else{
            // Cogemos el numero eliminando los posibles puntos que tenga
            nuevoNumero=numero.replace(/\,/g,'');
        }
        // Si tiene decimales, se los quitamos al numero
        if(numero.indexOf(".")>=0){
            nuevoNumero=nuevoNumero.substring(0,nuevoNumero.indexOf("."));
        }
        // Ponemos un punto cada 3 caracteres
        for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i--, j++){
            resultado = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 == 0)? ",": "") + resultado;   
        }
            
        // Si tiene decimales, se lo añadimos al numero una vez forateado con 
        // los separadores de miles
        if(numero.indexOf(".")>=0){
            resultado+=numero.substring(numero.indexOf("."));
        }
        if(numero[0]=="-")
        {
            // Devolvemos el valor añadiendo al inicio el signo negativo
            return "-" + resultado;
        }else{
            return resultado;
        }
    }