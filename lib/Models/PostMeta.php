<?php


namespace JayJay666\WPRSSMapper\Models;


use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class PostMeta implements XmlSerializable
{
    public $meta_key;
    /**
     * Can contains:
     * - Hash string, example: 4d2198f7665dab04151ddefd319f5fd2c0b9190e
     * - Serialized string as metadata, example: a:5:{s:5:"width";i:450;s:6:"height";i:802;s:4:"file";s:19:"2020/04/phone-x.png";s:5:"sizes";a:6:{s:21:"woocommerce_thumbnail";a:5:{s:4:"file";s:19:"phone-x-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:9:"uncropped";b:0;}s:29:"woocommerce_gallery_thumbnail";a:4:{s:4:"file";s:19:"phone-x-100x100.png";s:5:"width";i:100;s:6:"height";i:100;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:19:"phone-x-168x300.png";s:5:"width";i:168;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}s:9:"thumbnail";a:4:{s:4:"file";s:19:"phone-x-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:19:"phone-x-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:19:"phone-x-100x100.png";s:5:"width";i:100;s:6:"height";i:100;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}
     * - String as attached file, example: 2020/04/phone-x.png
     * - SVG String, example: <svg ...>
     * - and others
     *
     * @var string
     */
    public $meta_value;

    public function xmlSerialize(Writer $writer)
    {
        $wp = '{http://wordpress.org/export/1.2/}';

        $writer->write([
            $wp . 'postmeta' => [
                $wp . 'meta_key' => new Cdata($this->meta_key),
                $wp . 'meta_value' => new Cdata($this->meta_value),
            ]
        ]);
    }
}