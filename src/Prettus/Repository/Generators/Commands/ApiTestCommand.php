<?php
namespace Prettus\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Prettus\Repository\Exceptions\ClassExistsException;
use Prettus\Repository\Generators\FileAlreadyExistsException;
use Prettus\Repository\Generators\TestGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ApiTestCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'make:api-test';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new test API class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Test';


    /**
     * Execute the command.
     *
     * @throws FileAlreadyExistsException
     * @throws ClassExistsException
     *
     * @return void
     */
    public function fire()
    {
        try {
            (new TestGenerator([
                'name'          => $this->argument('name'),
                'force'         => $this->option('force'),
                '--fillable'    => $this->option('fillable'),
            ]))->run();
            $this->info($this->type . ' created successfully.');

            $this->call('make:faker', [
                'name'    => $this->argument('name'),
                '--force' => $this->option('force')
            ]);
        } catch (FileAlreadyExistsException $e) {
            $this->error($this->type . ' already exists!');

            return false;
        }
    }


    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of model for which the controller is being generated.',
                null
            ],
        ];
    }


    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            [
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null
            ],
            [
                'fillable',
                null,
                InputOption::VALUE_OPTIONAL,
                'The fillable attributes.',
                null
            ],
        ];
    }
}
