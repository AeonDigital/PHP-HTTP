<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Uri\Tests\Concrete\HierPartUri as HierPartUri;

require_once __DIR__ . "/../../phpunit.php";






class aHierPartUriTest extends TestCase
{



    public function test_constructor_invalid_scheme()
    {
        $fail = false;
        try {
            $nMock = new HierPartUri("htt");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"scheme\". Expected [ , http, https, ftp, ssh, urn, view-source, ws, wss, file ]. Given: [ htt ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_invalid_port()
    {
        $fail = false;
        try {
            $nMock = new HierPartUri("http", "username", "pass1234", "testdomain", 500000);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"port\". Expected ``null`` or an integer between 1 and 65535. Given: [ 500000 ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_ok()
    {
        $nMock = new HierPartUri("http", "username", "pass1234", "testdomain", 400);
        $this->assertTrue(is_a($nMock, HierPartUri::class));
    }


    public function test_method_get_user()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "username");
        $this->assertSame("username", $nMock->getUser());
    }


    public function test_method_get_user_empty()
    {
        $fail = false;
        $nMock = new HierPartUri("http");
        $this->assertSame("", $nMock->getUser());
    }


    public function test_method_get_user_encoded()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "user@encoded");
        $this->assertSame("user%40encoded", $nMock->getUser());
    }


