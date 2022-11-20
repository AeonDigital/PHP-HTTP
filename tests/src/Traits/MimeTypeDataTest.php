<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Traits\MimeTypeData as MimeTypeData;

require_once __DIR__ . "/../../phpunit.php";






class MimeTypeDataTest extends TestCase
{



    public function test_property_mimeTypeList()
    {
        $keysAndValues = [
            "-"     => null,
            "css"   => "text/css",
            "dmg"   => "application/x-apple-diskimage",
            "gph"   => "application/vnd.flographit",
            "les"   => "application/vnd.hhe.lesson-player",
            "mp4"   => "video/mp4",
            "nml"   => "application/vnd.enliven",
            "otf"   => "application/x-font-otf",
            "spf"   => "application/vnd.yamaha.smaf-phrase",
            "tiff"  => "image/tiff",
            "wma"   => "audio/x-ms-wma",
            "xul"   => "application/vnd.mozilla.xul+xml",
        ];

        $nMock = new MimeTypeDataMockClass();
        foreach ($keysAndValues as $key => $value) {
            $this->assertSame($value, $nMock->getMimeTypeByExtension($key));
        }
    }





    public function test_property_responseMimeTypes()
    {
        $keysAndValues = [
            "css"   => false,
            "dmg"   => false,
            "gph"   => false,
            "les"   => false,
            "mp4"   => false,
            "nml"   => false,
            "otf"   => false,
            "spf"   => false,
            "tiff"  => false,
            "wma"   => false,
            "xul"   => false,

            "txt"   => true,
            "html"  => true,
            "xhtml" => true,
            "json"  => true,
            "xml"   => true,
            "pdf"   => true,
            "csv"   => true,
            "xls"   => true,
            "xlsx"  => true
        ];

        $nMock = new MimeTypeDataMockClass();
        foreach ($keysAndValues as $key => $value) {
            $this->assertSame($value, $nMock->isValidResponseMime($key));
        }
    }





    public function test_method_retrieveFileMimeType()
    {
        $keysAndValues = [
            "-"     => "application/octet-stream",
            "css"   => "text/css",
            "dmg"   => "application/x-apple-diskimage",
            "gph"   => "application/vnd.flographit",
            "les"   => "application/vnd.hhe.lesson-player",
            "mp4"   => "video/mp4",
            "nml"   => "application/vnd.enliven",
            "otf"   => "application/x-font-otf",
            "spf"   => "application/vnd.yamaha.smaf-phrase",
            "tiff"  => "image/tiff",
            "wma"   => "audio/x-ms-wma",
            "xul"   => "application/vnd.mozilla.xul+xml",
        ];

        $nMock = new MimeTypeDataMockClass();
        foreach ($keysAndValues as $key => $value) {
            $this->assertSame($value, $nMock->retrieveFileMimeType("filename." . $key));
        }
    }
}





class MimeTypeDataMockClass
{
    use MimeTypeData;

    public function getMimeTypeByExtension(string $extension): ?string
    {
        return ((isset($this->mimeTypeList[$extension]) === true) ? $this->mimeTypeList[$extension] : null);
    }

    public function isValidResponseMime(string $extension): bool
    {
        $keys = array_keys($this->responseMimeTypes);
        return (in_array($extension, $keys));
    }
}
