<?php

namespace Statamic\Addons\MarkdownTools;

use Illuminate\Support\ServiceProvider;

class MarkdownToolsServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Modifier::class, function ($app) {
            $modifier = new Modifier;
            $modifier->addModifier(new Modifiers\MarkuaBlocksModifier);
            $modifier->addModifier(new Modifiers\ContentMinifierModifier);
            return $modifier;
        });
    }

}