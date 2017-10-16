<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NewsTest extends TestCase
{
    use DatabaseMigrations;

    protected $news;

    public function setUp()
    {
        parent::setUp();

        $this->news = create('App\News');
    }

    /** @test */
    function each_article_can_make_string_path()
    {
        $news = create('App\News');

        $this->assertEquals(
            "/news/{$news->id}",
            $news->path()
        );
    }

}
