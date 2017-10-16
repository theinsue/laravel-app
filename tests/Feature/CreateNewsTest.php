<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateNewsTest extends TestCase
{
    use DatabaseMigrations;

    protected $news;

    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    function each_article_requires_a_title()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->publishArticle(['title' => null]);

    }

    /** @test */
    function each_article_requires_a_description()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->publishArticle(['description' => null]);
    }

    /** @test */
    function each_article_requires_source_link()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->publishArticle(['link' => null]);
    }

    /** @test */
    function each_article_requires_a_creator()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->publishArticle(['creator' => null]);
    }

    /** @test */
    function each_article_requires_guid()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->publishArticle(['guid' => null]);
    }

    /** @test */
    function each_article_requires_thumbnail_url()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->publishArticle(['thumbnail' => null]);
    }

    /** @test */
    function each_article_requires_published_date()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->publishArticle(['pubDate' => null]);
    }

    function publishArticle($overrides = [])
    {
        $news = make('App\News', $overrides);

        return $this->post('/news', $news->toArray());

    }
}
