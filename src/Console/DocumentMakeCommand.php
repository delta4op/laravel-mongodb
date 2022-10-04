<?php

namespace Delta4op\Mongodb\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class DocumentMakeCommand extends GeneratorCommand
{
    public $signature = 'make:document {name} {--c|collection=} {--e|embedded}';

    public $description = 'Create a new document class';

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    protected function isEmbeddedDocument(): bool
    {
        return $this->options()['embedded'] === true;
    }

    public function getBaseDocumentName()
    {
        return $this->isEmbeddedDocument()
            ? config('makeDocument.baseEmbeddedDocument', 'Delta4op\Mongodb\Documents\EmbeddedDocument')
            : config('makeDocument.baseDocument', 'Delta4op\Mongodb\Documents\Document');
    }

    /**
     * @return string
     */
    public function getBaseDocumentShortName(): string
    {
        $baseDocumentNameExplode = explode('\\', $this->getBaseDocumentName());
        return $baseDocumentNameExplode[count($baseDocumentNameExplode) - 1];
    }

    /**
     * @return bool|array|string|null
     */
    protected function getCollectionName(): bool|array|string|null
    {
        return $this->hasOption('collection')
            ? $this->option('collection')
            : Str::snake(Str::pluralStudly($this->argument('name')));
    }

    /**
     * @param $name
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        dd($this->getBaseDocumentName());
        $stub = str_replace('{{ baseDocument }}', $this->getBaseDocumentName(), $stub);
        $stub = str_replace('{{ baseDocumentShortName }}', $this->getBaseDocumentShortName(), $stub);

        if(!$this->isEmbeddedDocument()) {
            $stub = str_replace('{{ collection }}', $this->getCollectionName(), $stub);
        }

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        $relativePath = $this->isEmbeddedDocument()
            ? '/stubs/embeddedDocument.stub'
            : '/stubs/document.stub';

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
        ];
    }
}
