<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetallepagosModel;
use App\Models\PagosModel;
use App\Models\QuincenaModel;
use App\Models\AniosModel;
use App\Models\TipoNominaModel;
use App\Libraries\Xml;
use App\Libraries\Extrator;

class Pagos extends BaseController
{
    private $modelQuincenas;
    private $modelAnios;
    private $modelPagos;
    private $modelTipoNomina;
    private $modelDetallePagos;

    public function __construct()
    {
        $this->modelAnios = new AniosModel();
        $this->modelTipoNomina = new TipoNominaModel();
        $this->modelQuincenas = new QuincenaModel();
        $this->modelPagos = new PagosModel();
        $this->modelDetallePagos = new DetallepagosModel();
    }

    /**
      ** Metodo para listar los pagos Registrados   *
    */
    public function index()
    {
        //$data['css'] = ['prueba', 'prueba2'];
        $data['js'] = ['pagos/pagos'];
        $data['quincenas'] = $this->modelQuincenas->getQuincenas();
        $data['nominas'] = $this->modelTipoNomina->getTipoNomina();
        $data['anios'] = $this->modelAnios->getAnios();
        $data['pagos'] = $this->modelPagos->getMasterPagos();
        return view('pagos/index', $data);

    }

    /**Metodo para mostrar el formulario de importacion de pagos */
    public function importarPagos()
    {
        $data['js'] = ['pagos/importar'];
        $data['quincenas'] = $this->modelQuincenas->getQuincenas();
        $data['anios'] = $this->modelAnios->getAnios();
        return view('pagos/importar', $data);
    }

    /*Metodo para importar los archivos rar de los pagos */
    public function procesarArchivos()
    {
        //echo print_r($_POST);
        //echo print_r($_FILES);
        //exit;
        //echo WRITEPATH . 'uploads'; exit; 

        $myFile = $this->request->getFileMultiple('file-rar');
        $idAnio = trim($this->request->getVar('cboAnio'));
        $anio = $this->modelAnios->getAnioCompleto($idAnio);

        //dd($myFile);
        if (!$myFile) {
            //no se ha pasado la validacion
            print_r('Selecciona un archivo');

        } else {

            //inicializo la session
            $session = session();

            //obtengo el id del usuario activo
            $idUsuario = session('id');

            /*Borro la info del anio seleccionado */
            $cant = $this->modelPagos->existePagosEnAnio($anio, $idUsuario);
            if ($cant > 0) {
                $borroPagos = $this->modelPagos->deletePagoAnio($anio, $idUsuario);
            }

            //instancia de la clase para descomprimir archivos
            $extractor = new Extrator;

            if ($rarFile = $this->request->getFiles()) 
            {
                foreach($rarFile['file-rar'] as $file) 
                {

                    $fileXmlNme = $this->getZipFile($extractor, $file, $anio);
                    //echo $fileXmlNme;"<br>";exit;
                    $info = explode("_", $fileXmlNme);
                    if($fileXmlNme != "") 
                    {
                        $_myFile = [];
                        $info = explode("_", $fileXmlNme);
                        if (count($info) >= 3) 
                        {
                            $_anioFile = $idAnio; //$this->modelPagos->getIdAnio(substr($info[3], 0, 4));
                            $_quincenaFile = (int)($info[3]);
                            $_plazaPago = trim($info[4]); //explode(".", $info[4]);
                            //$_plazaPago = $_plazaPago[0];
                            $_myFile['tmp_name'] = $fileXmlNme;

                            //leo la informacion del archivo que envie
                            $file = $this->readXmlFile($_anioFile, $_quincenaFile, $_myFile, $_plazaPago);

                            //pregunto se obtuvo informacion del archivo leido
                            if (count($file) > 0) {

                                //inserta la informacion en la bd del archivo analizado
                                $insert_result = $this->modelPagos->insertPagosDb($file);

                                //borar el archivo xml analizado
                                unlink($fileXmlNme);
                            }
                        }
                    }
                }
            }
        }    
        return redirect()->to('pagos');
    }

