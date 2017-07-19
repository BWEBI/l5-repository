<?php
namespace Prettus\Repository\Generators;

/**
 * Class ApiControllerGenerator
 * @package Prettus\Repository\Generators
 */
class ApiControllerGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'controller/api-controller';

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return str_replace('/', '\\', parent::getRootNamespace() . parent::getConfigGeneratorClassPath($this->getPathConfigNode()));
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'api-controllers';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . $this->getApiName() . 'ApiController.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return config('repository.generator.basePath', app()->path());
    }

    /**
     * Gets api name based on model
     *
     * @return string
     */
    public function getApiName()
    {

        return ucfirst($this->getSingularName());
    }

    /**
     * Gets plural name based on model
     *
     * @return string
     */
    public function getPluralName()
    {

        return str_plural(lcfirst(ucwords($this->getClass())));
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {

        return array_merge(parent::getReplacements(), [
            'api'       => $this->getApiName(),
            'plural'    => $this->getPluralName(),
            'singular'  => $this->getSingularName(),
            'service'   => $this->getService(),
            'appname'   => $this->getAppNamespace(),
        ]);
    }

    /**
     * Gets singular name based on model
     *
     * @return string
     */
    public function getSingularName()
    {
        return str_singular(lcfirst(ucwords($this->getClass())));
    }

    /**
     * Gets service full class name
     *
     * @return string
     */
    public function getService()
    {
        $serviceGenerator = new ServiceGenerator([
            'name' => $this->name,
        ]);

        $service = $serviceGenerator->getRootNamespace() . '\\' . $serviceGenerator->getName();

        return 'use ' . str_replace([
            "\\",
            '/'
        ], '\\', $service) . 'Service;';
    }

}
