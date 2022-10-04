<?php

namespace Delta4op\Mongodb\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class DocumentMakeCommand extends GeneratorCommand
{
    public $signature = 'make:document {name} {--collection=}';

    public $description = 'Create a new document class';

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);

        if(!$this->hasArgument('collection')) {

            $name = $this->argument('name');

            $this->addArgument(
                'collection',
                Str::snake(Str::pluralStudly($name))
            );
        }
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        $relativePath = '/stubs/document.stub';

        return __DIR__.$relativePath;
    }

    /**
     * @param $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return config(
            'mongodb.defaultDocument',
            $rootNamespace.'\Mongo\Documents'
        );
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['class', InputArgument::REQUIRED, 'The name of the document class'],
            ['collection', InputArgument::REQUIRED, 'The name of the collection'],
        ];
    }
}
