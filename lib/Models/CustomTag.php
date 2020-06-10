<?php


namespace JayJay666\WPRSSMapper\Models;

use Sabre\Xml\Element\Cdata;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class CustomTag implements XmlSerializable
{
    public $name;
    public $attributes = [];
    public $value;
    public $cdata = true;

    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            [
                'name' => $this->name,
                'attributes' => $this->attributes,
                'value' => $this->cdata ? new Cdata($this->value) : $this->value
            ],
        ]);
    }
}