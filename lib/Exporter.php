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

define("generatorLink", "https://jakubforman.eu/wp-rss-mapper");

// WP defined
define("excerptLink", "http://wordpress.org/export/1.2/excerpt/");
define("contentLink", "http://purl.org/rss/1.0/modules/content/");
define("wfwLink", "http://wellformedweb.org/CommentAPI/");
define("wpLink", "http://wordpress.org/export/1.2/");
define("dcLink", "http://purl.org/dc/elements/1.1/");

/**
 * Class Exporter
 *
 * WordPress RSS Mapper
 * Can export every website to WordPress RSS theme for import
 *
 * @author JayJay666
 * @package JayJay666\WPRSSMapper
 */
class Exporter
{
    private $filename = null;
    private $pageName = null;
    protected $charset = "UTF-8";
    /**
     * @var Chanel
     */
    protected $chanel;
    /**
     * @var Author[]
     */
    protected $authors = [];
    /**
     * @var Category[]
     */
    protected $categories = [];
    /**
     * @var Tag[]
     */
    protected $tags = [];
    /**
     * @var Term[]
     */
    protected $terms = [];
    /**
     * @var Item[]
     */
    protected $items = [];

    public function __construct()
    {
    }

    /**
     * Autogenerate name
     */
    protected function createName()
    {
        if (is_null($this->filename)) {
            $date = date("Y-m-d");
            $pageName = strtolower(preg_replace('/\s/', '', $this->pageName));
            $this->filename = "$pageName.WordPress.$date.xml";
        }
    }


    function view()
    {
        // header('Content-Type: text/text');
        header('Content-Type: text/xml');
        $this->createName();
        // TODO: echo XML structure as text
        echo $this->getContent();
    }

    /**
     * Download XML
     */
    function download()
    {
        $this->createName();

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=' . $this->filename);
        header('Content-Type: text/xml; charset=' . $this->charset, true);

        echo $this->getContent();
    }

    function setChanel(Chanel $chanel)
    {
        $this->pageName = $chanel->title;
        $this->chanel = $chanel;
    }

    /**
     * Getting XML content
     *
     * @return string
     */
    protected function getContent()
    {
        $service = new Service();

        $service->classMap = [
            "version" => "2.0"
        ];
        $service->namespaceMap = [
            excerptLink => 'excerpt',
            contentLink => 'content',
            wfwLink => 'wfw',
            wpLink => 'wp',
            dcLink => 'dc'
        ];

        /*
         * Export final structure
         */
        return $service->write('rss', [
            'channel' => [
                "generator" => generatorLink,
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
     * @param Author $author
     */
    public function addAuthor(Author $author)
    {
        $this->authors[] = $author;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }

    /**
     * @param Term $term
     */
    public function addTerm(Term $term)
    {
        $this->terms[] = $term;
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }
}