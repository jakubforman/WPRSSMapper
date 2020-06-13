<?php


namespace JayJay666\WPRSSMapper;

use JayJay666\WPRSSMapper\Models\Author;
use JayJay666\WPRSSMapper\Models\Category;
use JayJay666\WPRSSMapper\Models\Chanel;
use JayJay666\WPRSSMapper\Models\Comment;
use JayJay666\WPRSSMapper\Models\CustomTag;
use JayJay666\WPRSSMapper\Models\Item;
use JayJay666\WPRSSMapper\Models\PostMeta;
use JayJay666\WPRSSMapper\Models\Tag;
use JayJay666\WPRSSMapper\Models\Term;
use Sabre\Xml\Service;
use Sabre\Xml\Writer;

// Generator link
define("generatorLink", "https://github.com/JayJay666/WPRSSMapper");

// WordPress Extension
define("excerptLink", "http://wordpress.org/export/1.2/excerpt/");
// WordPress Extension
define("wpLink", "http://wordpress.org/export/1.2/");
// Extensions include the RDF site summary content module
define("contentLink", "http://purl.org/rss/1.0/modules/content/");
// Well-formed web comment AP
define("wfwLink", "http://wellformedweb.org/CommentAPI/");
// Dublin Core metadata element se
define("dcLink", "http://purl.org/dc/elements/1.1/");

/**
 * Class WPRSSMapper
 *
 * WordPress RSS Mapper - WXR
 * Can export every website to WordPress RSS theme for import
 *
 * @author JayJay666
 * @package JayJay666\WPRSSMapper
 */
class WPRSSMapper
{
    private $version = 1.1;
    private $filename = null;
    private $pageName = null;
    protected $charset = "UTF-8";
    /**
     * Chanel
     *
     * Default values for import
     *
     * @var Chanel
     */
    protected $chanel;
    /**
     * Authors
     *
     * All authors used in items
     *
     * @var Author[]
     */
    protected $authors = [];
    /**
     * Categories
     *
     * All Categories used in items
     *
     * @var Category[]
     */
    protected $categories = [];
    /**
     * Tags
     *
     * All tags used in items
     *
     * @var Tag[]
     */
    protected $tags = [];
    /**
     * Own Terms
     *
     * @var Term[]
     */
    protected $terms = [];
    /**
     * Items
     *
     * All items from site, post, pages, attachment and more
     *
     * @var Item[]
     */
    protected $items = [];

    public function __construct()
    {
    }

    /**
     * Generate name
     *
     * Auto-generate name of file
     */
    protected function createName()
    {
        if (is_null($this->filename)) {
            $date = date("Y-m-d");
            $array = explode('\\', __CLASS__);
            $path = array_pop($array);
            $pageName = strtolower(preg_replace('/\s/', '', $this->pageName));
            $this->filename = "$pageName." . $path . ".$date.xml";
        }
    }


    /**
     * View XML
     *
     * Set headers & echo XML as text/xml
     */
    function view()
    {
        //header('Content-Type: text/text');
        header('Content-Type: text/xml');
        $this->createName();
        // TODO: echo XML structure as text
        echo $this->getContent();
    }

    /**
     * Download XML
     *
     * Set headers & echo content as text/xml downloadable file
     */
    function download()
    {
        $this->createName();

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=' . $this->filename);
        header('Content-Type: text/xml; charset=' . $this->charset, true);

        echo $this->getContent();
    }

    /**
     * Set Chanel
     *
     * Set Chanel of XML coument
     *
     * @param Chanel $chanel
     */
    function setChanel(Chanel $chanel)
    {
        $this->pageName = $chanel->title;
        $this->chanel = $chanel;
    }

    /**
     * GetXML
     *
     * Getting XML content
     *
     * @return string
     */
    protected function getContent()
    {
        /*
         * Export final structure
         */
        return $this->export("rss", [
            'channel' => [
                "generator" => generatorLink, // Is the name or a URL pointing to the homepage of the application that was used to create the Rss document.
                $this->chanel,
                $this->authors,
                $this->categories,
                $this->tags,
                $this->terms,
                $this->items
            ],
        ]);
    }

    /**
     * Export as XML
     *
     * Export value with root element & contextUri
     *
     * @param string $rootElementName
     * @param $value
     * @param string|null $contextUri
     * @return string
     */
    protected function export(string $rootElementName, $value, string $contextUri = null)
    {
        /*
         * Export final structure
         */
        $writer = new Writer();
        $writer->openMemory();
        $writer->contextUri = $contextUri;
        $writer->setIndent(true);
        $writer->startDocument();
        $writer->classMap = [
            "version" => "2.0"
        ];
        $writer->namespaceMap = [
            excerptLink => 'excerpt',
            contentLink => 'content',
            wfwLink => 'wfw',
            wpLink => 'wp',
            dcLink => 'dc'
        ];
        // comments
        $writer->write("<!-- This is a WordPress eXtended RSS file generated by WPRSSMapper as an export of your site. -->\n" .
            "<!-- This file is not intended to serve as a complete backup of your site. -->\n" .
            "<!-- Home of project: https://github.com/JayJay666/WPRSSMapper -->\n" .
            "\n<!-- generator=\"WPRSSMapper/$this->version\" created=\"" . date("Y-m-d H:m") . "\" -->\n");

        $writer->writeElement($rootElementName, $value);
        return $writer->outputMemory();
    }

    /**
     * Add author
     *
     * Adding author to collection
     *
     * @param Author $author
     */
    public function addAuthor(Author $author)
    {
        $this->authors[] = $author;
    }

    /**
     * Add category
     *
     * Adding category to collection
     *
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }

    /**
     * Add term
     *
     * Adding term to collection
     *
     * @param Term $term
     */
    public function addTerm(Term $term)
    {
        $this->terms[] = $term;
    }

    /**
     * Add item
     *
     * Adding item to collection
     *
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /**
     * Add tag
     *
     * Adding tag to collection
     *
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }
}