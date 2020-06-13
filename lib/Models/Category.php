<?php

namespace JayJay666\WPRSSMapper\Models;

use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class Category
 *
 * Each container holds information on a category used by the site for the classification of posts.
 * You can view and edit the list within the WordPress Dashboard under Posts, Categories.
 * Each category contains the following 4 child elements.
 *
 * @package JayJay666\WPRSSMapper\Models
 */
class Category implements XmlSerializable
{
    /**
     * Id
     *
     * Is a unique numeric identifier assigned by WordPress to this category.
     * It is found in URL strings that reference this category.
     *
     * @var integer
     */
    public $term_id;

    /**
     * URL formated name
     *
     * Is the category name in a URL friendly format.
     *
     * @var string
     */
    public $category_nicename;

    /**
     * Parent nicename
     *
     * If the category belongs to a hierarchy then the parent category is listed.
     *
     * @var string
     */
    public $category_parent;

    /**
     * Full text name
     *
     * The original name of the category contained within an unparsed character data enclosure.
     *
     * @var string
     */
    public $cat_name;

    public function xmlSerialize(Writer $writer)
    {
        $wp = '{http://wordpress.org/export/1.2/}';


        $writer->write([
            $wp . 'category' => [
                $wp . 'term_id' => $this->term_id,
                $wp . 'category_nicename' => $this->category_nicename,
                $wp . 'category_parent' => $this->category_parent,
                $wp . 'cat_name' => new Cdata($this->cat_name),
            ]
        ]);
    }
}