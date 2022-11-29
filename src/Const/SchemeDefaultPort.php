<?php

declare(strict_types=1);

namespace AeonDigital\Http\Const;




/**
 * Array associativo contendo, nas chaves, os nomes dos tipos de ``scheme`` conhecidos e,
 * correlacionados aos mesmos, o valor padrão para o componente ``port``.
 *
 * ```php
 *  [
 *      "http"     => 80
 *      "https"    => 433
 *      "ftp"      => 21
 *  ]
 * ```
 *
 * @var array
 */
const SchemeDefaultPort = [
    ""              => null,
    "http"          => 80,
    "https"         => 433,
    "ftp"           => 21,
    "ssh"           => 22,
    "urn"           => 80,
    "view-source"   => 80,
    "ws"            => 80,
    "wss"           => 433,
    "file"          => 80
];
