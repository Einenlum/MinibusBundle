<?php

namespace Knp\MinibusBundle\Routing\Reader;

use Knp\MinibusBundle\Path\BundlePathResolver;
use Knp\MinibusBundle\Yaml\YamlParser;
use Knp\MinibusBundle\Exception\MisstatedRouteException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * It read a yaml routing ressource and also resolve the content.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class YamlResourceReader
{
    /**
     * @var BundlePathResolver $pathResolver
     */
    private $pathResolver;

    /**
     * @var YamlParser $parser
     */
    private $parser;

    /**
     * @param BundlePathResolver $pathResolver
     * @param YamlParser         $parser
     */
    public function __construct(BundlePathResolver $pathResolver, YamlParser $parser = null)
    {
        $this->pathResolver = $pathResolver;
        $this->parser       = $parser ?: new YamlParser;
    }

    /**
     * Read a resource and "resolve" or "validate" it's content.
     *
     * @param string $resource
     *
     * @throws MisstatedRouteException
     *
     * @return array the parsed resource
     */
    public function read($resource)
    {
        $path      = $this->pathResolver->getPath($resource);
        $rawRoutes = $this->parser->parse($path);
        $routes    = [];

        foreach ($rawRoutes as $name => $attributes) {
            try {
                $validatedAttributes = $this->validateAttributes($attributes);
            } catch (\Exception $reason) {
                throw new MisstatedRouteException($name, $reason);
            }

            $routes[$name] = $validatedAttributes;
        }

        return $routes;
    }

    /**
     * @param array $attributes
     *
     * @return array resolved attributes
     */
    private function validateAttributes(array $attributes)
    {
        $resolver = new OptionsResolver;

        $resolver
            ->setRequired(['pattern', 'line', 'terminus'])
            ->setDefaults([
                'method'       => 'GET',
                'format'       => 'html',
                'condition'    => null,
                'host'         => null,
                'scheme'       => null,
                'defaults'     => [],
                'requirements' => []
            ])
            ->setAllowedTypes([
                'pattern'       => 'string',
                'line'         => 'array',
                'terminus'     => 'array',
                'method'       => ['string', 'array'],
                'format'       => 'string',
                'condition'    => ['string', 'null'],
                'host'         => ['string', 'null'],
                'scheme'       => ['string', 'null'],
                'defaults'     => 'array',
                'requirements' => 'array'
            ])
        ;

        return $resolver->resolve($attributes);
    }
}
