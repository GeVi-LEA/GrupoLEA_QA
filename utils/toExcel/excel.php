<?php
require_once base.'/composer/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;

class Excel {
    
   const STYLEBORDER = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ]
            ]
        ];
    const STYLEBORDERRIGHT = [
            'borders' => [
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ]
            ]
        ];
    
    const STYLEBORDEDOUBLE = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                    'color' => ['argb' => '00000000']
                ]
            ]
        ];
    
        const STYLEBORDERTHIN = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ]
            ]
        ];
    
        const FORMAT_ACCOUNTING_USD_SINDECIMAL = '_("$"* #,##0_);_("$"* \(#,##0\);_("$"* "-"??_);_(@_)';
    
        public static function reporteComprasBasicos($embarques, $pdf) {
            
        $sumaImpote = 0;
        $sumaAceite = 0;
        $sumaOtros = 0; 
        $datosArray = [
          ["NUMERO FACTURA", "FECHA DE FACTURA", "PRODUCTO", "GALONES FACTURADOS", "LITROS FACTURADOS", "PRECIO POR GALON", "IMPORTE DE LA FACTURA LEA", 
              "NUMERO DE PEDIMENTO", "FECHA DE PEDIMENTO","TIPO DE CAMBIO PEDIMENTO","TOTAL A PAGAR PEDIMENTO","AGENCIA", "CT/AT", "NOTA CREDITO", "OTROS CARGOS", 
              "PROVEEDOR DLLS.", "PROVEEDOR COMPLEM.", "COMPLEM. ACEITE", "OTROS CARGOS MN"],
        ];
        foreach($embarques as $e){
            $carro = $e['carro_tanque_id'] != null ? $e['carroTanque'] : $e['numero_transporte'];
            $fechaFactura = $e['fecha_factura'] != null  ? date('d/m/Y', strtotime($e['fecha_factura'])) : "";
            $fechaPedimento = $e['fechaPedimento'] != null  ? date('d/m/Y', strtotime($e['fechaPedimento'])) : "";
            $producto = UtilsHelp::recortarString($e['producto'], '(');
            $ped = explode(" ", $e['pedimento']);
            $pedimento = $ped != null ? end($ped) : "";
            $nota = $e['notaCredito'] == 0 ? "" : $e['notaCredito'];
            $otrosCargos = $e['oil_fee'] + $e['otrosCargos'];
            $proveedorDll =  $e['importe'] + $otrosCargos;
            $proveedorCompl =  ($e['tipoCambio']* $proveedorDll) - $proveedorDll;
            $aceiteCompl =  ($e['importe'] * $e['tipoCambio']) - $e['importe'];
            $cargosMn = $otrosCargos * $e['tipoCambio'];
            
         $datosArray[]= [$e["numero_factura"], $fechaFactura, $producto, $e['cantidad_cargada'], 
            $e['litros_facturados'],  $e['precio_producto'],
            $e['importe'] , $pedimento, $fechaPedimento, $e['tipoCambio'], 
            $e['totalImpuestos'], $e['claveAduana'] , $carro , $nota, $otrosCargos, $proveedorDll, $proveedorCompl, $aceiteCompl, $cargosMn];  
         
         $sumaAceite = $sumaAceite + $aceiteCompl;
         $sumaImpote = $sumaImpote + $e['importe'];
         $sumaOtros = $sumaOtros + $cargosMn;
       }
       
        $spreadsheet = new Spreadsheet();
        
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet(); 
        $sheet->freezePane('B2');
        $sheet->getStyle('A:N')->getFont()->setName('Arial Narrow')->setSize(10);
        $sheet->getStyle('A5:S5')->getFont()->setBold('Calibri Light')->setSize(8);
        $sheet->getColumnDimension('A')->setWidth(16);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('right');
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getStyle('B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->getStyle('B')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getStyle('C')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getStyle('D')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('D')->getNumberFormat()->setFormatCode('#,##0_-');
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getStyle('E')->getNumberFormat()->setFormatCode('#,##0_-');
        $sheet->getStyle('E')->getAlignment()->setHorizontal('right');
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getStyle('F')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->getStyle('F')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('G')->setWidth(16);
        $sheet->getStyle('G')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->getStyle('G')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getStyle('H')->getAlignment()->setHorizontal('right');
        $sheet->getColumnDimension('I')->setWidth(14);
        $sheet->getStyle('I')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->getStyle('I')->getAlignment()->setHorizontal('right');
        $sheet->getColumnDimension('J')->setWidth(10);
        $sheet->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.0000');
        $sheet->getStyle('J')->getAlignment()->setHorizontal('right');
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->getStyle('K')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD);
        $sheet->getStyle('K')->getAlignment()->setHorizontal('right');
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->getStyle('L')->getAlignment()->setHorizontal('right');
        $sheet->getColumnDimension('M')->setWidth(14);
        $sheet->getStyle('M')->getAlignment()->setHorizontal('right'); 
        $sheet->getColumnDimension('N')->setWidth(10);
        $sheet->getStyle('N')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        $sheet->getStyle('N')->getAlignment()->setHorizontal('right');
        $sheet->getColumnDimension('O')->setWidth(12);
        $sheet->getStyle('O')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->getStyle('O')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('P')->setWidth(16);
        $sheet->getStyle('P')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->getStyle('P')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('Q')->setWidth(16);
        $sheet->getStyle('Q')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->getStyle('Q')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('R')->setWidth(16);
        $sheet->getStyle('R')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->getStyle('R')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('S')->setWidth(14);
        $sheet->getStyle('S')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->getStyle('S')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('B1:S1')->setCellValue('B1', 'GRUPO LEA DE MEXICO S. DE R.L DE C.V');
        $sheet->getStyle('B1:S1')->getFont()->setBold('Calibri')->setSize(22)->setUnderline('true')->setItalic('true');
        $sheet->getStyle('B1:S1')->getAlignment()->setHorizontal('center');       
        $sheet->mergeCells('B2:S2')->setCellValue('B2', 'REPORTE DE COMPRAS');
        $sheet->getStyle('B2:N2')->getFont()->setBold('Calibri')->setSize(18);
        $sheet->getStyle('B2:N2')->getAlignment()->setHorizontal('center');   
        $sheet->mergeCells('P3:Q3')->setCellValue('P3', 'Fecha elaboración:');
        $sheet->getStyle('P3:Q3')->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('R3',date('d/m/Y', strtotime(UtilsHelp::today())));
        $sheet->getStyle('R3')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('P3')->getFont()->setBold('Calibri')->setSize(16);
        $sheet->getStyle('A5:S5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('C5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('D5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('E5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('G5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('H5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('I5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('J5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('K5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('L5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('M5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center'); 
        $sheet->getStyle('N5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center'); 
        $sheet->getStyle('O5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center'); 
        $sheet->getStyle('P5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('Q5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center'); 
        $sheet->getStyle('R5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center'); 
        $sheet->getStyle('S5')->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');    
        $sheet->getStyle('A5:S5')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setRGB('9bc2e6');
        $sheet->getStyle('A5:S5')->applyFromArray(self::STYLEBORDER);
        $sheet->getRowDimension('5')->setRowHeight(30);
        $sheet->fromArray($datosArray, null, 'A5');
        $sheet->setSelectedCell('A6');
        $sheet->setTitle('Reporte Compras');
        
        $spreadsheet->getProperties()->setCreator("Erp. LEA de México")->setTitle('Reporte compras');
        
         $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Grupo LEA de México');
            $drawing->setDescription('logo');
            $drawing->setPath(assets_root.'img/default.jpg'); 
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(110);
            $drawing->setOffsetY(5);
            $drawing->setWidthAndHeight(75, 75);
            $drawing->setWorksheet($sheet);
                   
        $filas = count($embarques)+5;        
        $totales = $filas + 3;
        $sheet->setCellValue('G'.$totales, $sumaImpote);
        $sheet->setCellValue('R'.$totales, $sumaAceite);
        $sheet->setCellValue('S'.$totales, $sumaOtros);
        
      if(!$pdf){
        $nombreDelDocumento = "Reporte_compras_basicos.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      }
      else{
        $columnas = 19;
        for($i=1; $i <= $columnas; $i++){
             $l = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
             for($j=6; $j <= $filas; $j++){                 
                    $sheet->getStyle($l.$j)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->setColor(new Style\Color('00000000'));
             }
        }
       
        $sheet->getPageMargins()->setTop(.3);
        $sheet->getPageMargins()->setRight(.5); 
        $sheet->getPageMargins()->setLeft(.5); 
        $sheet->getPageMargins()->setBottom(.3);
                
        $nombreDelDocumento = "Reporte_compras_basicos.pdf";
        $writer = IOFactory::createWriter($spreadsheet, 'Mpdf');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
      }
         ob_clean();
        $writer->save('php://output');
        exit();
    }
    
     public static function reportePedimentos($embarques, $pdf) {
        $datosArray = [
          ["Num.", "REF.", "Fecha", "Número", "Embarque", "Invoice", "Gallons", "Description", "Unit Price", "U.S. Amount", "T.C." ,
              "Valor pesos", "Incrementables", "Otros", "Valor aduana", "IVA importación", "DTA", "PRV", "IVA PRV", "Total impuestos", "Aduana"],
        ];
        $i = 1;
        foreach($embarques as $e){
            $otrosCargos = $e['oil_fee'] + $e['otrosCargos'];
            $carro = $e['carro_tanque_id'] != null ? $e['carroTanque'] : $e['numero_transporte'];
            $fechaPedimento = $e['fechaPedimento'] != null  ? date('d/m/Y', strtotime($e['fechaPedimento'])) : "";
            $producto = UtilsHelp::recortarString($e['producto'], '(');
            $otros = $otrosCargos == 0 ? "" : $otrosCargos;
            $dta = $e['dta'] == 0 ? "" : $e['dta'];
            $ped = explode(" ", $e['pedimento']);
            $pedimento = $ped != null ? end($ped) : "";
            
         $datosArray[]= [$i, $e['referencia'], $fechaPedimento, $pedimento, $carro , $e['numero_factura'], $e['cantidad_cargada'], $producto,
             $e['precio_producto'], $e['importe'], $e['tipoCambio'], round($e['valorComercial']), round($e['incrementablesPesos']), $otros,
             round($e['valorAduana']), round($e['ivaImportacion']), $dta, round($e['prv']), round($e['ivaPrv']), round($e['totalImpuestos']), $e['claveAduana']];
         $i++;
       }
        $columnas = 21;
        $spreadsheet = new Spreadsheet();      
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet(); 
      
        $sheet->getStyle('A:U')->getFont()->setName('Arial')->setSize(12);
        $sheet->getStyle('B2:T2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B2:T2')->getFont()->setSize(24)->setUnderline('true');
        $sheet->mergeCells('B2:T2')->setCellValue('B2', 'GRUPO LEA DE MÉXICO, S. DE R.L. DE C.V.');
        $sheet->getStyle('A3')->getFont()->setSize(18)->setUnderline('true');
        $sheet->mergeCells('A3:T3')->setCellValue('A3', 'PEDIMENTOS DE IMPORTACION DEL '. date('Y') )->getStyle('A3:T3')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('C5:D5')->setCellValue('C5', 'PEDIMENTO')->getStyle('C5')->getFont()->setSize(14)->setBold('true');
        $sheet->getStyle('C5')->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('C5')->applyFromArray(self::STYLEBORDEDOUBLE);
        $sheet->getStyle('A6:U6')->getFont('Arial')->setSize(12)->setBold('true');
        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getStyle('B')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getStyle('C')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('C')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getStyle('D')->getAlignment()->setHorizontal('right');
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getStyle('E')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('F')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('F')->setWidth(14);
        $sheet->getColumnDimension('G')->setWidth(14);
        $sheet->getStyle('G')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0_-');
        $sheet->getColumnDimension('H')->setWidth(19);
        $sheet->getStyle('H')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('I')->setWidth(13);
        $sheet->getStyle('I')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->getStyle('I')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('J')->setWidth(19);
        $sheet->getStyle('J')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->getStyle('J')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.0000');
        $sheet->getStyle('K')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('L')->getNumberFormat()->setFormatCode(self::FORMAT_ACCOUNTING_USD_SINDECIMAL);
        $sheet->getStyle('L')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getStyle('M')->getNumberFormat()->setFormatCode(self::FORMAT_ACCOUNTING_USD_SINDECIMAL);
        $sheet->getStyle('M')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('M')->setWidth(13);
        $sheet->getStyle('N')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->getStyle('N')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('N')->setWidth(13);
        $sheet->getStyle('O')->getNumberFormat()->setFormatCode(self::FORMAT_ACCOUNTING_USD_SINDECIMAL);
        $sheet->getStyle('O')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('O')->setWidth(17);
        $sheet->getStyle('P')->getNumberFormat()->setFormatCode(self::FORMAT_ACCOUNTING_USD_SINDECIMAL);
        $sheet->getStyle('P')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('P')->setWidth(17);
        $sheet->getStyle('Q')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->getStyle('Q')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('Q')->setWidth(13);
        $sheet->getStyle('R')->getNumberFormat()->setFormatCode(self::FORMAT_ACCOUNTING_USD_SINDECIMAL);
        $sheet->getStyle('R')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('R')->setWidth(13);
        $sheet->getStyle('S')->getNumberFormat()->setFormatCode(self::FORMAT_ACCOUNTING_USD_SINDECIMAL);
        $sheet->getStyle('S')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('S')->setWidth(13);
        $sheet->getStyle('T')->getNumberFormat()->setFormatCode(self::FORMAT_ACCOUNTING_USD_SINDECIMAL);
        $sheet->getStyle('T')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('T')->setWidth(16);
        $sheet->getStyle('U')->getAlignment()->setHorizontal('left');
        $sheet->getColumnDimension('U')->setWidth(17);
        $sheet->mergeCells('R4:S4')->setCellValue('R4', 'Fecha elaboración:');
        $sheet->getStyle('R4:S4')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('R4:S4')->getFont()->setBold('Calibri');
        $sheet->setCellValue('T4',date('d/m/Y', strtotime(UtilsHelp::today())));
        $sheet->getStyle('T4')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('T4')->getFont('Calibri')->setSize(12);
        $sheet->getStyle('A6:U6')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:U6')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE)->setColor(new Style\Color('00000000'));
        for($i=1; $i <= $columnas; $i++){
             $l = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);               
                   $sheet->getStyle($l.'6')->applyFromArray(self::STYLEBORDERTHIN)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        }
       $filas = count($embarques)+6;
        for($i=1; $i <= $columnas; $i++){
             $l = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
             for($j=6; $j <= $filas; $j++){                 
                    $sheet->getStyle($l.$j)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE)->setColor(new Style\Color('00000000'));
             }
        }
        $sheet->fromArray($datosArray, null, 'A6');
        $sheet->setSelectedCell('A7');
        $sheet->setTitle('Reporte pedimentos');
        
        $spreadsheet->getProperties()->setCreator("Erp. LEA de México")->setTitle('Reporte compras');
        
         $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Grupo LEA de México');
            $drawing->setDescription('logo');
            $drawing->setPath(assets_root.'img/default.jpg'); 
            $drawing->setCoordinates('A2');
            $drawing->setOffsetX(110);
            $drawing->setOffsetY(10);
            $drawing->setWidthAndHeight(75, 75);
            $drawing->setWorksheet($sheet);
        
      if(!$pdf){
        $sheet->getSheetView()->setZoomScale(80);
        $nombreDelDocumento = "Reporte_pedimentos.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      }
      else{

        $sheet->getPageMargins()->setTop(.2);
        $sheet->getPageMargins()->setRight(.4); 
        $sheet->getPageMargins()->setLeft(.4); 
        $sheet->getPageMargins()->setBottom(.2);
                
        $nombreDelDocumento = "Reporte_pedimentos.pdf";
        $writer = IOFactory::createWriter($spreadsheet, 'Mpdf');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
      }
         ob_clean();
        $writer->save('php://output');
        exit();
    }
    
         public static function reporteAlmacenTransito($embarques, $pdf) {
      $datosArrayTerminal = [
          ["CARRO", "PRODUCTO", "LITROS", "GALONES", "PRECIO", "COSTO", "FECHA LLEGADA" ,"DÍAS LEA", "FACTURA", "REFINERIA", "PEDIMENTO", "UBICACIÓN"],
        ];
        $datosArray = [
          ["CARRO", "PRODUCTO", "LITROS", "GALONES", "PRECIO", "COSTO", "FECHA TRANS." ,"DÍAS TRANSITO", "FACTURA", "REFINERIA", "PEDIMENTO", "UBICACIÓN"],
        ];
        $i = 1;
        foreach($embarques as $e){
            $carro = $e['carro_tanque_id'] != null ? $e['carroTanque'] : $e['numero_transporte'];

            $producto = UtilsHelp::recortarString($e['producto'], '(');
            $refineria =  substr(UtilsHelp::recortarString($e['producto'], '(', true),0, -1);
            $ped = explode(" ", $e['pedimento']);
            $pedimento = $ped != null ? end($ped) : "";
            $ubicacion = count($e['movimiento']) >= 1 ? ubicaciones_kansas[$e['movimiento'][0]['ubicacion']] : "";
            
           if($e['estatus_id']== 8){ 
         $fechaTransito = $e['fecha_transito'] != null  ? date('d/m/Y', strtotime($e['fecha_transito'])) : "";
         $datosArray[]= [$carro, $producto, $e['litros_facturados'], $e['cantidad_cargada'], $e['precio_producto'], $e['importe'],
              $fechaTransito,  $e['dias_transito'],  $e['numero_factura'], $refineria, $pedimento, $ubicacion
           ];
           }elseif($e['estatus_id'] == 11){
              $fechaTransito = $e['fecha_llegada'] != null  ? date('d/m/Y', strtotime($e['fecha_llegada'])) : "";
              $datosArrayTerminal[]= [$carro, $producto, $e['litros_facturados'], $e['cantidad_cargada'], $e['precio_producto'], $e['importe'],
              $fechaTransito, $e['dias_llegada'],  $e['numero_factura'], $refineria, $pedimento, $ubicacion
           ];
           }
       }
       
        $columnas = 12;
        $spreadsheet = new Spreadsheet();      
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet(); 
        $sheet->getStyle('A:L')->getFont()->setName('Times New Roman')->setSize(12);
        $sheet->getStyle('B2:L2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B2:L2')->getFont()->setSize(24)->setUnderline('true');
        $sheet->mergeCells('B2:L2')->setCellValue('B2', 'GRUPO LEA DE MÉXICO, S. DE R.L. DE C.V.');
        $sheet->getStyle('A3')->getFont()->setSize(18)->setUnderline('true');
        $sheet->mergeCells('A3:L3')->setCellValue('A3', 'ALMACÉN EN TERMINAL' )->getStyle('A3:L3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A6:L6')->getFont('Arial')->setSize(12)->setBold('true');
        $sheet->getColumnDimension('A')->setWidth(16);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getStyle('B')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getStyle('C')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('C')->getNumberFormat()->setFormatCode('#,##0_-');;
        $sheet->getColumnDimension('D')->setWidth(14);
        $sheet->getStyle('D')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D')->getNumberFormat()->setFormatCode('#,##0_-');;
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getStyle('E')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('E')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        $sheet->getStyle('F')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getColumnDimension('F')->setWidth(17);
        $sheet->getColumnDimension('G')->setWidth(16);
        $sheet->getStyle('G')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('H')->setWidth(10);
        $sheet->getStyle('H')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getStyle('I')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getStyle('J')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('K')->setWidth(16);
        $sheet->getStyle('K')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('L')->setWidth(16);
        $sheet->getStyle('L')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A6:L6')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setRGB('c3c3ce');
        $sheet->getStyle('A6:L6')->getAlignment()->setHorizontal('center');
        for($i=1; $i <= $columnas; $i++){
             $l = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);               
                   $sheet->getStyle($l.'6')->applyFromArray(self::STYLEBORDERTHIN)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        }
       $filas = count($datosArrayTerminal) + 5;
        for($i=1; $i <= $columnas; $i++){
             $l = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
             for($j=7; $j <= $filas; $j++){                 
                    $sheet->getStyle($l.$j)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->setColor(new Style\Color('00000000'));
             }
        }
        $sheet->fromArray($datosArrayTerminal, null, 'A6');

        $filasTrans = $filas + 2;
        $filasArray = $filas + 4;
        $cordenada = 'A'.$filasTrans.':L'.$filasTrans;
        $cordenadaArray = 'A'.$filasArray.':L'.$filasArray;
        $sheet->mergeCells($cordenada)->setCellValue('A'.$filasTrans, 'ALMACÉN EN TRÁNSITO' )->getStyle($cordenada)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A'.$filasTrans)->getFont()->setSize(18)->setUnderline('true');
        
        
        $sheet->getStyle($cordenadaArray)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setRGB('c3c3ce');
        $sheet->getStyle($cordenadaArray)->getAlignment()->setHorizontal('center');
        $sheet->getStyle($cordenadaArray)->getFont('Arial')->setSize(12)->setBold('true');
        for($i=1; $i <= $columnas; $i++){
             $l = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);               
                   $sheet->getStyle($l.$filasArray)->applyFromArray(self::STYLEBORDERTHIN)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        }
        
       $filasTerminal = count($datosArray) + ($filasArray - 1);
        for($i=1; $i <= $columnas; $i++){
             $l = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
             for($j=$filasArray + 1; $j <= $filasTerminal; $j++){                 
                    $sheet->getStyle($l.$j)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->setColor(new Style\Color('00000000'));
             }
        }
        
        $sheet->fromArray($datosArray, null, 'A'.$filasArray);
        $sheet->setSelectedCell('A7');
        $sheet->setTitle('Almacén básicos');
        $spreadsheet->getProperties()->setCreator("Erp. LEA de México")->setTitle('Reporte almacén básicos');
        
         $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Grupo LEA de México');
            $drawing->setDescription('logo');
            $drawing->setPath(assets_root.'img/default.jpg'); 
            $drawing->setCoordinates('A2');
            $drawing->setOffsetX(110);
            $drawing->setOffsetY(10);
            $drawing->setWidthAndHeight(75, 75);
            $drawing->setWorksheet($sheet);
        
      if(!$pdf){
        $sheet->getSheetView()->setZoomScale(100);
        $nombreDelDocumento = "Reporte_almacen_basicos.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      }
      else{

        $sheet->getPageMargins()->setTop(.2);
        $sheet->getPageMargins()->setRight(.4); 
        $sheet->getPageMargins()->setLeft(.4); 
        $sheet->getPageMargins()->setBottom(.2);
                
        $nombreDelDocumento = "Reporte_almacen_basicos.pdf";
        $writer = IOFactory::createWriter($spreadsheet, 'Mpdf');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
      }
        ob_clean();
        $writer->save('php://output');
        exit();
    }
    
      public static function generarInventarioEquipoComputo($equipos, $doc) {
        $datosArray = [
          ["TIPO EQUIPO", 'FOLIO', "MODELO", "MARCA", "NÚMERO DE SERIE", "FECHA COMPRA", "FACTURA", "USUARIO" ,"DEPARTAMENTO", "ASIGNACIÓN",  
              "CARACTERISTICAS", "APLICACIONES", "FECHA BAJA", "MANTENIMIENTO", "MAC ETHERNET", "MAC WIFI", "OBSERVACIONES"],
        ];
       
        foreach($equipos as $e){
            $tipoEquipo = equipos_sistemas[$e->tipo_equipo];
            $marca = marcas_sistemas[$e->marca];
            $fechaCompra = $e->fecha_compra != null  ? date('d/m/Y', strtotime($e->fecha_compra)) : "";
            $fechaAsignacion = $e->fecha_asignacion != null  ? date('d/m/Y', strtotime($e->fecha_asignacion)) : "";
            $fechaBaja = $e->fecha_baja != null  ? date('d/m/Y', strtotime($e->fecha_baja)) : "";
            $fechaMantenimiento = $e->fecha_mantenimiento!= null  ? date('d/m/Y', strtotime($e->fecha_mantenimiento)) : "";
            $procesador = $e->procesador;
            $disco =  $e->disco_duro != "" ? ", ". $e->disco_duro: "";
            $ram = $e->memoria_ram != "" ? ", " . $e->memoria_ram : "";
            $caracteristicas = $procesador.$ram.$disco;
            $aplicaciones = Utils::getAplicaionesSistemas($e->aplicaciones);
            
         $datosArray[]= [$tipoEquipo, $e->folio, $e->modelo, $marca, $e->numero_serie, $fechaCompra, $e->factura, $e->usuario, $e->departamento, $fechaAsignacion,
             $caracteristicas, $aplicaciones, $fechaBaja, $fechaMantenimiento, $e->red_lan, $e->red_wifi, $e->observaciones];
       }
       
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet(); 
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getStyle('A:Q')->getFont()->setName('Arial Narrow')->setSize(10);
        $sheet->getStyle('A5:Q5')->getFont()->setBold('Calibri Light')->setSize(8);
        $sheet->getColumnDimension('A')->setWidth(14);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getStyle('B')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getStyle('C')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('D')->setWidth(14);
        $sheet->getStyle('D')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('E')->setWidth(16);
        $sheet->getStyle('E')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('F')->setWidth(14);
        $sheet->getStyle('F')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->getColumnDimension('G')->setWidth(16);
        $sheet->getStyle('G')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getStyle('H')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getStyle('I')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('J')->setWidth(14);
        $sheet->getStyle('J')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->getStyle('J')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('K')->setWidth(18);
        $sheet->getStyle('K')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('L')->setWidth(26);
        $sheet->getStyle('L')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('M')->setWidth(14);
        $sheet->getStyle('M')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->getStyle('M')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('N')->setWidth(14);
        $sheet->getStyle('N')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->getStyle('N')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('O')->setWidth(18);
        $sheet->getStyle('O')->getAlignment()->setHorizontal('center'); 
        $sheet->getColumnDimension('P')->setWidth(18);
        $sheet->getStyle('P')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('Q')->getAlignment()->setHorizontal('center'); 
        $sheet->getColumnDimension('Q')->setWidth(100);
        $sheet->mergeCells('B1:Q1')->setCellValue('B1', 'GRUPO LEA DE MÉXICO S. DE R.L DE C.V');
        $sheet->getStyle('B1:Q1')->getFont()->setBold('Calibri')->setSize(22);
        $sheet->getStyle('B1:Q1')->getAlignment()->setHorizontal('center');       
        $sheet->mergeCells('A2:Q2')->setCellValue('A2', 'INVENTARIO EQUIPO CÓMPUTO');
        $sheet->getStyle('A2:Q2')->getFont()->setBold('Calibri')->setSize(16);
        $sheet->getStyle('A2:Q2')->getAlignment()->setHorizontal('center');   
        $sheet->mergeCells('L3:M3')->setCellValue('L3', 'Fecha elaboración:');
        $sheet->getStyle('L3:M3')->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('N3',date('d/m/Y', strtotime(UtilsHelp::today())));
        $sheet->getStyle('N3')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('L3:M3')->getFont()->setBold('Calibri')->setSize(12);
        $sheet->getStyle('A5:Q5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('C5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('D5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('E5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('G5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('H5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('I5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('J5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('K5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('L5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('M5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center'); 
        $sheet->getStyle('N5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center'); 
        $sheet->getStyle('O5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center'); 
        $sheet->getStyle('P5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center'); 
        $sheet->getStyle('Q5')->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');    
        $sheet->getStyle('A5:Q5')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setRGB('c4c2c7');
        $sheet->getStyle('A5:Q5')->applyFromArray(self::STYLEBORDER);
        $sheet->getRowDimension('5')->setRowHeight(30);
        $sheet->fromArray($datosArray, null, 'A5');
        $sheet->setSelectedCell('A6');
        $sheet->setTitle('Inventario equipo de cómputo');      
        $columnas =17;
               $filas = count($datosArray) + 4;
                for($i=1; $i <= $columnas; $i++){
                $l = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);               
                $sheet->getStyle($l.'6')->applyFromArray(self::STYLEBORDERTHIN)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
                 for($j=6; $j <= $filas; $j++){                 
                    $sheet->getStyle($l.$j)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->setColor(new Style\Color('00000000'));
             }
        }
        $sheet->setCellValue('Q'.($filas+1), $doc != null ? $doc->codigo : "");   
        $sheet->getStyle('Q'.($filas+1))->getAlignment()->setHorizontal('right');
        $sheet->getStyle('Q'.($filas+1))->getFont()->setBold('Calibri')->setSize(8);
        $spreadsheet->getProperties()->setCreator("Erp. LEA de México")->setTitle('Inventario equipo cómputo');
        
         $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Grupo LEA de México');
            $drawing->setDescription('logo');
            $drawing->setPath(assets_root.'img/default.jpg'); 
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(120);
            $drawing->setWidthAndHeight(85, 85);
            $drawing->setWorksheet($sheet);
        
        $nombreDelDocumento = "Inventario equipo cómputo.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        ob_clean();
        $writer->save('php://output');
        exit();
    }
    
  public static function generarReporteIndicadorServicio($solicitudes, $pdf) {
        $datosArray = [
          ["FOLIO", "TIPO REQUERIMIENTO", "TIPO SOLICITUD", "PRIORIDAD", "SOLICITANTE", "FECHA SOLICITUD", "FECHA ATENCION", "FECHA FIN", 
              "ATENCIÓN (MINUTOS)", "STATUS ATENCIÓN",  "FINALIZACIÓN (DÍAS)", "STATUS SOLUCIÓN"],
        ];
  
        foreach($solicitudes as $s){
              $tipoRequerimiento = requerimientos[$s['tipo_requerimiento']];
              $tipoSolicitud= tipoSolicitud[$s['tipo_solicitud']];
              $prioridad = prioriodades[$s['prioridad']];
              $fechaSolicitud =  date('d/m/Y H:i:s', strtotime($s['fecha_solicitud']));
              $fechaAtencion = date('d/m/Y H:i:s', strtotime($s['fecha_atencion']));
              $fechaSolucion =  date('d/m/Y H:i:s', strtotime($s['fecha_solucion']));
              $atencion =  $s['tiempo_atencion'];
              $solucion =  $s['tiempo_solucion'];
              if($s['prioridad'] == 1){
                $statusAtencion = $atencion >= 20 ? "No cumple" : "Cumple";
                $statusFin = $solucion >= 2 ? "No cumple" : "Cumple";
              }elseif ($s['prioridad'] == 2) {
                $statusAtencion = $atencion >= 60 ? "No cumple" : "Cumple";
                $statusFin = $solucion >= 5 ? "No cumple" : "Cumple";
            }else{
                $statusAtencion = $atencion >= 360 ? "No cumple" : "Cumple";
                $statusFin = $solucion >= 10 ? "No cumple" : "Cumple";
            }            

        $datosArray[]= [$s['folio'], $tipoRequerimiento, $tipoSolicitud, $prioridad, $s['usuario'], $fechaSolicitud, $fechaAtencion, $fechaSolucion,  
            $atencion, $statusAtencion, $solucion, $statusFin];
       }
       
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet(); 
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getStyle('A:L')->getFont()->setName('Arial Narrow')->setSize(10);
        $sheet->getStyle('A5:L5')->getFont()->setBold('Calibri Light')->setSize(8);
        $sheet->getColumnDimension('A')->setWidth(14);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getStyle('B')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getStyle('C')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('D')->setWidth(9);
        $sheet->getStyle('D')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('E')->setWidth(28);
        $sheet->getStyle('E')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('F')->setWidth(17);
        $sheet->getStyle('F')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('G')->setWidth(17);
        $sheet->getStyle('G')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('H')->setWidth(17);
        $sheet->getStyle('H')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getStyle('I')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('J')->setWidth(14);
        $sheet->getStyle('J')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->getStyle('K')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('L')->setWidth(14);
        $sheet->getStyle('L')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:L1')->setCellValue('A1', 'GRUPO LEA DE MÉXICO S. DE R.L DE C.V');
        $sheet->getStyle('A1:L1')->getFont()->setBold('Calibri')->setSize(22);
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal('center');       
        $sheet->mergeCells('A2:L2')->setCellValue('A2', 'INDICADOR SOLICITUDES SERVICIO SISTEMAS');
        $sheet->getStyle('A2:L2')->getFont()->setBold('Calibri')->setSize(16);
        $sheet->getStyle('A2:L2')->getAlignment()->setHorizontal('center');   
        $sheet->mergeCells('I3:J3')->setCellValue('I3', 'Fecha elaboración:');
        $sheet->getStyle('I3:J3')->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('K3',date('d/m/Y', strtotime(UtilsHelp::today())));
        $sheet->getStyle('K3')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('I3:J3')->getFont()->setBold('Calibri')->setSize(12);
        $sheet->getStyle('A5:L5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('C5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('D5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('E5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('G5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('H5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('I5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('J5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('K5')->applyFromArray(self::STYLEBORDERRIGHT)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('L5')->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');    
        $sheet->getStyle('A5:L5')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setRGB('c4c2c7');
        $sheet->getStyle('A5:L5')->applyFromArray(self::STYLEBORDER);
        $sheet->getRowDimension('5')->setRowHeight(30);
        $sheet->fromArray($datosArray, null, 'A5');
        $sheet->setSelectedCell('A6');
        $sheet->setTitle('Indicador servicio');      
        $columnas =12;
        $filas = count($datosArray) + 4;
         for($i=1; $i <= $columnas; $i++){
         $l = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);               
         $sheet->getStyle($l.'6')->applyFromArray(self::STYLEBORDERTHIN)->getAlignment()->setWrapText(true)->setHorizontal('center')->setVertical('center');
           for($j=6; $j <= $filas; $j++){                 
             $sheet->getStyle($l.$j)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->setColor(new Style\Color('00000000'));
            }
        }
            $conditional1 = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
            $conditional1->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CONTAINSTEXT);
            $conditional1->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_CONTAINSTEXT);
            $conditional1->setText('No');
            $conditional1->getStyle()->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $conditional1->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $conditional1->getStyle()->getFill()->getEndColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
            $conditional1->getStyle()->getFont()->setBold(true);

            $conditional2 = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
            $conditional2->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CONTAINSTEXT);
            $conditional2->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_NOTCONTAINS);
            $conditional2->setText('No');
            $conditional2->getStyle()->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $conditional2->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $conditional2->getStyle()->getFill()->getEndColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
            $conditional2->getStyle()->getFont()->setBold(true);

            $conditionalStyles = $sheet->getStyle('J6:J'.$filas)->getConditionalStyles();
            $conditionalStyles[] = $conditional1;
            $conditionalStyles[] = $conditional2;

            $sheet->getStyle('J6:J'.$filas)->setConditionalStyles($conditionalStyles);

            $conditionalStyles = $sheet->getStyle('L6:L'.$filas)->getConditionalStyles();
            $conditionalStyles[] = $conditional1;
            $conditionalStyles[] = $conditional2;

            $sheet->getStyle('L6:L'.$filas)->setConditionalStyles($conditionalStyles);
            
            $sheet->getComment('J5')->getText()->createTextRun('Prioridad alta, tiempo atención 20 min.')->getFont()->setBold('Calibri')->setSize(8);
            $sheet->getComment('J5')->getText()->createTextRun("\r \n");
            $sheet->getComment('J5')->getText()->createTextRun('Prioridad media, tiempo atención 60 min.')->getFont()->setBold('Calibri')->setSize(8);
            $sheet->getComment('J5')->getText()->createTextRun("\r \n");
            $sheet->getComment('J5')->getText()->createTextRun('Prioridad baja, tiempo atención 180 min.')->getFont()->setBold('Calibri')->setSize(8);
            $sheet->getComment('J5')->setHeight(150);
            
            $sheet->getComment('L5')->getText()->createTextRun('Prioridad alta, tiempo solución 2 días')->getFont()->setBold('Calibri')->setSize(8);
            $sheet->getComment('L5')->getText()->createTextRun("\r \n");
            $sheet->getComment('L5')->getText()->createTextRun('Prioridad media, tiempo solución 5 días.')->getFont()->setBold('Calibri')->setSize(8);
            $sheet->getComment('L5')->getText()->createTextRun("\r \n");
            $sheet->getComment('L5')->getText()->createTextRun('Prioridad baja, tiempo solución 10 días.')->getFont()->setBold('Calibri')->setSize(8);
            $sheet->getComment('L5')->setHeight(150);                 
                    
            $fn = $filas + 2;
            $sheet->mergeCells('B'.$fn.':C'.$fn)->setCellValue('B'.$fn, 'Solicitudes en le periódo:');
            $sheet->setCellValue('F'.($fn+1), 'ATENCIÓN:');
            $sheet->setCellValue('F'.($fn+2), 'SOLUCIÓN:');
            $sheet->setCellValue('D'.$fn, count($solicitudes));
            $sheet->setCellValue('G'.$fn, 'CUMPLEN');
            $sheet->setCellValue('H'.$fn, 'NO CUMPLEN');
            $sheet->setCellValue('I'.$fn, 'PROMEDIO');
            $sheet->setCellValue('G'.($fn+1), '=COUNTIF(J6:J'.($filas).',"Cumple")');
            $sheet->setCellValue('H'.($fn+1), '=COUNTIF(J6:J'.($filas).',"No cumple")');
            $sheet->setCellValue('G'.($fn+2), '=COUNTIF(L6:L'.($filas).',"Cumple")');
            $sheet->setCellValue('H'.($fn+2), '=COUNTIF(L6:L'.($filas).',"No cumple")');
            $sheet->setCellValue('I'.($fn+1), '=ROUND(G'.($fn+1).'* 100/D'.($fn).',2)');
            $sheet->setCellValue('I'.($fn+2), '=ROUND(G'.($fn+2).'* 100/D'.($fn).',2)');
            
           $sheet->getComment('I'.$fn)->getText()->createTextRun('Meta 95%')->getFont()->setBold('Calibri')->setSize(8);
            
            $sheet->getStyle('B'.$fn.':C'.$fn)->getAlignment()->setHorizontal('right');
            $sheet->getStyle('D'.$fn)->getFont()->setBold(true);
            $sheet->getStyle('F'.($fn+1))->getAlignment()->setHorizontal('right');
            $sheet->getStyle('F'.($fn+2))->getAlignment()->setHorizontal('right');
            $spreadsheet->getProperties()->setCreator("Erp. LEA de México")->setTitle('Indicador servicio');
            
            $conditional3 = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
            $conditional3->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CELLIS);
            $conditional3->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_LESSTHANOREQUAL);
            $conditional3->addCondition('95');
            $conditional3->getStyle()->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $conditional3->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $conditional3->getStyle()->getFill()->getEndColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
            $conditional3->getStyle()->getFont()->setBold(true);

            $conditional4 = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
            $conditional4->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CELLIS);
            $conditional4->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_GREATERTHANOREQUAL);
            $conditional4->addCondition('95');
            $conditional4->getStyle()->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $conditional4->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $conditional4->getStyle()->getFill()->getEndColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
            $conditional4->getStyle()->getFont()->setBold(true);

            $conditionalPromedio = $sheet->getStyle('I'.($fn+1).':I'.($fn+2))->getConditionalStyles();
            $conditionalPromedio[] = $conditional3;
            $conditionalPromedio[] = $conditional4;

            $sheet->getStyle('I'.($fn+1).':I'.($fn+2))->setConditionalStyles($conditionalPromedio);
            
        
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Grupo LEA de México');
        $drawing->setDescription('logo');
        $drawing->setPath(assets_root.'img/default.jpg'); 
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(120);
        $drawing->setWidthAndHeight(85, 85);
        $drawing->setWorksheet($sheet);
        
      if(!$pdf){
        $nombreDelDocumento = "Indicador servicio.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      }
      else{
  
        $sheet->getPageMargins()->setTop(.3);
        $sheet->getPageMargins()->setRight(.4); 
        $sheet->getPageMargins()->setLeft(.4); 
        $sheet->getPageMargins()->setBottom(.3);
                
        $nombreDelDocumento = "Inventario servicio.pdf";
        $writer = IOFactory::createWriter($spreadsheet, 'Mpdf');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
      }
         ob_clean();
        $writer->save('php://output');
        exit();
    }
    
}
