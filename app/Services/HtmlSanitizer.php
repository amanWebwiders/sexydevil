<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Allowlist-based HTML sanitizer for rich text written in the admin editor.
 *
 * Anything not explicitly allowed is removed: unknown tags are unwrapped (their text is kept),
 * dangerous tags are dropped with their content, every attribute is checked against a per-tag
 * allowlist, URLs are restricted to safe schemes and iframes to known video hosts.
 */
class HtmlSanitizer
{
    /** tag => allowed attributes (on top of the global ones) */
    private const TAGS = [
        'p' => [], 'br' => [], 'hr' => [], 'div' => [], 'span' => [],
        'h1' => [], 'h2' => [], 'h3' => [], 'h4' => [], 'h5' => [], 'h6' => [],
        'strong' => [], 'b' => [], 'em' => [], 'i' => [], 'u' => [], 's' => [], 'strike' => [], 'del' => [],
        'ins' => [], 'sub' => [], 'sup' => [], 'mark' => [], 'small' => [], 'abbr' => [], 'cite' => [], 'q' => [],
        'blockquote' => [], 'pre' => [], 'code' => [],
        'ul' => [], 'ol' => ['start', 'type', 'reversed'], 'li' => [],
        'a' => ['href', 'target', 'rel', 'name'],
        'img' => ['src', 'alt', 'width', 'height', 'loading'],
        'figure' => [], 'figcaption' => [],
        'table' => ['border', 'cellpadding', 'cellspacing', 'width'], 'caption' => [],
        'thead' => [], 'tbody' => [], 'tfoot' => [], 'tr' => [],
        'th' => ['colspan', 'rowspan', 'scope', 'width'], 'td' => ['colspan', 'rowspan', 'width'],
        'colgroup' => ['span'], 'col' => ['span', 'width'],
        'iframe' => ['src', 'width', 'height', 'allowfullscreen', 'frameborder', 'allow', 'loading'],
        'video' => ['src', 'controls', 'width', 'height', 'poster', 'preload', 'playsinline', 'muted', 'loop'],
        'source' => ['src', 'type'],
    ];

    private const GLOBAL_ATTRIBUTES = ['style', 'class', 'title', 'dir', 'lang'];

    /** Removed together with everything inside them. */
    private const DROP_WITH_CONTENT = [
        'script', 'style', 'object', 'embed', 'applet', 'form', 'input', 'button', 'textarea', 'select', 'option',
        'svg', 'math', 'template', 'noscript', 'link', 'meta', 'base', 'frame', 'frameset', 'head', 'title',
    ];

    private const URL_ATTRIBUTES = ['href', 'src', 'poster'];

    private const SAFE_LINK_SCHEMES = ['http', 'https', 'mailto', 'tel'];

    private const SAFE_MEDIA_SCHEMES = ['http', 'https'];

    private const IFRAME_HOSTS = [
        'www.youtube.com', 'youtube.com', 'www.youtube-nocookie.com', 'youtube-nocookie.com',
        'player.vimeo.com', 'www.dailymotion.com', 'dailymotion.com',
    ];

    private const STYLE_PROPERTIES = [
        'text-align', 'color', 'background-color', 'text-decoration', 'font-weight', 'font-style', 'font-size',
        'width', 'height', 'max-width', 'min-width', 'float', 'vertical-align', 'list-style-type',
        'margin', 'margin-left', 'margin-right', 'margin-top', 'margin-bottom',
        'padding', 'padding-left', 'padding-right', 'padding-top', 'padding-bottom',
        'border', 'border-width', 'border-style', 'border-color', 'border-collapse', 'border-spacing',
        'display', 'line-height', 'white-space',
    ];

    public function clean(?string $html): string
    {
        $html = trim((string) $html);
        if ($html === '') {
            return '';
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML(
            '<?xml encoding="UTF-8"?><div id="__sanitizer_root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $document->getElementById('__sanitizer_root');
        if (!$root) {
            return '';
        }

        $this->cleanChildren($root);

        $output = '';
        foreach ($root->childNodes as $child) {
            $output .= $document->saveHTML($child);
        }

        return trim($output);
    }

    private function cleanChildren(DOMNode $node): void
    {
        // Iterate over a static copy: children are removed / unwrapped while walking.
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child->nodeType === XML_TEXT_NODE || $child->nodeType === XML_CDATA_SECTION_NODE) {
                continue;
            }

            if (!$child instanceof DOMElement) {
                // Comments, processing instructions, etc.
                $node->removeChild($child);
                continue;
            }

            $tag = strtolower($child->nodeName);

            if (in_array($tag, self::DROP_WITH_CONTENT, true)) {
                $node->removeChild($child);
                continue;
            }

            if (!array_key_exists($tag, self::TAGS)) {
                $this->cleanChildren($child);
                while ($child->firstChild) {
                    $node->insertBefore($child->firstChild, $child);
                }
                $node->removeChild($child);
                continue;
            }

            if (!$this->cleanAttributes($child, $tag)) {
                $node->removeChild($child);
                continue;
            }

            $this->cleanChildren($child);
        }
    }

