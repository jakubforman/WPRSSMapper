<?php


namespace JayJay666\WPRSSMapper\Models;


use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Item implements XmlSerializable
{
    public $title;
    public $post_name; // TODO: pokud zadá pouze title, post name se musí vyplnit z title
    public $link;
    /**
     * Creator Nick
     *
     * Example: Jay489, AndrejHOHO
     *
     * @var string
     */
    public $creator;
    public $pubDate;
    /**
     * Contains URL of item
     *
     * example:
     * - http://ex.example.com/?page_id=192
     * - https://lern.jakubforman.eu/wp-content/uploads/2020/05/for_users_order-1.png
     *
     * @var string
     */
    public $guid;
    public $description;
    public $isPermaLink = false;
    /**
     * Content of item
     *
     * Contains HTML or plain text
     *
     * @var string
     */
    public $contentEncoded = "";
    public $excerptEncoded = "";
    public $post_id;
    public $post_date;
    public $post_date_gmt;
    public $comment_status = 'closed';
    public $ping_status = 'closed';
    /**
     * - publish
     * -
     * @var string
     */
    public $status = 'inherit';
    /**
     * ID of parent page
     * @var int
     */
    public $post_parent = 0;
    public $menu_order = 0;
    /**
     * - post
     * - page
     * - attachment
     *
     * @var string
     */
    public $post_type = 'attachment'; // TODO: Zobrazit jaké ještě existují
    public $post_password;
    /**
     * Bool value, enabled or disabled
     *
     * @var int
     */
    public $is_sticky = 0;
    public $attachment_url;
    public $category;
    /**
     * @var CustomTag[]
     */
    public $customTags = [];
    /**
     * @var PostMeta[]
     */
    public $postmeta = [];
    /**
     * @var Comment[]
     */
    public $comments = [];


    public function xmlSerialize(Writer $writer)
    {
        $excerpt = "{" . excerptLink . "}";
        $content = "{" . contentLink . "}";
        $dc = "{" . dcLink . "}";
        $wp = "{" . wpLink . "}";


        $writer->write([
            'item' => [
                'title' => $this->title,
                'link' => $this->link,
                'pubDate' => $this->pubDate,
                $dc . 'creator' => new Cdata($this->creator),
                [
                    'name' => 'guid',
                    'attributes' => ['isPermalink' => $this->isPermaLink ? 'true' : 'false'],
                    'value' => $this->guid
                ],
                'description' => $this->description,
                $content . 'encoded' => new Cdata($this->contentEncoded),
                $excerpt . 'encoded' => new Cdata($this->excerptEncoded),
                $wp . 'post_id' => $this->post_id,
                $wp . 'post_date' => new Cdata($this->post_date),
                $wp . 'post_date_gmt' => new Cdata($this->post_date_gmt),
                $wp . 'comment_status' => new Cdata($this->comment_status),
                $wp . 'ping_status' => new Cdata($this->ping_status),
                $wp . 'post_name' => new Cdata($this->post_name),
                $wp . 'status' => new Cdata($this->status),
                $wp . 'post_parent' => $this->post_parent,
                $wp . 'menu_order' => $this->menu_order,
                $wp . 'post_type' => new Cdata($this->post_type),
                $wp . 'post_password' => new Cdata($this->post_password),
                $wp . 'is_sticky' => $this->is_sticky,
                $wp . 'attachment_url' => new Cdata($this->attachment_url),
                $this->customTags,
                $this->comments,
                $this->postmeta
            ]
        ]);
    }
}