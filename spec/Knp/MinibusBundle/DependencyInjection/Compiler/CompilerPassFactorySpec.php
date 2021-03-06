<?php

namespace spec\Knp\MinibusBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CompilerPassFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\MinibusBundle\DependencyInjection\Compiler\CompilerPassFactory');
    }

    function it_create_station_registration_pass()
    {
        $this->createStationRegistration()->shouldHaveType('Knp\MinibusBundle\DependencyInjection\Compiler\RegisterStationPass');
    }

    function it_create_terminus_registration_pass()
    {
        $this->createTerminusRegistration()->shouldHaveType('Knp\MinibusBundle\DependencyInjection\Compiler\RegisterTerminusPass');
    }

    function it_create_auto_station_registration_pass(
        Bundle $bundle
    ) {
        $this->createAutoStationRegistration($bundle)->shouldHaveType('Knp\MinibusBundle\DependencyInjection\Compiler\AutoRegisterStationPass');
    }

    function it_create_auto_terminus_registration_pass(
        Bundle $bundle
    ) {
        $this->createAutoTerminusRegistration($bundle)->shouldHaveType('Knp\MinibusBundle\DependencyInjection\Compiler\AutoRegisterTerminusPass');
    }
}
