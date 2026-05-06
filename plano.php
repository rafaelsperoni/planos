<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('img/logo-ifc.png',6,8,40);
    // Logo
    $this->Image('img/logo.png',179,6,25);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,utf8_decode('Plano de Emergência'),0,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $txt = "IFC-Camboriú - Curso Técnico em Defesa Civil - Autoproteção Social\n";
    $txt .= "https://www.camboriu.ifc.edu.br/autoprotecao-social/                                         Página ".$this->PageNo()." de {nb}\n";
    $this->MultiCell(0,5,utf8_decode($txt),0,1);
    $this->Image('img/qrcode_planos.png',179,275,20);
}
}

//var_dump($_POST);

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
//data
$pdf->Cell(0,8,utf8_decode('1. Data: '.date('d/m/Y').'. Recomendável atualizar a cada 06 meses.'),0,1);
//defesa civil sms
$pdf->SetFont('Arial','',12);

$pdf->Cell(0,8,utf8_decode('2. Receba avisos e alertas da Defesa Civil:'),0,1);
//img defesa civil
$pdf->Image('img/defesacivil.png', 75, null, 60);
//kit
$pdf->Cell(0,8,utf8_decode('3. Verifique seu kit/mochila de emergência.'),0,1);

//endereco
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,utf8_decode('Informações da Família'),0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,utf8_decode($_POST['endereco']),0,1);

//membros
$pdf->Cell(0,8,utf8_decode('Membro(s) da Família:'),0,1);

$txt = "";
for ($i=0;$i<sizeof($_POST['membro_nome']);$i++){
    $txt .= "Nome: ".$_POST['membro_nome'][$i]."\n";
    $txt .= "Telefone: ".$_POST['membro_telefone'][$i]."\n";
    $txt .= "Redes Sociais: ".$_POST['membro_redes_sociais'][$i]."\n";
    $txt .= "E-mail: ".$_POST['membro_email'][$i]."\n";
    $txt .= "Informações: ".$_POST['membro_informacoes'][$i]."\n";
    if ($i != sizeof($_POST['membro_nome'])-1){
        $txt .= "\n";
    }
}
$pdf->MultiCell(0,5,utf8_decode($txt),1,1);

//planos
$pdf->Cell(0,8,utf8_decode('Plano(s) de Emergência: '),0,1);
$txt = "";
for ($i=0;$i<sizeof($_POST['plano_nome']);$i++){
    $txt .= "Nome: ".$_POST['plano_nome'][$i]."\n";
    $txt .= "Endereço: ".$_POST['plano_endereco'][$i]."\n";
    $txt .= "Telefone: ".$_POST['plano_telefone'][$i]."\n";
    $txt .= "Website: ".$_POST['plano_website'][$i]."\n";
    $txt .= "Plano: ".$_POST['plano_plano'][$i]."\n";
    if ($i != sizeof($_POST['plano_nome'])-1){
        $txt .= "\n";
    }
}
$pdf->MultiCell(0,5,utf8_decode($txt),1,1);

//contatos
$pdf->Cell(0,8,utf8_decode('Contato(s) de Emergência: '),0,1);
$txt = "";
for ($i=0;$i<sizeof($_POST['contato_nome']);$i++){
    $txt .= "Nome: ".$_POST['contato_nome'][$i]."\n";
    $txt .= "Endereço: ".$_POST['contato_endereco'][$i]."\n";
    $txt .= "Telefone: ".$_POST['contato_celular'][$i]."\n";
    $txt .= "E-mail: ".$_POST['contato_email'][$i]."\n";
    if ($i != sizeof($_POST['contato_nome'])-1){
        $txt .= "\n";
    }
}
$pdf->MultiCell(0,5,utf8_decode($txt),1,1);

//locais
$pdf->Cell(0,8,utf8_decode('Local(is) de Encontro: '),0,1);
$txt = "";
for ($i=0;$i<sizeof($_POST['local_localizacao']);$i++){
    $txt .= "Local: ".$_POST['local_localizacao'][$i]."\n";
    $txt .= "Instruções: ".$_POST['local_instrucoes'][$i]."\n";
    if ($i != sizeof($_POST['local_localizacao'])-1){
        $txt .= "\n";
    }
}
$pdf->MultiCell(0,5,utf8_decode($txt),1,1);

//medicos
$pdf->Cell(0,8,utf8_decode('Contato(s) Médico(s): '),0,1);
$txt = "";
for ($i=0;$i<sizeof($_POST['medico_nome']);$i++){
    $txt .= "Nome: ".$_POST['medico_nome'][$i]."\n";
    $txt .= "Contato: ".$_POST['medico_contato'][$i]."\n";
    $txt .= "Observações: ".$_POST['medico_observacoes'][$i]."\n";
    if ($i != sizeof($_POST['medico_nome'])-1){
        $txt .= "\n";
    }
}
$pdf->MultiCell(0,5,utf8_decode($txt),1,1);

$arq = 'plano_'.date('dmY-His').'.pdf';
$pdf->Output('D', $arq);
?>

