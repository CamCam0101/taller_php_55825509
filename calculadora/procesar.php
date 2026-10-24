<?php
session_start();
include "../clases/Calculadora.php";

if (!isset($_POST['numero1']) || !isset($_POST['numero2']) || !isset($_POST['operacion'])) {
    header("Location: index.php");
    exit;
}

// isset y no empty, porque el 0 es un dato válido
if (!is_numeric($_POST['numero1']) || !is_numeric($_POST['numero2'])) {
    $_SESSION['error'] = "Ingrese solo números.";
    header("Location: index.php");
    exit;
}

$a = (float) $_POST['numero1'];
$b = (float) $_POST['numero2'];
$operacion = $_POST['operacion'];
$calculadora = new Calculadora($a, $b);

switch ($operacion) {
    case "suma":
        $resultado = $calculadora->sumar();
        $texto = "$a + $b";
        break;
    case "resta":
        $resultado = $calculadora->restar();
        $texto = "$a - $b";
        break;
    case "multiplicacion":
        $resultado = $calculadora->multiplicar();
        $texto = "$a × $b";
        break;
    case "division":
        $resultado = $calculadora->dividir();
        $texto = "$a ÷ $b";
        break;
    case "porcentaje":
        $resultado = $calculadora->porcentaje();
        $texto = "$a % de $b";
        break;
    default:
        header("Location: index.php");
        exit;
}

if ($resultado === null) {
    $_SESSION['error'] = "No se puede dividir entre cero.";
} else {
    if (!isset($_SESSION['historial'])) {
        $_SESSION['historial'] = [];
    }
    $linea = $texto . " = " . round($resultado, 10);
    $_SESSION['historial'][] = $linea;
    $_SESSION['ultimo'] = $linea;   // para mostrarlo grande
}

header("Location: index.php");
exit;
