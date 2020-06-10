<?php


namespace JayJay666\WPRSSMapper\Models;

use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Comment implements XmlSerializable
{
    public $comment_id;
    public $comment_author;
    public $comment_author_email;
    public $comment_author_url;
    public $comment_author_IP;
    public $comment_date;
    public $comment_date_gmt;
    public $comment_content;
    public $comment_approved = 0;
    public $comment_type;
    public $comment_parent = 0;
    public $comment_user_id = 0;

    public function xmlSerialize(Writer $writer)
    {
        $wp = "{" . wpLink . "}";

        $writer->write([
            $wp . 'comment' => [
                $wp . 'comment_id' => $this->comment_id,
                $wp . 'comment_author' => new Cdata($this->comment_author),
                $wp . 'comment_author_email' => $this->comment_author_email,
                $wp . 'comment_author_url' => $this->comment_author_url,
                $wp . 'comment_author_IP' => $this->comment_author_IP,
                $wp . 'comment_date' => $this->comment_date,
                $wp . 'comment_date_gmt' => $this->comment_date_gmt,
                $wp . 'comment_content' => new Cdata($this->comment_content),
                $wp . 'comment_approved' => $this->comment_approved,
                $wp . 'comment_type' => $this->comment_type,
                $wp . 'comment_parent' => $this->comment_parent,
                $wp . 'comment_user_id' => $this->comment_user_id,
            ]
        ]);
    }
}