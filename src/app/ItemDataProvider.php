<?php

namespace App;

use Goose\Client as GooseClient;
use Goose\Article as GooseArticle;

class ItemDataProvider
{
    /**
     * The URL we will get data for.
     *
     * @var string
     */
    private $url = '';

    /**
     * Data built for this URL.
     *
     * @var array
     */
    private $data = [];

    /**
     * Constructor.
     *
     * @param string $url The URL to get data for.
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Get the URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get all data.
     *
     * @return array
     */
    public function getData()
    {
        if (empty($this->data)) {
            $this->data = array_merge(
                static::basicData($this->url),
                static::fetchData($this->url)
            );
        }

        return $this->data;
    }

    /**
     * Remove the query string from a URL.
     *
     * @return string
     */
    private static function removeQuery($url)
    {
        return strtok($url, '?');
    }

    /**
     * Build basic data for a URL.
     *
     * @return array
     */
    private static function basicData($url)
    {
        $parts = parse_url($url);

        return [
            'host' => $parts['host'],
            'title' => static::removeQuery($url)
        ];
    }

    /**
     * Get data from the URL.
     *
     * @return array
     */
    public static function fetchData(string $url)
    {
        try {
            $goose = new GooseClient();
            $article = $goose->extractContent($url);
            return static::parseGooseArticle($article);
        } catch (\Exception $e) {
            // Failed to fetch.
        }

        return [];
    }

    /**
     * Parse and sanitize requested data.
     *
     * @return array
     */
    private static function parseGooseArticle(GooseArticle $a)
    {
        $d = [];
        $m = $a->getOpenGraph();

        // Site name.
        $d['site_name'] = !empty($m['site_name']) ? $m['site_name'] : '';

        // Title.
        $d['title'] = !empty($m['title']) ? $m['title'] : $a->getTitle();

        // Description.
        $d['description'] = !empty($m['description']) ? $m['description'] : $a->getMetaDescription();

        // Remove the description if it repeats the title.
        if ($d['title'] == $d['description']) $d['description'] = '';

        // Trim the title, removing the site name etc.
        $d['title'] = static::trimTitle($d['title']);

        // Image.
        $d['image_url'] = $a->getTopImage() ? $a->getTopImage()->getImageSrc() : '';
        if (!$d['image_url'] && !empty($m['image'])) $d['image_url'] = $m['image'];

        return $d;
    }

    /**
     * Reduce a web page's title string.
     *
     * @return string
     */
    private static function trimTitle(string $title)
    {
        $chars = ['-', '–', ':', '|'];
        $pattern = '/\s+?[' . preg_quote(join($chars)) . ']+\s+/';
        $parts = preg_split($pattern, $title);

        return trim($parts[0]);
    }
}
