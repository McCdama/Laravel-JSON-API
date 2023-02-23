<?php

namespace App\JsonApi\V1;

use LaravelJsonApi\Core\Server\Server as BaseServer;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

# contains the configuration for the JSON:API server
class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        // use sanctum guard when authenticating requests.
        // use php artisan tinker in the terminal based on a user
        // $token = $user->createToken('test');
        Auth::shouldUse('sanctum');

        // automatically assign the authenticated user as the author of a post when the model is created
        Post::creating(static function (Post $post): void {
           $post->author()->associate(Auth::user());
        });
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            Posts\PostSchema::class,
            Comments\CommentSchema::class,
            Tags\TagSchema::class,
            Users\UserSchema::class,
            Jobs\JobSchema::class,
            JobLocations\JobLocationSchema::class,
            Lands\LandSchema::class,
        ];
    }
}
