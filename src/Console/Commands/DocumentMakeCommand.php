<?php

namespace Delta4op\Mongodb\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class DocumentMakeCommand extends GeneratorCommand
{
    public $signature = 'make:document';

    public $description = 'Command to create mongo document';

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
        return $rootNamespace.'\Mongo\Documents';
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
