<?php namespace App\Http\Controllers;

use Illuminate\Html\HtmlBuilder;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Timing;
use App\Models\TimingCannibale;
use App\Models\TimingVentourist;
use App\Models\User;
use App;
use PDF;
use Illuminate\Support\Facades\Auth;
use View;
use Input;
use Illuminate\Database\Query\Builder;

use Request;

class TimingController extends Controller {
	use ControllerUtils;

	function timeDiff($firstTime,$lastTime){
		$firstTime=strtotime($firstTime);
		$lastTime=strtotime($lastTime);
		$timeDiff=$lastTime-$firstTime;
		return $timeDiff;
	}

	function secondsToTime($seconds){
		$hours = floor($seconds / (60 * 60));
		$hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
		$divisor_for_minutes = $seconds % (60 * 60);
		$minutes = floor($divisor_for_minutes / 60);
		$minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
		$divisor_for_seconds = $divisor_for_minutes % 60;
		$seconds = ceil($divisor_for_seconds);
		$seconds = str_pad($seconds, 2, "0", STR_PAD_LEFT);
		return $hours.":".$minutes.":".$seconds;
	}

	function calculateCanibale($timingstamps){
		//calculate total time
		$timeneutraltime = 0;
		$cycletime = 0;
		if ($timingstamps['malaucene'] != "00:00:00" && $timingstamps['top2'] != "00:00:00"){
			$cycletime = $this->timeDiff($timingstamps['malaucene'], $timingstamps['top2']);
			if ($timingstamps['top1'] != "00:00:00" && $timingstamps['sault1'] != "00:00:00"){
				$timeneutraltime = $this->timeDiff($timingstamps['top1'], $timingstamps['sault1']);
			}
			if ($timeneutraltime != 0){
				$cycletime = $this->secondsToTime($cycletime-$timeneutraltime);
			}else{
				$cycletime = $this->secondsToTime($cycletime);
			}
		}else{
			if($timingstamps['top2'] == "00:00:00"){
				// DEZE AANPASSING WEGENS AFSLUITEN TOP NA 17:00u
				if($timingstamps['reynard']>"17:00:00"){
					//echo '<br>if('.$timingstamps['reynard'].'>"17:00:00"){';
					//exit();
					$timingstamps['top2'] = "AFGESLOTEN (omwille van hevige rukwinden)";
					$cycletime = $this->timeDiff($timingstamps['malaucene'], $timingstamps['reynard']);
					if ($timingstamps['top1'] != "00:00:00" && $timingstamps['sault1'] != "00:00:00"){
						$timeneutraltime = $this->timeDiff($timingstamps['top1'], $timingstamps['sault1']);
					}
					if ($timeneutraltime != 0){
						$cycletime = $this->secondsToTime($cycletime-$timeneutraltime);
					}else{
						$cycletime = $this->secondsToTime($cycletime);
					}
				}else{
					$timingstamps['top2'] = "<i>geen registratie</i>";
					$cycletime = "Rit onvolledig";
				}
			}
		}
		return(array('timingstamps'=>$timingstamps, 'cycletime'=>$cycletime));
	}

