<?php
class Secuencia
{
    private int $numero;

    function __construct(int $numero)
    {
        $this->numero = $numero;
    }

    // Primeros N términos: 0, 1, 1, 2, 3, 5...
    function getFibonacci(): array
    {
        $serie = [];
        $a = 0;
        $b = 1;
        for ($i = 0; $i < $this->numero; $i++) {
            $serie[] = $a;
            $siguiente = $a + $b;
            $a = $b;
            $b = $siguiente;
        }
        return $serie;
    }

    // Factoriales de 1! hasta N!
    function getFactorial(): array
    {
        $serie = [];
        $resultado = 1;
        for ($i = 1; $i <= $this->numero; $i++) {
            $resultado *= $i;
            $serie[] = $resultado;
        }
        return $serie;
    }
}