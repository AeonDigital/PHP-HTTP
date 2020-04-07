<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Stream\FileStream as FileStream;

require_once __DIR__ . "/../../phpunit.php";







class FileStreamTest extends TestCase
{





    public function test_constructor_file_does_not_exist()
    {
        global $dirFiles;
        $baseTgtDir = $dirFiles . "\\\\";
        $tgtFile = $baseTgtDir . "does-not-exist.md";

        $fail = false;
        try {
            $obj = new FileStream($tgtFile);
        } catch (\Exception $ex) {
            $fail = true;
            $correctPath = $dirFiles . "\\does-not-exist.md";
            $this->assertSame("The target file does not exists [ \"" . $correctPath . "\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_ok()
    {
        global $dirFiles;
        $tgtFile = $dirFiles . "/original-resource.md";
        $obj = new FileStream($tgtFile);

        $this->assertTrue(is_a($obj, FileStream::class));
    }


    public function test_method_getPathToFile()
    {
        global $dirFiles;
        $obj = prov_instanceOf_Http_FileStream_fromFile("original-resource.md");
        $correctPath = to_system_path($dirFiles . "/original-resource.md");
        $this->assertSame($correctPath, $obj->getPathToFile());
    }


    public function test_method_getFilename()
    {
        $obj = prov_instanceOf_Http_FileStream_fromFile("original-resource.md");
        $this->assertSame("original-resource.md", $obj->getFilename());
    }


    public function test_method_getMimeType()
    {
        $obj = prov_instanceOf_Http_FileStream_fromFile("original-resource.md");
        $this->assertSame("text/markdown", $obj->getMimeType());
    }


    public function test_method_setFileStream()
    {
        global $dirFiles;

        $obj = prov_instanceOf_Http_FileStream_fromFile("original-resource.md");
        $correctPath = to_system_path($dirFiles . "/original-resource.md");
        $this->assertSame($correctPath, $obj->getPathToFile());
        $this->assertSame("original-resource.md", $obj->getFilename());
        $this->assertSame("text/markdown", $obj->getMimeType());


        $obj->setFileStream($dirFiles . "/test-image.jpg");
        $correctPath = to_system_path($dirFiles . "/test-image.jpg");
        $this->assertSame($correctPath, $obj->getPathToFile());
        $this->assertSame("test-image.jpg", $obj->getFilename());
        $this->assertSame("image/jpeg", $obj->getMimeType());
    }
}
