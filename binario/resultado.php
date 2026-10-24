<?php
include "../clases/Binario.php";

if (!isset($_POST['numero'])) {
    header("Location: index.html");
    exit;
}

// filter_var devuelve false si no es un entero válido
$numero = filter_var($_POST['numero'], FILTER_VALIDATE_INT, [
    "options" => ["min_range" => -2147483647, "max_range" => 2147483647]
]);

if ($numero === false) {
    header("Location: index.html");
    exit;
}

$binario = new Binario($numero);
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
    <a href="../index.html">Volver al Menú principal</a>
    <br><br>
    <p>Decimal: <?php echo $numero; ?></p>
    <p class="green">Binario: <?php echo $binario->getBinario(); ?></p>

    <?php if ($numero != 0): ?>
        <h3>Divisiones sucesivas</h3>
        <table border="1">
            <thead>
                <tr><th>Dividendo</th><th>Cociente</th><th>Residuo</th></tr>
            </thead>
            <tbody>
                <?php foreach ($binario->getPasos() as $paso): ?>
                    <tr>
                        <td><?php echo $paso[0]; ?> ÷ 2</td>
                        <td><?php echo $paso[1]; ?></td>
                        <td><?php echo $paso[2]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>El binario se lee de los residuos de <strong>abajo hacia arriba</strong>.</p>
    <?php endif; ?>
</body>

</html>