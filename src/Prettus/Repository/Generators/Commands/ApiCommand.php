<?php
namespace Prettus\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Prettus\Repository\Generators\ApiBaseControllerGenerator;
use Prettus\Repository\Generators\ApiControllerGenerator;
use Prettus\Repository\Generators\FileAlreadyExistsException;
use Prettus\Repository\Generators\TestGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ApiCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'make:api';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new RESTfull API controller.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'API Controller';


    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        try {
            // Generate a service for the api controller
            $this->call('make:service', [
                'name' => $this->argument('name'),
                '--force' => $this->option('force'),
            ]);

            (new ApiControllerGenerator([
                'name' => $this->argument('name'),
                '--force' => $this->option('force'),
            ]))->run();
            $this->info($this->type . ' created successfully.');

            (new ApiBaseControllerGenerator())->run();
            $this->info('API base controller created successfully.');

            if ($this->confirm('Would you like to create a Test API Class? [y|N]')) {
                $this->call('make:api-test', [
                    'name'    => $this->argument('name'),
                    '--force' => $this->option('force')
                ]);
            }
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
                'The name of model for which the api controller is being generated.',
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
        ];
    }
}
