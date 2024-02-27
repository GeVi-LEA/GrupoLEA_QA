<?php

class UtilsHelp
{
    public static function validarNombreClaveUnico($array, $nombre, $clave)
    {
        $errores = array();
        // $searchNombre = array_search($nombre, array_column($array, 'nombre'));
        // if (is_numeric($searchNombre)) {
        // unset($array[$searchNombre]);
        // $searchNombre = array_search($nombre, array_column($array, 'nombre'));
        // if (is_numeric($searchNombre)) {
        // $errores['nombre'] = "invalid";
        // }
        // }
        if ($clave != null) {
            $searchClave = array_search($clave, array_column($array, 'clave'));
            if (is_numeric($searchClave)) {
                unset($array[$searchClave]);
                $searchClave = array_search($clave, array_column($array, 'clave'));
                if (is_numeric($searchClave)) {
                    $errores['clave'] = 'invalid';
                }
            }
        }
        return $errores;
    }

    public static function validarNombreClaveExiste($array, $nombre, $clave)
    {
        $errores = array();
        // $searchNombre = array_search($nombre, array_column($array, 'nombre'));
        // if (is_numeric($searchNombre)) {
        // $errores['nombre'] = 'invalid';
        // }
        if ($clave != null) {
            $searchClave = array_search($clave, array_column($array, 'clave'));
            if (is_numeric($searchClave)) {
                $errores['clave'] = 'invalid';
            }
        }
        return $errores;
    }

    public static function capitalizeString($string)
    {
        // $strArray = str_word_count($string, 1, 'ÁáÉéÍíÖÓóüÚúÄäñ1234567890.');
        $strArray = explode(' ', $string);
        $strFix   = '';
        foreach ($strArray as $word) {
            if ($word != '' && (strlen($word) >= 3)) {
                if (!strpos($word, '.')) {
                    $s       = ucfirst(mb_strtolower($word, 'UTF-8'));
                    $strFix .= $s . ' ';
                } else {
                    $s       = mb_strtoupper($word, 'UTF-8');
                    $strFix .= $s . ' ';
                }
            } else {
                $s       = mb_strtolower($word, 'UTF-8');
                $strFix .= $s . ' ';
            }
        }
        return trim($strFix);
    }

    public static function fixString($string)
    {
        return ucfirst(mb_strtolower(trim($string), 'UTF-8'));
    }

    public static function toUpperString($string)
    {
        return (mb_strtoupper(trim($string), 'UTF-8'));
    }

    public static function covertDatetoDateSql($fecha)
    {
        $stringFecha = 'null';
        if (($fecha != '') && ($fecha != ' ::00')) {
            $stringFecha = str_replace('/', '-', $fecha);
            // print_r('<pre>');
            // print_r(strlen($stringFecha));
            // print_r('</pre>');
            if (strlen($stringFecha) > 10) {
                if (strlen(explode('-', $stringFecha)[0]) != 4) {
                    $fecha       = explode(' ', $stringFecha)[0];
                    $hora        = explode(' ', $stringFecha)[1];
                    $stringFecha = explode('-', $fecha)[2] . '-' . explode('-', $fecha)[1] . '-' . explode('-', $fecha)[0] . ' ' . $hora;
                }
            } else {
                if (strlen(explode('-', $stringFecha)[0]) != 4) {
                    $fecha       = explode(' ', $stringFecha)[0];
                    $stringFecha = explode('-', $fecha)[2] . '-' . explode('-', $fecha)[1] . '-' . explode('-', $fecha)[0] . ' 00:00:00';
                }
            }
        } else {
            $stringFecha = 'null';
        }
        return $stringFecha;
    }

    public static function today()
    {
        setlocale(LC_TIME, idioma);
        $now = new DateTime();
        return $now->format('Y-m-d');
    }

    public static function fechaCompleta($fecha)
    {
        setlocale(LC_TIME, idioma);
        return self::capitalizeString(strftime('%A, %d de %B del %Y - %X ', strtotime($fecha)));
    }

    public static function fechaHora($fecha)
    {
        if ($fecha != null || $fecha != '') {
            return date('d/m/Y', strtotime($fecha)) . ' - ' . date('H:i:s', strtotime($fecha));
        } else {
            return '';
        }
    }

    public static function formatoFecha($fecha)
    {
        if ($fecha != null || $fecha != '') {
            return date('d/m/Y', strtotime($fecha));
        } else {
            return '';
        }
    }

    public static function formatoHora($hora)
    {
        if ($hora != null || $hora != '') {
            return date('H:i:s', strtotime($hora));
        } else {
            return '';
        }
    }

    public static function numero2Decimales($str, $decimales = false, $numDecimales = 2)
    {
        if ($decimales) {
            $int = floatval($str);
            return number_format($int, $numDecimales);
        } else {
            $strArray = preg_split('/[.]/', $str);
            try {
                if (count($strArray) > 1) {
                    if (intval($strArray[1]) == 0) {
                        $int = intval($str);
                        return number_format($int);
                    } else {
                        $int = floatval($str);
                        return number_format($int, $numDecimales);
                    }
                } else {
                    return $str;
                }
            } catch (\Throwable $th) {
                return $int;
            }
        }
    }

    public static function string2Entero($str)
    {
        $int = intval($str);
        return number_format($int);
    }

    public static function validarCorreos($correos)
    {
        $valido = true;
        foreach ($correos as $c) {
            if (!filter_var($c, FILTER_VALIDATE_EMAIL)) {
                $valido = false;
            }
        }
        return $valido;
    }

    public static function recortarString($str, $char, $inverso = false)
    {
        if ($inverso) {
            return substr($str, (strpos($str, $char) + 1));
        } else {
            return substr($str, 0, strpos($str, $char));
        }
    }

    public static function stringtoArray($str, $char)
    {
        if ($str != null || $str != '') {
            return explode($char, $str);
        }
        return null;
    }

    public static function quitarEspacios($str)
    {
        return trim(str_replace(' ', '', $str));
    }

    public static function sumarColumnaArray($array, $columna)
    {
        $suma = null;
        if (!empty($array)) {
            foreach ($array as $s) {
                $suma += intval($s[$columna]);
            }
        }
        return $suma;
    }

    public static function tiempoTranscurrido($minutos)
    {
        $transcurrido = array();
        if ($minutos > 0) {
            $d = floor($minutos / 1440);
            $h = floor(($minutos / 60) - ($d * 24));
            $m = floor($minutos - (($h * 60) + ($d * 1440)));
            $transcurrido = [
                'dias'    => $d,
                'horas'   => $h,
                'minutos' => $m
            ];
        } else {
            $transcurrido = [
                'dias'    => '',
                'horas'   => '',
                'minutos' => ''
            ];
        }
        return $transcurrido;
    }
}
