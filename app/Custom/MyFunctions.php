<?php
namespace App\Custom;

use DateTime;

abstract class MyFunctions {

    public static function loguear($modo, $nombre_archivo, $mensaje, $conFecha = true) {
        $date = new DateTime();
        $format_date = $date->format('Y-m-d H:i:s');
        $fp = fopen($nombre_archivo, $modo);
        if($conFecha) {
            fwrite($fp, "[" . $format_date . "]\t" . $mensaje . PHP_EOL);
        } else {
            fwrite($fp, $mensaje);
        }
        fclose($fp);
    }
    public static function readFile($nombre_archivo){
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
    public static function curlPost ($url, $postfields, $content_type) {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: ' . $content_type,
                "Authorization: Bearer " . env('META_TOKEN')
            ),
        ));
        $json = curl_exec($ch);
        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $rta = "Code: " . $info . " || " . $json;
        if ($info != 200) {
            MyFunctions::loguear('a+', '../storage/logs/errorsWhatsappAPI.txt', $rta);
        }
        return $json;
    }
    public static function curlGet ($url) {
        $ch = curl_init();

        curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . env('META_TOKEN')
        ),
        ));
        $json = curl_exec($ch);
        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $rta = "Code: " . $info . " || " . $json;
        if ($info != 200) {
            MyFunctions::loguear('a+', '../storage/logs/errorsWhatsappAPI.txt', $rta);
        }
        return $json;
    }
    public function curlGetFile ($url, $fileName) {
        $fh = fopen($fileName, 'w+') or exit("Error opening file $fileName");
            
        $ch = curl_init();

        curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . env('META_TOKEN')
        ),
        CURLOPT_FILE => $fh,
        ));
        $json = curl_exec($ch);
        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fh);
        $rta = "Code: " . $info . " || " . $json;
        if ($info != 200) {
            MyFunctions::loguear('a+', '../storage/logs/errorsWhatsappAPI.txt', $rta);
        }
        return $json;
        }
}