<?php

namespace App\Libraries;
use App\Libraries\CFDINode;

class Xml
{
    protected $data;
    protected $type;

    /**
     * CFDI constructor.
     * @param null $xml_path
     */
    public function __construct($xml = null)
    {
        if ($xml) {
            $this->type = 'cfdi';
            $this->render($xml);
        }
    }

    /**
     * Convert CFDI to json
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->data);
    }

    /**
     * Render CFDIs
     *
     * @param String $xml
     * @return void
     */
    public function render($xml)
    {
        //echo $xml['tmp_name'];
        if (is_string($xml)) {
            $xml = simplexml_load_file($xml, 'SimpleXMLElement', 0, $this->type, true);
        } else {
            $file_path = $xml['tmp_name']; 
            $xmlfile = trim(utf8_encode(file_get_contents($file_path)));
            $xml = simplexml_load_string($xmlfile, 'SimpleXMLElement', 0, $this->type, true);
        }

        $result = [];
        $this->iterator($xml, $result, "//{$this->type}:Comprobante");
        $this->data = $result;
        //echo "<pre>";
        //echo print_r($result);                
        //echo print($result['Comprobante']['Version']);
        //echo print_r($result['Comprobante']['Emisor']);
        //echo print_r($result['Comprobante']['Receptor']);
        //echo print_r($result['Comprobante']['Conceptos']);
        //echo print_r($result['Comprobante']['Impuestos']);
        //echo print_r($result['Comprobante']['Complemento']);
        //echo "</pre>";
        // $this->data = collect($result)->first();

        // $this->data['cadena_original'] = $this->makeOriginalString($xml);
        // $this->en_data = $this->translate($this->data);
        // $this->es_data = $this->translate($this->data, 'es');
        // $this->en_data->url_qr = $this->makeUrl();
        // $this->es_data->url_qr = $this->makeUrl();
    }

    /**
     * Interacts between nodes to convert to array
     * @param $xml
     * @param $parent
     * @param string $path
     */
    protected function iterator($xml, &$parent, $path = '')
    {
        $result = [];
        $name = $xml->getName();

        foreach ($xml->attributes() as $key => $value) {
            $result[$key] = (string)$xml->attributes()->{$key};
        }

        $namespaces = $xml->getNamespaces(true);
        foreach ($namespaces as $pre => $ns) {
            foreach ($xml->children($ns) as $k => $v) {
                $new_path = $path . "//{$pre}:{$k}";
                $this->iterator($v, $result, $new_path);
            }
        }

        $path_parts = explode('//', $path);

        //if (str_ends_with($path, 'Deduccion')) {
            //    dd($path_parts);
        //}

        if (
            count($path_parts) >= 1 and
            in_array($path_parts[count($path_parts) - 2], [end($path_parts) . 's', end($path_parts) . 'es'])
            ) {
            $parent[] = $result;
        } else {
            $parent[$name] = $result;
        }
    }

    public function getDatosGenerales()
    {
        return [
            'Version'           => (isset($this->data['Comprobante']['Version']) ? trim($this->data['Comprobante']['Version']) : ''),
            'Folio'             => (isset($this->data['Comprobante']['Folio']) ? trim($this->data['Comprobante']['Folio']) : ''),
            'Fecha'             => (isset($this->data['Comprobante']['Fecha']) ? trim($this->data['Comprobante']['Fecha']) : ''),
            'FormaPago'         => (isset($this->data['Comprobante']['FormaPago']) ? trim($this->data['Comprobante']['FormaPago']) : ''),
            'MetodoPago'        => (isset($this->data['Comprobante']['MetodoPago']) ? trim($this->data['Comprobante']['MetodoPago']) : ''),
            'Moneda'            => (isset($this->data['Comprobante']['Moneda']) ? trim($this->data['Comprobante']['Moneda']) : ''),
            'LugarExpedicion'   => (isset($this->data['Comprobante']['LugarExpedicion']) ? trim($this->data['Comprobante']['LugarExpedicion']) : ''),
            'CondicionesDePago' => (isset($this->data['Comprobante']['CondicionesDePago']) ? trim($this->data['Comprobante']['CondicionesDePago']) : ''),
            'TipoDeComprobante' => (isset($this->data['Comprobante']['TipoDeComprobante']) ? trim($this->data['Comprobante']['TipoDeComprobante']) : ''),
            'Serie'             => (isset($this->data['Comprobante']['Serie']) ? trim($this->data['Comprobante']['Serie']) : ''),
            'SubTotal'          => (isset($this->data['Comprobante']['SubTotal']) ? trim($this->data['Comprobante']['SubTotal']) : ''),
            'Total'             => (isset($this->data['Comprobante']['Total']) ? trim($this->data['Comprobante']['Total']) : ''),
            'NoCertificado'     => (isset($this->data['Comprobante']['NoCertificado']) ? trim($this->data['Comprobante']['NoCertificado']) : ''),
            'Certificado'       => (isset($this->data['Comprobante']['Certificado']) ? trim($this->data['Comprobante']['Certificado']) : ''),
            'Sello'             => (isset($this->data['Comprobante']['Sello']) ? trim($this->data['Comprobante']['Sello']) : ''),
        ];
    }
    
