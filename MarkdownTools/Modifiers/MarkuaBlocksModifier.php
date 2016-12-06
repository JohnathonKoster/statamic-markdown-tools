<?php

namespace Statamic\Addons\MarkdownTools\Modifiers;

use Illuminate\Support\Str;
use Statamic\Addons\MarkdownTools\ModifierInterface;

class MarkuaBlocksModifier implements ModifierInterface
{

    const MARKUA_GENERAL_BLOCK = 'markua-general-block';

    /**
     * The Markua blocks to parse.
     *
     * @var array
     */
    protected $markuaBlocksToParse = [
        '<p data-markua-feature="general-block">',

        '<p data-markua-feature="info-block">',
        '<p data-markua-feature="aside-block">',
        '<p data-markua-feature="warning-block">',
        '<p data-markua-feature="tip-block">',
        '<p data-markua-feature="error-block">',
        '<p data-markua-feature="question-block">',
        '<p data-markua-feature="discussion-block">',
        '<p data-markua-feature="exercise-block">',
    ];

    /**
     * A mapping of the Markua blocks to convert.
     *
     * @var array
     */
    protected $markuaBlocks = [
        '<p>G> ' => '<p data-markua-feature="general-block">',
        'G> ' => '</p><p data-markua-feature="general-block">',
        'G>' => '</p><p data-markua-feature="general-block">',

        '<p>I> ' => '<p data-markua-feature="info-block">',
        'I> ' => '</p><p data-markua-feature="info-block">',
        'I>' => '</p><p data-markua-feature="info-block">',

        '<p>A> ' => '<p data-markua-feature="aside-block">',
        'A> ' => '</p><p data-markua-feature="aside-block">',
        'A>' => '</p><p data-markua-feature="aside-block">',

        '<p>W> ' => '<p data-markua-feature="warning-block">',
        'W> ' => '</p><p data-markua-feature="warning-block">',
        'W>' => '</p><p data-markua-feature="warning-block">',

        '<p>T> ' => '<p data-markua-feature="tip-block">',
        'T> ' => '</p><p data-markua-feature="tip-block">',
        'T>' => '</p><p data-markua-feature="tip-block">',

        '<p>E> ' => '<p data-markua-feature="error-block">',
        'E> ' => '</p><p data-markua-feature="error-block">',
        'E>' => '</p><p data-markua-feature="error-block">',

        '<p>Q> ' => '<p data-markua-feature="question-block">',
        'Q> ' => '</p><p data-markua-feature="question-block">',
        'Q>' => '</p><p data-markua-feature="question-block">',

        '<p>D> ' => '<p data-markua-feature="discussion-block">',
        'D> ' => '</p><p data-markua-feature="discussion-block">',
        'D>' => '</p><p data-markua-feature="discussion-block">',

        '<p>X> ' => '<p data-markua-feature="exercise-block">',
        'X> ' => '</p><p data-markua-feature="exercise-block">',
        'X>' => '</p><p data-markua-feature="exercise-block">',
    ];

    /**
     * Replaces Markua-formatted blocks within the given string.
     *
     * @param $string
     * @return string
     */
    private function replaceMarkuaBlocks($string)
    {
        return strtr($string, $this->markuaBlocks);
    }

    /**
     * Normalizes new lines within the given string.
     *
     * @param $string
     * @return mixed
     */
    private function normalizeNewLines($string)
    {
        return str_replace("\n", "\r\n", $string);
    }

    /**
     * Get the icon that should represent the block.
     *
     * @param $string
     * @return string
     */
    private function findMarkuaIcon($string)
    {
        $blockToReturn = 'aside-block';

        switch ($string) {
            case Str::contains($string, 'aside-block'):
                $blockToReturn = 'markua-aside-block';
                break;
            case Str::contains($string, 'warning-block'):
                $blockToReturn = 'fa fa-exclamation-triangle';
                break;
            case Str::contains($string, 'general-block'):
                $blockToReturn = self::MARKUA_GENERAL_BLOCK;
                break;
            case Str::contains($string, 'info-block'):
                $blockToReturn = 'fa fa-info-circle';
                break;
            case Str::contains($string, 'tip-block'):
                $blockToReturn = 'fa fa-key';
                break;
            case Str::contains($string, 'error-block'):
                $blockToReturn = 'fa fa-bug';
                break;
            case Str::contains($string, 'question-block'):
                $blockToReturn = 'fa fa-question-circle';
                break;
            case Str::contains($string, 'discussion-block'):
                $blockToReturn = 'fa fa-comments';
                break;
            case Str::contains($string, 'exercise-block'):
                $blockToReturn = 'fa fa-pencil';
                break;
        }

        return $blockToReturn;
    }

