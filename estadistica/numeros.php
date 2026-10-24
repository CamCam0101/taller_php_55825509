<?php
if (!isset($_POST['cantidad'])) {
    header("Location: index.html");
    exit;
}

$cantidad = (int) $_POST['cantidad'];

if ($cantidad < 1 || $cantidad > 50) {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ingresar números</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <h1>Ingrese los <?php echo $cantidad; ?> números</h1>
    <a href="index.html">Cambiar cantidad</a>
    <a href="../index.html">Volver al Menú principal</a>
    <br><br>
    <form action="resultado.php" method="post">
        <?php for ($i = 1; $i <= $cantidad; $i++): ?>
            <label for="num<?php echo $i; ?>">Número <?php echo $i; ?>:</label>
            <input type="number" step="any" name="numeros[]" id="num<?php echo $i; ?>" required>
            <br><br>
        <?php endfor; ?>
        <button type="submit">Calcular</button>
    </form>
</body>

</html>