    public function getEmisor()
    {
        return [
            'Rfc'           => (isset($this->data['Comprobante']['Emisor']['Rfc']) ? trim($this->data['Comprobante']['Emisor']['Rfc']) : ''),
            'Nombre'        => (isset($this->data['Comprobante']['Emisor']['Nombre']) ? trim($this->data['Comprobante']['Emisor']['Nombre']) : ''),
            'RegimenFiscal' => (isset($this->data['Comprobante']['Emisor']['RegimenFiscal']) ? trim($this->data['Comprobante']['Emisor']['RegimenFiscal']) : ''),
        ];
    }
    
    public function getReceptor()
    {
        return [
            'Rfc'       => (isset($this->data['Comprobante']['Receptor']['Rfc']) ? trim($this->data['Comprobante']['Receptor']['Rfc']) : ''),
            'Nombre'    => (isset($this->data['Comprobante']['Receptor']['Nombre']) ? trim($this->data['Comprobante']['Receptor']['Nombre']) : ''),
            'UsoCFDI'   => (isset($this->data['Comprobante']['Receptor']['UsoCFDI']) ? trim($this->data['Comprobante']['Receptor']['UsoCFDI']) : ''),
        ];
    }

    public function getConceptos()
    {
        $conceptos = [];
        if(isset($this->data['Comprobante']['Conceptos']))
        {
            foreach($this->data['Comprobante']['Conceptos'] as $concepto)
            {
                $conceptos[] = $concepto;
            }
        }
        return $conceptos;
    }