	function calculateVentourist($timings)
	{
		$checkpoints = array(1 => "Malaucene", 2 => "Bedoin", 3 => "Sault", 4 => "Chalet Reynard", 5 => "Chalet Liotard", 6 => "Top Ventoux");

		//dd($timings);
		$timingslist = array();
		foreach($timings as $timing){
			//echo '<br>';
			//print_r($timing);
			$timingstamps = array();
			if ($timing['start'] == 0) {
				$timingstamps['starttime'] = '00:00:00';
			} else {
				$timingstamps['starttime'] = Timing::where('tijden_id', '=', $timing['start'])->first()->tijden_tijd;
				$startplace = Timing::where('tijden_id', '=', $timing['start'])->first()->tijden_checkpoint;
				$timingstamps['startplace'] = $checkpoints[$startplace];
			}
			//echo '<br>starttime: '.$timingstamps['starttime'];
			//echo '<br>startplaceid: '.$startplace;
			//echo '<br>startplace: '.$timingstamps['startplace'];
			if ($timing['tussentijd'] == 0) {
				$timingstamps['checkpointtime'] = "00:00:00";
				$timingstamps['checkpointplace'] = '';
			} else {
				$timingstamps['checkpointtime'] = Timing::where('tijden_id', '=', $timing['tussentijd'])->first()->tijden_tijd;
				$checkpoint = Timing::where('tijden_id', '=', $timing['tussentijd'])->first()->tijden_checkpoint;
				$timingstamps['checkpointplace'] = $checkpoints[$checkpoint];
			}
			//echo '<br>checkpointtime: '.$timingstamps['checkpointtime'];
			//echo '<br>checkpointplaceid: '.$checkpoint;
			//echo '<br>checkpointplace: '.$timingstamps['checkpointplace'];
			if ($timing['aankomst'] == 0) {
				$timingstamps['endtime'] = '00:00:00';
				$timingstamps['checkpointplace'] = '';

			} else {
				$timingstamps['endtime'] = Timing::where('tijden_id', '=', $timing['aankomst'])->first()->tijden_tijd;
				$endplace = Timing::where('tijden_id', '=', $timing['aankomst'])->first()->tijden_checkpoint;
				$timingstamps['endplace'] = $checkpoints[$endplace];
			}
			//echo '<br>endtime: '.$timingstamps['endtime'];
			//echo '<br>endplaceid: '.$endplace;
			//echo '<br>endplace: '.$timingstamps['endplace'];
			//echo '<br>$timingstamps[cycletime] = timeDiff('.$timingstamps['starttime'].', '.$timingstamps['endtime'].')';
			//echo '<br>cycletime: '.$timingstamps['cycletime'];

			if ($timing['start'] != 0 && $timing['aankomst'] != 0) {
				$timingstamps['cycletime'] = $this->secondsToTime($this->timeDiff($timingstamps['starttime'], $timingstamps['endtime']));
			}else{
				$timingstamps['cycletime'] = "Onvolledig";
			}

			$timingslist[] = $timingstamps;
		}

		//dd($timingslist);

		return $timingslist;
	}

	public function init()
	{
		global $timingtype;
		global $timingstamps;
		global $timings;

		//check for Cannibale(tte) timings
		$timings = Auth::user()->timingCannibale()->first();
		if(count($timings) == 0){
			//check for Ventourist timings
			$timings = Auth::user()->timingVentourist()->get()->toArray();
			if(count($timings) == 0) {
				$timingtype = 'none';
			}else{
				$timingtype = 'ventourist';
			}
		}else{
			if($timings->perty == 0){
				$timingtype = 'cannibalette';
			}else {
				$timingtype = 'cannibale';
			}
			//in even years Cannibale(tte) goes clockwise
			$checkpoints = array('malaucene', 'liotard', 'top1', 'sault1', 'perty', 'sederon', 'sault2', 'reynard', 'top2');
			//in odd years Cannibale(tte) goes counterclockwise
			//$checkpoints = array('bedoin', 'reynard1', 'top1', 'sault1', 'perty', 'aulan', 'sault2', 'reynard2', 'top2');

			foreach($checkpoints as $checkpoint){
				if($timings->$checkpoint == 0) {//checkpoint not checked (no timing for checkpoint)
					if(! ($timingtype == 'cannibalette' && $checkpoint == 'perty')) {
						//add only timestamp checkpoint perty for cannibale
						$timingstamps[$checkpoint] = '00:00:00';
					}
				}else {
					$timingstamps[$checkpoint] = Timing::where('tijden_id', '=', $timings->$checkpoint)->first()->tijden_tijd;
				}
			}

		}
	}

