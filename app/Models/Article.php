<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\JoinClause;

/**
 * @method void filtered(Builder $query)
 * @method void withAuthor(Builder $query)
 */
class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that can be set with Mass Assignment.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'body', 'is_active', 'publish_at'];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = array(
        'is_active' => 'boolean',
        'publish_at' => 'datetime',
    );

    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed $value
     * @param string|null $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('name', $value)->firstOrFail();
    }

    /**
     * The user that belong to the article.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope a query to filtered articles.
     * @param Builder $query
     */
    public function scopeFiltered(Builder $query): void
    {
        $fltWith = request('filter.with', 0);
        $fltQ = request('filter.q', 0);
        $whereFullTextCols = [];
        if ($fltWith && $fltQ && is_array($fltWith)) {
            foreach ($fltWith as $f) {

                if ($f !== 'author') {
                    if (in_array($f, ['title', 'body'])) {
                        $whereFullTextCols[] = $f;
                    } else {
                        $query->where($f, 'like', $fltQ);
                    }
                }

            }
            if (count(($whereFullTextCols))) {
                $query->whereFullText($whereFullTextCols, $fltQ);
            }
        }

    }

    /**
     * Scope a query to author of articles.
     * @param Builder $query
     */
    public function scopeWithAuthor(Builder $query): void
    {
        $fltWith = request('filter.with', 0);
        $fltQ = request('filter.q', 0);
        $isFlt = $fltWith && $fltQ && is_array($fltWith);

        $query->join('users as u', function (JoinClause $join) use ($isFlt, $fltWith, $fltQ) {
            //  $wer=  $join;
            $join->on('articles.user_id', '=', 'u.id');
            if ($isFlt) {
                if (in_array('author', $fltWith)) {
                    $join->where('u.name', 'like', $fltQ);
                }
            }
        })->addSelect('u.name as author');
    }

}
