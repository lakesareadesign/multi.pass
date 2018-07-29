<?php

namespace PotSimilarity\Tests;

use Gettext\Translations;
use PHPUnit\Framework\TestCase;
use PotSimilarity\Library\Parser;

class TestParser extends TestCase
{
    public function testParser100()
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

        $parser = new Parser($poFileName, 100);
        $parser->parse();

        $this->assertCount(1, $parser->getSimilars());
    }

    public function testParserLess100()
    {
        // should be 95,...%
        $a = 'First Text';
        $b = 'First texts';

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

        $parser = new Parser($poFileName, 90);
        $parser->parse();

        $this->assertCount(1, $parser->getSimilars());

        $parser = new Parser($poFileName, 97);
        $parser->parse();

        $this->assertCount(0, $parser->getSimilars());
    }
}