    public function getZipFile($extractor, $file, $anio)
    {
        $myFile = "";
        $path = WRITEPATH . 'uploads'."/";
        if ($file->isValid() && ! $file->hasMoved()) {
            
            //01.-Recibo_202101_ROVL770804HSLDLS00_070213CF3481000.0070008_20220427010114114
            $FileNameRar = $file->getName();
            $file->move(WRITEPATH . 'uploads', $FileNameRar);

            //cambio los permisos del arhcivo
            chmod($path.$FileNameRar, 0755);

            $extract = $extractor->extract($path.$FileNameRar, $path);
            if($extract)
            {
                //es para borrar los *.pdf
                array_map( "unlink", glob($path."*.pdf") );
                
                //armo el nombre del archivo que voy a retornar
                $info = explode("_", $FileNameRar);
                $myExt = explode(".", $info[5]);
                $FileNameXml = $path."CFDI_Comprobante_".strtoupper(trim($info[2]))."_".trim($info[3])."_".trim($info[4])."_".trim($myExt[0]).".xml";
                $myFile = $FileNameXml;
                
                //echo $myFile;exit;
            }   
            //es para borrar el archivo rar que estoy analizando 
            unlink($path.$FileNameRar);
        }
        return $myFile;
    }


    public function deletePagos($anio=0)
    {
        //inicializo la session
        $session = session();

        //obtengo el id del usuario activo
        $idUsuario = session('id');

        $idAnio = (($this->request->getVar('id') != null && $this->request->getVar('id') != "0") ? $this->request->getVar('id') : "0");
        if($idAnio != "0")
        {
            if($this->modelPagos->deletePagosDb($idAnio, $idUsuario)){
                echo "OK";
            }else{
                echo "Ocurrio un error";
            }
        }

    }


    /*Metodo para procesar los archvos eviados dese el formulario de importacion*/
    public function procesar()
    {
        //echo print_r($_POST);
        //echo print_r($_FILES);
        //exit;
       
        //$myFile = $this->request->getFile('file-xml');
        $myFile = $this->request->getFileMultiple('file-xml');
        //$xml = new Xml($myFile);

        //dd($myFile);
        $tmpFiles = [];
        $anio = trim($this->request->getVar('cboAnio'));
        $quincena = trim($this->request->getVar('cboQuincena'));

        //validacion del archivo
        $input = $this->validate([
            'file-xml[]' => [
                'uploaded[file-xml]',
                'max_size[file-xml, 10240]',
                'mime_in[file-xml, text/xml]',
            ],
            //'mime_in[file-xml,image/jpg,image/jpeg,image/png]',
        ]);

        //dd($myFile);
        if (!$myFile) {
            //no se ha pasado la validacion
            print_r('Selecciona un archivo');

        } else {

            //inicializo la session
            $session = session();

            //obtengo el id del usuario activo
            $idUsuario = session('id');

            // Count total files
            $countfiles = count($_FILES['file-xml']['name']);

            /*Borro la info del anio seleccionado */
            $cant = $this->modelPagos->existePagosEnAnio($anio, $idUsuario);
            if ($cant > 0) {
                $borroPagos = $this->modelPagos->deletePagoAnio($anio, $idUsuario);
            }

            //ciclo para recorrer los archivos enviados
            for ($i = 0; $i < $countfiles; $i++) {

                //formo un array con los datos del archivo actual
                $_myFile = [
                    'name'     => $_FILES['file-xml']['name'][$i],
                    'type'     => $_FILES['file-xml']['type'][$i],
                    'tmp_name' => $_FILES['file-xml']['tmp_name'][$i],
                    'error'    => $_FILES['file-xml']['error'][$i],
                    'size'     => $_FILES['file-xml']['size'][$i],
                ];

                //echo print_r($_myFile);exit;
                $xml = new Xml($_myFile);
                /*echo "<pre>";
                //echo print_r($xml);
                echo print_r($xml->getDatosGenerales());
                echo print_r($xml->getEmisor());
                echo print_r($xml->getReceptor());
                echo print_r($xml->getConceptos());
                echo print_r($xml->getComplementos());
                echo print_r($xml->getImpuestos());
                echo print_r($xml->getNomina());
                echo "</pre>";
                exit;*/

                //CFDI_Comprobante_ROVL770804HSLDLS00_01_070213CF3481000.0070008_202305081044414441.zip

                //CFDI_Comprobante_ROVL770804HSLDLS00_202001_1.xml
                //estructrura de un archvo a leer
                //  0       1              2            3    4
                //CFDI  ->Nombre del archivo
                //_
                //Comprobante ->Nombre del archivo
                //_
                //ROVL770804HSLDLS00 ->Curp del empledo
                //_
                //202001 -> anio 4 digitos y quincena 2
                //_1
                $info = explode("_", $_FILES['file-xml']['name'][$i]);
                if (count($info) >= 3) {

                    //los obtine de los archivos seleccionados
                    $_anioFile = $this->modelPagos->getIdAnio(substr($info[3], 0, 4));
                    $_quincenaFile = (int) (substr($info[3], 4, 2));
                    //echo $_anioFile . " - " . $_quincenaFile;exit;
                    
                    /*Es para obtenerlos de los combos*/
                    //$_anioFile = $anio;
                    //$_quincenaFile = $quincena;

                    //leo la informacion del archivo que envie
                    $file = $this->readXmlFile($_anioFile, $_quincenaFile, $_myFile);
                    $tmpFiles[] = $file;
                    
                    /*echo "<pre>";
                    echo print_r($file);
                    echo "</pre>";
                    exit;*/
                    
                    //pregunto se obtuvo informacion del archivo leido
                    if (count($file) > 0) {

                        $insert_result = $this->modelPagos->insertPagosDb($file);
                    }
                }
            }
            return redirect()->to('pagos');
            //exit;

            //obtengo la ruta del archivo que envie
            //$myFile = $this->request->getFile('file-xml');

            //leo la informacion del archivo que envie
            /*$file = $this->readXmlFile($anio, $quincena, $myFile);

            //valido que el tenga informacion
            if (count($file) > 0) {

            $borroPagos = true;
            $cant = $this->modelPagos->existePago();
            if ($cant > 0) {
            $borroPagos = $this->modelPagos->deletePago();
            }

            //if()
            $insert_result = $this->modelPagos->insertPagosDb($file);
            if ($insert_result) {
            return redirect()->to('pagos');
            //pagos
            }
            }*/
            // echo "<pre>";
            // echo print_r($file);
            //echo "</pre>";
        }

    }

