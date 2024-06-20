<?php
require 'vendor/autoload.php';
include "db_connect.php";

$sql = "SELECT id, studentNum, naamStudent, bewijs FROM aanvraag ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("No student data found.");
}

$sql = "SELECT * FROM aanvraag_examens WHERE aanvraag_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$student['id']]);
$examens = $stmt->fetchAll(PDO::FETCH_ASSOC);

$image_file = 'download.png';

class MYPDF extends TCPDF
{
    protected $logoPath;

    public function __construct($logoPath, $orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa)
    {
        $this->logoPath = $logoPath;
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }

    public function Header()
    {
        if (file_exists($this->logoPath)) {
            $this->Image($this->logoPath, 10, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        } else {
            $this->Cell(0, 15, 'Logo file not found', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        }
        $this->SetFont('helvetica', 'B', 20);
        $this->Cell(0, 15, 'Vrijstelling Aanvraag', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetY(50);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

function generateAndSavePDF($student, $examens, $image_file)
{
    $pdf = new MYPDF($image_file, PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Indien PDF');
    $pdf->SetHeaderData('', 0, '', '');
    $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
    $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->AddPage();
    $pdf->SetFont('', '', 12);

    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Studentgegevens', 0, 1, 'L');
    $pdf->SetFont('', '', 12);
    $pdf->Cell(0, 10, 'Naam: ' . htmlspecialchars($student['naamStudent']), 0, 1, 'L');
    $pdf->Cell(0, 10, 'Studentnummer: ' . htmlspecialchars($student['studentNum']), 0, 1, 'L');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Examens', 0, 1, 'L');

    $pdf->SetFont('', '', 12);
    foreach ($examens as $examen) {
        $pdf->Cell(0, 10, 'Examen naam: ' . htmlspecialchars($examen['examenNaam']), 0, 1, 'L');
        $pdf->Cell(0, 10, 'Examen code: ' . htmlspecialchars($examen['examenCode']), 0, 1, 'L');
        $pdf->Ln();
    }

    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Bewijs', 0, 1, 'L');
    $pdf->SetFont('', '', 12);
    $pdf->Cell(0, 10, 'Bewijs: ' . (isset($student['bewijs']) && $student['bewijs'] !== 'nee' ? 'Ja, bewijs is verstuurd.' : 'Nee, geen bewijs verstuurd.'), 0, 1, 'L');
    $pdf->Ln();

    $pdfPath = __DIR__ . '/pdfs/IndieningExamen.pdf';
    if (!file_exists(__DIR__ . '/pdfs')) {
        mkdir(__DIR__ . '/pdfs', 0777, true);
    }

    $pdf->Output($pdfPath, 'F');

    return $pdfPath;
}

$pdfPath = generateAndSavePDF($student, $examens, $image_file);
