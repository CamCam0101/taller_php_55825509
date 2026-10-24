<?php
include_once "Nodo.php";

class ArbolBinario
{
    private ?Nodo $raiz = null;
    private string $metodo = "";
    private string $error = "";

    function __construct(array $pre, array $in, array $post)
    {
        $recorridos = ["preorden" => $pre, "inorden" => $in, "postorden" => $post];
        $dados = [];
        foreach ($recorridos as $nombre => $lista) {
            if (count($lista) > 0) {
                $dados[$nombre] = $lista;
            }
        }

        if (count($dados) < 2) {
            $this->error = "Ingrese al menos dos recorridos.";
            return;
        }

        // Validar: sin repetidos y con los mismos nodos
        $referencia = null;
        foreach ($dados as $nombre => $lista) {
            if (count($lista) != count(array_unique($lista))) {
                $this->error = "El recorrido $nombre tiene nodos repetidos.";
                return;
            }
            $ordenada = $lista;
            sort($ordenada, SORT_STRING);
            if ($referencia === null) {
                $referencia = $ordenada;
            } elseif ($ordenada !== $referencia) {
                $this->error = "Los recorridos no tienen los mismos nodos.";
                return;
            }
        }

        // Elegir el método (si dan los tres, gana preorden - inorden)
        if (count($pre) > 0 && count($in) > 0) {
            $this->metodo = "preorden - inorden";
            $this->raiz = $this->construirPreIn($pre, $in);
        } elseif (count($in) > 0 && count($post) > 0) {
            $this->metodo = "inorden - postorden";
            $this->raiz = $this->construirInPost($in, $post);
        } else {
            $this->metodo = "preorden - postorden";
            $this->raiz = $this->construirPrePost($pre, $post);
        }

        // Verificar que el árbol construido genera los recorridos ingresados
        foreach ($dados as $nombre => $lista) {
            if ($this->getRecorrido($nombre) !== $lista) {
                $this->error = "Los recorridos ingresados no corresponden a un mismo árbol.";
                $this->raiz = null;
                return;
            }
        }
    }

    private function construirPreIn(array $pre, array $in): ?Nodo
    {
        if (count($pre) == 0) {
            return null;
        }
        $nodo = new Nodo($pre[0]);
        $i = array_search($pre[0], $in, true);

        $nodo->setIzq($this->construirPreIn(array_slice($pre, 1, $i), array_slice($in, 0, $i)));
        $nodo->setDer($this->construirPreIn(array_slice($pre, $i + 1), array_slice($in, $i + 1)));
        return $nodo;
    }

    private function construirInPost(array $in, array $post): ?Nodo
    {
        $n = count($in);
        if ($n == 0) {
            return null;
        }
        $nodo = new Nodo($post[$n - 1]);
        $i = array_search($post[$n - 1], $in, true);

        $nodo->setIzq($this->construirInPost(array_slice($in, 0, $i), array_slice($post, 0, $i)));
        $nodo->setDer($this->construirInPost(array_slice($in, $i + 1), array_slice($post, $i, $n - $i - 1)));
        return $nodo;
    }

    private function construirPrePost(array $pre, array $post): ?Nodo
    {
        $n = count($pre);
        if ($n == 0) {
            return null;
        }
        $nodo = new Nodo($pre[0]);
        if ($n == 1) {
            return $nodo;
        }
        // el segundo de preorden es la raíz del subárbol izquierdo
        $i = array_search($pre[1], $post, true);
        $tam = $i + 1; // cantidad de nodos del subárbol izquierdo

        $nodo->setIzq($this->construirPrePost(array_slice($pre, 1, $tam), array_slice($post, 0, $tam)));
        $nodo->setDer($this->construirPrePost(array_slice($pre, $tam + 1), array_slice($post, $tam, $n - $tam - 1)));
        return $nodo;
    }

    private function pre(?Nodo $n): array
    {
        if ($n === null) {
            return [];
        }
        return array_merge([$n->getValor()], $this->pre($n->getIzq()), $this->pre($n->getDer()));
    }

