<?php

namespace spec\Knp\MinibusBundle\Bundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\MinibusBundle\DependencyInjection\Compiler\PassFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Knp\MinibusBundle\DependencyInjection\Compiler\CompilerPassFactory;

class MinibusBundleSpec extends ObjectBehavior
{
    function let(CompilerPassFactory $passFactory)
    {
        $this->beConstructedWith($passFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\MinibusBundle\Bundle\MinibusBundle');
    }

    function it_is_a_bundle()
    {
        $this->shouldHaveType('Symfony\Component\HttpKernel\Bundle\Bundle');
    }

    function it_register_the_auto_station_registration_pass(
        $passFactory,
        CompilerPassInterface $pass,
        ContainerBuilder $container
    ) {
        $passFactory->createAutoStationRegistration($this)->willReturn($pass);
        $container->addCompilerPass($pass)->shouldBeCalled();

        $this->build($container);
    }
}
