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

## Markua Blocks Modifier

The Markua Blocks modifier (`markua-blocks`) converts LeanPub flavored markdown/Markua blocks to HTML that can be styled using your theme. For example:

```
T> ## This is a Tip
T>
T> To make a tip, put `T>` at the beginning of the lines of
T> the tip, similar to the `>` that you use for a blockquote.
T>
T> To make paragraphs in a tip, you need to put lines
T> with just `T>` between your paragraphs.
```

would be converted to:

```html
<div class="markua-block markua-tip-block">
  <div class="markua-feature-icon"><span class="fa fa-key"></span></div>
  <div class="markua-feature-content markua-tip-block">
    <p data-markua-style="block-header" data-markua-feature="tip-block"> This is a Tip</p>
    <p data-markua-feature="tip-block"> </p>
    <p data-markua-feature="tip-block">To make a tip, put <code>T&gt;</code> at the beginning of the lines of </p>
    <p data-markua-feature="tip-block">the tip, similar to the <code>&gt;</code> that you use for a blockquote. </p>
    <p data-markua-feature="tip-block"> </p>
    <p data-markua-feature="tip-block">To make paragraphs in a tip, you need to put lines </p>
    <p data-markua-feature="tip-block">with just <code>T&gt;</code> between your paragraphs.</p>
  </div>
</div>
```

The following CSS can be used in your themes to style the generated blocks:

```css
.markua-feature-icon {
  display: table-cell;
  vertical-align: top;
  font-size: 2em;
  width: 2em;
  text-align: center;
  padding-top: 0.3em;
}
.markua-block {
  padding: 10px 20px;
  margin: 0 0 20px;
  font-size: 17.5px;
}
.markua-block.markua-aside-block {
  border: 1px solid #eee;
  margin-left: 40px;
  margin-right: 40px;
  padding-left: 0;
  padding-right: 0;
}
.markua-feature-content {
  display: table-cell;
  vertical-align: top;
  padding-left: 20px;
}
.markua-feature-content [data-markua-style="block-header"] {
  font-weight: 400;
  font-family: 'Droid Sans', sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
}
.markua-feature-content [data-markua-feature="aside-block"],
.markua-feature-content [data-markua-feature="warning-block"],
.markua-feature-content [data-markua-feature="general-block"],
.markua-feature-content [data-markua-feature="tip-block"],
.markua-feature-content [data-markua-feature="error-block"],
.markua-feature-content [data-markua-feature="info-block"],
.markua-feature-content [data-markua-feature="question-block"],
.markua-feature-content [data-markua-feature="discussion-block"],
.markua-feature-content [data-markua-feature="exercise-block"] {
  margin-bottom: 0 !important;
  margin-top: 0 !important;
}

```

Just like when working with LeanPub, this modifier makes use of the [Font Aesome](http://fontawesome.io/) CSS font. Make sure to include it in your theme to get the icons to show up.

If you want a convenient place to test out your styles on the generated output of this modifier, simply fork the following pen CodePen:

[http://codepen.io/JohnathonKoster/pen/mOLrKp](http://codepen.io/JohnathonKoster/pen/mOLrKp)