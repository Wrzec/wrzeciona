<?php
//Tu już nie ładujemy konfiguracji - sam widok nie będzie już punktem wejścia do aplikacji.
//Wszystkie żądania idą do kontrolera, a kontroler wywołuje skrypt widoku.
?>
<!DOCTYPE HTML>
<html lang="pl-PL">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kalkulator</title>
</head>
<body>

<div>
	<a href="<?php print(_APP_ROOT); ?>/app/inna_chroniona.php">kolejna chroniona strona</a>
	<a href="<?php print(_APP_ROOT); ?>/app/security/logout.php">Wyloguj</a>
</div>

<div>

<form action="<?php print(_APP_URL); ?>/app/calc.php" method="POST">
    <label for="id_kurs">Kurs:</label>
    <input id="id_kurs" type="number" step="0.01" min="0" name="x" value="<?php isset($x) ? print($x) : print("") ?>" />

    <br />

    <label for="id_kwota">Kwota:</label>
    <input id="id_kwota" type="number" min="0" name="y" value="<?php isset($y) ? print($y) : print("") ?>" />

    <br />

    <label for="id_przewal1">Przewalutowanie:</label>
    <br />
    <input id="id_przewal1" type="radio" name="operation" value="1" <?php
      if ((isset($operation) && $operation == 1) || !isset($operation)) {
        print("checked");
      }
    ?> />
    <label for="id_przewal1">PLN => EUR</label>
    <br />
    <input id="id_przewal2" type="radio" name="operation" value="2" <?php
      if (isset($operation) && $operation == 2) {
        print("checked");
      }
    ?> />
    <label for="id_przewal2">EUR => PLN</label>

    <br />

    <input type="submit" value="Oblicz" />
  </form>

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		print("<ol style='margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;'>");
		foreach ( $messages as $key => $msg ) {
			print('<li>'.$msg.'</li>');
		}
		print("</ol>");
	}
}
if (isset($result)) {
	$waluta = "";
	if ($operation == 1) {
	  $waluta = "EUR";
	} else if ($operation == 2) {
	  $waluta = "PLN";
	}

	print("<div style='margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;'>Wynik: ".$result." ".$waluta."</div>");
  }

  ?>



</body>
</html>