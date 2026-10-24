<?php
include "../clases/Secuencia.php";

if (empty($_POST['numero']) || empty($_POST['operacion'])) {
    header("Location: index.html");
    exit;
}

$numero = (int) $_POST['numero'];
$operacion = $_POST['operacion'];

$mensaje = "";
$serie = [];
$titulo = "Resultado";

if ($operacion == "fibonacci") {
    if ($numero < 1 || $numero > 90) {
        $mensaje = "Para Fibonacci ingrese un número entre 1 y 90.";
    } else {
        $titulo = "Fibonacci de $numero términos";
        $serie = (new Secuencia($numero))->getFibonacci();
    }
} elseif ($operacion == "factorial") {
    if ($numero < 1 || $numero > 20) {
        $mensaje = "Para Factorial ingrese un número entre 1 y 20.";
    } else {
        $titulo = "Factorial hasta $numero";
        $serie = (new Secuencia($numero))->getFactorial();
    }
} else {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <h1><?php echo $titulo; ?></h1>
    <a href="index.html">Calcular otro</a>
    <br>
    <a href="../index.html">Volver al Menú</a>
    <br><br>
    <?php if ($mensaje != ""): ?>
        <p><?php echo $mensaje; ?></p>
    <?php else: ?>
        <p class="green"><?php echo implode(", ", $serie); ?></p>
    <?php endif; ?>
</body>

</html>