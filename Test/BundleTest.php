<?php

class BundleTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testInitBundle()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        // Test if the service exists
        self::assertTrue($container->has('white_october_breadcrumbs.helper'));

        $service = $container->get('white_october_breadcrumbs.helper');
        self::assertInstanceOf(\WhiteOctober\BreadcrumbsBundle\Templating\Helper\BreadcrumbsHelper::class, $service);
    }

    public function testRendering()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        /** @var \WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs $service */
        $service = static::$container->get(WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs::class);
        $service->addItem('foo');

        /** @var \WhiteOctober\BreadcrumbsBundle\Twig\Extension\BreadcrumbsExtension $breadcrumbsExtension */
        $breadcrumbsExtension = $container->get('white_october_breadcrumbs.twig');

        self::assertSame(
            '<ol id="wo-breadcrumbs" class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList"><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">foo</span><meta itemprop="position" content="1" /></li></ol>',
            $breadcrumbsExtension->renderBreadcrumbs()
        );
    }

    public static function getKernelClass()
    {
        return \WhiteOctober\BreadcrumbsBundle\Test\AppKernel::class;
    }
}
