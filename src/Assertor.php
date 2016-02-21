<?php

namespace Rmtram\SimilarImage;

class Assertor
{

    /**
     * @var array
     */
    private $allowExtension = ['jpg', 'jpeg'];

    /**
     * @param array $extensions
     */
    public function setAllowExtension(array $extensions)
    {
        $this->allowExtension = $extensions;
    }

    /**
     * @param string $file
     * @return $this
     */
    public function extension($file)
    {
        $fileInfo = new \SplFileInfo($file);
        $extension = strtolower($fileInfo->getExtension());
        if (!in_array($extension, $this->allowExtension)) {
            throw new \InvalidArgumentException('prohibit extension in ' . $extension);
        }
        return $this;
    }

    /**
     * @param string $file
     * @return $this
     */
    public function file($file)
    {
        if (!is_readable($file)) {
            throw new \InvalidArgumentException('could not file in ' . $file);
        }
        return $this;
    }

}