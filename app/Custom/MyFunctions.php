<?php
namespace App\Custom;

use DateTime;

abstract class MyFunctions {
    public static function loguear($modo, $nombre_archivo, $mensaje, $conFecha = true) {
        $date = new DateTime();
        $format_date = $date->format('Y-m-d H:i:s');
        $fp = fopen($nombre_archivo, $modo);
        if($conFecha) {
            fwrite($fp, "[" . $format_date . "]\t" . $mensaje);
        } else {
            fwrite($fp, $mensaje);
        }
        fclose($fp);
    }

        public static function readFile($nombre_archivo) {
    $fp = fopen($nombre_archivo, "r");
    while (!feof($fp)) {
        $line = fgets($fp);
        $element = explode(" = ", $line);
        if (!isset($result[$element[0]])){
            $result[$element[0]] = $element[1];
        }
    }
    fclose($fp);
    return $result;
    }

    public static function iterator($array, $id = "") {
        $result = "";
        foreach ($array as $key => $value) {
            if (!is_numeric($key)) {
                $new_id = $id . "." . $key;
            } else {
                $new_id = $id;
            }
            if (is_numeric($key) || is_array($value) ) {
                $result .= self::iterator($value, $new_id);
            } else {
                $result .= $new_id . " = " . $value . PHP_EOL;
            }
        }
        return $result;
    }
}