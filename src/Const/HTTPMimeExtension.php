<?php

declare(strict_types=1);

namespace AeonDigital\Http\Const;




/**
 * Array associativo contendo a coleção de extensões de arquivo
 * correlacionada a seus mimetypes e que estão aptos a serem usados
 * como uma resposta a uma requisição HTTP.
 *
 * @var array
 */
const HTTPMimeExtension = [
    "txt" => "text/plain",

    "html" => "text/html",
    "xhtml" => "application/xhtml+xml",
    "json" => "application/json",
    "xml" => "application/xml",

    "pdf" => "application/pdf",
    "csv" => "text/csv",
    "xls" => "application/vnd.ms-excel",
    "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
];
