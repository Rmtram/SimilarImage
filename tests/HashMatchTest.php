<?php

namespace Rmtram\SimilarImage\Tests;

use Rmtram\SimilarImage\SimilarImage;
use Rmtram\SimilarImage\Strategy\HashStrategy;

class HashMatchTest extends AbstractTestCase
{
    public function testP007()
    {
        $images = $this->loadClassImage('p007');
        $base = reset($images);
        $similar = new SimilarImage(new HashStrategy());
        $ret = $similar->tolerance(75)->run($base, $images);
        var_dump($ret);
    }
}