<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Data\FileCollection as FileCollection;

require_once __DIR__ . "/../../phpunit.php";







class FileCollectionTest extends TestCase
{




    public function test_constructor_ok()
    {
        $files = new FileCollection();
        $this->assertTrue(is_a($files, FileCollection::class));
    }


    public function test_constructor_ok_with_values()
    {
        $fs1 = provider_PHPStream_InstanceOf_FileStream("upload-image-1.jpg");
        $f1 = provider_PHPHTTPData_InstanceOf_File($fs1);
        $fs2 = provider_PHPStream_InstanceOf_FileStream("upload-image-2.jpg");
        $f2 = provider_PHPHTTPData_InstanceOf_File($fs2);


        $files = new FileCollection(["file1" => $f1, "file2" => $f2]);
        $this->assertTrue(is_a($files, FileCollection::class));
    }


    public function test_constructor_initial_values_fail()
    {
        $ckie = new FileCollection(["key1" => "value1"]);
        $this->assertFalse($ckie->has("hey1"));
    }


    public function test_method_get()
    {
        $fs1 = provider_PHPStream_InstanceOf_FileStream("upload-image-1.jpg");
        $f1 = provider_PHPHTTPData_InstanceOf_File($fs1);
        $fs2 = provider_PHPStream_InstanceOf_FileStream("upload-image-2.jpg");
        $f2 = provider_PHPHTTPData_InstanceOf_File($fs2);

        $files = provider_PHPHTTPData_InstanceOf_FileCollection(["file1" => $f1, "file2" => $f2]);

        $this->assertSame($f1, $files->get("file1"));
        $this->assertSame($f2, $files->get("file2"));
    }


    public function test_method_set_values_on_same_keyname()
    {
        $fs1 = provider_PHPStream_InstanceOf_FileStream("upload-image-1.jpg");
        $f1 = provider_PHPHTTPData_InstanceOf_File($fs1);
        $fs2 = provider_PHPStream_InstanceOf_FileStream("upload-image-2.jpg");
        $f2 = provider_PHPHTTPData_InstanceOf_File($fs2);

        $files = provider_PHPHTTPData_InstanceOf_FileCollection(["uploadField" => [$f1, $f2]]);

        $oFiles = $files->get("uploadField");
        $this->assertTrue(is_array($oFiles));
        $this->assertSame(2, count($oFiles));

        $this->assertSame($f1, $oFiles[0]);
        $this->assertSame($f2, $oFiles[1]);
    }


    public function test_method_drop_streams()
    {
        $fs1 = provider_PHPStream_InstanceOf_FileStream("upload-image-1.jpg");
        $f1 = provider_PHPHTTPData_InstanceOf_File($fs1);
        $fs2 = provider_PHPStream_InstanceOf_FileStream("upload-image-2.jpg");
        $f2 = provider_PHPHTTPData_InstanceOf_File($fs2);

        $files = provider_PHPHTTPData_InstanceOf_FileCollection(["file1" => $f1, "file2" => $f2]);

        $this->assertSame(10552, $files->get("file1")->getSize());
        $this->assertSame(10552, $files->get("file2")->getSize());

        $files->dropStreams();
        $this->assertSame(null, $files->get("file1")->getSize());
        $this->assertSame(null, $files->get("file2")->getSize());
    }
}
