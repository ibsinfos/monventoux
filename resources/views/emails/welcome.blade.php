@extends('emails/layout')

@section('content')

Beste {{ $user['voornaam'] }},<br><br>

@if( isset($bulk) && $bulk === true )
	<p>
		We hebben uw inschrijving voor Mon Ventoux ontvangen via het bedrijf/de groep "{{ $user['bedrijf'] }}".
	</p>
@endif

<p>Fijn dat je gekozen hebt voor Mon Ventoux. Samen maken we van jouw uitdaging op 18 juni 2016 een sportief en extrasportief hoogtepunt. Deze mail is de bevestiging van jouw inschrijving.</p>

<h2>JOUW PROFIEL</h2>
Gebruikersnaam: {{ $user['username'] }} <br>
@if($receiver == 'user')
	Wachtoord: {{ $passwordUnhashed }}<br>
@endif
Uitdaging: {{ $user['formule'] }}<br><br>

@if(!isset($bulk) || $bulk === false)
	<table class="bordered" cellpadding="10">
		<tr>
			<td align="right">Deelname als {{ $user['formule'] }} :</td>
			<td align="left">{{ '€ ' . number_format($priceFormule,'2',',','') }}</td>
		</tr>
		@if( isset($user['cmlid']) && $user['cmlid'] == 'ja' )
			<tr>
				<td align="right">Korting CM-lid</td>
				<td align="left">{{ '€ - ' . number_format($discountCM,'2',',','') }}</td>
			</tr>		
		@endif
		@if( isset($user['annulatieverzekering_deelname']) && $user['annulatieverzekering_deelname'] > 0 )
			<tr>
				<td align="right">Annulatieverzekering</td>
				<td align="left">{{ '€ ' . number_format($user['annulatieverzekering_deelname'],'2',',','') }}</td>
			</tr>
		@endif
			<tr>
				<th align="right">Totaal:</th>
				<th align="left">{{ '€ ' . number_format($totalPrice,'2',',','') }}</th>
			</tr>
	</table>
@endif

<p>
	Tip: bewaar jouw login-gegevens.<br>
	Mocht je op een later tijdstip jouw gegevens willen wijzigen dan kan dit via jouw profiel.
</p>
<table border="0" cellpadding="0" cellspacing="0" width="auto" style="background-color:#505050; border:1px solid #353535; border-radius:5px;">
    <tr>
        <td align="center" valign="middle" style="color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; letter-spacing:-.5px; line-height:150%; padding-top:15px; padding-right:30px; padding-bottom:15px; padding-left:30px;">
            <a href="{{ url('gebruiker') }}" target="_blank" style="color:#FFFFFF; text-decoration:none;">Naar jouw profiel</a>
        </td>
    </tr>
</table>

@if(!isset($bulk) || $bulk === false)
	<h2>BETALING</h2>

	<p>Binnen enkele dagen vind je de factuur terug in jouw mailbox. Na betaling bezorgt de postbode jouw lidkaart waarna het dromen echt kan beginnen. </p>

@endif

	<h2>VERBLIJF/VERVOER</h2> 

	<p>
		Mon Ventoux biedt niet langer de service georganiseerd verblijf en/of vervoer aan. Een selectie hotels en b&b’s vind je op onze <a href="{{ url('p/verblijf') }}" target="_blank">website</a>.
	</p>

	<h2>MEDISCH ATTEST</h2> 

	<p>
		Mon Ventoux propageert medisch verantwoord sporten. Zonder medisch geschiktheidsattest, geen deelname. Lees op onze <a href="{{ url('p/medisch') }}" target="_blank">site</a> wat je moet doen. 
	</p>

	<h2>VRIENDEN & FAMILIE</h2>

	<p>
		Hoe meer zielen hoe meer vreugd. Alleen werkt Mon Ventoux niet meer met dossiers voor één of meerdere personen maar met unieke profielen die door elke deelnemer zelf beheerd worden.
	</p>

<h2>VRAGEN?</h2> 

<p>
	Wij zijn er om jou te helpen. <br>
	E info@monventoux.be  <br>
	T 014 53 95 75
</p>

@stop

