<?php
namespace Prettus\Repository\Generators;

/**
 * Class FactoryGenerator
 * @package Prettus\Repository\Generators
 */
class FakerGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'faker/factory';


    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . $this->getFactoryName() . 'Factory.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return app()->basePath() . '/database/factories/';
    }

    /**
     * Gets factory name based on model
     *
     * @return string
     */
    public function getFactoryName()
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
            'entity'     => $this->getFactoryName(),
            'plural'     => $this->getPluralName(),
            'singular'   => $this->getSingularName(),
            'appname'    => $this->getAppNamespace(),
            'model'      => config('repository.generator.paths.models')
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
     * @return mixed
     */
    public function getPathConfigNode()
    {
        return '';
    }
}
