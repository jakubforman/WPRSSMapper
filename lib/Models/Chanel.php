<?php


namespace JayJay666\WPRSSMapper\Models;


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Chanel implements XmlSerializable
{
    public $title;
    public $link;
    public $description;
    public $pubDate;
    public $language;
    public $wxr_version;
    public $base_site_url;
    public $base_blog_url;

    public function xmlSerialize(Writer $writer)
    {
        $wp = '{http://wordpress.org/export/1.2/}';

        $writer->write([
            'title' => $this->title,
            'link' => $this->link,
            'description' => $this->description,
            'pubDate' => $this->pubDate,
            'language' => $this->language,
            $wp . 'wxr_version' => $this->wxr_version,
            $wp . 'base_site_url' => $this->base_site_url,
            $wp . 'base_blog_url' => $this->base_blog_url,
        ]);
    }
}