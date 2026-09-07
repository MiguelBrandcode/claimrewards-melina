<?php

function sanitize($txt)
{
    setlocale(LC_ALL, "en_US.utf8");
    $sanitizedText = iconv("utf-8", "ascii//TRANSLIT", $txt);
    $sanitizedText=strtolower($sanitizedText);
    $sanitizedText=trim($sanitizedText);
    
    return $sanitizedText;
}
