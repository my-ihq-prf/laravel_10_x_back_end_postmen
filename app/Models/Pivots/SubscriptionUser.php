<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SubscriptionUser extends Pivot
{
    // ...
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that can be set with Mass Assignment.
     *
     * @var array
     */
    protected $fillable = ['subscription_id', 'user_id', 'is_active', 'start_at'];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = array(
        'is_active' => 'boolean',
        'start_at' => 'datetime',
    );

    /**
     * @inheritdoc
     */
    public function update(array $attributes = [], array $options = []): bool
    {
        if (auth()?->user()?->can('update', $this)) {
            return parent::update($attributes, $options);
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function delete(): void
    {
        if (auth()?->user()?->can('delete', $this)) {
            parent::delete();
        }
    }

    /**
     * @inheritdoc
     */
    public function forceDelete(): void
    {
        if (auth()?->user()?->can('delete', $this)) {
            parent::forceDelete();
        }
    }
}