    public function test_check_for_prevent_double_percent_encode()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "user%252540encoded");
        $this->assertSame("user%40encoded", $nMock->getUser());
    }


    public function test_check_for_invalid_encode_string()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "user%encoded");
        $this->assertSame("user%25encoded", $nMock->getUser());
    }


    public function test_method_get_password()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "username", "password");
        $this->assertSame("password", $nMock->getPassword());
    }


    public function test_method_get_password_empty()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "username", "");
        $this->assertSame("", $nMock->getPassword());
    }


    public function test_method_get_password_null()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "username", null);
        $this->assertSame(null, $nMock->getPassword());
    }


    public function test_method_get_password_encoded()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "username", "p4@w(rd");
        $this->assertSame("p4%40w%28rd", $nMock->getPassword());
    }


    public function test_method_get_host()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "username", "pass1234", "testdomain");
        $this->assertSame("testdomain", $nMock->getHost());
    }


    public function test_method_get_host_empty()
    {
        $fail = false;
        $nMock = new HierPartUri("http");
        $this->assertSame("", $nMock->getHost());
    }


    public function test_method_get_port()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "username", "pass1234", "testdomain", 88);
        $this->assertSame(88, $nMock->getPort());
    }


    public function test_method_get_default_port()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "username", "pass1234", "testdomain", 88);
        $this->assertSame(80, $nMock->getDefaultPort());
    }


    public function test_method_get_port_null_because_it_is_not_set()
    {
        $fail = false;
        $nMock = new HierPartUri("http");
        $this->assertSame(null, $nMock->getPort());
    }


    public function test_method_get_port_null_because_is_default_for_scheme()
    {
        $fail = false;
        $nMock = new HierPartUri("https", "username", "pass1234", "testdomain", 433);
        $this->assertSame(null, $nMock->getPort());
    }


    public function test_method_get_user_info()
    {
        $fail = false;
        $nMock = new HierPartUri("https", "username", "pass1234", "testdomain", 433);
        $this->assertSame("username:pass1234", $nMock->getUserInfo());
    }


    public function test_method_get_user_info_empty()
    {
        $fail = false;
        $nMock = new HierPartUri("https", "", null, "testdomain", 433);
        $this->assertSame("", $nMock->getUserInfo());
    }


    public function test_method_get_user_info_no_user_and_password_empty()
    {
        $fail = false;
        $nMock = new HierPartUri("https", "", "", "testdomain", 433);
        $this->assertSame(":", $nMock->getUserInfo());
    }


    public function test_method_get_user_info_with_user_and_no_password()
    {
        $fail = false;
        $nMock = new HierPartUri("https", "username", null, "testdomain", 433);
        $this->assertSame("username", $nMock->getUserInfo());
    }


    public function test_method_get_authority()
    {
        $fail = false;
        $nMock = new HierPartUri("https", "username", "pass1234", "testdomain", 455);
        $this->assertSame("username:pass1234@testdomain:455", $nMock->getAuthority());
    }


    public function test_method_get_authority_empty()
    {
        $fail = false;
        $nMock = new HierPartUri("https", "", null, "", 433);
        $this->assertSame("", $nMock->getAuthority());
    }


    public function test_method_get_authority_only_username()
    {
        $fail = false;
        $nMock = new HierPartUri("https", "username", null, "", 433);
        $this->assertSame("username@", $nMock->getAuthority());
    }


    public function test_method_get_authority_with_username_and_domain()
    {
        $fail = false;
        $nMock = new HierPartUri("https", "username", null, "testdomain", 433);
        $this->assertSame("username@testdomain", $nMock->getAuthority());
    }


    public function test_method_get_authority_with_username_and_domain_and_port()
    {
        $fail = false;
        $nMock = new HierPartUri("https", "username", null, "testdomain", 455);
        $this->assertSame("username@testdomain:455", $nMock->getAuthority());
    }


    public function test_method_get_path()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "username", "pass1234", "testdomain", null, "/segment$/segment&/seg-ment");
        $this->assertSame("/segment%24/segment%26/seg-ment", $nMock->getPath());
    }


    public function test_method_get_path_empty()
    {
        $fail = false;
        $nMock = new HierPartUri("http", "username", "pass1234", "testdomain", null, "");
        $this->assertSame("", $nMock->getPath());
    }


    public function test_method_clone_with_scheme()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455);
        $this->assertSame("https", $nMock->getScheme());


        $nMock2 = $nMock->withScheme("HtTp");
        $this->assertSame("http", $nMock2->getScheme());
        $this->assertSame("username", $nMock2->getUser());
        $this->assertSame("https", $nMock->getScheme());
    }


    public function test_method_clone_with_user()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455);
        $this->assertSame("username", $nMock->getUser());


        $nMock2 = $nMock->withUser("anotherUser");
        $this->assertSame("anotherUser", $nMock2->getUser());
        $this->assertSame("username", $nMock->getUser());
    }


    public function test_method_clone_with_user_fail()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455);
        $this->assertSame("username", $nMock->getUser());
    }


    public function test_method_clone_with_password()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455);
        $this->assertSame("pass1%40234", $nMock->getPassword());


        $nMock2 = $nMock->withPassword("another&pass");
        $this->assertSame("another%26pass", $nMock2->getPassword());
        $this->assertSame("pass1%40234", $nMock->getPassword());
    }


    public function test_method_clone_with_password_to_remove_it()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455);
        $this->assertSame("pass1%40234", $nMock->getPassword());


        $nMock2 = $nMock->withPassword(null);
        $this->assertSame(null, $nMock2->getPassword());
        $this->assertSame("pass1%40234", $nMock->getPassword());
    }


    public function test_method_clone_with_password_fail()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455);
        $this->assertSame("pass1%40234", $nMock->getPassword());
    }


    public function test_method_clone_with_host()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455);
        $this->assertSame("testdomain", $nMock->getHost());


        $nMock2 = $nMock->withHost("ahotherdomain");
        $this->assertSame("ahotherdomain", $nMock2->getHost());
        $this->assertSame("testdomain", $nMock->getHost());
    }


    public function test_method_clone_with_host_fail()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455);
        $this->assertSame("testdomain", $nMock->getHost());
    }


    public function test_method_clone_with_port()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455);
        $this->assertSame(455, $nMock->getPort());


        $nMock2 = $nMock->withPort(433);
        $this->assertSame(null, $nMock2->getPort());
        $this->assertSame(455, $nMock->getPort());
    }


    public function test_method_clone_with_port_fail()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455);
        $this->assertSame(455, $nMock->getPort());
    }


    public function test_method_clone_with_user_info()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455);
        $this->assertSame("username", $nMock->getUser());
        $this->assertSame("pass1%40234", $nMock->getPassword());
        $this->assertSame("username:pass1%40234", $nMock->getUserInfo());


        $nMock2 = $nMock->withUserInfo("newuser", null);
        $this->assertSame("newuser", $nMock2->getUserInfo());
        $this->assertSame("username:pass1%40234", $nMock->getUserInfo());
    }


    public function test_method_clone_with_authority()
    {
        $nMock = new HierPartUri("http", "username", "pass1@234", "testdomain", 455);
        $this->assertSame("username", $nMock->getUser());
        $this->assertSame("pass1%40234", $nMock->getPassword());
        $this->assertSame("testdomain", $nMock->getHost());
        $this->assertSame(455, $nMock->getPort());
        $this->assertSame("username:pass1%40234@testdomain:455", $nMock->getAuthority());


        $nMock2 = $nMock->withAuthority("newuser", "", "anotherdomain", 80);
        $this->assertSame("newuser:@anotherdomain", $nMock2->getAuthority());
        $this->assertSame("username:pass1%40234@testdomain:455", $nMock->getAuthority());
    }


    public function test_method_clone_with_path()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455, "/segment$/segment&/seg-ment");
        $this->assertSame("/segment%24/segment%26/seg-ment", $nMock->getPath());


        $nMock2 = $nMock->withPath("another/path/to/test/");
        $this->assertSame("another/path/to/test/", $nMock2->getPath());
        $this->assertSame("/segment%24/segment%26/seg-ment", $nMock->getPath());
    }


    public function test_method_clone_with_path_fail()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455, "/segment$/segment&/seg-ment");
        $this->assertSame("/segment%24/segment%26/seg-ment", $nMock->getPath());
    }


    public function test_method_get_base()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455, "/segment$/segment&/seg-ment");
        $this->assertSame("https://username:pass1%40234@testdomain:455", $nMock->getBase());
    }


    public function test_method_get_base_path()
    {
        $nMock = new HierPartUri("https", "username", "pass1@234", "testdomain", 455, "segment$/segment&/seg-ment");
        $this->assertSame("https://username:pass1%40234@testdomain:455/segment%24/segment%26/seg-ment", $nMock->getBasePath());
    }
}
