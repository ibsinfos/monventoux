<?php
//require_once("../db_drupal.php");
//require_once("../db_monventoux.php");
// require_once("../drupalfunctions.php");
//require_once("inc/drupal2ventoux.php");
// require_once("inc/connect.inc.php");
// require_once("inc/ventouxfunctions.php");
// require_once("inc/functions.php");
// function attestDeelnemer($id){
// 	global $werkjaar;
// 	$sql = "SELECT formule FROM mv".$werkjaar."_deelnemers WHERE sadn_id=".$id." AND sadn_id>0";
// 	$result = mysql_query($sql) or die (mysql_error());
// 	if(mysql_num_rows($result)>0){
// 		$r=mysql_fetch_array($result);
// 		$formule = $r['formule'];
// 		if($formule=="ventourist" || $formule=="cannibale" || $formule=="cannibalette"){
// 			return true;
// 		}else{
// 			return false;
// 		}
// 	}else{
// 		return false;
// 	}
// }

// if($_GET['id']){
// 	$id = $_GET['id'];
	// if(attestDeelnemer($id)){	
		require_once("inc/fpdf.php");
		class PDF extends FPDF{
			// Page header
			function Header(){
				$this->SetXY(0,0);
				// Header image
				$this->Image(__DIR__.'/images/maheader.png',0,0,-150);
				$this->Ln(20);
			}
			// Page footer
			function Footer(){
				// Position at 1.5 cm from bottom
				$this->SetY(-30);
				// Footer image
				$this->Image(__DIR__.'/images/mafooter.png',0,260,-150);
			}
		}
		class PDF_Code39 extends PDF {
			function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5){
				$wide = $baseline;
				$narrow = $baseline / 3 ;
				$gap = $narrow;

				$barChar['0'] = 'nnnwwnwnn'; $barChar['1'] = 'wnnwnnnnw'; $barChar['2'] = 'nnwwnnnnw'; $barChar['3'] = 'wnwwnnnnn'; $barChar['4'] = 'nnnwwnnnw'; $barChar['5'] = 'wnnwwnnnn'; $barChar['6'] = 'nnwwwnnnn';
				$barChar['7'] = 'nnnwnnwnw'; $barChar['8'] = 'wnnwnnwnn'; $barChar['9'] = 'nnwwnnwnn'; $barChar['A'] = 'wnnnnwnnw'; $barChar['B'] = 'nnwnnwnnw'; $barChar['C'] = 'wnwnnwnnn'; $barChar['D'] = 'nnnnwwnnw';
				$barChar['E'] = 'wnnnwwnnn'; $barChar['F'] = 'nnwnwwnnn'; $barChar['G'] = 'nnnnnwwnw'; $barChar['H'] = 'wnnnnwwnn'; $barChar['I'] = 'nnwnnwwnn'; $barChar['J'] = 'nnnnwwwnn'; $barChar['K'] = 'wnnnnnnww';
				$barChar['L'] = 'nnwnnnnww'; $barChar['M'] = 'wnwnnnnwn'; $barChar['N'] = 'nnnnwnnww'; $barChar['O'] = 'wnnnwnnwn'; $barChar['P'] = 'nnwnwnnwn'; $barChar['Q'] = 'nnnnnnwww'; $barChar['R'] = 'wnnnnnwwn';
				$barChar['S'] = 'nnwnnnwwn'; $barChar['T'] = 'nnnnwnwwn'; $barChar['U'] = 'wwnnnnnnw'; $barChar['V'] = 'nwwnnnnnw'; $barChar['W'] = 'wwwnnnnnn'; $barChar['X'] = 'nwnnwnnnw'; $barChar['Y'] = 'wwnnwnnnn';
				$barChar['Z'] = 'nwwnwnnnn'; $barChar['-'] = 'nwnnnnwnw'; $barChar['.'] = 'wwnnnnwnn'; $barChar[' '] = 'nwwnnnwnn'; $barChar['*'] = 'nwnnwnwnn'; $barChar['$'] = 'nwnwnwnnn'; $barChar['/'] = 'nwnwnnnwn';
				$barChar['+'] = 'nwnnnwnwn'; $barChar['%'] = 'nnnwnwnwn';

				$this->SetFont('Arial', '', 10);
				$this->Text($xpos, $ypos + $height + 4, $code);
				$this->SetFillColor(0);

				$code = '*'.strtoupper($code).'*';
				for($i=0; $i<strlen($code); $i++){
					$char = $code{$i};
					if(!isset($barChar[$char])){
						$this->Error('Invalid character in barcode: '.$char);
					}
					$seq = $barChar[$char];
					for($bar=0; $bar<9; $bar++){
						if($seq{$bar} == 'n'){
							$lineWidth = $narrow;
						}else{
							$lineWidth = $wide;
						}
						if($bar % 2 == 0){
							$this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
						}
						$xpos += $lineWidth;
					}
					$xpos += $gap;
				}
			}	
		}
		$id = $user->sadn_id;
		//echo "Medisch attest voor ".$id;
		// $sql = "SELECT naam, voornaam, straatennummer, postcode, woonplaats, geboortedatum FROM mv".$werkjaar."_deelnemers WHERE sadn_id=".$id;
		// $result = mysql_query($sql);
		// $r=mysql_fetch_array($result);
		$werkjaar = 2016;
		$naam = $user['naam'];
		$voornaam = $user['voornaam'];
		$adres = $user['straatennummer']." - ".$user['postcode']." ".$user['woonplaats'];
		$gebdatum = date('d/m/Y',strtotime($user['geboortedatum']));
		$pdf = new PDF_Code39();
		$pdf->AddPage();
		$pdf->SetFont('Helvetica','',16);
		$pdf->SetXY(30,50);
		$pdf->Cell(60,10,'Naam deelnemer:',0,0);
		$pdf->Cell(60,10,$naam,0,1);
		$pdf->SetX(30);
		$pdf->Cell(60,10,'Vooraam:',0,0);
		$pdf->Cell(30,10,$voornaam,0,1);
		$pdf->SetX(30);
		$pdf->Cell(60,10,'Adres:',0,0);
		$pdf->Cell(60,10,$adres,0,1);
		$pdf->SetX(30);
		$pdf->Cell(60,10,'Geboortedatum:',0,0);
		$pdf->Cell(60,10,$gebdatum,0,1);
		$pdf->Code39(150, 30, $id,1,10);
		$pdf->Ln(30);
		$pdf->SetLeftMargin(30);
		$pdf->SetRightMargin(20);
		$pdf->SetFont('Helvetica','',16);
		$pdf->Write(8,'Ondergetekende, .............................................., ');
		$pdf->Ln();
		$pdf->Write(8, 'dokter in de geneeskunde, verklaart hiermee dat bovenvermelde patiënt na sportmedisch onderzoek geen tegenindicaties vertoont om deel te nemen aan het Sporta wielerevenement "Mon Ventoux" op 18 juni '.$werkjaar.'.');
		$pdf->Ln(20);
		$pdf->Write(8,'Verplicht en volledig ingevuld terug te sturen vóór 15 mei '.$werkjaar.'.');
		$pdf->Ln(20);
		$pdf->Cell(50,10,'Datum:',0,0);
		$pdf->Cell(50,10,'Handtekening:',0,0,'C');
		$pdf->Cell(50,10,'Stempel:',0,0,'R');
		// $pdf->AddPage();
		// $pdf->SetFont('Helvetica','B',14);
		// $pdf->SetXY(30,45);
		// $pdf->Write(5,'Info Sportmedisch onderzoek');
		// $pdf->Ln(7);
		// $pdf->SetFont('Helvetica','BU',12);
		// $pdf->Write(5,'1. Mannen >35 jaar en vrouwen >45 jaar');
		// $pdf->SetFont('Helvetica','',12);
		// $pdf->Ln();
		// $pdf->Write(5,'Sportmedische screening houdt minimaal in:');
		// $pdf->Ln();
		// $pdf->Write(5,'- een vragenlijst (naar de persoonlijke en familiale voorgeschiedenis)');
		// $pdf->Ln();
		// $pdf->Write(5,'- een lichamelijk onderzoek');
		// $pdf->Ln();
		// $pdf->Write(5,'- een rustelektrocardiogram');
		// $pdf->Ln();
		// $pdf->Write(5,'- het bepalen van het SCORE-risico (een Europees erkende inschatting van het risico op aderverkalking op basis van leeftijd, geslacht, bloeddruk, cholesterol en rookgedrag).');
		// $pdf->Ln(7);
		// $pdf->Write(5,'Deze screening gebeurt bij voorkeur door een erkend keuringsarts.');
		// $pdf->Ln(7);
		// $pdf->Write(5,'Bij een SCORE-risico van 5% of hoger, is een inspanningselektrocardiogram aangeraden. Het inspanningselektrocardiogram wordt afgenomen tijdens een inspanningstest op een fietsergometer . Dit onderzoek kan uitgevoerd worden bij een erkend keuringsarts. Indien nodig verwijst de keuringsarts u door naar de hartspecialist of cardioloog. Deze test dient enkel om de sportmedische geschiktheid te beoordelen. Voor het bepalen van de trainingshartfrequenties en trainingsadvies wordt een andere test gebruikt, met afname van melkzuur tijdens de test.');
		// $pdf->Ln(7);
		// $pdf->Write(5,'Sportmedische herkeuring is jaarlijks (intensieve sportbeoefening) en minstens om de vijf jaar of eerder volgens het advies van de keuringsarts of bij (nieuwe) klachten (recreatieve sportbeoefening) aangeraden.');
		// $pdf->Ln(7);
		// $pdf->Write(5,'Naast onderliggende hartaandoeningen bestaan er nog andere risicofactoren voor sportbeoefening, die meestal eigen zijn aan een bepaalde sport. Vraag dit na aan je (sport)arts.');
		// $pdf->Ln(7);
		// $pdf->SetFont('Helvetica','BU',12);
		// $pdf->Write(5,'2. Mannen tussen 18-34 jaar en vrouwen tussen 18-44 jaar');
		// $pdf->SetFont('Helvetica','',12);
		// $pdf->Ln(7);
		// $pdf->Write(5,'Aan te raden sportmedische screening vanaf 18 jaar:');
		// $pdf->Ln();
		// $pdf->Write(5,'- een vragenlijst (naar de persoonlijke en familiale voorgeschiedenis)');
		// $pdf->Ln();
		// $pdf->Write(5,'- een lichamelijk onderzoek');
		// $pdf->Ln();
		// $pdf->Write(5,'- een rustelektrocardiogram');
		// $pdf->Ln(7);
		// $pdf->Write(5,'Deze screening gebeurt bij voorkeur door een erkend keuringsarts.');
		// $pdf->Ln(7);
		// $pdf->Write(5,'Sportmedische herkeuring om de twee jaar (bij intensieve sportbeoefening en competitiesport) is aangeraden en volgens het advies van de keuringsarts of bij (nieuwe) klachten bij recreatieve sportbeoefening. Deze sportmedische herkeuring bestaat minimaal uit een vragenlijst (naar de persoonlijke en familiale voorgeschiedenis), een lichamelijk onderzoek en elk extra onderzoek dat de keuringsarts noodzakelijk vindt.');
		// $pdf->Ln(7);
		// $pdf->Write(5,'Naast onderliggende hartaandoeningen bestaan er nog andere risicofactoren voor sportbeoefening, die meestal eigen zijn aan een bepaalde sport. Vraag dit na aan je (sport)arts.');
		
		$pdf->Output();
		exit();
	// }else{
	// 	echo "Geen Medisch attest vereist voor deze deelnemer";
	// }
// }
?>