    /**
     * Returns a targetable class that represents the current Markua block.
     *
     * @param  string $string
     * @return string
     */
    private function findWhatMarkuaBlockWeAreParsing($string)
    {
        $blockToReturn = 'aside-block';

        switch ($string) {
            case Str::contains($string, 'aside-block'):
                $blockToReturn = 'markua-aside-block';
                break;
            case Str::contains($string, 'warning-block'):
                $blockToReturn = 'markua-warning-block';
                break;
            case Str::contains($string, 'general-block'):
                $blockToReturn = 'markua-general-block';
                break;
            case Str::contains($string, 'info-block'):
                $blockToReturn = 'markua-info-block';
                break;
            case Str::contains($string, 'tip-block'):
                $blockToReturn = 'markua-tip-block';
                break;
            case Str::contains($string, 'error-block'):
                $blockToReturn = 'markua-error-block';
                break;
            case Str::contains($string, 'question-block'):
                $blockToReturn = 'markua-question-block';
                break;
            case Str::contains($string, 'discussion-block'):
                $blockToReturn = 'markua-discussion-block';
                break;
            case Str::contains($string, 'exercise-block'):
                $blockToReturn = 'markua-exercise-block';
                break;
        }

        return $blockToReturn;
    }

    /**
     * Parses the Markua-style formatted blocks.
     *
     * @param  array $lines
     * @return string
     */
    private function parseMarkuaBlocks(array $lines)
    {
        $newContents = "";
        $lastLine = null;
        $nextLine = null;
        $currentIndex = 0;

        foreach ($lines as $currentContent) {
            $originalContent = $currentContent;
            $currentContent = $this->replaceMarkuaBlocks($currentContent);

            if (array_key_exists($currentIndex - 1, $lines)) {
                $lastLine = $lines[$currentIndex - 1];
            } else {
                $lastLine = null;
            }

            if (array_key_exists($currentIndex + 1, $lines)) {
                $nextLine = $lines[$currentIndex + 1];
            } else {
                $nextLine = null;
            }

            if (Str::contains($currentContent, $this->markuaBlocksToParse)
                && (
                    strlen(trim($lastLine)) == 0
                    || Str::startsWith($lastLine, '<p>{icon=')
                )
            ) {

                $icon = null;

                // If the last line contains an icon instruction, we will extract
                // the icon that we should be using for a general block. We will
                // also remove the last line so that it doesn't appear in the
                // final, generated, output.
                if (Str::startsWith($lastLine, '<p>{icon=')) {
                    $icon = mb_substr($lastLine, 9, -2);
                    $newContents = mb_substr($newContents, 0, (-1 * strlen($lastLine)) -1 );
                }

                $markuaBlock = $this->findWhatMarkuaBlockWeAreParsing($currentContent);

                $newContents .= '<div class="markua-block '.$markuaBlock.'">';

                $newContents .= '<div class="markua-feature-icon">';

                if ($markuaBlock === self::MARKUA_GENERAL_BLOCK && $icon !== null) {
                    $newContents .= '<span class="fa fa-'.$icon.'"></span>';
                } else {
                    $newContents .= '<span class="'.$this->findMarkuaIcon($currentContent).'"></span>';
                }

                $newContents .= '</div>';

                $newContents .= '<div class="markua-feature-content '.$markuaBlock.'">';

                $isHeader = Str::contains($currentContent, '#');
                $currentContent = str_replace('#', '', $currentContent);

                if ($isHeader) {
                    $currentContent = str_replace('<p data-markua-feature', '<p data-markua-style="block-header" data-markua-feature', $currentContent);
                    // dd($currentContent);
                }

                if (Str::startsWith($lastLine, '<p>{icon=')) {
                    $currentContent = mb_substr($currentContent, 4);
                }

                $newContents .= $currentContent;

            } else {
                $newContents .= $currentContent ;

            }

            if (Str::contains($currentContent, $this->markuaBlocksToParse) && strlen(trim($nextLine)) == 0) {
                $newContents .= '</div></div>';
            }

            $currentIndex++;
        }


        return $newContents;
    }


    /**
     * Formats Markua-style markdown blocks.
     *
     * @param  array $lines
     * @return string
     */
    public function modify(array $lines)
    {
        return $this->parseMarkuaBlocks($lines);
    }

}