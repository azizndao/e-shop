<?php


namespace App\clazz;


class PageMetadata
{

    private string $title;
    private string $description;
    private array $scripts;
    private array $css;


    public function __construct(
        string $title,
        string $description = '',
        array $scripts = [],
        array $css = []
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->scripts = $scripts;
        $this->css = $css;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getScripts(): array
    {
        return $this->scripts;
    }

    public function getCss(): array
    {
        return $this->css;
    }
}
