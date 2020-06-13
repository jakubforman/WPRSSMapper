<?php

namespace JayJay666\WPRSSMapper\Models;

use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class Author
 *
 * Author Mapper, determining every author in document.
 * Contains details on the authors of the site. Each author gets their own wp_author container.
 *
 * @package JayJay666\WPRSSMapper\Models
 */
class Author implements XmlSerializable
{
    /**
     * Login
     *
     * Is the author’s WordPress login user name.
     *
     * @var string
     */
    public $author_login;

    /**
     * Email
     *
     * Is the author’s e-mail address associated with their WordPress account.
     *
     * @var string
     */
    public $author_email;

    /**
     * Nick
     *
     * Is the author’s public display name used in instead of the login user name for comments and posts
     *
     * @var string
     */
    public $author_display_name;

    /**
     * First name
     *
     * Is the author’s first name.
     *
     * @var string
     */
    public $author_first_name;

    /**
     * Last name
     *
     * Is the author’s last name.
     *
     * @var string
     */
    public $author_last_name;

    public function xmlSerialize(Writer $writer)
    {
        $ns = '{http://wordpress.org/export/1.2/}';
        $writer->write([
            $ns . 'author' => [
                $ns . 'author_login' => new Cdata($this->author_login),
                $ns . 'author_email' => new Cdata($this->author_email),
                $ns . 'author_display_name' => new Cdata($this->author_display_name),
                $ns . 'author_first_name' => new Cdata($this->author_first_name),
                $ns . 'author_last_name' => new Cdata($this->author_last_name),
            ]
        ]);
    }
}