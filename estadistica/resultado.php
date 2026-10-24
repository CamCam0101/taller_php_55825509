<?php
include "../clases/Estadistica.php";

if (!isset($_POST['numeros']) || !is_array($_POST['numeros']) || count($_POST['numeros']) == 0) {
    header("Location: index.html");
    exit;
}

$numeros = [];
foreach ($_POST['numeros'] as $valor) {
    if (!is_numeric($valor)) {
        header("Location: index.html");
        exit;
    }
    $numeros[] = (float) $valor;
}

$estadistica = new Estadistica($numeros);
$moda = $estadistica->getModa();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <h1>Resultado</h1>
    <a href="index.html">Calcular otro</a>
    <a href="../index.html">Volver al Menú principal</a>
    <br><br>
    <p>Números: <?php echo implode(", ", $numeros); ?></p>
    <p class="green">Promedio: <?php echo round($estadistica->getPromedio(), 2); ?></p>
    <p class="green">Mediana: <?php echo round($estadistica->getMediana(), 2); ?></p>
    <p class="green">Moda:
        <?php
        if (count($moda) == 0) {
            echo "No hay moda (ningún número se repite)";
        } else {
            echo implode(", ", $moda);
        }
        ?>
    </p>
</body>

</html>