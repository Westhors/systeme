<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Resources\AccountResource;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * عرض شجرة الحسابات كاملة بكل المستويات
     */
    public function index()
    {
        // جلب كل الحسابات الرئيسية مع كل الأبناء والأحفاد
        $accounts = Account::with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderBy('code')
            ->get();

        return AccountResource::collection($accounts);
    }

    /**
     * عرض حساب معين بكل أبنائه وأحفاده
     */
    public function show($code)
    {
        $account = Account::with('childrenRecursive')
            ->where('code', $code)
            ->firstOrFail();

        return new AccountResource($account);
    }

    /**
     * عرض شجرة كاملة كقائمة مسطحة مع تحديد المستوى
     */
    public function flatTree()
    {
        $accounts = Account::with('parent')->orderBy('code')->get();

        $formatted = $accounts->map(function($account) {
            return [
                'id' => $account->id,
                'code' => $account->code,
                'name' => $account->name,
                'debit' => $account->debit,
                'credit' => $account->credit,
                'balance' => $account->balance,
                'level' => $account->level,
                'parent_code' => $account->parent?->code,
                'parent_name' => $account->parent?->name,
                'full_path' => $this->getFullPath($account),
            ];
        });

        return response()->json([
            'data' => $formatted,
            'total' => $accounts->count()
        ]);
    }

    /**
     * الحصول على المسار الكامل للحساب
     */
    private function getFullPath($account)
    {
        $path = [];
        $current = $account;

        while ($current) {
            array_unshift($path, $current->name);
            $current = $current->parent;
        }

        return implode(' > ', $path);
    }

    /**
     * عرض إحصائيات الشجرة
     */
    public function treeStats()
    {
        $mainAccounts = Account::whereNull('parent_id')->count();
        $totalAccounts = Account::count();

        // حساب أقصى عمق للشجرة
        $maxLevel = 0;
        $accounts = Account::with('parent')->get();
        foreach ($accounts as $account) {
            $level = $account->level;
            if ($level > $maxLevel) {
                $maxLevel = $level;
            }
        }

        return response()->json([
            'total_accounts' => $totalAccounts,
            'main_accounts' => $mainAccounts,
            'sub_accounts' => $totalAccounts - $mainAccounts,
            'max_depth' => $maxLevel,
            'tree_levels' => $maxLevel + 1, // +1 لأن المستوى يبدأ من 0
        ]);
    }
}
