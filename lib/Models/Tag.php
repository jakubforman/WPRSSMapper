<?php


namespace JayJay666\WPRSSMapper\Models;


use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Tag implements XmlSerializable
{
    public $term_id;
    /**
     * SLUG name
     * example:
     * - stitek1
     * - tag-second
     * @var string
     */
    public $tag_slug;
    public $tag_name;
    public $tag_description;

    public function xmlSerialize(Writer $writer)
    {
        $wp = '{' . wpLink . '}';

        $writer->write([
            $wp . 'tag' => [
                $wp . 'term_id' => $this->term_id,
                $wp . 'tag_slug' => new Cdata($this->tag_slug),
                $wp . 'tag_name' => new Cdata($this->tag_name),
                $wp . 'tag_description' => new Cdata($this->tag_description),
            ]
        ]);
    }
}