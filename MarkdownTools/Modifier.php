<?php

namespace Statamic\Addons\MarkdownTools;

class Modifier
{

    /**
     * A list of modifiers.
     *
     * @var array
     */
    protected $modifiers = [];

    /**
     * Add a new Modifier.
     *
     * @param ModifierInterface $modifier
     */
    public function addModifier(ModifierInterface $modifier)
    {
        $this->modifiers[] = $modifier;
    }

    /**
     * Returns a new string with normalized new line characters.
     *
     * @param  string $content
     * @return string
     */
    protected function normalizeNewLines($content)
    {
        return str_replace("\n", "\r\n", $content);
    }

    /**
     * Converst the string into an array of lines.
     *
     * @param  string $content
     * @return array
     */
    protected function convertIntoArray($content)
    {
        return explode("\n", $content);
    }

    public function modify($content)
    {
        $lines = $this->convertIntoArray($this->normalizeNewLines($content));

        /** @var ModifierInterface $modifier */
        foreach ($this->modifiers as $modifier) {
            $lines = $this->convertIntoArray($this->normalizeNewLines($modifier->modify($lines)));
        }

        return implode("\n", $lines);
    }

}