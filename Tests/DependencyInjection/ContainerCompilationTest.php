<?php

/*
 * This file is part of the XabbuhPandaBundle package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xabbuh\PandaBundle\Tests\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Xabbuh\PandaBundle\Tests\DependencyInjection\Kernel;

class ContainerCompilationTest extends KernelTestCase
{
    public function testServicesCanBeBuilt()
    {
        $container = $this->bootKernel()->getContainer();

        foreach ($container->getParameter('xabbuh_panda.test_service_aliases') as $id => $type) {
            $this->assertInstanceOf($type, $container->get($id, ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE));
        }
    }

    /**
     * @group legacy
     */
    public function testDeprecatedServicesCanBeBuilt()
    {
        $container = $this->bootKernel()->getContainer();

        foreach ($container->getParameter('xabbuh_panda.deprecated_test_service_aliases') as $id => $type) {
            $this->assertInstanceOf($type, $container->get($id, ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE));
        }
    }

    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }
}
