<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Execute as Execute;

require_once __DIR__ . "/../phpunit.php";







class ExecuteTest extends TestCase
{





    public function test_method_execute_request()
    {
        $parans = [
            "foo"=>"bar",
            "baz"=>"boom",
            "cow"=>"milk"
        ];
        $result = Execute::request("GET", "http://localhost/LICENSE#ignore-hash", $parans);
        $this->assertNotNull($result);
    }



    public function test_method_execute_download()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;

        $absoluteURL = "http://localhost/tests/resources/todownload/sonic-animacao.jpg";
        $absoluteSystemPathToDir = $dirResources . $ds . "files" . $ds;

        // Exclui arquivo de teste
        $fileName = "background.jpg";
        @unlink($absoluteSystemPathToDir . $fileName);

        // Altera a extenção do arquivo para salvar...
        // a extenção original deve ser mantida
        $fileName = "background.txt";


        $result = Execute::download(
            $absoluteURL,
            $absoluteSystemPathToDir,
            $fileName
        );


        // Mantem a extenção original do arquivo.
        $fileName = "background.jpg";
        $this->assertTrue($result);
        $this->assertTrue(file_exists($absoluteSystemPathToDir . $fileName));
    }
}
