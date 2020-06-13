<?php

namespace JayJay666\WPRSSMapper\Models;

use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class Tag
 *
 * Contains a complete collection of the tags assigned to posts.
 * You can view and edit the tags within the Dashboard under Posts Tags.
 * It contains the following 4 child elements.
 *
 * @package JayJay666\WPRSSMapper\Models
 */
class Tag implements XmlSerializable
{
    /**
     * Id
     *
     * Is a unique numeric identifier assigned by WordPress to this tag. It is found in URL strings that reference this tag.
     *
     * @var integer
     */
    public $term_id;

    /**
     * SLUG name
     *
     * Is the URL friendly name of the tag.
     * example:
     * - stitek1
     * - tag-second
     *
     * @var string
     */
    public $tag_slug;

    /**
     * Full text name
     *
     * Is the original name of the tag contained within an unparsed character data enclosure.
     *
     * @var string
     */
    public $tag_name;

    /**
     * Description
     *
     * Is the original description of the tag.
     *
     * @var string
     */
    public $tag_description;

    public function xmlSerialize(Writer $writer)
    {
        $wp = '{' . wpLink . '}';

        $writer->write([
            $wp . 'tag' => [
                $wp . 'term_id' => $this->term_id,
                $wp . 'tag_slug' => $this->tag_slug,
                $wp . 'tag_name' => new Cdata($this->tag_name),
                $wp . 'tag_description' => new Cdata($this->tag_description),
            ]
        ]);
    }
}