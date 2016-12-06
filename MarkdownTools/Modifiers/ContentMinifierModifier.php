<?php

namespace Statamic\Addons\MarkdownTools\Modifiers;

use Statamic\Addons\MarkdownTools\ModifierInterface;

class ContentMinifierModifier implements ModifierInterface
{

    /**
     * Determines whether or not the content should be minified.
     *
     * @param  string $content
     * @return bool
     */
    protected function shouldCompile($content)
    {
        if (preg_match('/skipmin/', $content)
            || preg_match('/<(pre|textarea)/', $content)
            || preg_match('/<script[^\??>]*>[^<\/script>]/', $content)
            || preg_match('/value=("|\')(.*)([ ]{2,})(.*)("|\')/', $content)
        ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Minfies the content.
     *
     * @param  string $content
     * @return string
     */
    protected function compile($content)
    {
        if ($this->shouldCompile($content)) {
            $replace = [
                //'/<!--[^\[](.*?)[^\]]-->/s' => '',
                "/<\?php/" => '<?php ',
                "/\n([\S])/" => ' $1',
                "/\r/" => '',
                "/\n/" => '',
                "/\t/" => ' ',
                "/ +/" => ' ',
            ];

            return preg_replace(array_keys($replace), array_values($replace), $content);
        }

        return $content;
    }

    /**
     * Minifies the content.
     *
     * @param  array $lines
     * @return string
     */
    public function modify(array $lines)
    {
        return $this->compile(implode("\n", $lines));
    }

}