    private function in(?Nodo $n): array
    {
        if ($n === null) {
            return [];
        }
        return array_merge($this->in($n->getIzq()), [$n->getValor()], $this->in($n->getDer()));
    }

    private function post(?Nodo $n): array
    {
        if ($n === null) {
            return [];
        }
        return array_merge($this->post($n->getIzq()), $this->post($n->getDer()), [$n->getValor()]);
    }

    function getRecorrido(string $tipo): array
    {
        if ($tipo == "preorden") {
            return $this->pre($this->raiz);
        } elseif ($tipo == "inorden") {
            return $this->in($this->raiz);
        }
        return $this->post($this->raiz);
    }

    private function dibujar(?Nodo $n, int $nivel, string $etiqueta): string
    {
        if ($n === null) {
            return "";
        }
        $texto = str_repeat("    ", $nivel) . $etiqueta . $n->getValor() . "\n";
        $texto .= $this->dibujar($n->getIzq(), $nivel + 1, "izq: ");
        $texto .= $this->dibujar($n->getDer(), $nivel + 1, "der: ");
        return $texto;
    }

        // Calcula la columna (orden inorden) y el nivel de cada nodo
    private function ubicar(?Nodo $n, int $nivel, int &$col, array &$pos): void
    {
        if ($n === null) {
            return;
        }
        $this->ubicar($n->getIzq(), $nivel + 1, $col, $pos);
        $pos[spl_object_id($n)] = [$col, $nivel];
        $col++;
        $this->ubicar($n->getDer(), $nivel + 1, $col, $pos);
    }

    // Dibuja las líneas entre cada nodo y sus hijos
    private function lineas(?Nodo $n, array $pos): string
    {
        if ($n === null) {
            return "";
        }
        $svg = "";
        $x1 = 40 + $pos[spl_object_id($n)][0] * 60;
        $y1 = 40 + $pos[spl_object_id($n)][1] * 70;

        foreach ([$n->getIzq(), $n->getDer()] as $hijo) {
            if ($hijo !== null) {
                $x2 = 40 + $pos[spl_object_id($hijo)][0] * 60;
                $y2 = 40 + $pos[spl_object_id($hijo)][1] * 70;
                $svg .= "<line x1='$x1' y1='$y1' x2='$x2' y2='$y2' stroke='black' stroke-width='2'/>";
                $svg .= $this->lineas($hijo, $pos);
            }
        }
        return $svg;
    }

    // Dibuja los círculos con la letra de cada nodo
    private function circulos(?Nodo $n, array $pos): string
    {
        if ($n === null) {
            return "";
        }
        $x = 40 + $pos[spl_object_id($n)][0] * 60;
        $y = 40 + $pos[spl_object_id($n)][1] * 70;
        $valor = htmlspecialchars($n->getValor());

        $svg = "<circle cx='$x' cy='$y' r='20' fill='white' stroke='black' stroke-width='2'/>";
        $svg .= "<text x='$x' y='" . ($y + 5) . "' text-anchor='middle' font-size='16' font-family='Arial'>$valor</text>";
        $svg .= $this->circulos($n->getIzq(), $pos);
        $svg .= $this->circulos($n->getDer(), $pos);
        return $svg;
    }

    function getSVG(): string
    {
        if ($this->raiz === null) {
            return "";
        }
        $pos = [];
        $col = 0;
        $this->ubicar($this->raiz, 0, $col, $pos);

        $maxNivel = 0;
        foreach ($pos as $p) {
            $maxNivel = max($maxNivel, $p[1]);
        }
        $ancho = 80 + ($col - 1) * 60;
        $alto = 80 + $maxNivel * 70;

        return "<svg width='$ancho' height='$alto' xmlns='http://www.w3.org/2000/svg'>"
            . $this->lineas($this->raiz, $pos)
            . $this->circulos($this->raiz, $pos)
            . "</svg>";
    }

    function getTexto(): string
    {
        return $this->dibujar($this->raiz, 0, "raíz: ");
    }

    function getMetodo(): string
    {
        return $this->metodo;
    }

    function getError(): string
    {
        return $this->error;
    }
}