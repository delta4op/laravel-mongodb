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
    }

    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        $baseDocumentName = config('defaultDocument', 'Delta4op\Mongodb\Documents\Document');
        $baseDocumentNameExplode = explode('\\', $baseDocumentName);
        $baseDocumentShortName = $baseDocumentNameExplode[count($baseDocumentNameExplode) - 1];

        $collection = $this->hasOption('collection')
            ? $this->option('collection')
            : Str::snake(Str::pluralStudly($this->argument('name')));

        $stub = str_replace('{{ collection }}', $collection, $stub);
        $stub = str_replace('{{ baseDocument }}', $baseDocumentName, $stub);
        $stub = str_replace('{{ baseDocumentShortName }}', $baseDocumentShortName, $stub);

        if(!$this->hasOption('collection')) {

            $name = $this->argument('name');

            $this->input->setArgument(
                'collection',
                Str::snake(Str::pluralStudly($name))
            );
        }



        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
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
            'mongodb.path',
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
            ['baseDocument', InputArgument::OPTIONAL, ''],
            ['baseDocumentShortName', InputArgument::OPTIONAL, ''],
        ];
    }
}
