<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Assignment
 * @package App\Models
 * @property string $document_number;
 * @property string $preamble;
 * @property string $text;
 * @property int $author_id;
 * @property int $addressed_id;
 * @property int $executor_id;
 * @property int $department_id;
 * @property string $status;
 * @property $deadline;
 * @property $real_deadline;
 */

class Assignment extends Model
{
    use HasFactory;

    public const STATUS_IN_PROGRESS = 'В работе';
    public const STATUS__EXPIRED = 'Просрочено';
    public const STATUS_DONE = 'Выполнено';
    public const STATUS_NULL = 'Без статуса';

    protected $fillable = [
        'document_number',
        'preamble',
        'text',
        'author_id',
        'addressed_id',
        'executor_id',
        'department_id',
        'status',
        'status_color',
        'register_date',
        'deadline',
        'real_deadline'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class,'author_id');
    }

    public function addressed(): BelongsTo
    {
        return $this->belongsTo(User::class,'addressed_id');
    }

    public function executor(): BelongsTo
    {
        return $this->belongsTo(User::class,'executor_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }


    public function getRegisterDateAttribute($value): mixed
    {
        if (is_null($value)) return null;
        return Carbon::parse($value)->format('d.m.Y');
    }

    public function getDeadlineAttribute($value): mixed
    {
        if (is_null($value)) return null;

        return Carbon::parse($value)->format('d.m.Y');
    }

    public function getRealDeadlineAttribute($value): mixed
    {
        if (is_null($value)) return null;

        return Carbon::parse($value )->format('d.m.Y');
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS__EXPIRED,
            self::STATUS_DONE,
            self::STATUS_IN_PROGRESS,
            self::STATUS_NULL
        ];
    }

    public function isProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function isDone(): bool
    {
        return $this->status === self::STATUS_DONE;
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS__EXPIRED;
    }

    public function isNone(): bool
    {
        return $this->status === self::STATUS_NULL;
    }
}
