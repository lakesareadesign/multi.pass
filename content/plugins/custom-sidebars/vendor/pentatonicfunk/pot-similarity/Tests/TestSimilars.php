<?php

namespace PotSimilarity\Tests;

use PHPUnit\Framework\TestCase;
use PotSimilarity\Library\Similar;
use PotSimilarity\Library\Similars;

class TestSimilars extends TestCase
{
    public function testArrayAccess()
    {
        $similars      = new Similars();
        $similars[]    = new Similar('', '', '');
        $similars[200] = new Similar('', '', '');


        $this->assertFalse(isset($similars[9]));
        $this->assertNull($similars[9]);

        $this->assertNotEmpty($similars[0]);
        $this->assertInstanceOf(Similar::class, $similars[200]);

        unset($similars[0]);
        $this->assertFalse(isset($similars[0]));
        $this->assertNull($similars[0]);
    }
}