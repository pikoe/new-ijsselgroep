<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="/css/pdf.css" rel="stylesheet">
</head>
<body>
    <img src="{{ env('APP_URL', 'http://localhost') }}/img/ijsselgroep-logo.svg" alt="Scouting IJsselgroep Gorssel" style="float:left; width:5cm">
	<div style="float:right;">{{ date('n F Y') }}</div>
	<h1>Overeenkomst</h1>
</body>
</html>
