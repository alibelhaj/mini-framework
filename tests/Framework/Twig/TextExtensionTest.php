<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 25/01/18
 * Time: 11:09
 */

namespace tests\Framework\Twig;


use Framework\Twig\TextExtension;
use PHPUnit\Framework\TestCase;

class TextExtensionTest extends TestCase
{
    /**
     * @var TextExtension
     */
    private $textExtension;

    public function setUp()
    {

        $this->textExtension = new TextExtension();
    }

    public function testExcerptWithShortText()
    {
        $text = 'salut';
        $this->assertEquals($text,$this->textExtension->excerpt($text,10));
    }

    public function testExcerptWithLongText()
    {
        $text = 'salut les gens';
        $this->assertEquals('salut...',$this->textExtension->excerpt($text,7));
        $this->assertEquals('salut les...',$this->textExtension->excerpt($text,12));
    }
}