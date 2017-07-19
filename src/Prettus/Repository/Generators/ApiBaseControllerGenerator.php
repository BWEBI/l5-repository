<?php
namespace Prettus\Repository\Generators;

/**
 * Class ApiBaseControllerGenerator
 * @package Prettus\Repository\Generators
 */
class ApiBaseControllerGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'controller/api-base-controller';

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
        return 'api-base';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/ApiBaseController.php';
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
            'appname' => $this->getAppNamespace(),
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

}
