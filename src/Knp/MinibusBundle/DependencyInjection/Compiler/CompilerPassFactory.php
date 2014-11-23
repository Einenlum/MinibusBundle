<?php

namespace Knp\MinibusBundle\DependencyInjection\Compiler;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Knp\MinibusBundle\Finder\ClassFinder;
use Knp\MinibusBundle\DependencyInjection\DefinitionFactory;
use Knp\MinibusBundle\DependencyInjection\Compiler\RegisterTerminusPass;
use Knp\MinibusBundle\DependencyInjection\Compiler\AutoRegisterStationPass;

/**
 * For SOLID principle convenient, and to disable any contributor to create
 * compiler pass by hand, this factory can create any MinibusBundle compiler
 * pass.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class CompilerPassFactory
{
    /**
     * @return RegisterStationPass
     */
    public function createStationRegistration()
    {
        return new RegisterStationPass;
    }

    /**
     * @return RegisterTerminusPass
     */
    public function createTerminusRegistration()
    {
        return new RegisterTerminusPass;
    }

    /**
     * @param BundleInterface $bundle
     *
     * @return AutoRegisterStationPass
     */
    public function createAutoStationRegistration(Bundle $bundle)
    {
        return new AutoRegisterStationPass($bundle);
    }
}
