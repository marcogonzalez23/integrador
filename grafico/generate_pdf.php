<?php
//incluir conexión
include_once("connection.php");
include_once('fpdf.php');

class PDF extends FPDF
{
// Para dar parametros especificos al momento de generár las páginas del PDF
function Header()
{
    // Logotipo
    $this->Image('dog.jpg',10,-5,40); //X  Y T
    $this->SetFont('Arial','B',13);
    // Mover
    $this->Cell(80);
    // Titulo principal
    $this->Cell(80,10,'Datos dispensador',1,0,'C');
    // Espacio hacia abajo de los datos en la tabla
    $this->Ln(20);
}

// Página 
function Footer()
{
    // Posición a 1.5 cm para el boton
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Datos de la tabla
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$db = new dbObj();
$connString =  $db->getConnstring();
$display_heading = array('id'=>'ID', 'presion'=> '% del contenedor', 'humedad'=> 'Humedad','temperatura'=> 'Temperatura','distancia'=> 'Distancia mascota','fecha_hora'=> 'Fecha y hora',);

$result = mysqli_query($connString, "SELECT id, presion, humedad, temperatura, distancia, fecha_hora FROM tabla_sensor") or die("database error:". mysqli_error($connString));
$header = mysqli_query($connString, "SHOW columns FROM tabla_sensor");

$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',9);
foreach($header as $heading) {
$pdf->Cell(32,12,$display_heading[$heading['Field']],1);
}
foreach($result as $row) {
$pdf->Ln();
foreach($row as $column)
$pdf->Cell(32,12,$column,1);
}
$pdf->Output();
?>