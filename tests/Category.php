<?php

namespace Mayoz\Tests\Categorizable;

use Mayoz\Categorizable\Category as BaseCategory;

class Category extends BaseCategory
{
    /**
     * Get all posts for the relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'categorizable');
    }
}
