<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetallepagosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/*
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
 */
class Excelexport extends BaseController
{
    private $modelDetallePagos;
    public function __construct()
    {
        $this->modelDetallePagos = new DetallepagosModel();
    }
    public function index($anio = '3')
    {
        //echo print_r($_POST); exit;
        //echo $anio; exit;
        $session = session();
        $idUser = $session->get('id');

        $pagos = $this->modelDetallePagos->getDatosExcel($anio, $idUser);
        $fileName = 'pagos.xlsx'; // File is to create
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Año');
        $sheet->setCellValue('B1', 'Quincena');
        $sheet->setCellValue('C1', 'Nomina');
        $sheet->setCellValue('D1', 'Tipo');
        $sheet->setCellValue('E1', 'Concepto');
        $sheet->setCellValue('F1', 'Descripción');
        $sheet->setCellValue('G1', 'Importe');

        $rows = 2;

        if (count($pagos) > 0) {
            $quincena = 0;
            foreach ($pagos as $pago) {

                if ($rows > 2) {
                    if ($quincena < $pago->quincena) {
                        $rows = $rows + 5;
                        $quincena = $pago->quincena;
                        $sheet->setCellValue('A' . $rows, $pago->anio);
                        $sheet->setCellValue('B' . $rows, $pago->quincena);
                        $sheet->setCellValue('C' . $rows, 'NOMINA');
                        $sheet->setCellValue('D' . $rows, 'PERCEPCION');
                        $sheet->setCellValue('E' . $rows, 'COMPE');
                        $sheet->setCellValue('F' . $rows, 'COMPENSACION');
                        $sheet->setCellValue('G' . $rows, 0);
                        $rows++;

                    }

                } else {
                    $quincena = $pago->quincena;
                    $sheet->setCellValue('A' . $rows, $pago->anio);
                    $sheet->setCellValue('B' . $rows, $pago->quincena);
                    $sheet->setCellValue('C' . $rows, $pago->nomina);
                    $sheet->setCellValue('D' . $rows, $pago->tipoperocepcion);
                    $sheet->setCellValue('E' . $rows, 'COMPE');
                    $sheet->setCellValue('F' . $rows, 'COMPENSACION');
                    $sheet->setCellValue('G' . $rows, 0);
                    $rows++;
                }

                if ($pago->concepto == "ISR" && $pago->importe == 0) {
                    next($pagos);

                } else {
                    $sheet->setCellValue('A' . $rows, $pago->anio);
                    $sheet->setCellValue('B' . $rows, $pago->quincena);
                    $sheet->setCellValue('C' . $rows, $pago->nomina);
                    $sheet->setCellValue('D' . $rows, $pago->tipoperocepcion);
                    $sheet->setCellValue('E' . $rows, $pago->concepto);
                    $sheet->setCellValue('F' . $rows, $pago->descropcion);
                    $sheet->setCellValue('G' . $rows, $pago->importe);
                    $rows++;

                }

            }

            $writer = new Xlsx($spreadsheet);

            // file inside /public folder
            $filepath = $fileName;
            $writer->save($filepath);
            header("Content-Type: application/vnd.ms-excel");
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            exit;
        } else {

        }
    }

