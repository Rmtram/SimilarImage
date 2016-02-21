<?php

namespace Rmtram\SimilarImage\Strategy;
use Jenssegers\ImageHash\ImageHash;

/**
 * Class HashStrategy
 * @package Rmtram\SimilarImage\Strategy
 */
class HashStrategy implements InterfaceStrategy
{
    /**
     * @var ImageHash
     */
    private $compiler;

    /**
     * @var int
     */
    private $max = 100;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->compiler = new ImageHash();
    }

    /**
     * 画像データをhashに変換させる
     * @param string $file
     * @return int
     */
    public function compile($file)
    {
        return $this->compiler->hash($file);
    }

    /**
     * 画像同士を比較する
     * @param string $base
     * @param string $target
     * @return double
     */
    public function compare($base, $target)
    {
        $current = $this->compiler->compare($base, $target);
        $ratio = ($this->max - $current) * 0.01;
        return [$target => $ratio];
    }
}