    /**
     * @return bool false when the element itself must be removed (e.g. iframe from an unknown host)
     */
    private function cleanAttributes(DOMElement $element, string $tag): bool
    {
        $allowed = array_merge(self::GLOBAL_ATTRIBUTES, self::TAGS[$tag]);

        foreach (iterator_to_array($element->attributes) as $attribute) {
            $name = strtolower($attribute->nodeName);
            $value = $attribute->nodeValue;

            if (!in_array($name, $allowed, true)) {
                $element->removeAttribute($attribute->nodeName);
                continue;
            }

            if (in_array($name, self::URL_ATTRIBUTES, true)) {
                $schemes = $tag === 'a' ? self::SAFE_LINK_SCHEMES : self::SAFE_MEDIA_SCHEMES;
                if (!$this->isSafeUrl($value, $schemes)) {
                    $element->removeAttribute($attribute->nodeName);
                }
                continue;
            }

            if ($name === 'style') {
                $style = $this->cleanStyle($value);
                $style === '' ? $element->removeAttribute('style') : $element->setAttribute('style', $style);
                continue;
            }

            if ($name === 'class') {
                $clean = trim(preg_replace('/[^A-Za-z0-9_\- ]/', '', $value));
                $clean === '' ? $element->removeAttribute($name) : $element->setAttribute($name, $clean);
                continue;
            }

            if ($name === 'target') {
                in_array($value, ['_blank', '_self'], true) ? null : $element->removeAttribute('target');
                continue;
            }

            if ($name === 'allow') {
                $element->setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen');
            }
        }

        if ($tag === 'a' && $element->getAttribute('target') === '_blank') {
            $rel = array_filter(preg_split('/\s+/', strtolower($element->getAttribute('rel'))));
            $rel = array_unique(array_merge(array_intersect($rel, ['nofollow', 'sponsored', 'ugc']), ['noopener', 'noreferrer']));
            $element->setAttribute('rel', implode(' ', $rel));
        } elseif ($tag === 'a' && $element->hasAttribute('rel')) {
            $rel = array_intersect(preg_split('/\s+/', strtolower($element->getAttribute('rel'))), ['nofollow', 'sponsored', 'ugc', 'noopener', 'noreferrer']);
            $rel ? $element->setAttribute('rel', implode(' ', $rel)) : $element->removeAttribute('rel');
        }

        if ($tag === 'iframe') {
            $host = strtolower((string) parse_url($element->getAttribute('src'), PHP_URL_HOST));
            if (!preg_match('#^https://#i', $element->getAttribute('src')) || !in_array($host, self::IFRAME_HOSTS, true)) {
                return false;
            }
            $element->setAttribute('loading', 'lazy');
            $element->setAttribute('allowfullscreen', 'allowfullscreen');
        }

        if ($tag === 'img') {
            if (!$element->hasAttribute('src')) {
                return false;
            }
            if (!$element->hasAttribute('alt')) {
                $element->setAttribute('alt', '');
            }
        }

        return true;
    }

    private function isSafeUrl(string $url, array $schemes): bool
    {
        // Browsers ignore control characters and whitespace inside schemes ("java\nscript:")
        $normalized = strtolower(preg_replace('/[\x00-\x20\x7F]+/', '', $url));

        if ($normalized === '') {
            return false;
        }

        if (preg_match('/^([a-z][a-z0-9+.\-]*):/', $normalized, $m)) {
            return in_array($m[1], $schemes, true);
        }

        // Relative URL, anchor or protocol-relative URL. Reject anything with a colon before the
        // first slash that the regex above did not catch.
        return !preg_match('#^[^/?\#]*:#', $normalized);
    }

    private function cleanStyle(string $style): string
    {
        $clean = [];

        foreach (explode(';', $style) as $declaration) {
            if (!str_contains($declaration, ':')) {
                continue;
            }

            [$property, $value] = array_map('trim', explode(':', $declaration, 2));
            $property = strtolower($property);

            if (!in_array($property, self::STYLE_PROPERTIES, true)) {
                continue;
            }

            if (!preg_match('/^[#a-zA-Z0-9\s.,%\-()!]+$/', $value) || preg_match('/(url|expression|javascript|behavior|@import)/i', $value)) {
                continue;
            }

            $clean[] = $property . ': ' . $value;
        }

        return implode('; ', $clean);
    }
}
