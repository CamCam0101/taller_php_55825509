<?php
class Acronimo
{
    private string $frase;

    function __construct(string $frase)
    {
        $this->frase = $frase;
    }

    function getAcronimo(): string
    {
        // los guiones se vuelven espacios
        $texto = str_replace("-", " ", $this->frase);
        // se eliminan los demás signos de puntuación
        $texto = preg_replace('/[^\p{L}\p{N}\s]/u', '', $texto);

        $palabras = preg_split('/\s+/', trim($texto));
        $acronimo = "";

        foreach ($palabras as $palabra) {
            $acronimo .= mb_strtoupper(mb_substr($palabra, 0, 1));
        }
        return $acronimo;
    }
}