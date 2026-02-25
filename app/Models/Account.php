<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'debit',
        'credit',
        'balance',
        'parent_id'
    ];

    protected $casts = [
        'debit' => 'float',
        'credit' => 'float',
        'balance' => 'float',
    ];

    // العلاقة العادية
    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    // 🔥 العلاقة العودية لجلب كل الأبناء والأحفاد
    public function childrenRecursive()
    {
        return $this->hasMany(Account::class, 'parent_id')->with('childrenRecursive');
    }

    // 🔥 العلاقة العودية لجلب كل الآباء والأجداد
    public function parentRecursive()
    {
        return $this->belongsTo(Account::class, 'parent_id')->with('parentRecursive');
    }

    // دالة مساعدة لمعرفة مستوى الحساب (عمق الشجرة)
    public function getLevelAttribute()
    {
        $level = 0;
        $parent = $this->parent;
        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }
        return $level;
    }

    // دالة لجلب كل الأحفاد (جميع المستويات)
    public function getAllDescendants()
    {
        $descendants = collect();

        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getAllDescendants());
        }

        return $descendants;
    }
}
