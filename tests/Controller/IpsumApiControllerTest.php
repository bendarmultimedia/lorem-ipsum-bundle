<?php

namespace KnpU\LoremIpsumBundle\Test\Controller;

use KnpU\LoremIpsumBundle\KnpUIpsum;
use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\HttpKernelBrowser;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;

class IpsumApiControllerTest extends TestCase
{
    public function testIndex()
    {
        $kernel = new KnpULoremIpsumControllerKernel();
        $client = new HttpKernelBrowser($kernel);

        $client->request('GET', '/api/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}

class KnpULoremIpsumControllerKernel extends Kernel
{
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }


    public function registerBundles()
    {
        return [
            new KnpULoremIpsumBundle(),
            new FrameworkBundle(),
        ];
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import(__DIR__ . '/../../src/Resources/config/routes.xml', '/api');
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->loadFromExtension('framework', [
            'secret' => 'F00BAR',
            // 'routing' => ['utf8' => true],
        ]);
    }

    public function getCacheDir()
    {
        return __DIR__ . '/../var/cache/' . spl_object_hash($this);
    }

}