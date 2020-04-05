<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Stream\Stream as Stream;

require_once __DIR__ . "/../../phpunit.php";







class StreamTest extends TestCase
{





    public function test_constructor_invalid_stream()
    {
        $fail = false;
        try {
            $obj = new Stream("");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Argument must be a valid resource type.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_ok()
    {
        $fileTest = provider_PHPStream_ObjectStreamFromText();
        $obj = new Stream($fileTest);

        $this->assertTrue(is_a($obj, Stream::class));
    }


    public function test_method_detach()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "rw", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertSame($stats["size"], $obj->getSize());
        $obj->detach();
        $this->assertNull($obj->getSize());
    }


    public function test_method_close()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "rw", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertSame($stats["size"], $obj->getSize());

        $obj->close();
        $this->assertNull($obj->getSize());
    }


    public function test_method_getMetadata()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "rw", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertNull($obj->getMetadata("unexist"));
        foreach ($meta as $key => $value) {
            $result = $obj->getMetadata($key);
            $this->assertSame($value, $result);
        }

        $obj->close();
    }


    public function test_method_isSeekable_true()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "rw", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertTrue($obj->isSeekable());
        $obj->close();
    }


    public function test_method_isSeekable_false()
    {
        provider_copyFile("image-resource.jpg", "test-image.jpg");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-image.jpg", "rw", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertTrue($obj->isSeekable());
        $obj->close();
    }


    public function test_method_isReadable_true()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "r", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertTrue($obj->isReadable());
        $obj->close();
    }


    public function test_method_isReadable_false()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "a", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertFalse($obj->isReadable());
        $obj->close();
    }


    public function test_method_isWritable_true()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "a", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertTrue($obj->isWritable());
        $obj->close();
    }


    public function test_method_isWritable_false()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "r", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertFalse($obj->isWritable());
        $obj->close();
    }


    public function test_method_getSize()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "r", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertSame($stats["size"], $obj->getSize());
        $obj->close();
    }


    public function test_method_eof()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "r", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        // Move the cursor of stream to last position
        fread($fileTest, $stats["size"] + 1);
        // Check that cursor is in "eof"
        $this->assertSame(true, feof($fileTest));


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertSame(true, $obj->eof());
        $obj->close();
    }


    public function test_method_tell()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "r", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        // Move the cursor 16 position forward
        fread($fileTest, 16);


        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertSame(16, $obj->tell());
        $obj->close();
    }


    public function test_method_seek()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "rw", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);



        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertTrue($obj->isSeekable());
        $obj->seek(50);
        $this->assertSame(50, $obj->tell());
        $obj->close();
    }


    public function test_method_rewind()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "rw", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);



        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertTrue($obj->isSeekable());
        $obj->seek(50);
        $this->assertSame(50, $obj->tell());
        $obj->rewind();
        $this->assertSame(0, $obj->tell());
        $obj->close();
    }


    public function test_method_read()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "rw", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);



        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertTrue($obj->isReadable());
        $this->assertSame(" Code Craft PHP Framework", $obj->read(25));
        $obj->close();
    }


    public function test_method_write()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "r+", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);



        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertTrue($obj->isWritable());
        $str = "Phrase to test the method \"write\". This method is binary-safe\n";
        $this->assertSame(62, $obj->write($str));
        $obj->close();
    }


    public function test_method_getContents()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "r+", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);


        // retrieve the full contents of test file
        $fullFile = stream_get_contents($fileTest);

        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);

        // set the cursor back to start position.
        $obj->rewind();
        $this->assertSame($fullFile, $obj->getContents());
        $obj->close();
    }


    public function test_stream_object_to_string()
    {
        $stats = null;
        $meta = null;

        provider_copyFile("original-resource.md", "test-file.md");
        $fileTest = provider_PHPStream_ObjectStreamFromFile("test-file.md", "r+", $stats, $meta);

        $this->assertNotNull($fileTest);
        $this->assertNotNull($stats);
        $this->assertNotNull($meta);



        $obj = provider_PHPStream_InstanceOf_Stream($fileTest);
        $this->assertTrue($obj->isReadable());


        // gets entire contents of test file
        $fullFile = stream_get_contents($fileTest);
        $this->assertTrue($obj->eof());

        // sets the cursor to position 55 to check if the cursor position has been ignored for this method
        $obj->seek(55);
        $this->assertSame(55, $obj->tell());

        // gets entire contents of Stream object
        // using que magic method "__toString"
        $allStream = $obj . "";


        // check if the position of cursor still the same
        $this->assertFalse($obj->eof());
        $this->assertSame(55, $obj->tell());


        $this->assertSame($fullFile, $allStream);
        $obj->close();
    }
}
