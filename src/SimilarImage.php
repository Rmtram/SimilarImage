<?php

namespace Rmtram\SimilarImage;

use Rmtram\SimilarImage\Strategy\InterfaceStrategy;
use Snidel;

/**
 * Class SimilarImage
 * @package Rmtram\SimilarImage
 */
class SimilarImage
{
    /**
     * @var InterfaceStrategy $strategy
     */
    private $strategy;

    /**
     * @var Snidel
     */
    private $processor;

    /**
     * @var Assertor
     */
    private $assertor;

    /**
     * @var double
     */
    private $tolerance = 80;

    /**
     * @param InterfaceStrategy $strategy
     * @param int $concurrency プロセス数
     */
    public function __construct(InterfaceStrategy $strategy, $concurrency = 10)
    {
        $this->processor = new Snidel($concurrency);
        $this->strategy = $strategy;
        $this->assertor = new Assertor();
    }

    /**
     * 許容値の設定をする 85%以上でマッチと判定したい場合は
     * $this->tolerance(85);
     * と設定をする
     * @param double $double // 0 - 100
     * @return $this
     */
    public function tolerance($double)
    {
        if ($double > 0 && $double < 100) {
            $this->tolerance = $double / 100;;
            return $this;
        }
        throw new \InvalidArgumentException('range error 0 - 100');
    }

    /**
     * @param double $ratio
     * @return bool
     */
    private function isPermit($ratio)
    {
        return $ratio > $this->tolerance;
    }

    /**
     * @param string $baseImage
     * @param array $targetImages
     * @return array
     */
    public function run($baseImage, array $targetImages)
    {
        $generator = $this->generator($baseImage, $targetImages);
        foreach ($generator as $base => $target) {
            $this->entry($base, $target);
        }

        $images = $this->processor->get();
        if (empty($images)) {
            return $images;
        }

        $ret = [];
        foreach ($images as $fileName => $imageRatio) {
            if ($this->isPermit($imageRatio)) {
                $ret[$fileName] = $imageRatio;
            }
        }
        return $ret;
    }

    /**
     * @param $baseImage
     * @param array $targetImages
     * @return \Generator
     */
    private function generator($baseImage, array $targetImages)
    {
        $this->assertor
            ->file($baseImage)
            ->extension($baseImage);
        foreach ($targetImages as $targetImage) {
            $this->assertor
                ->file($targetImage)
                ->extension($targetImage);
            yield $baseImage => $targetImage;
        }
    }

    /**
     * @param string $baseImage
     * @param string $targetImage
     */
    private function entry($baseImage, $targetImage)
    {
        $callable = [$this->strategy, 'compare'];
        $this->processor->fork($callable, [$baseImage, $targetImage]);
    }

}