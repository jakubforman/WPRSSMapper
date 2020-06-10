<?php


namespace JayJay666\WPRSSMapper\Models;


use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class Author
 *
 * Author Mapper
 *
 * @package Models
 */
class Author implements XmlSerializable
{
    public $author_id;
    public $author_login;
    public $author_email;
    public $author_display_name;
    public $author_first_name;
    public $author_last_name;

    public function xmlSerialize(Writer $writer)
    {
        $ns = '{http://wordpress.org/export/1.2/}';
        $writer->write([
            $ns . 'author' => [
                $ns . 'author_id' => $this->author_id,
                $ns . 'author_login' => new Cdata($this->author_login),
                $ns . 'author_email' => new Cdata($this->author_email),
                $ns . 'author_display_name' => new Cdata($this->author_display_name),
                $ns . 'author_first_name' => new Cdata($this->author_first_name),
                $ns . 'author_last_name' => new Cdata($this->author_last_name),
            ]
        ]);
    }
}