    public function filtrar()
    {
        //echo print_r($_POST);exit;
        $session = session();
        $anio = trim($this->request->getVar('cboAnioFiltro'));
        $quincena = trim($this->request->getVar('cboQuincenaFiltro'));
        $tipoNomina = trim($this->request->getVar('cboTipoNominaFiltro'));
        $idUser = $session->get('id');
        //echo $anio . "--" . $quincena . "--" . $idUser;exit;

        $data = $this->modelPagos->getDatos($anio, $quincena, $tipoNomina, $idUser);
        //dd($data);
        if (count($data) > 0) {
            foreach ($data as $row) {
                $color = (($row->tipo == 'PERCEPCION') ? 'green' : 'red');
                echo '<tr class="fs12" style="color:' . $color . '">';
                echo '<td class="text-bold-500 fs12">' . $row->anio . ' </td>';
                echo '<td class="fs12">' . $row->quincena . '</td>';
                echo '<td class="fs12">' . $row->plaza . '</td>';
                echo '<td class="fs12">' . $row->nomina . '</td>';
                echo '<td class="fs12">' . $row->tipo . '</td>';
                echo '<td class="text-bold-500 fs12">' . $row->concepto . '</td>';
                echo '<td class="fs12" title="'.$row->descripcion.'">' . ((strlen($row->descripcion) > 65 ) ? substr($row->descripcion,0, 64) : $row->descripcion ) . '</td>';
                echo '<td class="fs12">$' . number_format($row->importe, 2) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr>';
            echo '<td  class="text-bold-500" colspan="8">No hay Pagos</td>';
            echo '</tr>';
        }
        //dd($data);
    }

    public function getTotalespagos()
    {
        $session = session();
        $anio = trim($this->request->getVar('cboAnioFiltro'));
        $tipoNomina = trim($this->request->getVar('cboTipoNominaFiltro'));
        $quincena = trim($this->request->getVar('cboQuincenaFiltro'));
        $idUser = $session->get('id');

        $data = $this->modelPagos->getTotalespagos($anio, $quincena, $tipoNomina, $idUser);
        if (count($data) > 0) {
            foreach ($data as $row) {
                echo '<span> PERCEPCIONES: $' . number_format($row->subtotal, 2) . '</span>';
                echo '<span> DESCUENTOS: $' . number_format($row->deducciones, 2) . '</span>';
                echo '<span> LIQUIDO: $' . number_format($row->total, 2) . '</span>';
            }
        } else {
            echo '<span>Subtotal: $0.00</span>';
            echo '<span>Deducciones: $0.00</span>';
            echo '<span>Total: $0.00</span>';

        }
    }

    private function readXmlFile($anio, $quincena, $myFile, $plazaPago)
    {
        //https: //gist.github.com/goedecke/03e9c7c178ff947b1e9d9eaea4bbe369
        
        //https://gist.github.com/goedecke/03e9c7c178ff947b1e9d9eaea4bbe369?permalink_comment_id=3134372

        //$file_name = $myFile->getName(); //es para obtener el nombre en codeigniter
        //$file_path = $myFile->getTempName(); //es para obtener la ruta del archvio que se ha enviado
        $file_path = $myFile['tmp_name']; //es para obtener la ruta del archvio que se ha enviado
        $file_path = str_replace('/', '\\', $file_path);
        //echo $file_path;exit;
        $xmlfile = trim(mb_convert_encoding(file_get_contents($file_path),"UTF-8"));

        //echo $xmlfile;exit;
        $xmlObject = simplexml_load_string($xmlfile);
        $ns = $xmlObject->getNamespaces(true);
        $response = $this->XMLNode($xmlObject, $ns);

        //echo $response['Complemento']['Nomina']['TipoNomina'];exit;

        /*echo "<pre>";
        echo print_r($response);
        echo "</pre>";
        exit;*/

        $montoISR_P = 0;
        $montoISR_D = 0;
        $datos = [];
        $dataPagos = [];
        $percepciones = [];
        $deducciones = [];
        $dataDeatalles = [];

        //tabla padre
        if (count($response) > 0) {
            $idUsuario = session('id');
            $dataPagos['fn_usuario'] = session('id');
            $dataPagos['fn_nomina'] =  (($response['Complemento']['Nomina']['TipoNomina']=="O") ? 1 : (($response['Complemento']['Nomina']['TipoNomina']=="E") ? 2 : 3) );
            $dataPagos['fn_anio'] = $anio;
            $dataPagos['fn_quincena'] = $quincena;
            $dataPagos['df_fecha_pago'] = $response['Complemento']['Nomina']['FechaPago'];
            $dataPagos['df_fecha_inicio_pago'] = $response['Complemento']['Nomina']['FechaInicialPago'];
            $dataPagos['df_fecha_fin_pago'] = $response['Complemento']['Nomina']['FechaFinalPago'];
            $dataPagos['dn_dias_pago'] = $response['Complemento']['Nomina']['NumDiasPagados'];
            $dataPagos['dn_subtotal'] = $response['SubTotal'];
            $dataPagos['dn_decucciones'] = $response['Descuento'];
            $dataPagos['dn_total'] = $response['Total'];
            $dataPagos['da_uuid'] = $response['Complemento']['TimbreFiscalDigital']['UUID'];
            $dataPagos['da_status'] = 'A';
            $dataPagos['da_plaza'] = $plazaPago;

            //percepciones
            $percepcionesTmp = $response['Complemento']['Nomina']['Percepciones'];
            foreach ($percepcionesTmp as $percepcion) {
                if (is_array($percepcion)) {
                    $claveConcepto = ((trim($percepcion['Clave']) == 'ISR') ? 'ISR_P' : $percepcion['Clave']);
                    if ($percepcion['Clave'] == 'ISR') {
                        $montoISR_P = $percepcion['ImporteGravado'];
                    }
                    $tmpPercepcion = array(
                        'fn_pago' => 0,
                        'fn_usuario' => session('id'),
                        'fn_nomina' => (($response['Complemento']['Nomina']['TipoNomina']=="O") ? 1 : (($response['Complemento']['Nomina']['TipoNomina']=="E") ? 2 : 3) ),
                        'fn_anio' => $anio,
                        'fn_quincena' => $quincena,
                        'fn_tipoPercepcion' => 1,
                        //'fn_tipoConcepto' => $percepcion['TipoPercepcion'],
                        'da_clave' => $claveConcepto,
                        'da_descripcion' => $percepcion['Concepto'],
                        'dn_importe_gravado' => $percepcion['ImporteGravado'],
                        'dn_importe_exento' => $percepcion['ImporteExento'],
                        'da_plaza' => $plazaPago,
                        'da_status' => 'A',

                    );
                    $percepciones[] = $tmpPercepcion;
                }
            }

            //deducciones
            $deduccionesTmp = ((isset($response['Complemento']['Nomina']['Deducciones'])) ? $response['Complemento']['Nomina']['Deducciones'] : []);
            if (count($deduccionesTmp) > 0) {
                foreach ($deduccionesTmp as $deduccion) {
                    if (is_array($deduccion)) {

                        $claveConcepto = ((trim($deduccion['Clave']) == 'ISR') ? 'ISR_D' : $deduccion['Clave']);
                        if ($deduccion['Clave'] == 'ISR') {
                            $montoISR_D = $deduccion['Importe'];
                        }
                        $tmpdeduccion = array(
                            'fn_pago' => 0,
                            'fn_usuario' => session('id'),
                            'fn_nomina' => (($response['Complemento']['Nomina']['TipoNomina']=="O") ? 1 : (($response['Complemento']['Nomina']['TipoNomina']=="E") ? 2 : 3) ),
                            'fn_anio' => $anio,
                            'fn_quincena' => $quincena,
                            'fn_tipoPercepcion' => 2,
                            //'fn_tipoConcepto' => $deduccion['TipoDeduccion'],
                            'da_clave' => $claveConcepto,
                            'da_descripcion' => $deduccion['Concepto'],
                            'dn_importe_gravado' => $deduccion['Importe'],
                            'dn_importe_exento' => 0,
                            'da_plaza' => $plazaPago,
                            'da_status' => 'A',
                        );
                        $deducciones[] = $tmpdeduccion;
                    }
                }
            }else{
                $montoISR_D = 0;
                $claveConcepto = 'ISR_D';
                $tmpdeduccion = array(
                    'fn_pago' => 0,
                    'fn_usuario' => session('id'),
                    'fn_nomina' => (($response['Complemento']['Nomina']['TipoNomina']=="O") ? 1 : (($response['Complemento']['Nomina']['TipoNomina']=="E") ? 2 : 3) ),
                    'fn_anio' => $anio,
                    'fn_quincena' => $quincena,
                    'fn_tipoPercepcion' => 2,
                    //'fn_tipoConcepto' => $deduccion['TipoDeduccion'],
                    'da_clave' => $claveConcepto,
                    'da_descripcion' => '',
                    'dn_importe_gravado' => 0, //isr
                    'dn_importe_exento' => 0,
                    'da_plaza' => $plazaPago,
                    'da_status' => 'A',
                );
                $deducciones[] = $tmpdeduccion;
            }

            //Hago la resta del ISR_D - ISR_P para obtener el valor del isr del talon
            if (($montoISR_D > 0) && ($montoISR_P >= 0)) {
                $tmpdeduccion = array(
                    'fn_pago' => 0,
                    'fn_usuario' => session('id'),
                    'fn_nomina' => (($response['Complemento']['Nomina']['TipoNomina']=="O") ? 1 : (($response['Complemento']['Nomina']['TipoNomina']=="E") ? 2 : 3) ),
                    'fn_anio' => $anio,
                    'fn_quincena' => $quincena,
                    'fn_tipoPercepcion' => 2,
                    'da_clave' => 'ISR',
                    'da_descripcion' => 'IMPUESTO SOBRE LA RENTA',
                    'dn_importe_gravado' => ($montoISR_D - $montoISR_P),
                    'dn_importe_exento' => 0,
                    'da_plaza' => $plazaPago,
                    'da_status' => 'A',
                );
                $deducciones[] = $tmpdeduccion;
            }

            $datos[] = $dataPagos;
            $datos[] = $percepciones;
            $datos[] = $deducciones;
        }
        /*echo $anio . "--" . $quincena;
        echo "<pre>";
        //echo print_r($response['Complemento']['Nomina']['Deducciones']);
        //Deducciones
        echo print_r($dataPagos);
        echo print_r($percepciones);
        echo print_r($deducciones);
        echo "</pre>";*/
        return $datos;
    }

    private function XMLNode($XMLNode, $ns)
    {
        $nodes = [];
        $response = [];
        $attributes = [];

        // first item ?
        $_isfirst = true;

        // each namespace
        //  - xmlns:cfdi="http://www.sat.gob.mx/cfd/3"
        //  - xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital"
        foreach ($ns as $eachSpace) {
            //
            // each node
            foreach ($XMLNode->children($eachSpace) as $_tag => $_node) {
                //
                //$_value = $this->XMLNode($_node, $ns);
                $_value = $this->XMLNode($_node, $ns);

                // exists $tag in $children?
                if (key_exists($_tag, $nodes)) {
                    if ($_isfirst) {
                        $tmp = $nodes[$_tag];
                        unset($nodes[$_tag]);
                        $nodes[] = $tmp;
                        $is_first = false;
                    }
                    $nodes[] = $_value;
                } else {
                    $nodes[$_tag] = $_value;
                }
            }
        }

        //
        /*$attributes = array_merge(
            $attributes,
            current($XMLNode->attributes())
        );*/

        //$actual =  (array) current((array) $XMLNode->attributes());
        //echo print_r($actual); exit;
        //$attributes = array_merge($attributes, $actual );


        $attributes = array_merge(
            $attributes,
            (array) current( (array) $XMLNode->attributes())
        );

        // nodes ?
        if (count($nodes)) {
            $response = array_merge(
                $response,
                $nodes
            );
        }

        // attributes ?
        if (count($attributes)) {
            $response = array_merge(
                $response,
                $attributes
            );
        }

        return (empty($response) ? null : $response);
    }

}