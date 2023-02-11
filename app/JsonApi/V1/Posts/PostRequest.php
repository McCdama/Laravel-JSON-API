<?php

namespace App\JsonApi\V1\Posts;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class PostRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    // only validated data will be filled into the model
    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
            'publishedAt' => ['nullable', JsonApiRule::dateTime()],
            'slug' => ['required', 'string', Rule::unique('posts', 'slug')],
            // data.relationships.tags.data
            'tags' => JsonApiRule::toMany(),
            // data.attributes.title
            'title' => ['required', 'string'],
        ];
    }

}
