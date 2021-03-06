<?php

namespace App\Transformers;

use Gate;
use League\Fractal\TransformerAbstract;
use App\Entities\Tag;
use App\Services\ResourceUrl;

/**
 * Class TagTransformer.
 */
class TagTransformer extends TransformerAbstract
{
    public function __construct(ResourceUrl $urlGen)
    {
        $this->urlGen = $urlGen;
    }

    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'owner',
        'games',
        'shared_with',
    ];

    /**
     * Transform the \Tag entity.
     *
     * @param \Tag $model
     *
     * @return array
     */
    public function transform(Tag $model)
    {
        return array_filter([
            'url'        => $this->urlGen->generate($model),
            'name'       => isset($model->name)       ? $model->name                          : null,
            'public'     => isset($model->public)     ? (int) $model->public                        : null,
            'owner_url'  => $this->urlGen->generate($model->owner),
            'created_at' => isset($model->created_at) ? $model->created_at->toIso8601String() : null,
            'updated_at' => isset($model->updated_at) ? $model->updated_at->toIso8601String() : null,
        ], function ($v) {
            return !is_null($v);
        });
    }

    /**
     * Include owner.
     *
     * @param Tag $tag
     *
     * @return League/Fractal/ItemResource
     */
    public function includeOwner(Tag $tag)
    {
        if (Gate::allows('show', $tag->owner)) {
            return $this->item($tag->owner, new UserTransformer());
        }

        return $this->item($tag->owner, new UserSummaryTransformer());
    }

    /**
     * Include Games.
     *
     * @param Tag $tag
     *
     * @return League/Fractal/CollectionResource
     */
    public function includeGames(Tag $tag)
    {
        // no authorization check needed
        return $this->collection($tag->games, new GameSummaryTransformer());
    }

    /**
     * Include SharedWith.
     *
     * @param Tag $tag
     *
     * @return League/Fractal/CollectionResource
     */
    public function includeSharedWith(Tag $tag)
    {
        // no authorization needed because UserSummaryTransformer is used
        return $this->collection($tag->sharedWith, new UserSummaryTransformer());
    }
}
