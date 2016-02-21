<?php

namespace Rmtram\SimilarImage\Tests;


class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $cacheImages = [];

    /**
     * constructor.
     */
    public function __construct()
    {
        $iterator = new \DirectoryIterator(__DIR__ . '/fixtures');
        foreach ($iterator as $item) {
            if ('jpg' === strtolower($item->getExtension())) {
                $this->cacheImages[] = clone $item;
            }
        }
    }

    /**
     * fixtureにあるクラス分類から画像を取得する
     * @param string $className (p001)とか
     * @return array
     */
    public function loadClassImage($className)
    {
        $pattern = sprintf('/^%s_[0-9]{1,}/', $className);
        $ret = [];
        /** @var \SplFileInfo $image */
        foreach ($this->cacheImages as $image) {
            if (preg_match($pattern, $image->getFilename())) {
                $ret[] = $image->getRealPath();
            }
        }
        return $ret;
    }
}