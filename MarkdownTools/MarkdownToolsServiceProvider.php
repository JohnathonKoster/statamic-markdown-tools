<?php

namespace Statamic\Addons\MarkdownTools;

use Illuminate\Support\Str;
use Statamic\Extend\Extensible;
use Illuminate\Support\ServiceProvider;

class MarkdownToolsServiceProvider extends ServiceProvider
{
    use Extensible;

    protected $addon_name = 'MarkdownTools';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Modifier::class, function ($app) {
            $modifier = new Modifier;

            foreach ($this->getConfig('modifiers') as $modifierClass) {
                $modifierClass = Str::studly($modifierClass);
                $modifierClass = "\\Statamic\\Addons\\MarkdownTools\\Modifiers\\{$modifierClass}Modifier";
                $modifier->addModifier(new $modifierClass);
            }

            return $modifier;
        });
    }

}