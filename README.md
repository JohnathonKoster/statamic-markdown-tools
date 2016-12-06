# Markdown Tools for Statamic

The Markdown Tools addon is simply a collection of modifiers for the generated markdown output. These can be used to accomplish the following:

* Minify the generated output before it's sent to your visitors;
* Convert LeanPub Markua style blocks (like errors, warnings, etc) into nicely formatted HTML blocks (convenient if you write a lot using the Markua/LeanPub flavored markdown syntax);
* More to surely come in the future!

## Installation

Copy the `MarkdownTools` folder into your `site/addons` folder. That should be all you have to do.

## Configuration

The Markdown Tools addon allows you to specify which modifiers should run, and probably more importantly, which order they should run in. To do this, create a new settings file located at `site/settings/addons/markdown_tools.yaml`. This settings file should contain something similar to this:

```yaml
modifiers:
  - 'markua-blocks'
  - 'content-minifier'
```

It is by modifying the `modifiers` setting value that we can control which modifiers run and in what order. Use the following table to figure out the setting name of the modifiers:

| Modifier | Description | Setting Name | Class |
|---|---|---|---|
| Content Minifier | Minifies the generated output. | `content-minifier` | `Statamic\Addons\MarkdownTools\Modifiers\ContentMinifierModifier` |
| Markua Blocks | Converts Markua flavored markdown blocks to HTML that can be styled. | `markua-blocks` | `Statamic\Addons\MarkdownTools\Modifiers\MarkuaBlocksModifier` |