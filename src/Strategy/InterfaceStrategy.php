<?php

namespace Rmtram\SimilarImage\Strategy;

/**
 * Interface InterfaceStrategy
 * @package Rmtram\SimilarImage\Strategy
 */
interface InterfaceStrategy
{
    /**
     * @param string $file
     * @return mixed
     */
    public function compile($file);

    /**
     * @param string $base
     * @param string $target
     * @return mixed
     */
    public function compare($base, $target);
}