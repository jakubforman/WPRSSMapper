<?php

namespace JayJay666\WPRSSMapper\Models;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class Chanel
 *
 * Determining default data to XML document in tag <chanel>
 *
 * @package JayJay666\WPRSSMapper\Models
 */
class Chanel implements XmlSerializable
{
    /**
     * Title
     *
     * Contains the title of the site.
     *
     * @var string
     */
    public $title;

    /**
     * Link
     *
     * Is the URL of the site as determined by WordPress.
     *
     * @var string
     */
    public $link;

    /**
     * Tagline
     *
     * Is a tagline that can be modified in the Dashboard under Settings, General Settings, Tagline.
     *
     * @var string
     */
    public $description;

    /**
     * Time of creation
     *
     * Was the time and date that the WXR document was created.
     * It is in the RFC-822 format http://asg.web.cmu.edu/rfc/rfc822.html as required by the Rss standard.
     * The format should be self explanatory except for the last numeric value which represents the local differential from GMT using a +/-hhmm format.
     * Plus 2 hours from GMT would be represented as +0200.
     * The WordPress time zone can be changed in the Dashboard under Settings, General Settings, Timezone
     *
     * Example: Sun, 07 Jun 2020 09:34:25 +0000
     *
     * @var string
     */
    protected $pubDate;

    /**
     * Language code
     *
     * Is the primary language the site is written in as determined by Settings, General Settings, Language in the WordPress Dashboard.
     * A list of valid codes used to represent the language can be found at http://www.rssboard.org/rss-language-codes.
     *
     * @var string
     */
    public $language;

    /**
     * WXR version of document
     *
     * <wp:wxr_version> is the version number for the WordPress extension Rss.
     * At the last update in December 2013 the version number was at 1.2.
     *
     * @var double
     */
    protected $wxr_version = 1.2;

    /**
     * Root provider URL
     *
     * Is the root URL  of the WordPress hosting provider.
     *
     * @var string
     */
    public $base_site_url;

    /**
     * Root WordPress URL
     *
     * Is the root URL of the WordPress site.
     *
     * @var string
     */
    public $base_blog_url;

    public function __construct()
    {
        $this->pubDate = date("D, d M Y H:i:s O");
    }

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