<?php
include "../clases/Acronimo.php";

if (empty($_POST['frase'])) {
    header("Location: index.html");
    exit;
}

$acronimo = new Acronimo($_POST['frase']);
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
    <a href="index.html">Convertir otro</a>
    <br><br>
    <a href="../index.html">Volver al Menú</a>
    <br>
    <p>Frase: <?php echo $_POST['frase']; ?></p>
    <p class="green">Acrónimo: <?php echo $acronimo->getAcronimo(); ?></p>
</body>

</html>