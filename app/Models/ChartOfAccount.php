<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChartOfAccount extends Model
{
    //
    protected $table ='chart_of_account';
    protected $fillable = [
        'account_code',
        'account_name',
        'account_type',
        'account_balance',
        'parent_id',
        'level',
        'is_postable',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent_id');
    }
    public function children(): HasMany
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id');
    }
    public function childrenRecursive()
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id')->with('childrenRecursive');
    }

}
