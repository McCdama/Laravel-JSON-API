<?php

namespace App\JsonApi\V1\Posts;

use App\Models\Post;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;

class PostSchema extends Schema
{

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Post::class;


    // support include query parameter.
    // (add data member to each ressource) --> Compound Document
    // no need for spearate (child/nested)queries
    // e.g. GET http://localhost:8000/api/v1/posts/1?include=author,comments.user HTTP/1.1
    /**
     * The maximum include path depth.
     *
     * @var int
     */
    protected int $maxDepth = 3; //  include the post's author, plus its comments and each user attached to each comment.

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
           ID::make(),
           Str::make('content'),
           DateTime::make('publishedAt')->sortable(),
           Str::make('slug'),
           Str::make('title')->sortable(),
           DateTime::make('createdAt')->sortable()->readOnly(),
           DateTime::make('updatedAt')->sortable()->readOnly(),

           BelongsTo::make('author')->type('users')->readOnly(),
           HasMany::make('comments')->readOnly(),
           BelongsToMany::make('tags'),
        ];
    }

    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
        ];
    }

    /**
     * Get the resource paginator.
     *
     * @return Paginator|null
     */
    public function pagination(): ?Paginator
    {
        return PagePagination::make();
    }

}
