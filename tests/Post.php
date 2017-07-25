<?php

namespace Mayoz\Tests\Categorizable;

use Mayoz\Categorizable\Categorizable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Categorizable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
