<?php

namespace KnpU\LoremIpsumBundle\Tests;

use KnpU\LoremIpsumBundle\KnpUIpsum;
use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

class FunctionalTest extends TestCase
{
    public function testServiceWiring()
    {
        $kernel = new KnpULoremIpsumTestingKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        $ipsum = $container->get('knpu-lorem-ipsum.knpu_ipsum');
        $this->assertInstanceOf(KnpUIpsum::class, $ipsum);
        $this->assertIsString('string', $ipsum->getParagraphs());
    }
}

class KnpULoremIpsumTestingKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new KnpULoremIpsumBundle()
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        // TODO: Implement registerContainerConfiguration() method.
    }

}