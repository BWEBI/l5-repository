<?php
namespace Prettus\Repository\Generators;

/**
 * Class TestGenerator
 * @package Prettus\Repository\Generators
 */
class TestGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'test/api-test';

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
        return 'tests';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . $this->getTestName() . 'Test.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return app()->basePath() . '/tests/'.config('repository.generator.paths.'.$this->getPathConfigNode(), app()->path());
    }

    /**
     * Gets test name based on model
     *
     * @return string
     */
    public function getTestName()
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
            'test'       => $this->getTestName(),
            'fillable'   => $this->getFillableInfo(),
            'plural'     => $this->getPluralName(),
            'singular'   => $this->getSingularName(),
            'appname'    => $this->getAppNamespace(),
            'path'       => config('repository.generator.paths.'.$this->getPathConfigNode())
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
     * Get the fillable attributes info.
     *
     * @return string
     */
    public function getFillableInfo()
    {
        $results = '[' . PHP_EOL;
dd($this->fillable);
        if (!$this->fillable) {
            $results .= "\t\t\t'// Add data (key => value) to test'";
        } else {
            foreach ($this->getSchemaParser()->toArray() as $column => $value) {
                $results .= "\t\t'{$column}' => ''," . PHP_EOL;
            }
        }

        return $results . PHP_EOL . "\t\t" . ']';
    }

    /**
     * Get schema parser.
     *
     * @return SchemaParser
     */
    public function getSchemaParser()
    {
        return new SchemaParser($this->fillable);
    }

}
