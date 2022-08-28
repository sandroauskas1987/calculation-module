<?php

namespace App\Services;

use App\Rules\SlimFile;
use App\Rules\SlimFileMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory;

class ValidatorService
{
    private $factory;

    public function __construct()
    {
        $this->factory = new Factory($this->loadTranslator());
        $this->factory->setPresenceVerifier(new DatabasePresenceVerifier(Model::getConnectionResolver()));
        $this->factory->setContainer(\Illuminate\Container\Container::getInstance());
        $this->factory->extend('slim_file', SlimFile::class);
        $this->factory->extend('slim_file_media', SlimFileMedia::class);
    }

    protected function loadTranslator(): Translator
    {
        $filesystem = new Filesystem();
        $loader     = new FileLoader($filesystem, BASE_PATH . 'lang');
        $loader->addNamespace('lang', BASE_PATH . 'lang');
        $loader->load('ru', 'validation', 'lang');

        return new Translator($loader, 'ru');
    }

    public function __call($method, $args)
    {
        return call_user_func_array(
            [$this->factory, $method],
            $args
        );
    }

    public function validated(...$args)
    {
        $validator = $this->factory->make(...$args);
        return $validator->validated();
    }
}