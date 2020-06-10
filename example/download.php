<?php

use JayJay666\WPRSSMapper\Models\Author;
use JayJay666\WPRSSMapper\Models\Category;
use JayJay666\WPRSSMapper\Models\Chanel;
use JayJay666\WPRSSMapper\Models\Comment;
use JayJay666\WPRSSMapper\Models\CustomTag;
use JayJay666\WPRSSMapper\Models\Item;
use JayJay666\WPRSSMapper\Models\PostMeta;
use JayJay666\WPRSSMapper\Models\Tag;
use JayJay666\WPRSSMapper\Models\Term;

ini_set("display_errors", 'on');

// Class
include_once __DIR__ . "/../vendor/autoload.php";
$exporter = new \JayJay666\WPRSSMapper\Exporter();

//
// DEMO of mapping
//

// Example data in object
$chanel = new Chanel();
$chanel->title = 'Example website';
$chanel->link = 'http://ex.example.com';
$chanel->description = 'Další web používající WordPress';
$chanel->pubDate = 'Sun, 07 Jun 2020 09:34:25 +0000';
$chanel->language = 'cs';
$chanel->wxr_version = '1.2';
$chanel->base_site_url = 'https://lern.jakubforman.eu';
$chanel->base_blog_url = 'https://lern.jakubforman.eu';
$exporter->setChanel($chanel);

// START AUTHORS
$author = new Author();
$author->author_id = "1";
$author->author_login = "JohnDoe";
$author->author_email = "john.doe@example.com";
$author->author_display_name = "John Doe";
$author->author_first_name = "";
$author->author_last_name = "";
$exporter->addAuthor($author);
// END AUTHORS

// START CATEGORIES
$category = new Category();
$category->term_id = "1";
$category->category_nicename = "my-category";
$category->category_parent = "";
$category->cat_name = "My category";
$exporter->addCategory($category);
/*$term = new Term();
$term->term_id = "1";
$term->term_taxonomy = "category";
$term->term_slug = "my-category";
$term->term_parent = "";
$term->term_name = "My category";
$exporter->addTerm($term);*/

$category2 = new Category();
$category2->term_id = "2";
$category2->category_nicename = "zarazena-rubrika";
$category2->category_parent = "my-category";
$category2->cat_name = "Zařazená rubrika";
$exporter->addCategory($category2);
/*$term = new Term(); // Only for own terms
$term->term_id = "2";
$term->term_taxonomy = "category";
$term->term_slug = "zarazena-rubrika";
$term->term_parent = "my-category";
$term->term_name = "Zařazená rubrika";
$exporter->addTerms($term);*/
// END CATEGORIES

// START TAGS
$tag = new Tag();
$tag->term_id = "3";
$tag->tag_name = "Další štítek";
$tag->tag_slug = "dalsi-stitek";
$tag->tag_description = "Popis tagu";
$exporter->addTag($tag);

/*
$term = new Term();
$term->term_id = "3";
$term->term_taxonomy = "post_tag";
$term->term_slug = "dalsi-stitek";
$term->term_parent = "";
$term->term_name = "Další štítek";
$term->term_description = "Popis tagu";
$exporter->addTerm($term);*/
// END TAGS

// START ITEMS
$item = new Item();
$item->title = 'Vintage-Logo.png';
$item->link = 'https://lern.jakubforman.eu/vintage-logo-png/';
$item->pubDate = 'Thu, 16 Apr 2020 12:02:53 +0000';
$item->creator = 'JohnDoe';
$item->guid = 'http://lern.jakubforman.eu/wp-content/uploads/2020/04/Vintage-Logo.png';
$item->isPermaLink = false;
$item->description = "";
$item->contentEncoded = "<!-- wp:paragraph -->
<p>Právě si prohlížíte ukázkovou stránku, která byla vytvořena automaticky během instalace WordPressu. Stránky se liší od příspěvků zejména tím, že obsahují nějaký statický text a jsou zobrazovány na stále stejném místě webu (u většiny šablon jde o navigační menu). Lidé obvykle nejdříve vytvářejí základní informační stránky, kde se představí návštěvníkům webu a seznámí je se svými záměry. Může to být např. něco v následujícím stylu:</p>
<!-- /wp:paragraph -->

<!-- wp:quote -->
<blockquote class=\"wp-block-quote\"><p>Zdravím! Jsem Josef a bydlím v Plzni. Pracuji jako řidič autobusu a po nocích bloguji o, alespoň dle mého, zajímavých věcech...</p></blockquote>
<!-- /wp:quote -->";
$item->post_id = "15";
$item->post_date = "2020-04-16 14:02:53";
$item->post_date_gmt = "2020-04-16 12:02:53";
$item->comment_status = "open";
$item->ping_status = "closed";
$item->post_name = "vintage-logo-png";
$item->status = "inherit";
$item->post_parent = "0";
$item->menu_order = "0";
$item->post_type = "attachment";
$item->post_password = "";
$item->is_sticky = "0";
$item->attachment_url = "https://lern.jakubforman.eu/wp-content/uploads/2020/04/Vintage-Logo.png";
// Custom tags
// existing category
$categoryTag = new CustomTag();
$categoryTag->name = "category";
$categoryTag->value = "Nezařazené";
$categoryTag->attributes = ["domain" => 'category', 'nicename' => 'nezarazene'];

$categoryTag2 = new CustomTag();
$categoryTag2->name = "category";
$categoryTag2->value = "Zařazená rublika";
$categoryTag2->attributes = ["domain" => 'category', 'nicename' => 'zarazena-rubrika'];

// existing tags
$tag = new CustomTag();
$tag->name = "category";
$tag->value = "další štítek";
$tag->attributes = ["domain" => 'post_tag', 'nicename' => 'dalsi-stitek'];

$item->customTags = [$categoryTag, $categoryTag2, $tag];
// Meta data
$postmeta = new PostMeta();
$postmeta->meta_key = "_wp_attached_file";
$postmeta->meta_value = "2020/04/Vintage-Logo.png";
$item->postmeta = [$postmeta, $postmeta];
$comment = new Comment();
$comment->comment_id = '167';
$comment->comment_author = 'Anon';
$comment->comment_author_email = 'anon@example.com';
$comment->comment_author_IP = '59.167.157.3';
$comment->comment_date = '2007-09-04 10:49:28';
$comment->comment_date_gmt = '2007-09-04 00:49:28';
$comment->comment_content = 'Anonymous comment.';
$item->comments = [$comment];
$exporter->addItem($item);
// END ITEMS

// download XML
$exporter->download();
