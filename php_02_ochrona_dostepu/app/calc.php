<?php
require_once dirname(__FILE__).'/../config.php';

// KONTROLER strony kalkulatora

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

//pobranie parametrów
function getParams(&$x,&$y,&$operation){
	$x = isset($_POST['x']) ? $_POST['x'] : null;
	$y = isset($_POST['y']) ? $_POST['y'] : null;
	$operation = isset($_POST['op']) ? $_POST['op'] : null;	
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$x,&$y,&$operation,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($x) && isset($y) && isset($operation))) {
		// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		// teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
		return false;
	}

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $x == "") {
		$messages [] = 'Nie podano liczby kursu';
	}
	if ( $y == "") {
		$messages [] = 'Nie podano liczby kwoty';
	}

	//nie ma sensu walidować dalej gdy brak parametrów
	if (count ( $messages ) != 0) return false;
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $x )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $y )) {
		$messages [] = 'Druga wartość nie jest liczbą całkowitą';
	}	

	if (count ( $messages ) != 0) return false;
	else return true;
}

function process(&$x,&$y,&$operation,&$messages,&$result){
	global $role;
	
	//konwersja parametrów na int
	$x = floatval($x);
	$y = floatval($y);
	
	if ($role != "admin") {
		if ($kwota > 1000) {
		  $messages[] = "Tylko administrator może obliczać kwoty większe od 1000.";
		  return false;
		}  
	  }
	
	//wykonanie operacji
	switch ($operation) {
		case '2' :

      $result = $y * $x;

			break;
		default:
      if ($y == 0) {
        $messages[] = "Nie można dzielić przez 0.";
      } else {
        $result = $y / $x;
      }
      break;
	}

  }
//definicja zmiennych kontrolera
$x = null;
$y = null;
$operation = null;
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($x,$y,$operation);
if ( validate($x,$y,$operation,$messages) ) { // gdy brak błędów
	process($x,$y,$operation,$messages,$result);
}

// Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';
?>