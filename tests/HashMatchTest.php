<?php

namespace Rmtram\SimilarImage\Tests;

use Rmtram\SimilarImage\SimilarImage;
use Rmtram\SimilarImage\Strategy\HashStrategy;

class HashMatchTest extends AbstractTestCase
{

    public function testP001()
    {
        $this->compareTestImage('p001', 2);
    }

    public function testP002()
    {
        $this->compareTestImage('p002', 2);
    }

    public function testP003()
    {
        $this->compareTestImage('p003', 2);
    }

    public function testP004()
    {
        $this->compareTestImage('p004', 2);
    }

    public function testP005()
    {
        $this->compareTestImage('p005', 2);
    }

    public function testP006()
    {
        $this->compareTestImage('p006', 2);
    }

    public function testP007()
    {
        $this->compareTestImage('p007', 3);
    }

    public function testP008()
    {
        $this->compareTestImage('p008', 2);
    }

    public function testP009()
    {
        $this->compareTestImage('p009', 2);
    }

    /**
     * @param string  $cluster
     * @param int $actual
     */
    private function compareTestImage($cluster, $actual)
    {
        $images = $this->loadClassImage($cluster);
        $base = reset($images);
        $similar = new SimilarImage(new HashStrategy());
        $ret = $similar->tolerance(75)->run($base, $images);
        $this->assertEquals(count($ret), $actual);
    }
}