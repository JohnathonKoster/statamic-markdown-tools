<?php

namespace Statamic\Addons\MarkdownTools;

interface ModifierInterface
{

    /**
     * Modifies the provided lines and returns a new string.
     *
     * @param  array $lines
     * @return string
     */
    public function modify(array $lines);

}