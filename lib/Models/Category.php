<?php


namespace JayJay666\WPRSSMapper\Models;


use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Category implements XmlSerializable
{
    public $term_id;
    /**
     * Like URL category-b
     *
     * @var string
     */
    public $category_nicename;
    /**
     * String SLUG identifier of parent
     * example:
     * - nezarazene
     *
     * @var string
     */
    public $category_parent;
    /**
     * Name
     * @var string
     */
    public $cat_name;

    public function xmlSerialize(Writer $writer)
    {
        $wp = '{http://wordpress.org/export/1.2/}';


        $writer->write([
            $wp . 'category' => [
                $wp . 'term_id' => $this->term_id,
                $wp . 'category_nicename' => new Cdata($this->category_nicename),
                $wp . 'category_parent' => new Cdata($this->category_parent),
                $wp . 'cat_name' => new Cdata($this->cat_name),
            ]
        ]);
    }
}