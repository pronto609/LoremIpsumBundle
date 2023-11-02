<?php

namespace KnpU\LoremIpsumBundle\Test;

use KnpU\LoremIpsumBundle\KnpUIpsum;
use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use KnpU\LoremIpsumBundle\WordProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

class FunctionalTest extends TestCase
{
    public function testServiceWiring()
    {
        $kernel = new KnpULoremIpsumTestingKernel();
        $kernel->boot();
        $container = $kernel->getContainer();

        $ipsum = $container->get('knpu-lorem-ipsum.knpu_ipsum');
        $this->assertInstanceOf(KnpUIpsum::class, $ipsum);
        $this->assertIsString('string', $ipsum->getParagraphs());
    }

    public function testServiceWiringWithConfiguration()
    {
        $kernel = new KnpULoremIpsumTestingKernel([
            'word_provider'=>'stub_word_list'
        ]);
        $kernel->boot();
        $container = $kernel->getContainer();

        $ipsum = $container->get('knpu-lorem-ipsum.knpu_ipsum');
        $this->assertStringContainsString('stub', $ipsum->getWords(2));
    }
}

class KnpULoremIpsumTestingKernel extends Kernel
{
    /**
     * @var array
     */
    private $knpUIpsumConfig;

    public function __construct(array $knpUIpsumConfig = [])
    {
        parent::__construct('test', true);
        $this->knpUIpsumConfig = $knpUIpsumConfig;
    }

    public function registerBundles()
    {
        return [
            new KnpULoremIpsumBundle(),
            new FrameworkBundle()
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->register('stub_word_list', StubWordList::class);

            $container->loadFromExtension('knpu_lorem_ipsum', $this->knpUIpsumConfig);
        });
    }

    public function getCacheDir()
    {
        return __DIR__ . '/cache/' . spl_object_hash($this);
    }


}

class StubWordList implements WordProviderInterface
{
    public function getWordList(): array
    {
        return [
            'stub', 'stub2'
        ];
    }
}