    public function generarReporteExcel($anio = '3', $montoCompe=0, $compeAnt=0, $compeAct=0)
    {
        $session = session();
        $idUser = $session->get('id');
        $fecha = date('Y.m.d H.i.s');
        $fileName = 'Pagos_'.(string)$fecha.'.xlsx'; // File is to create

        //$anio = trim($this->request->getVar('anio'));
        //$montoCompe = trim($this->request->getVar('montoCompe'));
        //$segundaCompeAnioAnterior = trim($this->request->getVar('compeAnt'));
        //$primeraCompeAnioActual = trim($this->request->getVar('compeAct'));

        //se crea un libro de Excel
        $spreadsheet = new Spreadsheet();

        // delete the default active sheet
        $spreadsheet->removeSheetByIndex(0);
        $numQuincenas = 24;

        $rowData = 3;
        $INGRESOS = 1;
        $DESCUENTOS =2;

        //arreglo para la suma de totales por quincena
        $totQuincenas = [];
        $totQuincenas[] = array('Quincena', 'Monto'); //es el encabezado del arreglo
        $totISRQuincena = 0;
        $totPercepcionQuincena=0;
        $totalAnual = 0;

        //ciclo para recorrer las 
        for($q=1; $q <= $numQuincenas; $q++)
        {
            $totISRQuincena = 0;
            $totPercepcionQuincena = 0;

            $qna = (($q<10) ? "0".(string)$q : $q);
            $sheet = $spreadsheet->createSheet();
            $sheet = $spreadsheet->getSheet($q-1);
            $sheet->setTitle("Quicena ".$qna);

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);

            $styleHeaderArray = [
                'font' => [
                    'bold' => true,
                    "color" => ["argb" => "00000000"],
                    "size" => 14

                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];


            $styleRowArray = [
                'font' => [
                    'bold' => true,
                    "color" => ["argb" => "00000000"],
                    "size" => 12

                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
            ];

            $styleRowTotalArray = [
                'font' => [
                    'bold' => true,
                    "color" => ["argb" => "00000000"],
                    "size" => 12

                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                ],
            ];

            //Ingresos
            $ingresos = $this->modelDetallePagos->getPagosAnioQuincena($anio, $q, $INGRESOS, $idUser);
            //var_dump($ingresos);
            $totIngresos = count($ingresos);

            $sheet->mergeCells("A1:H1");
            $sheet->setCellValue('A1', 'PERCEPCIONES');
            $style = $sheet->getStyle("A1:H1");
            $style->applyFromArray($styleHeaderArray);

            $sheet->setCellValue('A2', 'Año');
            $sheet->setCellValue('B2', 'Quincena');
            $sheet->setCellValue('C2', 'Plaza');
            $sheet->setCellValue('D2', 'Nomina');
            $sheet->setCellValue('E2', 'Tipo');
            $sheet->setCellValue('F2', 'Concepto');
            $sheet->setCellValue('G2', 'Descripción');
            $sheet->setCellValue('H2', 'Importe');

            //APLICAN ESTILOS A LOS TITULOS
            $style = $sheet->getStyle("A2:H2");
            $style->applyFromArray($styleHeaderArray);
            $sheet->getStyle('A1:H1')->getAlignment()->setWrapText(true);

            $rowData = 3;

            //Creo primero el row de la Compe
            $sheet->setCellValue('A' . $rowData, $ingresos[0]->anio);
            $sheet->setCellValue('B' . $rowData, $ingresos[0]->quincena);
            $sheet->setCellValue('C' . $rowData, $ingresos[0]->plaza);
            $sheet->setCellValue('D' . $rowData, $ingresos[0]->nomina);
            $sheet->setCellValue('E' . $rowData, $ingresos[0]->tipoperocepcion);
            $sheet->setCellValue('F' . $rowData, 'COMPE');
            $sheet->setCellValue('G' . $rowData, 'COMPENSACION');
            $sheet->setCellValue('H' . $rowData, $montoCompe);
            $totPercepcionQuincena = $totPercepcionQuincena + $montoCompe;

            //APLICAN ESTILOS Al ROW QUE AGREGO
            $style = $sheet->getStyle("A3:G3");
            $style->applyFromArray($styleRowArray);

            $sheet->getStyle('H'. $rowData)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('H'. $rowData)->applyFromArray($styleRowTotalArray);

            $rowData++;
            $inicioSuma = $rowData-1;

            //Meto las percepciones de la BD
            //foreach ($ingresos as $ingreso)
            for ($i=0; $i < $totIngresos; $i++)
            {
                if ($ingresos[$i]->concepto == "ISR" && $ingresos[$i]->importe == 0 && $i <= ($totIngresos-1)) 
                {
                    //($ingresos[$i+1]);
                    continue;
                }else{

                    $sheet->setCellValue('A' . $rowData, $ingresos[$i]->anio);
                    $sheet->setCellValue('B' . $rowData, $ingresos[$i]->quincena);
                    $sheet->setCellValue('C' . $rowData, $ingresos[$i]->plaza);
                    $sheet->setCellValue('D' . $rowData, $ingresos[$i]->nomina);
                    $sheet->setCellValue('E' . $rowData, $ingresos[$i]->tipoperocepcion);
                    $sheet->setCellValue('F' . $rowData, $ingresos[$i]->concepto);
                    $sheet->setCellValue('G' . $rowData, $ingresos[$i]->descropcion);
                    $sheet->setCellValue('H' . $rowData, $ingresos[$i]->importe);

                    $totPercepcionQuincena = $totPercepcionQuincena + (double)$ingresos[$i]->importe;

                    //estilos
                    $style = $sheet->getStyle("A".$rowData.":G".$rowData);
                    $style->applyFromArray($styleRowArray);

                    $sheet->getStyle('H'. $rowData)->applyFromArray($styleRowTotalArray);
                    $sheet->getStyle('H'. $rowData)->getNumberFormat()->setFormatCode('#,##0.00');
                    $rowData++;
                }    
            }
            $finSuma = $rowData-1;
            $sheet->mergeCells("A".$rowData.":G".$rowData);
            $sheet->setCellValue('A'.$rowData, 'Total Percepciones');
            $sheet->getStyle("A".$rowData.":G".$rowData);
            $style->applyFromArray($styleHeaderArray);

            $sheet->setCellValue('H'.$rowData, "=SUM(H".$inicioSuma.":H".$finSuma.")");
            $sheet->getStyle('H' . $rowData)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $sheet->getStyle('H'. $rowData)->applyFromArray($styleRowTotalArray);
            
          
            //Descuentos
            $descuentos = $this->modelDetallePagos->getPagosAnioQuincena($anio, $q, $DESCUENTOS, $idUser);
            $totDescuentos = count($descuentos);

            $rowData = $rowData + 3;
            $sheet->mergeCells("A".$rowData.":H".$rowData);
            $sheet->setCellValue('A'.$rowData, 'DESCUENTOS');
            //estilos
            $style = $sheet->getStyle("A".$rowData.":H".$rowData);
            $style->applyFromArray($styleHeaderArray);


            $rowData++;
            $sheet->setCellValue('A'.$rowData, 'Año');
            $sheet->setCellValue('B'.$rowData, 'Quincena');
            $sheet->setCellValue('C'.$rowData, 'Plaza');
            $sheet->setCellValue('D'.$rowData, 'Nomina');
            $sheet->setCellValue('E'.$rowData, 'Tipo');
            $sheet->setCellValue('F'.$rowData, 'Concepto');
            $sheet->setCellValue('G'.$rowData, 'Descripción');
            $sheet->getStyle('H' . $rowData)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $sheet->setCellValue('H'.$rowData, 'Importe');
            //Estilos Columnas
            $style = $sheet->getStyle("A".$rowData.":H".$rowData);
            $style->applyFromArray($styleHeaderArray);
            
            $rowData++;
            $inicioSuma = $rowData;
            //foreach ($descuentos as $descuento)
            for ($i=0; $i < $totDescuentos; $i++)
            {
                if ($descuentos[$i]->concepto == "ISR" && $descuentos[$i]->importe == 0 && $i <= ($totDescuentos-1) ) 
                {
                    //($descuentos[$i+1]);
                    continue;

                }else{    
                    
                    $sheet->setCellValue('A'. $rowData, $descuentos[$i]->anio);
                    $sheet->setCellValue('B'. $rowData, $descuentos[$i]->quincena);
                    $sheet->setCellValue('C'. $rowData, $descuentos[$i]->plaza);
                    $sheet->setCellValue('D'. $rowData, $descuentos[$i]->nomina);
                    $sheet->setCellValue('E'. $rowData, $descuentos[$i]->tipoperocepcion);
                    $sheet->setCellValue('F'. $rowData, $descuentos[$i]->concepto);
                    $sheet->setCellValue('G'. $rowData, $descuentos[$i]->descropcion);
                    $sheet->setCellValue('H'. $rowData, $descuentos[$i]->importe);
                    

                    if ($descuentos[$i]->concepto == "ISR" && $descuentos[$i]->importe > 0)
                    {
                        $totISRQuincena = $totISRQuincena + (double)$descuentos[$i]->importe;
                    }

                    //estilos
                    $style = $sheet->getStyle("A".$rowData.":G".$rowData);
                    $style->applyFromArray($styleRowArray);

                    $sheet->getStyle('H'. $rowData)->applyFromArray($styleRowTotalArray);
                    $sheet->getStyle('H'. $rowData)->getNumberFormat()->setFormatCode('#,##0.00');

                    $rowData++;
                }    
            }
            
            $finSuma = $rowData-1;
            $sheet->mergeCells("A".$rowData.":G".$rowData);
            $sheet->setCellValue('A'.$rowData, 'Total Deducciones');
            $sheet->getStyle("A".$rowData.":G".$rowData);
            $style->applyFromArray($styleHeaderArray);
            
            $sheet->getStyle('H' . $rowData)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $sheet->setCellValue('H'.$rowData, "=SUM(H".$inicioSuma.":H".$finSuma.")");
            $sheet->getStyle('H'. $rowData)->applyFromArray($styleRowTotalArray);
            
            $rowData= $rowData + 4;

            //Total de percepciones de la quincena - el ISR 
            $sheet->mergeCells("A".$rowData.":G".$rowData);
            $sheet->setCellValue('A'.$rowData, 'Monto Percepciones menos ISR');
            $sheet->getStyle("A".$rowData.":G".$rowData);
            $style->applyFromArray($styleHeaderArray);

            $sheet->getStyle('H' . $rowData)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $sheet->setCellValue('H'.$rowData, ($totPercepcionQuincena - $totISRQuincena));
            $sheet->getStyle('H'. $rowData)->applyFromArray($styleRowTotalArray);

            //Estilos Columnas
            //$style = $sheet->getStyle("A1:G1");
            //$style->applyFromArray($styleArray);
            $totQuincenas[] = array("Quicena ".$qna, number_format(($totPercepcionQuincena - $totISRQuincena),2,'.',',')); //es el encabezado del arreglo
            $totalAnual =  $totalAnual + ($totPercepcionQuincena - $totISRQuincena);
        }
        $totQuincenas[] = array("Segunda Compe Año Anterior", number_format($compeAnt, 2,'.',',')); //es el encabezado del arreglo
        $totalAnual = $totalAnual + $compeAnt;
        $totQuincenas[] = array("Primera Compe Año Anterior", number_format($compeAct, 2,'.',',')); //es el encabezado del arreglo
        $totalAnual = $totalAnual + $compeAct;
        $totQuincenas[] = array("Total", number_format($totalAnual, 2,'.',',')); //es el encabezado del arreglo

        //Espara agregar la hoja de Totales
        $sheet = $spreadsheet->createSheet();
        //$sheet = $spreadsheet->getActiveSheet();
        $sheet = $spreadsheet->getSheet(24);
        $sheet->setTitle("Totales");
        $sheet->fromArray($totQuincenas, NULL, 'A1');


        $writer = new Xlsx($spreadsheet);

        // file inside /public folder
        $filepath = $fileName;
        $writer->save($filepath);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        exit;

    }

    public function generarReporteExcel2($anio = '3')
    {
        $session = session();
        $idUser = $session->get('id');
        //$date = new date('Y-m-d H:i:s');
        $fileName = 'pagos.xlsx'; // File is to create

        //se crea un libro de Excel
        $spreadsheet = new Spreadsheet();

        // delete the default active sheet
        $spreadsheet->removeSheetByIndex(0);
        $numQuincenas = 24;

        $rowData = 3;
        $rowHead = 1;
        $INGRESOS = 1;
        $DESCUENTOS =2;

        //ciclo para recorrer las 
        for($q=1; $q<=$numQuincenas; $q++)
        {
            $qna = (($q<10) ? "0".(string)$q : $q);
            $sheet = $spreadsheet->createSheet();
            $sheet = $spreadsheet->getSheet($q-1);
            $sheet->setTitle("Quicena ".$qna);

            //Ingresos
            $ingresos = $this->modelDetallePagos->getPagosAnioQuincena($anio, $q, $INGRESOS, $idUser);
            
            $sheet->mergeCells("A1:G1");
            $sheet->setCellValue('A1', 'PERCEPCIONES');
            $sheet->setCellValue('A2', 'Año');
            $sheet->setCellValue('B2', 'Quincena');
            $sheet->setCellValue('C2', 'Nomina');
            $sheet->setCellValue('D2', 'Tipo');
            $sheet->setCellValue('E2', 'Concepto');
            $sheet->setCellValue('F2', 'Descripción');
            $sheet->setCellValue('G2', 'Importe');
            
            $rowData = 3;

            //Creo primero el row de la Compe
            $sheet->setCellValue('A' . $rowData, $ingresos[0]->anio);
            $sheet->setCellValue('B' . $rowData, $ingresos[0]->quincena);
            $sheet->setCellValue('C' . $rowData, $ingresos[0]->nomina);
            $sheet->setCellValue('D' . $rowData, $ingresos[0]->tipoperocepcion);
            $sheet->setCellValue('E' . $rowData, 'COMPE');
            $sheet->setCellValue('F' . $rowData, 'COMPENSACION');
            $sheet->setCellValue('G' . $rowData, 0);
            $rowData++;

            //Meto las percepciones de la BD
            foreach ($ingresos as $ingreso)
            {
                $sheet->setCellValue('A' . $rowData, $ingreso->anio);
                $sheet->setCellValue('B' . $rowData, $ingreso->quincena);
                $sheet->setCellValue('C' . $rowData, $ingreso->nomina);
                $sheet->setCellValue('D' . $rowData, $ingreso->tipoperocepcion);
                $sheet->setCellValue('E' . $rowData, $ingreso->concepto);
                $sheet->setCellValue('F' . $rowData, $ingreso->descropcion);
                $sheet->setCellValue('G' . $rowData, $ingreso->importe);
                $rowData++;
            }

            //Descuentos
            $descuentos = $this->modelDetallePagos->getPagosAnioQuincena($anio, $q, $DESCUENTOS, $idUser);
            $rowData = $rowData + 3;
            $sheet->mergeCells("A".$rowData.":G".$rowData);
            $sheet->setCellValue('A'.$rowData, 'DESCUENTOS');

            $rowData++;
            $sheet->setCellValue('A'.$rowData, 'Año');
            $sheet->setCellValue('B'.$rowData, 'Quincena');
            $sheet->setCellValue('C'.$rowData, 'Nomina');
            $sheet->setCellValue('D'.$rowData, 'Tipo');
            $sheet->setCellValue('E'.$rowData, 'Concepto');
            $sheet->setCellValue('F'.$rowData, 'Descripción');
            $sheet->setCellValue('G'.$rowData, 'Importe');

            $rowData++;
            foreach ($descuentos as $descuento)
            {
                $sheet->setCellValue('A'. $rowData, $descuento->anio);
                $sheet->setCellValue('B'. $rowData, $descuento->quincena);
                $sheet->setCellValue('C'. $rowData, $descuento->nomina);
                $sheet->setCellValue('D'. $rowData, $descuento->tipoperocepcion);
                $sheet->setCellValue('E'. $rowData, $descuento->concepto);
                $sheet->setCellValue('F'. $rowData, $descuento->descropcion);
                $sheet->setCellValue('G'. $rowData, $descuento->importe);
                $rowData++;
            }
        }

        $writer = new Xlsx($spreadsheet);

        // file inside /public folder
        $filepath = $fileName;
        $writer->save($filepath);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        exit;

    }
}