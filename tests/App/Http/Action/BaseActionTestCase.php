<?php
/**
 * Created by PhpStorm.
 * User: mashine
 * Date: 16.05.18
 * Time: 13:13
 */

namespace Test\App\Http\Action;


use PHPUnit\Framework\TestCase;
use Framework\Template\PhpRenderer;

class BaseActionTestCase extends TestCase
{
    protected $renderer;

    public function setUp()
    {
        parent::setUp();
        $this->renderer = new PhpRenderer('templates');
    }
}