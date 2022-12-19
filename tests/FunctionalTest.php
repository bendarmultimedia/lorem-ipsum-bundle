<?php

namespace KnpU\LoremIpsumBundle\Tests;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use KnpU\LoremIpsumBundle\KnpUIpsum;
use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use KnpU\LoremIpsumBundle\KnpUWordProvider;
use KnpU\LoremIpsumBundle\WordProviderInterface;
use PHPUnit\Framework\TestCase;

class FunctionalTest extends TestCase
{
    public function testServiceWiring()
    {
        $kernel = new KnpULoremIpsumTestingKernel();
        $kernel->boot();
        $container = $kernel->getContainer();

        $ipsum = $container->get('knpu_lorem_ipsum.knpu_ipsum');
        $this->assertInstanceOf(KnpUIpsum::class, $ipsum);
        $this->assertIsString($ipsum->getParagraphs());
    }
    public function testServiceWiringWithConfiguration()
    {
        $kernel = new KnpULoremIpsumTestingKernel([
            'word_provider' => 'stub_word_list'
        ]);
        $kernel->boot();
        $container = $kernel->getContainer();

        $ipsum = $container->get('knpu_lorem_ipsum.knpu_ipsum');
        $this->assertStringContainsString('test', $ipsum->getWords(3));
    }
}

class KnpULoremIpsumTestingKernel extends Kernel
{
    private $knpuIpusmConfig;
    public function __construct(array $knpuIpsumConfig = [])
    {
        $this->knpuIpusmConfig = $knpuIpsumConfig;
        parent::__construct('test', true);
    }


    public function registerBundles()
    {
        return [
            new KnpULoremIpsumBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->register('stub_word_list', StubWordList::class);
            // load configs
            $container->loadFromExtension('knpu_lorem_ipsum', $this->knpuIpusmConfig);
        });
    }

    public function getCacheDir()
    {
        return __DIR__ . '/../var/cache/' . spl_object_hash($this);
    }

}

class StubWordList implements WordProviderInterface
{
    public function getWordList(): array
    {
        return ['test', 'words'];
    }
}
