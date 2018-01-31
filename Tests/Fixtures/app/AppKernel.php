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
        $path = $this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml';
        $loader->load($path);
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return sys_get_temp_dir() . '/var/' . $this->environment . '/cache';
    }

    public function getLogDir()
    {
        return sys_get_temp_dir() . '/var/' . $this->environment . '/logs';
    }
}
