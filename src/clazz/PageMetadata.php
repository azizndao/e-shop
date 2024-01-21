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

    /**
     * Retrieves the description of the page.
     *
     * @return string The description of the page.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Retrieves the scripts associated with the page.
     *
     * @return array The array of scripts.
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }

    /**
     * Retrieves the CSS files associated with the page.
     *
     * @return array An array of CSS file paths.
     */
    public function getCss(): array
    {
        return $this->css;
    }
}
