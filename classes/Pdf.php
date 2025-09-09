<?php

    namespace Classes;

    use Fpdf\Fpdf;
class Pdf {

    public function bauche_estudiante()
    {
        $dir = __DIR__ . '/../public/img/';
        $imagen_path = "";

        if (file_exists($dir . "banner-upt.png")) {
            $imagen_path = $dir . "banner-upt.png";
        }
        $pdf = new FPDF('P', 'mm', 'letter');
        $pdf->SetMargins(3, 8, 3);
        $pdf->SetAutoPageBreak(true);
        $pdf->AddPage();
        if (!empty($imagen_path)) {
            $pdf->Image($imagen_path, 10, null, 0, 12, 'PNG');
        }
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);
        $texto = 'UNIVERSIDAD POLITECNICA TERRITORIAL DEL ESTADO BOLIVAR "UPTEB"';
        $pdf->cell(0, 5, $texto, 0, 0, 'C');
        $pdf->Ln();
        $texto = 'G-20002070-9';
        $pdf->cell(0, 5, $texto, 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'RECIBO DE PAGO', 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(0, 10, 'ARANCELES', 0, 0, 'C');
        $pdf->Ln(20);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(150);
        $pdf->Cell(30, 5, '1574', 1, 0, 'C');
        $pdf->Ln();

        // pequeña tabla de fecha que fue creado y fecha reportado el pago 
        $pdf->SetX(113); // Posicionar el cursor en el lado derecho de la página
        $pdf->Cell(40, 8, 'Fecha:', 1, 0, 'C');
        $pdf->Cell(30, 8, '29/11/2023', 1, 1, 'C');
        $pdf->SetX(113); // Posicionar el cursor en el lado derecho de la página
        $pdf->Cell(40, 8, 'Fecha de Pago: ', 1, 0, 'C');
        $pdf->Cell(30, 8, '30/11/2023', 1, 1, 'C');

        $pdf->Ln(20);

        $pdf->SetX(20);
        $pdf->Cell(40, 10, 'ESTUDIANTE: ', 0, 0, 'C');
        $pdf->SetX(80);
        $pdf->Cell(100, 10, 'ESTEFANY GABRIELA VELASQUEZ ROJAS', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetX(60);
        $pdf->Cell(150, .5, '', 0, 0, 'C', true);
        $pdf->Ln(10);

        $pdf->SetX(20);
        $pdf->Cell(40, 10, 'CEDULA: ', 0, 0, 'C');
        $pdf->SetX(80);
        $pdf->Cell(100, 10, '25036025', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetX(60);
        $pdf->Cell(150, .5, '', 0, 0, 'C', true);
        $pdf->Ln(10);

        $pdf->SetX(20);
        $pdf->Cell(40, 10, 'CANTIDAD: ', 0, 0, 'C');
        $pdf->SetX(80);
        $pdf->Cell(100, 10, '100,10', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetX(80);
        $pdf->Cell(100, .5, '', 0, 0, 'C', true);
        $pdf->Ln(10);

        $pdf->SetX(20);
        $pdf->Cell(40, 10, 'BANCO EMISOR: ', 0, 0, 'C');
        $pdf->SetX(80);
        $pdf->Cell(100, 10, 'VENEZUELA', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetX(80);
        $pdf->Cell(100, .5, '', 0, 0, 'C', true);
        $pdf->Ln(10);

        $pdf->SetX(20);
        $pdf->Cell(40, 10, 'ARANCEL(ES): ', 0, 0, 'C');
        $pdf->SetX(80);
        $pdf->Cell(100, 10, 'CARNET', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetX(80);
        $pdf->Cell(100, .5, '', 0, 0, 'C', true);
        $pdf->Ln(10);

        $pdf->SetX(20);
        $pdf->Cell(40, 10, 'PNF: ', 0, 0, 'C');
        $pdf->SetX(80);
        $pdf->Cell(100, 10, 'INFORMATICA', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetX(80);
        $pdf->Cell(100, .5, '', 0, 0, 'C', true);
        $pdf->Ln(10);

        $pdf->SetX(20);
        $pdf->Cell(40, 10, 'Nº REFERENCIA: ', 0, 0, 'C');
        $pdf->SetX(80);
        $pdf->Cell(100, 10, '77440183', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetX(80);
        $pdf->Cell(100, .5, '', 0, 0, 'C', true);
        $pdf->Ln(10);

        $pdf->SetX(20);
        $pdf->Cell(40, 10, 'CATEGORIA: ', 0, 0, 'C');
        $pdf->SetX(80);
        $pdf->Cell(100, 10, 'ACADEMICO', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetX(80);
        $pdf->Cell(100, .5, '', 0, 0, 'C', true);
        $pdf->Ln(10);

        $pdf->Output();
    }
}

?>