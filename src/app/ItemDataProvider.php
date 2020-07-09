<?php

namespace App;

use Tomaj\Scraper\Scraper;
use Tomaj\Scraper\Parser\OgParser;

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
            $scraper = new Scraper();
            $parsers = [new OgParser()];
            $meta = $scraper->parseUrl($url, $parsers);

            return static::siftData([
                'site_name' => $meta->getOgSiteName(),
                'title' => $meta->getTitle(),
                'og_title' => $meta->getOgTitle(),
                'description' => $meta->getDescription(),
                'og_description' => $meta->getOgDescription(),
                'image_url' => $meta->getOgImage(),
                'keywords' => $meta->getKeywords()
            ]);
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
    private static function siftData(array $data)
    {
        // Trim everything.
        $data = array_map('trim', $data);

        // Fallback title.
        if (!$data['title']) {
            $data['title'] = $data['og_title'];
        }

        // Fallback description.
        if (!$data['description']) {
            $data['description'] = $data['og_description'];
        }

        // Remove description if it repeats the title.
        if ($data['title'] == $data['description']) {
            $data['description'] = '';
        }

        // Trim the title, removing the site name etc.
        $data['title'] = static::trimTitle($data['title']);

        return $data;
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
