<?php

namespace Mayoz\Tests\Categorizable;

class CategorizableTest extends TestCase
{
    protected $categories;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->categories = factory(Category::class, 5)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCategorize()
    {
        $post = factory(Post::class)->create();

        $post->categorize($this->categories);

        $this->assertEquals($this->categories->count(), $post->categories_count);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRecategorize()
    {
        $post = factory(Post::class)->create();

        $post->categorize($this->categories);
        $post->recategorize($this->categories->random(2));

        $this->assertEquals(2, $post->categories_count);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRecategorizeForRemove()
    {
        $post = factory(Post::class)->create();

        $post->categorize($this->categories);
        $post->recategorize([]);

        $this->assertEquals(0, $post->categories_count);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUncategorize()
    {
        $post = factory(Post::class)->create();

        $post->categorize($this->categories);
        $post->uncategorize($this->categories->random(3));

        $this->assertEquals(2, $post->categories_count);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRelationship()
    {
        $posts = factory(Post::class, 5)->create()->each(function ($post) {
            $post->categorize($this->categories);
        });

        $category = Category::find(1);

        $this->assertEquals($category->posts, $category->categorized(Post::class)->get());
        $this->assertEquals($posts->count(), $category->posts->count());
    }
}