	/**
	 * Display a listing of the checkpoins with their time registrations.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['bodyclass'] = 'auth';
		$data['navigation'] = $this->_getMenuItems();
		$data['footernavigation'] = $this->_getFooterMenuItems();
		$data['event'] = $this->_getEventData();

		global $timingtype;
		global $timingstamps;
		global $timings;

		$this->init();

		$data['timingtype'] = $timingtype;
		$data['timings'] = $timingstamps;

		if($data['timingtype'] == 'cannibale' || $data['timingtype'] == 'cannibalette'){
			$timinglist = $this->calculateCanibale($timingstamps);
			$data['timings'] = $timinglist['timingstamps'];
			$data['cycletime'] = $timinglist['cycletime'];
		}elseif ($data['timingtype'] == 'ventourist'){
			$timinglist = $this->calculateVentourist($timings);
			$data['timings'] = $timinglist;
			$data['cycletime'] = '';
		}else{
			$data['timings'] = array();
			$data['cycletime'] = '';
		}

		return view('page.user.timing',$data);


	}

	public function makePDF()
	{
		global $timingtype;
		global $timingstamps;
		global $timings;

		$this->init();

		$textCycletime = '';

		switch($timingtype) {
			case 'ventourist':
				$background = asset('/assets/img/visuals/visual-ventourist.png');
				$fontcolor = '#921A7E';
				$timinglist = $this->calculateVentourist($timings);
				//dd($timinglist);
				$divStyles = array();
				$divData = array();
				$counter = 1;
				$malauceneTop = 535;
				$bedoinTop = 680;
				$saultTop = 550;
				$liotardTop = 360;
				$reynardTop = 375;
				$topTop = 283;
				$fullClimbs = 0;

				//count number of full climbs to position first top time
				foreach ($timinglist as $climb => $climbdata) {
					if ($climbdata['starttime'] <> '00:00:00' && $climbdata['endtime'] <> '00:00:00') {
						++$fullClimbs;
					}
				}
				$topTop = $topTop - $fullClimbs * 20;

				//generate data to display
				foreach ($timinglist as $climb => $climbdata) {
					if ($climbdata['starttime'] <> '00:00:00' && $climbdata['endtime'] <> '00:00:00'){
						//add the startplace div
						switch (strtolower($climbdata['startplace'])) {
							case 'malaucene':
								$divStyles[] = '
									div.malaucene' . $counter . '{
										position: absolute;
										top: ' . $malauceneTop . 'px;
										left: 130px;
										font-family: lato;
										font-size: 12pt;
										color: #921A7E;
									}
								';
								$malauceneTop += 20;
								$divData[] = '
									<div class="malaucene' . $counter . '">' . $climbdata['starttime'] . ' (' .$counter. '<sup>e</sup> klim)</div>';
								break;
							case 'bedoin':
								$divStyles[] = '
									div.bedoin' . $counter . '{
										position: absolute;
										top: ' . $bedoinTop . 'px;
										left: 530px;
										font-family: lato;
										font-size: 12pt;
										color: #921A7E;
									}
								';
								$bedoinTop += 20;
								$divData[] = '
									<div class="bedoin' . $counter . '">' . $climbdata['starttime'] . ' (' .$counter. '<sup>e</sup> klim)</div>';
								break;
							case 'sault':
								$divStyles[] = '
									div.sault' . $counter . '{
										position: absolute;
										top: ' . $saultTop . 'px;
										left: 935px;
										font-family: lato;
										font-size: 12pt;
										color: #921A7E;
									}
								';
								$saultTop += 20;
								$divData[] = '
									<div class="sault' . $counter . '">' . $climbdata['starttime'] . ' (' .$counter. '<sup>e</sup> klim)</div>';
								break;
						}

						//add the checkpoint div
						if ($climbdata['checkpointtime'] <> '00:00:00') {
							switch (strtolower($climbdata['checkpointplace'])) {
								case 'chalet liotard':
									$divStyles[] = '
										div.liotard' . $counter . '{
											position: absolute;
											top: ' . $liotardTop . 'px;
											left: 270px;
											font-family: lato;
											font-size: 10pt;
											color: #921A7E;
										}
									';
									$liotardTop += 20;
									$divData[] = '
										<div class="liotard' . $counter . '">' . $climbdata['checkpointtime'] . ' (' . $counter . '<sup>e</sup> klim)</div>';
									break;
								case 'chalet reynard':
									$divStyles[] = '
										div.reynard' . $counter . '{
											position: absolute;
											top: ' . $reynardTop . 'px;
											left: 810px;
											font-family: lato;
											font-size: 10pt;
											color: #921A7E;
										}
									';
									$reynardTop += 20;
									$divData[] = '
										<div class="reynard' . $counter . '">' . $climbdata['checkpointtime'] . ' (' . $counter . '<sup>e</sup> klim)</div>';
									break;
							}
						}

						//add the checkpoint div
						$divStyles[] = '
							div.top' . $counter . '{
								position: absolute;
								top: ' . $topTop . 'px;
								left: 660px;
								font-family: lato;
								font-size: 12pt;
								color: #921A7E;
							}
						';
						$topTop += 20;
						$divData[] = '
							<div class="top' . $counter . '">' . $climbdata['endtime'] . ' (' . $counter . '<sup>e</sup> klim, totale klimtijd ' . $climbdata['cycletime'] . ')</div>';
					}
					++$counter;
				}
				$html='
					<html>
						<head>
							<style>
								@import url(https://fonts.googleapis.com/css?family=Lato|Flamenco);
								@font-face {
								  font-family: \'lato\';
								  font-style: normal;
								  font-weight: 400;
								}
								@font-face {
								  font-family: \'flamenco\';
								  font-style: normal;
								  font-weight: 400;
								}
								html{
									margin: 0px;
								}
								div.name{
									position: absolute;
									top: 50px;
									left: 100px;
									font-family: flamenco;
									font-size: 24pt;
									color: #53A1C9;
								}';
				//add the div styles
				foreach ($divStyles as $style) {
					$html .= $style;
				}

				$html .= '
							</style>
						</head>
						<body style="background: url('.$background.') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
						<div class="name">' . Auth::user()->voornaam . ' ' . Auth::user()->naam.'</div>';

				//add the div data
				foreach ($divData as $data) {
					$html .= $data;
				}

				$html .= '
						</body>
					</html>
				';
				//echo $html;
				//exit();
				break;
			case 'cannibalette':
				$timinglist = $this->calculateCanibale($timingstamps);
				$cycletime = $timinglist['cycletime'];

				$background = asset('/assets/img/visuals/visual-cannibalette-top-closed-at-start.png');
				$fontcolor = '#CB9540';
				$timingstamps['malaucene'] == '00:00:00' ? $textMalaucene = '' : $textMalaucene = $timingstamps['malaucene'] . ' START';
				$timingstamps['liotard'] == '00:00:00' ? $textLiotard = '' : $textLiotard = $timingstamps['liotard'];
				$timingstamps['top1'] == '00:00:00' ? $textTop1 = '' : $textTop1 = '(Doortocht) ' . $timingstamps['top1'];
				$timingstamps['sault1'] == '00:00:00' ? $textSault1 = '' : $textSault1 = $timingstamps['sault1'] . ' (Eerste doortocht) ';
				$timingstamps['sederon'] == '00:00:00' ? $textSederon = '' : $textSederon = $timingstamps['sederon'];
				$timingstamps['sault2'] == '00:00:00' ? $textSault2 = '' : $textSault2 = $timingstamps['sault2'] . ' (Tweede doortocht) ';
				if ($timingstamps['top2'] == '00:00:00') {//no finish time
					if ($timingstamps['reynard'] == '00:00:00') {//no CP time
						$textTop2 = '';
						$textReynard = '';
					} else {//CP time
						if ($timingstamps['reynard'] > '14:10:00') {//top closed after 14h, CP is temp Finish
							$textTop2 = 'Top afgesloten';
							$textReynard = $timingstamps['reynard'] . ' FINISH';
							$textCycletime = 'Totale rittijd: ' . $cycletime . '<br>(top afgesloten)';
						} else {
							$textTop2 = '';
							$textReynard = $timingstamps['reynard'] . ' FINISH';
						}
					}
				} else {//finish time
					$textTop2 = $timingstamps['top2'] . ' FINISH';
					$timingstamps['reynard'] == '00:00:00' ? $textReynard = '' : $textReynard = $timingstamps['reynard'];
					$textCycletime = 'Totale rittijd: ' . $cycletime;
				}
				$html='
					<html>
						<head>
							<style>
								@import url(https://fonts.googleapis.com/css?family=Lato|Flamenco);
								@font-face {
								  font-family: \'lato\';
								  font-style: normal;
								  font-weight: 400;
								}
								@font-face {
								  font-family: \'flamenco\';
								  font-style: normal;
								  font-weight: 400;
								}
								html{
									margin: 0px;
								}
								div.name{
									position: absolute;
									top: 70px;
									left: 100px;
									font-family: flamenco;
									font-size: 24pt;
									color: #53A1C9;
								}
								div.cycletime{
									position: absolute;
									top: 90px;
									left: 815px;
									font-family: lato;
									font-size: 16pt;
									color: #53A1C9;
								}
								div.malaucene{
									position: absolute;
									top: 510px;
									left: 50px;
									font-family: lato;
									color: '.$fontcolor.';
								}
								div.liotard{
									position: absolute;
									top: 360px;
									left: 280px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.top1{
									position: absolute;
									top: 310px;
									left: 295px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.top2{
									position: absolute;
									top: 310px;
									left: 500px;
									font-family: lato;
									font-size: 12pt;
									color: '.$fontcolor.';
								}
								div.reynard{
									position: absolute;
									top: 390px;
									left: 610px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.sault1{
									position: absolute;
									top: 535px;
									left: 765px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.sault2{
									position: absolute;
									top: 555px;
									left: 765px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.perty{
									position: absolute;
									top: 160px;
									left: 875px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.sederon{
									position: absolute;
									top: 342px;
									left: 920px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
							</style>
						</head>
						<body style="background: url('.$background.') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
						<div class="name">' . Auth::user()->voornaam . ' ' . Auth::user()->naam.'</div>
						<div class="cycletime">' . $textCycletime . '</div>
						<div class="malaucene">' . $textMalaucene . '</div>
						<div class="liotard">' . $textLiotard . '</div>
						<div class="top1">' . $textTop1 . '</div>
						<div class="sault1">' . $textSault1 . '</div>
						<div class="sederon">' . $textSederon . '</div>
						<div class="sault2">' . $textSault2 . '</div>
						<div class="reynard">' . $textReynard . '</div>
						<div class="top2">' . $textTop2 . '</div>
						</body>
					</html>
				';
				break;
			case 'cannibale':
				$timinglist = $this->calculateCanibale($timingstamps);
				$cycletime = $timinglist['cycletime'];

				$background = asset('/assets/img/visuals/visual-cannibale-top-closed-at-start.png');
				$fontcolor = 'red';
				$timingstamps['malaucene'] == '00:00:00' ? $textMalaucene = '' : $textMalaucene = $timingstamps['malaucene'] . ' START';
				$timingstamps['liotard'] == '00:00:00' ? $textLiotard = '' : $textLiotard = $timingstamps['liotard'];
				$timingstamps['top1'] == '00:00:00' ? $textTop1 = '' : $textTop1 = '(Doortocht) ' . $timingstamps['top1'];
				$timingstamps['sault1'] == '00:00:00' ? $textSault1 = '' : $textSault1 = $timingstamps['sault1'] . ' (Eerste doortocht) ';
				$timingstamps['perty'] == '00:00:00' ? $textPerty = '' : $textPerty = $timingstamps['perty'];
				$timingstamps['sederon'] == '00:00:00' ? $textSederon = '' : $textSederon = $timingstamps['sederon'];
				$timingstamps['sault2'] == '00:00:00' ? $textSault2 = '' : $textSault2 = $timingstamps['sault2'] . ' (Tweede doortocht) ';
				if ($timingstamps['top2'] == '00:00:00') {//no finish time
					if ($timingstamps['reynard'] == '00:00:00') {//no CP time
						$textTop2 = '';
						$textReynard = '';
					} else {//CP time
						if ($timingstamps['reynard'] > '14:10:00') {//top closed after 14h, CP is temp Finish
							$textTop2 = 'Top afgesloten';
							$textReynard = $timingstamps['reynard'] . ' FINISH';
							$textCycletime = 'Totale rittijd: ' . $cycletime . '<br>(top afgesloten)';
						} else {
							$textTop2 = '';
							$textReynard = $timingstamps['reynard'] . ' FINISH';
						}
					}
				} else {//finish time
					$textCycletime = 'Totale rittijd: ' . $cycletime;
					$textTop2 = $timingstamps['top2'] . ' FINISH';
					$timingstamps['reynard'] == '00:00:00' ? $textReynard = '' : $textReynard = $timingstamps['reynard'];
				}


				$html='
					<html>
						<head>
							<style>
								@import url(https://fonts.googleapis.com/css?family=Lato|Flamenco);
								@font-face {
								  font-family: \'lato\';
								  font-style: normal;
								  font-weight: 400;
								}
								@font-face {
								  font-family: \'flamenco\';
								  font-style: normal;
								  font-weight: 400;
								}
								html{
									margin: 0px;
								}
								div.name{
									position: absolute;
									top: 70px;
									left: 100px;
									font-family: flamenco;
									font-size: 24pt;
									color: #53A1C9;
								}
								div.cycletime{
									position: absolute;
									top: 90px;
									left: 815px;
									font-family: lato;
									font-size: 16pt;
									color: #53A1C9;
								}
								div.malaucene{
									position: absolute;
									top: 510px;
									left: 50px;
									font-family: lato;
									color: '.$fontcolor.';
								}
								div.liotard{
									position: absolute;
									top: 360px;
									left: 280px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.top1{
									position: absolute;
									top: 310px;
									left: 295px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.top2{
									position: absolute;
									top: 310px;
									left: 500px;
									font-family: lato;
									font-size: 12pt;
									color: '.$fontcolor.';
								}
								div.reynard{
									position: absolute;
									top: 390px;
									left: 610px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.sault1{
									position: absolute;
									top: 535px;
									left: 765px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.sault2{
									position: absolute;
									top: 555px;
									left: 765px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.perty{
									position: absolute;
									top: 160px;
									left: 875px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
								div.sederon{
									position: absolute;
									top: 342px;
									left: 920px;
									font-family: lato;
									font-size: 10pt;
									color: '.$fontcolor.';
								}
							</style>
						</head>
						<body style="background: url('.$background.') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
						<div class="name">' . Auth::user()->voornaam . ' ' . Auth::user()->naam.'</div>
						<div class="cycletime">' . $textCycletime. '</div>
						<div class="malaucene">' . $textMalaucene. '</div>
						<div class="liotard">' . $textLiotard . '</div>
						<div class="top1">' . $textTop1 . '</div>
						<div class="sault1">' . $textSault1 . '</div>
						<div class="perty">' . $textPerty . '</div>
						<div class="sederon">' . $textSederon . '</div>
						<div class="sault2">' . $textSault2 . '</div>
						<div class="reynard">' . $textReynard . '</div>
						<div class="top2">' . $textTop2 . '</div>
						</body>
					</html>
				';
				break;
			default:
				$background = '';
		}

		$pdf = App::make('dompdf.wrapper');
		$pdf->setPaper('A4', 'landscape');
		$pdf->loadHTML($html);
		return $pdf->stream();
	}

	public function diploma()
	{
		global $timingtype;
		global $timingstamps;
		global $timings;

		$this->init();

		$timingstamps;

		if($timingtype == 'cannibale' || $timingtype == 'cannibalette'){
			$timingtype == 'cannibale' ? $background = asset('/assets/img/diploma/diploma-cannibale-onvolledig.png') : $background = asset('/assets/img/diploma/diploma-cannibalette-onvolledig.png') ;
			$timinglist = $this->calculateCanibale($timingstamps);
			$timings = $timinglist['timingstamps'];
			$cycletime = $timinglist['cycletime'];
			$html='
				<html>
					<head>
						<style>
							@import url(https://fonts.googleapis.com/css?family=Lato|Flamenco);
							@font-face {
							  font-family: \'lato\';
							  font-style: normal;
							  font-weight: 400;
							}
							@font-face {
							  font-family: \'flamenco\';
							  font-style: normal;
							  font-weight: 400;
							}
							html{
								margin: 0px;
							}
							div.center-div{
								position:absolute; /* important. */
								top: 390px;
								left:50%; /*important if you want it absolutely centred in window. */ 
								margin-left:-400px; /* importnant. must be half the width. */
								width:800px; /* set to your requirements, but remember left margin setting. */
								text-align:center; /*not important. */
								font-family: flamenco;
								font-size: 18pt;
								color: #53A1C9;
							}
							table.timingtable{
								border:  1px solid #53A1C9;
								border-collapse: collapse;
							}
							td.name{
								padding-left: 10px;
								padding-right: 10px;
								text-align: center;
							}
							td.checkpoint{
								padding-left: 20px;
								padding-right: 20px;
								font-family: flamenco;
								font-size: 12pt;
								color: #53A1C9;
							}
							td.timing{
								padding-left: 20px;
								padding-right: 20px;
								font-family: lato;
								font-size: 10pt;
								color: #53A1C9;
								text-align: right;
							}
						</style>
					</head>
					<body style="background: url('.$background.') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
						<div class="center-div">
							<table class="timingtable" align="center">
                                <tr>
                                    <td colspan="2" class="name">' . Auth::user()->voornaam . ' ' . Auth::user()->naam . '</td>
                                </tr>
			';
			foreach($timings as $checkpoint => $time) {
				$html .= '
							<tr>
								<td class="checkpoint">' . ucfirst(str_replace(range(0, 9), '', $checkpoint)) . '</td>
								<td class="timing">';
				if ($time == '00:00:00') {
					$html .= '<i>geen registratie</i>';
				} else {
					$html .= $time;
				}
				$html .= '
								</td>
							</tr>
				';
			}
			$html .= '
							<tr>
								<td class="checkpoint" style="border-top: 1px solid;">Totale rittijd</td>
								<td class="timing" style="border-top: 1px solid;">' . $cycletime . '</td>
							</tr>
						</table>
					</div>
				</body>
			</html>
			';
		}elseif ($timingtype == 'ventourist'){
			$timinglist = $this->calculateVentourist($timings);
			$timings = $timinglist;
			$background = asset('/assets/img/diploma/diploma-ventourist-onvolledig.png');
			$html = '
				<html>
					<head>
						<style>
							@import url(https://fonts.googleapis.com/css?family=Lato|Flamenco);
							@font-face {
							  font-family: \'lato\';
							  font-style: normal;
							  font-weight: 400;
							}
							@font-face {
							  font-family: \'flamenco\';
							  font-style: normal;
							  font-weight: 400;
							}
							html{
								margin: 0px;
							}
							div.center-div{
								position:absolute; /* important. */
								top: 390px;
								left:50%; /*important if you want it absolutely centred in window. */ 
								margin-left:-350px; /* importnant. must be half the width. */
								width:700px; /* set to your requirements, but remember left margin setting. */
								text-align:center; /*not important. */
								font-family: flamenco;
								font-size: 18pt;
								color: #53A1C9;
							}
							table.timingtable{
								border:  1px solid #53A1C9;
								border-collapse: collapse;
								width: 700px;
								align: center;
							}
							td.name{
								padding-left: 10px;
								padding-right: 10px;
								text-align: center;
							}
							td.title{
								padding-left: 10px;
								padding-right: 10px;
								font-family: flamenco;
								font-size: 14pt;
								color: #53A1C9;
								text-align: center;
							}
							td.timing{
								padding-left: 20px;
								padding-right: 20px;
								font-family: lato;
								font-size: 10pt;
								color: #53A1C9;
								text-align: right;
							}
							td.timing-center{
								padding-left: 20px;
								padding-right: 20px;
								font-family: lato;
								font-size: 10pt;
								color: #53A1C9;
								text-align: center;
							}
						</style>
					</head>
					<body style="background: url('.$background.') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
						<div class="center-div">
							<table class="timingtable">
								<tr>
									<td colspan="4" class="name">
										' . Auth::user()->voornaam . ' ' . Auth::user()->naam . '<br /><span style="font-size: 12;">';
							if(count($timings)==1) {
								$html .= count($timings) . ' geregistreerde beklimming';
							} else {
								$html .= count($timings) . ' geregistreerde beklimmingen';
							}
							$html .= '
										</span>
									</td>
								</tr>
								<tr>
									<td class="title">Startplaats</td>
									<td class="title">Checkpoint</td>
									<td class="title">Top Mont Ventoux</td>
									<td class="title">Klimtijd</td>
								</tr>
							';
							foreach ($timings as $climbing => $times) {
								$html .= '
								<tr>
									<td class="timing">' . ucfirst($times['startplace']) . ': ';
								if ($times['starttime'] == '00:00:00') {
									$html .= '<i>geen registratie</i>';
								} else {
									$html .= $times['starttime'];
								}
								$html .= '
									</td>
									<td class="timing">' . ucfirst($times['checkpointplace']) . ': ';
								if ($times['checkpointtime'] == '00:00:00') {
									$html .= '<i>geen registratie</i>';
								} else {
									$html .= $times['checkpointtime'];
								}
								$html .= '
									</td>
									<td class="timing-center">
								   ';
								if ($times['endtime'] == '00:00:00') {
									if($times['checkpointtime'] > '10:00:00' && $times['checkpointtime'] < '14:00:00') {
										$html .= '<i>geen registratie</i>';
									} else {
										$html .= '<i>top afgesloten</i>';
									}
								} else {
									$html .= $times['endtime'];
								}
								$html .= '
									</td>
									<td class="timing-center">' . $times['cycletime'] . '</td>
								</tr>
								';
							}
							$html .= '
							</table>
						</div>
					</body>
				</html>
			';
		} else {
			$html = '
			<table class="flamenco color-white">
                                <tr>
                                    <td colspan="4" class="flamenco color-white text-center" style="font-weight: bold;">
				Geen tijden gevonden voor ' . Auth::user()->voornaam . ' ' . Auth::user()->naam . '<br />
                                    </td>
                                </tr>
                            </table>
            ';
		}

		//echo $html;
		//exit();

		$pdf = \App::make('dompdf.wrapper');
		$pdf->setPaper('A4', 'landscape');
		$pdf->loadHTML($html);
		return $pdf->stream();
	}

	public function ranking()
	{
		$data['bodyclass'] = 'auth';
		$data['navigation'] = $this->_getMenuItems();
		$data['footernavigation'] = $this->_getFooterMenuItems();
		$data['event'] = $this->_getEventData();

		$timinglist = App\Models\TimingRanking::where('publiek_tonen', 1)
							->orderBy('naam')
							->get();
		$data['timings'] = $timinglist;

		return view('page.user.timingtable',$data);


	}

}
