<?php
class Binario
{
    private int $numero;

    function __construct(int $numero)
    {
        $this->numero = $numero;
    }

    // Cada paso: [dividendo, cociente, residuo]
    function getPasos(): array
    {
        $pasos = [];
        $n = abs($this->numero);

        while ($n > 0) {
            $pasos[] = [$n, intdiv($n, 2), $n % 2];
            $n = intdiv($n, 2);
        }
        return $pasos;
    }

    function getBinario(): string
    {
        if ($this->numero == 0) {
            return "0";
        }

        $binario = "";
        foreach ($this->getPasos() as $paso) {
            $binario = $paso[2] . $binario; // el residuo se agrega al inicio
        }

        if ($this->numero < 0) {
            $binario = "-" . $binario;
        }
        return $binario;
    }
}