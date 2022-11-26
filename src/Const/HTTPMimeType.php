<?php

declare(strict_types=1);

namespace AeonDigital\Http\Const;




/**
 * Array associativo contendo a coleção de mimetypes
 * correlacionada a suas extensões de arquivo e que estão aptos a serem usados
 * como uma resposta a uma requisição HTTP.
 *
 * @var array
 */
const HTTPMimeType = [
    "text/plain" => "txt",

    "text/html" => "html",
    "application/xhtml+xml" => "xhtml",
    "application/json" => "json",
    "application/xml" => "xml",

    "application/pdf" => "pdf",
    "text/csv" => "csv",
    "application/vnd.ms-excel" => "xls",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" => "xlsx"
];
