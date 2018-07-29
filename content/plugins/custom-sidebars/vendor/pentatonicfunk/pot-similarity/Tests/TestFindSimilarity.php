<?php

namespace PotSimilarity\Tests;

use Gettext\Translations;

class TestFindSimilarity extends AbstractCommandTest
{
    public function testFileExist()
    {
        $output = self::runCommand('find:similar /this/file/not/exist.pot');
        $this->assertEquals(
            <<<EOT
Pot file is unreadable.\n
EOT
            ,
            $output
        );
    }

    public function testEmptyFile()
    {
        $messages = [];

        $t        = Translations::fromJsonDictionaryString(
            json_encode($messages)
        );
        $poString = $t->toPoString();

        $poFileName = sys_get_temp_dir().'/'.uniqid().'.po';
        file_put_contents($poFileName, $poString);

        $output = self::runCommand('find:similar '.$poFileName);
        $this->assertEquals(
            <<<EOT
Yeay all strings are unique.\n
EOT
            ,
            $output
        );
    }

    public function testValidFile()
    {
        // should be 100%
        $a = 'First Text';
        $b = 'First text';

        $messages = [
            $a => '',
            $b => '',
        ];

        $t        = Translations::fromJsonDictionaryString(
            json_encode($messages)
        );
        $poString = $t->toPoString();

        $poFileName = sys_get_temp_dir().'/'.uniqid().'.po';
        file_put_contents($poFileName, $poString);

        $output = self::runCommand('find:similar '.$poFileName.' 99');
        $this->assertContains(
            <<<EOT
Brace your self you can reduce 1 Similar Strings with 99% threshold\n
EOT
            ,
            $output
        );
    }
}