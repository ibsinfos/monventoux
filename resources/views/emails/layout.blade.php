<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<style>
body, p, a {
	font-family : "Helvetica Neue", Helvetica, Arial, sans-serif;
}

body, p {
	font-size   : 14px;
	line-height : 1.5;
	color       : #051539;
}

p {
	text-align : left;
}

a {
	color           : #F63E3D;
	text-decoration : underline;
	font-family     : Helvetica, Arial, sans-serif;
}

img {
	border : 0;
	width  : 100%;
	height : auto;
}

table {
	text-align : center;
	width: 480;
}

table.bordered {
    border-collapse: collapse;
}

table.bordered, table.bordered th, table.bordered td {
    border: 1px solid black;
}

</style>
	<center>
		<table border="0" cellpadding="15" width="480" style="text-align: left;">
			<thead>
				<tr>
					<th><img alt="Mon Ventoux" src="{{asset('/assets/img/email/header.jpg')}}" width="100%"
						style="border: 0;width: 100%;height: auto;"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						@yield('content')
		            </td>
		        </tr>
	        </tbody>
			<tfoot>
				<tr>
					<th><img alt="Mon Ventoux" src="{{asset('/assets/img/email/footer.jpg')}}" width="100%"
						style="border: 0;width: 100%;height: auto;"></th>
				</tr>
			</tfoot>	        
	    </table>
	</center>
</body>

</html>