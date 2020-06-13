<?php

namespace JayJay666\WPRSSMapper\Models;

use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class Item
 *
 * Items contain the details of the unique resources used by the WordPress site.
 * Like Posts, Pages, Media and more.
 *
 * @package JayJay666\WPRSSMapper\Models
 */
class Item implements XmlSerializable
{
    /**
     * Title
     *
     * Is the Title for a page and a post or the Name for media.
     *
     * @var string
     */
    public $title;

    /**
     * Post name
     *
     * Is a unique, URL friendly nicename based on the post title at the time of the first save.
     *
     * @var string
     */
    protected $post_name;

    /**
     * Link
     *
     * Is the site URL that points to the site page that displays the item.
     *
     * @var string
     */
    public $link;

    /**
     * Creator Login
     *
     * Lists the author of the item using the user name found in <wp:author_login> post.
     * The element is a Dublin Core Rss extension as the Rss specification doesn’t contain any suitable elements for this role.
     *
     * @var string
     */
    public $creator;

    /**
     * Date of publication
     *
     * Time and date the item posted to the site formatted to the RFC 822 specification.
     *
     * @var string
     */
    public $pubDate;

    /**
     * Link
     *
     * Is the globally unique identifier used for the identification of the item by Rss and WordPress clients.
     * Though in WXR the URLs are valid and point to the asset.
     *
     * example:
     * - http://ex.example.com/?page_id=192
     * - https://lern.jakubforman.eu/wp-content/uploads/2020/05/for_users_order-1.png
     *
     * @var string
     */
    public $guid;

    /**
     * Description of item
     *
     * In Rss documents this element contains the synopsis of the item but in WXR it is left blank.
     *
     * @var string
     */
    public $description;

    /**
     * The isPermaLink=false attribute according to the Rss standard should mean that this identifier is not a legitimate website URL and is not usable in a web browser.
     *
     * @var bool
     */
    public $isPermaLink = false;

    /**
     * Content of item
     *
     * Contains HTML or plain text.
     * Is the replacement for the restrictive Rss <description> element.
     * Enclosed within a character data enclosure is the complete WordPress formatted post or page complete with HTML tags and all.
     * For media this contains the Description which is also formatted in HTML.
     *
     * @var string
     */
    public $contentEncoded = "";

    /**
     * This contains a Caption used by media
     *
     * @var string
     */
    public $excerptEncoded = "";

    /**
     * ID
     *
     * This is an auto-incremental, numeric, unique identification number given to each post, media or page.
     *
     * @var integer
     */
    public $post_id;

    /**
     * Date
     *
     * Time and date that the item was published to the site.
     *
     * @var string
     */
    public $post_date;

    /**
     * Date
     *
     * Time and date in GMT that the item was published to the site.
     *
     * @var string
     */
    public $post_date_gmt;

    /**
     * Status
     *
     * A value stating whether public access for posting comments is opened or closed.
     * - open|close
     *
     * @var string
     */
    public $comment_status = 'closed';
    public $ping_status = 'closed';

    /**
     * Status
     *
     * Publish status of the item with the options:
     * - publish
     * - draft
     * - pending
     * - private
     * - trash
     * - inherit
     *
     * @var string
     */
    public $status = 'inherit';

    /**
     * Parent ID
     *
     * The numeric identification number if the parent item.
     * I think this is applicable to WordPress pages which can be nested within each other.
     *
     * @var int
     */
    public $post_parent = 0;

    /**
     * Menu order
     *
     * I assume is related to menu navigation of nested pages.
     *
     * @var int
     */
    public $menu_order = 0;

    /**
     * Item type
     *
     * - post
     * - page
     * - attachment
     *
     * @var string
     */
    public $post_type = 'attachment';

    /**
     * Password
     *
     * A non-encrypted password used by WordPress to restrict reading access to the post.
     *
     * @var string
     */
    public $post_password;

    /**
     * Sticked item
     *
     * A numeric Boolean value (0 is false, 1 is true) to determine if the post as a sticky.
     * A sticky post means the post will be displayed before all other non-sticky posts.
     *
     * @var int
     */
    public $is_sticky = 0;

    /**
     * Media item source
     *
     * The URL that points to the media item source. The URL could be used to display in a browser or used in an application to download the media.
     *
     * @var string
     */
    public $attachment_url;

    /**
     * Tags, Categories & more
     *
     * Each category or tag associated with the item is given 2 category attributes.
     * The domain attribute lists either post_tag or category while the nickname is the URL friendly name.
     * Media items are not given category tags.
     *
     * @var CustomTag[]
     */
    public $customTags = [];

    /**
     * Post meta
     *
     * Are containers for newer additions the WXR document format that have not been given their own WXR tags.
     * Each <wp:postmeta> element contains 2 child elements.
     *
     * @var PostMeta[]
     */
    public $postmeta = [];

    /**
     * Comments
     *
     * Is a child element for the post item that contains 13 sub-elements listed below.
     * These sub-elements belong to the a single post comment contained within a <wp:comment> element set.
     *
     * @var Comment[]
     */
    public $comments = [];


    public function xmlSerialize(Writer $writer)
    {
        $this->post_name = $this->title;

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