    public function getComplementos()
    {
        if(isset($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']))
        {
            return [
                'Version'           => (isset($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['Version']) ? trim($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['Version']) : ''),
                'UUID'              => (isset($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['UUID']) ? trim($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['UUID']) : ''),
                'FechaTimbrado'     => (isset($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['FechaTimbrado']) ? trim($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['FechaTimbrado']) : ''),
                'RfcProvCertif'     => (isset($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['RfcProvCertif']) ? trim($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['RfcProvCertif']) : ''),
                'SelloCFD'          => (isset($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['SelloCFD']) ? trim($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['SelloCFD']) : ''),
                'NoCertificadoSAT'  => (isset($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['NoCertificadoSAT']) ? trim($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['NoCertificadoSAT']) : ''),
                'SelloSAT'          => (isset($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['SelloSAT']) ? trim($this->data['Comprobante']['Complemento']['TimbreFiscalDigital']['SelloSAT']) : ''),
            ];

        }else if(isset($this->data['Comprobante']['TimbreFiscalDigital']))
        {
            return [
                'Version'           => (isset($this->data['Comprobante']['TimbreFiscalDigital']['Version']) ? trim($this->data['Comprobante']['TimbreFiscalDigital']['Version']) : ''),
                'UUID'              => (isset($this->data['Comprobante']['TimbreFiscalDigital']['UUID']) ? trim($this->data['Comprobante']['TimbreFiscalDigital']['UUID']) : ''),
                'FechaTimbrado'     => (isset($this->data['Comprobante']['TimbreFiscalDigital']['FechaTimbrado']) ? trim($this->data['Comprobante']['TimbreFiscalDigital']['FechaTimbrado']) : ''),
                'RfcProvCertif'     => (isset($this->data['Comprobante']['TimbreFiscalDigital']['RfcProvCertif']) ? trim($this->data['Comprobante']['TimbreFiscalDigital']['RfcProvCertif']) : ''),
                'SelloCFD'          => (isset($this->data['Comprobante']['TimbreFiscalDigital']['SelloCFD']) ? trim($this->data['Comprobante']['TimbreFiscalDigital']['SelloCFD']) : ''),
                'NoCertificadoSAT'  => (isset($this->data['Comprobante']['TimbreFiscalDigital']['NoCertificadoSAT']) ? trim($this->data['Comprobante']['TimbreFiscalDigital']['NoCertificadoSAT']) : ''),
                'SelloSAT'          => (isset($this->data['Comprobante']['TimbreFiscalDigital']['SelloSAT']) ? trim($this->data['Comprobante']['TimbreFiscalDigital']['SelloSAT']) : ''),
            ];
        }    
    }

    public function getImpuestos()
    {
        $Impuestos = [];
        if(isset($this->data['Comprobante']['Impuestos']))
        {
            $Impuestos['TotalImpuestosTrasladados'] = (isset($this->data['Comprobante']['Impuestos']['TotalImpuestosTrasladados']) ? trim($this->data['Comprobante']['Impuestos']['TotalImpuestosTrasladados']) : ''); 
            if(isset($this->data['Comprobante']['Impuestos']['Traslados'][0]))
            {
                $Impuestos['Impuesto'] = (isset($this->data['Comprobante']['Impuestos']['Traslados'][0]['Impuesto']) ? trim($this->data['Comprobante']['Impuestos']['Traslados'][0]['Impuesto']) : ''); 
                $Impuestos['Importe'] = (isset($this->data['Comprobante']['Impuestos']['Traslados'][0]['Importe']) ? trim($this->data['Comprobante']['Impuestos']['Traslados'][0]['Importe']) : ''); 
                $Impuestos['TipoFactor'] = (isset($this->data['Comprobante']['Impuestos']['Traslados'][0]['TipoFactor']) ? trim($this->data['Comprobante']['Impuestos']['Traslados'][0]['TipoFactor']) : ''); 
                $Impuestos['TasaOCuota'] = (isset($this->data['Comprobante']['Impuestos']['Traslados'][0]['TasaOCuota']) ? trim($this->data['Comprobante']['Impuestos']['Traslados'][0]['TasaOCuota']) : ''); 
            }
        }
        return $Impuestos;
    }

    public function getNomina()
    {
        $Nomina = [];
        if(isset($this->data['Comprobante']['Complemento']['Nomina']))
        {
            $Nomina['Version'] = (isset($this->data['Comprobante']['Complemento']['Nomina']['Version']) ? trim($this->data['Comprobante']['Complemento']['Nomina']['Version']) : ''); 
            $Nomina['TipoNomina'] = (isset($this->data['Comprobante']['Complemento']['Nomina']['TipoNomina']) ? trim($this->data['Comprobante']['Complemento']['Nomina']['TipoNomina']) : ''); 
            $Nomina['FechaPago'] = (isset($this->data['Comprobante']['Complemento']['Nomina']['FechaPago']) ? trim($this->data['Comprobante']['Complemento']['Nomina']['FechaPago']) : ''); 
            $Nomina['FechaFinalPago'] = (isset($this->data['Comprobante']['Complemento']['Nomina']['FechaFinalPago']) ? trim($this->data['Comprobante']['Complemento']['Nomina']['FechaFinalPago']) : ''); 
            $Nomina['NumDiasPagados'] = (isset($this->data['Comprobante']['Complemento']['Nomina']['NumDiasPagados']) ? trim($this->data['Comprobante']['Complemento']['Nomina']['NumDiasPagados']) : ''); 
            $Nomina['TotalPercepciones'] = (isset($this->data['Comprobante']['Complemento']['Nomina']['TotalPercepciones']) ? trim($this->data['Comprobante']['Complemento']['Nomina']['TotalPercepciones']) : ''); 
            $Nomina['TotalDeducciones'] = (isset($this->data['Comprobante']['Complemento']['Nomina']['TotalDeducciones']) ? trim($this->data['Comprobante']['Complemento']['Nomina']['TotalDeducciones']) : ''); 
            $Nomina['TotalOtrosPagos'] = (isset($this->data['Comprobante']['Complemento']['Nomina']['TotalOtrosPagos']) ? trim($this->data['Comprobante']['Complemento']['Nomina']['TotalOtrosPagos']) : ''); 

            //Emiror de la Nomina
            if(isset($this->data['Comprobante']['Complemento']['Nomina']['Emisor']))
            {
                $Nomina['Emiror'] = $this->getNominaEmisor($this->data['Comprobante']['Complemento']['Nomina']['Emisor']);
            }
            //Receptor de la Nomina
            if(isset($this->data['Comprobante']['Complemento']['Nomina']['Receptor']))
            {
                $Nomina['Receptor'] = $this->getNominaReceptor($this->data['Comprobante']['Complemento']['Nomina']['Receptor']);
            }

            //Percepciones de la Nomina
            if(isset($this->data['Comprobante']['Complemento']['Nomina']['Percepciones']))
            {
                $Nomina['Percepciones'] = $this->getNominaPercepciones($this->data['Comprobante']['Complemento']['Nomina']['Percepciones']);
            }
            
            //Deducciones de la Nomina
            if(isset($this->data['Comprobante']['Complemento']['Nomina']['Deducciones']))
            {
                $Nomina['Deducciones'] = $this->getNominaPercepciones($this->data['Comprobante']['Complemento']['Nomina']['Deducciones']);
            }

            //OtrosPagos de la Nomina
            // if(isset($this->data['Comprobante']['Complemento']['Nomina']['OtrosPagos']))
            // {
            //     $Nomina['Deducciones'] = $this->getNominaPercepciones($this->data['Comprobante']['Complemento']['Nomina']['OtrosPagos']);
            // }
            return $Nomina;

       }   
    }

    private function getNominaEmisor($Emisor = []){
        return [
            'RfcPatronOrigen'  => (isset($Emisor['RfcPatronOrigen']) ? trim($Emisor['RfcPatronOrigen']) : ''),
            'RegistroPatronal' => (isset($Emisor['RegistroPatronal']) ? trim($Emisor['RegistroPatronal']) : ''),
        ];
    }

    private function getNominaReceptor($Receptor = []){
        return [
            'Curp'                   => (isset($Receptor['Curp']) ? trim($Receptor['Curp']) : ''),
            'TipoContrato'           => (isset($Receptor['TipoContrato']) ? trim($Receptor['TipoContrato']) : ''),
            'TipoRegimen'            => (isset($Receptor['TipoRegimen']) ? trim($Receptor['TipoRegimen']) : ''),
            'NumEmpleado'            => (isset($Receptor['NumEmpleado']) ? trim($Receptor['NumEmpleado']) : ''),
            'PeriodicidadPago'       => (isset($Receptor['PeriodicidadPago']) ? trim($Receptor['PeriodicidadPago']) : ''),
            'CuentaBancaria'         => (isset($Receptor['CuentaBancaria']) ? trim($Receptor['CuentaBancaria']) : ''),
            'ClaveEntFed'            => (isset($Receptor['ClaveEntFed']) ? trim($Receptor['ClaveEntFed']) : ''),
            'NumSeguridadSocial'     => (isset($Receptor['NumSeguridadSocial']) ? trim($Receptor['NumSeguridadSocial']) : ''),
            'FechaInicioRelLaboral'  => (isset($Receptor['FechaInicioRelLaboral']) ? trim($Receptor['FechaInicioRelLaboral']) : ''),
            'Antigüedad'             => (isset($Receptor['Antigüedad']) ? trim($Receptor['Antigüedad']) : ''),
            'RiesgoPuesto'           => (isset($Receptor['RiesgoPuesto']) ? trim($Receptor['RiesgoPuesto']) : ''),
            'SalarioDiarioIntegrado' => (isset($Receptor['SalarioDiarioIntegrado']) ? trim($Receptor['SalarioDiarioIntegrado']) : ''),
        ];
    }

    private function getNominaPercepciones($Percepciones = [])
    {
        $data = [];
        foreach ($Percepciones as $Percepcion)
        {
            $data[] = $Percepcion;
        }
        return $data;
    }

    private function getNominaDeducciones($Deducciones = [])
    {
        $data = [];
        foreach ($Deducciones as $Deduccion)
        {
            $data[] = $Deduccion;
        }
        return $data;
    }
    
    private function getNominaOtrosPagos($OtrosPagos = [])
    {
        $data = [];
        foreach ($OtrosPagos as $OtrosPago)
        {
            $data[] = $OtrosPago;
        }
        return $data;
    }
    
}
