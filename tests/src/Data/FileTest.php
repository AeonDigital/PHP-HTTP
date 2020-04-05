<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Data\File as File;

require_once __DIR__ . "/../../phpunit.php";







class FileTest extends TestCase
{



    public function test_constructor_ok()
    {
        $fileStream = provider_PHPStream_InstanceOf_FileStream("image-resource.jpg");
        $obj = provider_PHPHTTPData_InstanceOf_File($fileStream);
        $this->assertTrue(is_a($obj, File::class));
    }


    public function test_method_get_stream()
    {
        $fileStream = provider_PHPStream_InstanceOf_FileStream("image-resource.jpg");
        $obj = provider_PHPHTTPData_InstanceOf_File($fileStream);
        $this->assertTrue(is_a($obj, File::class));
    }


    public function test_method_get_client_filename()
    {
        $fileStream = provider_PHPStream_InstanceOf_FileStream("image-resource.jpg");
        $obj = provider_PHPHTTPData_InstanceOf_File($fileStream, "another-name.jpg");
        $this->assertSame("another-name.jpg", $obj->getClientFilename());
    }


    public function test_method_get_size()
    {
        $fileStream = provider_PHPStream_InstanceOf_FileStream("image-resource.jpg");
        $obj = provider_PHPHTTPData_InstanceOf_File($fileStream);
        $this->assertSame(10552, $obj->getSize());
    }


    public function test_method_get_path_to_file()
    {
        global $tstFileDir;
        $fileStream = provider_PHPStream_InstanceOf_FileStream("image-resource.jpg");

        $expected = to_system_path($tstFileDir . "/image-resource.jpg");
        $obj = provider_PHPHTTPData_InstanceOf_File($fileStream);
        $this->assertSame($expected, $obj->getPathToFile());
    }


    public function test_method_get_client_file_name()
    {
        $fileStream = provider_PHPStream_InstanceOf_FileStream("image-resource.jpg");
        $obj = provider_PHPHTTPData_InstanceOf_File($fileStream);
        $this->assertSame("image-resource.jpg", $obj->getClientFilename());
    }


    public function test_method_get_media_type()
    {
        $fileStream = provider_PHPStream_InstanceOf_FileStream("image-resource.jpg");

        $obj = provider_PHPHTTPData_InstanceOf_File($fileStream);
        $this->assertSame("image/jpeg", $obj->getClientMediaType());

        $obj = provider_PHPHTTPData_InstanceOf_File($fileStream, "another-extension.txt");
        $this->assertSame("text/plain", $obj->getClientMediaType());
    }


    public function test_method_get_error()
    {
        $fileStream = provider_PHPStream_InstanceOf_FileStream("image-resource.jpg");
        $obj = provider_PHPHTTPData_InstanceOf_File($fileStream, "another-name.jpg", 10);
        $this->assertSame(10, $obj->getError());
    }


    public function test_method_drop_stream()
    {
        global $tstFileDir;
        $fileStream = provider_PHPStream_InstanceOf_FileStream("image-resource.jpg");
        $obj = provider_PHPHTTPData_InstanceOf_File($fileStream);

        $expected = to_system_path($tstFileDir . "/image-resource.jpg");
        $this->assertSame($fileStream, $obj->getStream());
        $this->assertSame(10552, $obj->getSize());
        $this->assertSame($expected, $obj->getPathToFile());
        $this->assertSame("image-resource.jpg", $obj->getClientFilename());
        $this->assertSame("image/jpeg", $obj->getClientMediaType());
        $this->assertSame(0, $obj->getError());

        $obj->dropStream();
        $this->assertSame($fileStream, $obj->getStream());
        $this->assertSame(null, $obj->getSize());
        $this->assertSame($expected, $obj->getPathToFile());
        $this->assertSame("image-resource.jpg", $obj->getClientFilename());
        $this->assertSame("image/jpeg", $obj->getClientMediaType());
        $this->assertSame(0, $obj->getError());
    }


    public function test_method_move_to()
    {
        global $tstFileDir;
        $fileStream = provider_PHPStream_InstanceOf_FileStream("image-resource.jpg");

        $expected1 = to_system_path($tstFileDir . "/image-resource.jpg");

        $obj = provider_PHPHTTPData_InstanceOf_File($fileStream);
        $this->assertSame($expected1, $obj->getPathToFile());


        $expected2 = to_system_path($tstFileDir . "/image-resource2.jpg");
        if (file_exists($expected2)) {
            unlink($expected2);
        }

        $obj->moveTo($expected2);
        $this->assertSame($expected2, $obj->getPathToFile());


        if (file_exists($expected2)) {
            $fileStream->detach();
            copy($expected2, $expected1);
            unlink($expected2);
        }
    }
}
