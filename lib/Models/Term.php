<?php


namespace JayJay666\WPRSSMapper\Models;


use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Term implements XmlSerializable
{
    public $term_id;
    /**
     * example:
     * - category
     * - post_tag
     * - nav_menu - menu item
     *
     * @var string
     */
    public $term_taxonomy;
    public $term_slug;
    public $term_parent;
    public $term_name;
    public $term_description;

    public function xmlSerialize(Writer $writer)
    {
        $wp = '{http://wordpress.org/export/1.2/}';

        $writer->write([
            $wp . 'term' => [
                $wp . 'term_id' => is_null($this->term_id) ?: new Cdata($this->term_id),
                $wp . 'term_taxonomy' => is_null($this->term_taxonomy) ?: new Cdata($this->term_taxonomy),
                $wp . 'term_slug' => is_null($this->term_slug) ?: new Cdata($this->term_slug),
                $wp . 'term_parent' => is_null($this->term_parent) ?: new Cdata($this->term_parent),
                $wp . 'term_name' => is_null($this->term_name) ?: new Cdata($this->term_name),
                $wp . 'term_description' => is_null($this->term_description) ?: new Cdata($this->term_description),
            ]
        ]);
    }
}