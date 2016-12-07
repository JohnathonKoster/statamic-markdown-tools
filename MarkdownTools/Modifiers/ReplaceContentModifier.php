<?php

namespace Statamic\Addons\MarkdownTools\Modifiers;

use Statamic\Extend\Extensible;
use Statamic\Addons\MarkdownTools\ModifierInterface;

class ReplaceContentModifier implements ModifierInterface
{
    use Extensible;

    protected $addon_name = 'MarkdownTools';

    /**
     * Replaces the configured
     *
     * @param  array $lines
     * @return string
     */
    public function modify(array $lines)
    {
        $replacements = $this->getConfig('replace');

        if ($replacements == null) {
            return null;
        }

        $newContent = '';

        foreach ($lines as $line) {
            $newContent .= str_replace(array_keys($replacements), array_values($replacements), $line);
        }

        return $newContent;

    }

}
