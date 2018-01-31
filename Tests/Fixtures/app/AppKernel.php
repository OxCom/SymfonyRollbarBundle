<?php

namespace SymfonyRollbarBundle\Tests\Fixtures\app;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \SymfonyRollbarBundle\SymfonyRollbarBundle(),
        ];

        return $bundles;
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return __DIR__;
    }

    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     *
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        $path = realpath(__DIR__ . '/../var/' . $this->environment . '/cache');
        return $path;
    }

    public function getLogDir()
    {
        $path = realpath(__DIR__ . '/../var/' . $this->environment . '/logs');
        return $path;
    }
}
