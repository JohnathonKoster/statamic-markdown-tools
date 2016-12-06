<?php

namespace Statamic\Addons\MarkdownTools;

use Illuminate\Http\Response;
use Statamic\Extend\Listener;

class MarkdownToolsListener extends Listener
{
    /**
     * The events to be listened for, and the methods to call.
     *
     * @var array
     */
    public $events = [
        'response.created' => 'runMarkdownTools'
    ];

    protected $modifier;

    public function __construct(Modifier $modifier)
    {
        parent::__construct();
        $this->modifier = $modifier;
    }

    public function runMarkdownTools(Response $response)
    {
        $content = $response->getContent();

        $response->setContent($this->modifier->modify($content));

        return $response;
    }

}
