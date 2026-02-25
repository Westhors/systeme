<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartOfAccountsSeeder extends Seeder
{
    public function run(): void
    {
        // مسح الحسابات القديمة (اختياري)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Account::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // مصفوفة جميع الحسابات مع الأرصدة من ملف Excel
        $accounts = [
            // ========== الأصول (Assets) - 1 ==========
            ['code' => '1', 'name' => 'Assets', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => null],
            ['code' => '11', 'name' => 'Long Term Assets', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '1'],
            ['code' => '111', 'name' => 'Fixed Assets', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '11'],
            ['code' => '1111', 'name' => 'Land', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '111'],
            ['code' => '1112', 'name' => 'Buildings, Constructions, Facilities and roads', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '111'],
            ['code' => '1113', 'name' => 'Machinery and equipments', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '111'],
            ['code' => '1114', 'name' => 'Transportation', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '111'],
            ['code' => '1115', 'name' => 'Tools & Equipments', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '111'],
            ['code' => '1116', 'name' => 'Animal & Water wealth', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '111'],

            ['code' => '112', 'name' => 'Ongoing Projects', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '11'],
            ['code' => '1128', 'name' => 'Investment expenditure', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '112'],
            ['code' => '11281', 'name' => 'Advance payments', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '1128'],
            ['code' => '11282', 'name' => 'LC for Fixed assets purchasing', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '1128'],

            ['code' => '113', 'name' => 'Long term investments', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '11'],
            ['code' => '1131', 'name' => 'Real State Investment', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '113'],
            ['code' => '1134', 'name' => 'Shares Investments in other companies', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '113'],
            ['code' => '1135', 'name' => 'Bond Investments', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '113'],
            ['code' => '1136', 'name' => 'Investments in Investment documents', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '113'],

            ['code' => '12', 'name' => 'Current Assets', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '1'],
            ['code' => '121', 'name' => 'Cash in Hand and at Bank', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '12'],
            ['code' => '1211', 'name' => 'Treasury', 'debit' => 28156863.374001, 'credit' => 24897636.183, 'balance' => 3259227.191001, 'parent_code' => '121'],
            ['code' => '1212', 'name' => 'Banks', 'debit' => 1592.6, 'credit' => 0, 'balance' => 1592.6, 'parent_code' => '121'],
            ['code' => '1213', 'name' => 'Employees Custody', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '121'],
            ['code' => '1214', 'name' => 'Bank term and Notice Deposits', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '121'],
            ['code' => '1215', 'name' => 'Escrow Account Guarantee', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '121'],
            ['code' => '1216', 'name' => 'Credit Cards', 'debit' => 522.2, 'credit' => 0, 'balance' => 522.2, 'parent_code' => '121'],

            ['code' => '122', 'name' => 'Stock', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '12'],
            ['code' => '1221', 'name' => 'Goods Stock', 'debit' => 25413504.563279, 'credit' => 24081261.583513003, 'balance' => 1332242.979766, 'parent_code' => '122'],
            ['code' => '1222', 'name' => 'Stock of Unfinished Goods', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '122'],
            ['code' => '1223', 'name' => 'Stock of Finished Goods', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '122'],
            ['code' => '1224', 'name' => 'Stock in External Warehouses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '122'],
            ['code' => '1225', 'name' => 'LC to Purchase Goods and Services', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '122'],
            ['code' => '1226', 'name' => 'Raw materials, Materials, Fuel and Spare Parts Warehouse', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '122'],
            ['code' => '1227', 'name' => 'Consignment Inventory', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '122'],
            ['code' => '1228', 'name' => 'Warehouse transfers', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '122'],

            ['code' => '123', 'name' => 'Accounts Receivable', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '12'],
            ['code' => '1231', 'name' => 'Clients', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '123'],
            ['code' => '1232', 'name' => 'Notes Receivable', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '123'],
            ['code' => '1233', 'name' => 'Receivables', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '123'],
            ['code' => '1234', 'name' => 'Foreign Customers', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '123'],
            ['code' => '1235', 'name' => 'Franchisees', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '123'],
            ['code' => '1236', 'name' => 'Distributors', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '123'],
            ['code' => '1237', 'name' => 'Returned Checks Portfolio', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '123'],

            ['code' => '124', 'name' => 'Accounts Receivable of Authorities and Bodies', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '12'],
            ['code' => '1241', 'name' => 'Customs Authority (deposits)', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '124'],
            ['code' => '1242', 'name' => 'Taxes', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '124'],
            ['code' => '1243', 'name' => 'General Customs Authority (third party deductions)', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '124'],
            ['code' => '1244', 'name' => 'General Authority for Zakat and Income', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '124'],

            ['code' => '125', 'name' => 'Debit accounts by employees', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '12'],
            ['code' => '1251', 'name' => 'Advances to Employees', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '125'],
            ['code' => '1252', 'name' => 'E-Services Payment entitlements', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '125'],
            ['code' => '1253', 'name' => 'End of Day Deficit', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '125'],

            ['code' => '126', 'name' => 'prepaid expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '12'],
            ['code' => '127', 'name' => 'Accrued Revenues', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '12'],
            ['code' => '128', 'name' => 'Cash Transfer between Branches', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '12'],

            ['code' => '129', 'name' => 'Current Investments and Securities', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '12'],
            ['code' => '1291', 'name' => 'Stocks', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '129'],
            ['code' => '1292', 'name' => 'investment bonds', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '129'],
            ['code' => '1293', 'name' => 'Investment documents', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '129'],
            ['code' => '1294', 'name' => 'Treasury bills', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '129'],

            ['code' => '13', 'name' => 'Other Assets', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '1'],
            ['code' => '131', 'name' => 'Intangible assets', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '13'],
            ['code' => '1311', 'name' => 'Goodwill', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '131'],
            ['code' => '1312', 'name' => 'Patents/Trademarks/Franchise Rights and Authorship', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '131'],
            ['code' => '1313', 'name' => 'Development cost', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '131'],

            ['code' => '132', 'name' => 'Capitalized Expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '13'],
            ['code' => '1321', 'name' => 'Business branches and showrooms modernization expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '132'],
            ['code' => '1322', 'name' => 'Company Contribution in Establishing Assets that it doesn\'t own but serve its purposes.', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '132'],
            ['code' => '1323', 'name' => 'In exchange for the right to usufruct a place through purchase of business assets', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '132'],

            ['code' => '133', 'name' => 'Deferred Expenses*', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '13'],
            ['code' => '1331', 'name' => 'Incorporation Expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '133'],
            ['code' => '1332', 'name' => 'Pre-production/Pre-operation Expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '133'],
            ['code' => '1333', 'name' => 'Advertising campaign', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '133'],

            // ========== الخصوم وحقوق الملكية (Liabilities and Property Rights) - 2 ==========
            ['code' => '2', 'name' => 'Liabilities and Property Rights', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => null],

            ['code' => '21', 'name' => 'Currents Liabilites', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '2'],

            ['code' => '211', 'name' => 'Accounts Payable', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '21'],
            ['code' => '2111', 'name' => 'Vendors', 'debit' => 249830.017, 'credit' => 653051.797, 'balance' => -403221.78, 'parent_code' => '211'],
            ['code' => '2112', 'name' => 'Notes Payable', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '211'],
            ['code' => '2113', 'name' => 'Creditors of Dividends', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '211'],
            ['code' => '2114', 'name' => 'Credit Accounts', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '211'],

            ['code' => '212', 'name' => 'Due expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '21'],
            ['code' => '2121', 'name' => 'Due salaries', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '212'],
            ['code' => '2122', 'name' => 'Revenues Collected in Advance', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '212'],
            ['code' => '2123', 'name' => 'Other Accounts Payable', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '212'],

            ['code' => '213', 'name' => 'Accounts Payable for Authorities and Bodies', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '21'],
            ['code' => '2131', 'name' => 'Customs authority', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '213'],
            ['code' => '2132', 'name' => 'VAT', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '213'],
            ['code' => '2133', 'name' => 'General Taxation Authority', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '213'],
            ['code' => '2134', 'name' => 'Real Estate Taxation Authority', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '213'],
            ['code' => '2135', 'name' => 'Social insurance current account', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '213'],
            ['code' => '2136', 'name' => 'Other Insurance Authorities', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '213'],
            ['code' => '2137', 'name' => 'Withholding Tax', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '213'],

            ['code' => '214', 'name' => 'Other Accounts Payable', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '21'],
            ['code' => '2141', 'name' => 'Overdraft', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '214'],
            ['code' => '2142', 'name' => 'Financing of LCs', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '214'],
            ['code' => '2143', 'name' => 'Short term loans', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '214'],
            ['code' => '2144', 'name' => 'Credit Accounts for Holding Company, Affiliated Company and Sister Company', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '214'],
            ['code' => '2145', 'name' => 'Unrealized Gains', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '214'],
            ['code' => '2146', 'name' => 'Discount Coupons', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '214'],

            ['code' => '22', 'name' => 'Long term Liabilities', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '2'],
            ['code' => '221', 'name' => 'Long term loans from Holding company, affiliated company and sister company', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '22'],
            ['code' => '222', 'name' => 'Long terms loans from banks', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '22'],
            ['code' => '223', 'name' => 'Long Terms Loans from Other Parties', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '22'],
            ['code' => '224', 'name' => 'Bonds', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '22'],

            ['code' => '23', 'name' => 'Provisions:', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '2'],

            ['code' => '231', 'name' => 'Provision for Fixed Assets Depreciation', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '23'],
            ['code' => '2311', 'name' => 'Provision for Destructible Perennial Produce', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '231'],
            ['code' => '2312', 'name' => 'Provision for Buildings, Construction, Facilities and Roads Depreciation', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '231'],
            ['code' => '2313', 'name' => 'Provision for Tools & Equipments Depreciation', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '231'],
            ['code' => '2314', 'name' => 'Provision for Transportation Depreciation', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '231'],
            ['code' => '2315', 'name' => 'Provision for Machines and Equipments Depreciation', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '231'],
            ['code' => '2316', 'name' => 'Provision for Furniture and Office Equipments Depreciation', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '231'],
            ['code' => '2317', 'name' => 'Provision for Animal & Water Wealth Depreciation', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '231'],

            ['code' => '232', 'name' => 'Provision for Unfinished Products Price Decrease', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '23'],
            ['code' => '233', 'name' => 'Provision for Finished Products Price Decrease', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '23'],
            ['code' => '234', 'name' => 'Provision for Purchased Goods Price Decrease', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '23'],
            ['code' => '235', 'name' => 'Provision for Securities Price Decrease', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '23'],
            ['code' => '236', 'name' => 'provision for doubtful debts', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '23'],
            ['code' => '237', 'name' => 'Provision for disputed taxes', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '23'],
            ['code' => '238', 'name' => 'provision for claims and disputes', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '23'],
            ['code' => '239', 'name' => 'other provisions', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '23'],

            ['code' => '24', 'name' => 'Property rights', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '2'],
            ['code' => '241', 'name' => 'Capital', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '24'],
            ['code' => '242', 'name' => 'Shareholders current accounts', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '24'],
            ['code' => '243', 'name' => 'Late installments', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '24'],
            ['code' => '244', 'name' => 'Retained Earnings (losses)', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '24'],
            ['code' => '245', 'name' => 'Treasury Stock', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '24'],

            ['code' => '246', 'name' => 'Reserves', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '24'],
            ['code' => '2461', 'name' => 'legal reserve', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '246'],
            ['code' => '2462', 'name' => 'Statutory Reserve', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '246'],
            ['code' => '2463', 'name' => 'Capital reserve', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '246'],
            ['code' => '2464', 'name' => 'other reserves', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '246'],

            ['code' => '247', 'name' => 'Opening balances', 'debit' => 0, 'credit' => 693164.009, 'balance' => -693164.009, 'parent_code' => '24'],

            // ========== المصروفات (Expenses) - 3 ==========
            ['code' => '3', 'name' => 'Expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => null],

            ['code' => '31', 'name' => 'Cost of Sold Goods', 'debit' => 23715392.018556003, 'credit' => 214268.087045, 'balance' => 23501123.931511, 'parent_code' => '3'],

            ['code' => '32', 'name' => 'Statement Expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3'],

            ['code' => '321', 'name' => 'General & Admin expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '32'],

            ['code' => '3211', 'name' => 'Material, fuel and spare parts', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '321'],
            ['code' => '32111', 'name' => 'Fuel and Oils', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3211'],
            ['code' => '32112', 'name' => 'Spare Parts and Gears', 'debit' => 124830, 'credit' => 0, 'balance' => 124830, 'parent_code' => '3211'],
            ['code' => '32113', 'name' => 'Electricity & water', 'debit' => 127395, 'credit' => 0, 'balance' => 127395, 'parent_code' => '3211'],
            ['code' => '32114', 'name' => 'Account 32114', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3211'],
            ['code' => '32115', 'name' => 'Account 32115', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3211'],
            ['code' => '32116', 'name' => 'Account 32116', 'debit' => 35600, 'credit' => 0, 'balance' => 35600, 'parent_code' => '3211'],

            ['code' => '3212', 'name' => 'Petty expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '321'],
            ['code' => '32121', 'name' => 'Telephones, Mobiles & Internet', 'debit' => 4949.5, 'credit' => 0, 'balance' => 4949.5, 'parent_code' => '3212'],
            ['code' => '32122', 'name' => 'In office and Out-of-office Expenses', 'debit' => 2787, 'credit' => 0, 'balance' => 2787, 'parent_code' => '3212'],
            ['code' => '32123', 'name' => 'Administrative tips', 'debit' => 5280.5, 'credit' => 0, 'balance' => 5280.5, 'parent_code' => '3212'],
            ['code' => '32124', 'name' => 'Stationary', 'debit' => 1551.5, 'credit' => 0, 'balance' => 1551.5, 'parent_code' => '3212'],
            ['code' => '32125', 'name' => 'Account 32125', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3212'],
            ['code' => '32126', 'name' => 'Account 32126', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3212'],

            ['code' => '3213', 'name' => 'Wages', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '321'],
            ['code' => '32131', 'name' => 'Wages in Cash', 'debit' => 401197.5, 'credit' => 0, 'balance' => 401197.5, 'parent_code' => '3213'],
            ['code' => '32132', 'name' => 'Advantages In kind', 'debit' => 1070, 'credit' => 0, 'balance' => 1070, 'parent_code' => '3213'],
            ['code' => '32133', 'name' => 'Social insurance', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3213'],
            ['code' => '32134', 'name' => 'transportation expenses', 'debit' => 1175, 'credit' => 0, 'balance' => 1175, 'parent_code' => '3213'],
            ['code' => '32135', 'name' => 'Legal and Accounting fees', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3213'],
            ['code' => '32136', 'name' => 'Salary of Sales Rep', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3213'],
            ['code' => '32137', 'name' => 'Account 32137', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3213'],

            ['code' => '3214', 'name' => 'Other Administrative Expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '321'],
            ['code' => '32141', 'name' => 'Purchases Services', 'debit' => 47056, 'credit' => 0, 'balance' => 47056, 'parent_code' => '3214'],
            ['code' => '32142', 'name' => 'Maintenance Expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3214'],
            ['code' => '32143', 'name' => 'Advertising, Publicity, Printing, PR and Reception Expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3214'],
            ['code' => '32144', 'name' => 'Transportation and communication expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3214'],
            ['code' => '32145', 'name' => 'Fixed Assets Rent  (real estate excluded)', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3214'],
            ['code' => '32146', 'name' => 'Government agencies &  Institutions  services', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3214'],

            ['code' => '3215', 'name' => 'Other Tertiary Expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '321'],

            ['code' => '32151', 'name' => 'Depreciation and Amortization', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3215'],
            ['code' => '321511', 'name' => 'Fixed assets depreciation', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '32151'],
            ['code' => '321512', 'name' => 'Intangible Assets and Capital Expenses Amortization', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '32151'],

            ['code' => '32152', 'name' => 'Interests', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3215'],
            ['code' => '32153', 'name' => 'Real Estate Rent (lands& buildings)', 'debit' => 53500, 'credit' => 0, 'balance' => 53500, 'parent_code' => '3215'],
            ['code' => '32154', 'name' => 'Real Estate Taxes', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3215'],
            ['code' => '32155', 'name' => 'Indirect Tax on Statement', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3215'],

            ['code' => '322', 'name' => 'marketing expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '32'],
            ['code' => '3221', 'name' => 'Hotels', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '322'],
            ['code' => '3222', 'name' => 'Publicity and Advertising', 'debit' => 16330, 'credit' => 0, 'balance' => 16330, 'parent_code' => '322'],
            ['code' => '3223', 'name' => 'Marketing Gifts and Samples', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '322'],
            ['code' => '3224', 'name' => 'Damaged Production/Purchased Goods (in sale stage).', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '322'],
            ['code' => '3225', 'name' => 'Delay penalties', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '322'],
            ['code' => '3226', 'name' => 'Conferences', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '322'],
            ['code' => '3227', 'name' => 'Tenders Specifications', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '322'],
            ['code' => '3228', 'name' => 'Marketing Tips', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '322'],
            ['code' => '3229', 'name' => 'Sales reps & Marketers Commissions', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '322'],

            ['code' => '323', 'name' => 'Financial expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '32'],
            ['code' => '3231', 'name' => 'Bank expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '323'],
            ['code' => '3232', 'name' => 'LG expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '323'],
            ['code' => '3233', 'name' => 'Bank Expenses and Commissions', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '323'],
            ['code' => '3234', 'name' => 'Bank statement expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '323'],

            ['code' => '324', 'name' => 'Operation and production expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '32'],
            ['code' => '3241', 'name' => 'Operating Salaries', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '324'],

            ['code' => '3242', 'name' => 'Operating Expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '324'],
            ['code' => '32421', 'name' => 'Operation Depreciation Expenses (tools& equipments)', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3242'],
            ['code' => '32422', 'name' => 'Maintenance and repair expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3242'],
            ['code' => '32423', 'name' => 'Operating expenses with others', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3242'],
            ['code' => '32424', 'name' => 'Operating transportation expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3242'],
            ['code' => '32425', 'name' => 'Rent Expenses for Operation Tools and Equipments', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3242'],

            ['code' => '33', 'name' => 'other expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '3'],

            ['code' => '331', 'name' => 'Provisions (other than depreciation)', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '33'],
            ['code' => '3310', 'name' => 'Inventory Adjustment Differences', 'debit' => 236848.079224, 'credit' => 244071.735024, 'balance' => -7223.6558, 'parent_code' => '331'],

            ['code' => '332', 'name' => 'Bad debts', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '33'],
            ['code' => '333', 'name' => 'Securities Sale Losses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '33'],
            ['code' => '334', 'name' => 'Miscellaneous burdens and losses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '33'],
            ['code' => '3341', 'name' => 'Waste Sale Losses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '334'],
            ['code' => '3342', 'name' => 'Raw material, Material and Spare Parts Sale Losses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '334'],
            ['code' => '3343', 'name' => 'Compensations and Penalties', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '334'],
            ['code' => '3344', 'name' => 'Donations and Aids', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '334'],
            ['code' => '3345', 'name' => 'Fraction Approximation Differences', 'debit' => 0.2332387, 'credit' => 0.2360956, 'balance' => -0.0028569, 'parent_code' => '334'],

            ['code' => '335', 'name' => 'Exchange rate losses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '33'],
            ['code' => '336', 'name' => 'Previous Years Expenses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '33'],
            ['code' => '337', 'name' => 'Capital losses', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '33'],
            ['code' => '338', 'name' => 'Financial adjustment differences', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '33'],
            ['code' => '339', 'name' => 'Income Taxes', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '33'],

            // ========== الإيرادات (Revenues) - 4 ==========
            ['code' => '4', 'name' => 'Revenues', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => null],

            ['code' => '41', 'name' => 'Activity revenues', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '4'],

            ['code' => '411', 'name' => 'sales', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '41'],
            ['code' => '4111', 'name' => 'Sales of Purchased Goods', 'debit' => 0, 'credit' => 28027033.291160002, 'balance' => -28027033.291160002, 'parent_code' => '411'],
            ['code' => '4112', 'name' => 'Sales of Finished Goods', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '411'],
            ['code' => '4113', 'name' => 'Sold services', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '411'],
            ['code' => '4114', 'name' => 'Consignment Goods Sale Returns (debit)', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '411'],
            ['code' => '4115', 'name' => 'Sales return (debit)', 'debit' => 214233.764, 'credit' => 0, 'balance' => 214233.764, 'parent_code' => '411'],
            ['code' => '4116', 'name' => 'Sales Allowances (debit)', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '411'],
            ['code' => '4117', 'name' => 'Sales of Consignment goods', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '411'],

            ['code' => '412', 'name' => 'Penalties', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '41'],
            ['code' => '4121', 'name' => 'Discount Allowed', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '412'],
            ['code' => '4122', 'name' => 'Discount Allowed (debit)', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '412'],
            ['code' => '4123', 'name' => 'Quantity Discount Earned', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '412'],
            ['code' => '4124', 'name' => 'Quantity Allowed Discount  (debit)', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '412'],

            ['code' => '413', 'name' => 'Other Statement Revenues', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '41'],
            ['code' => '4131', 'name' => 'Financial lease contract revenue', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '413'],
            ['code' => '4132', 'name' => 'Operation revenue for others', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '413'],
            ['code' => '4133', 'name' => 'Other Operating Revenues', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '413'],
            ['code' => '4134', 'name' => 'End of Day Surplus', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '413'],
            ['code' => '4135', 'name' => 'Realized Gains', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '413'],
            ['code' => '4136', 'name' => 'Delivery Income', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '413'],

            ['code' => '42', 'name' => 'Grants & Aids', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '4'],

            ['code' => '43', 'name' => 'Investment & Interest Revenues', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '4'],
            ['code' => '431', 'name' => 'Financial Investments Revenues from Holding Companies', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '43'],
            ['code' => '432', 'name' => 'Financial Investments Revenues from Sister Companies', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '43'],
            ['code' => '433', 'name' => 'Other Financial Investments Revenue', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '43'],
            ['code' => '434', 'name' => 'Loan Interests to Holding Companies, Affiliated Companies and Sister Companies', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '43'],
            ['code' => '435', 'name' => 'Other credit benefits', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '43'],

            ['code' => '44', 'name' => 'Other Revenues and Profits', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '4'],
            ['code' => '441', 'name' => 'Provisions no longer required', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '44'],
            ['code' => '442', 'name' => 'Debts Already Written-off', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '44'],
            ['code' => '443', 'name' => 'Securities Sale Profits', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '44'],

            ['code' => '444', 'name' => 'Diverse Revenues and Profits', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '44'],
            ['code' => '4441', 'name' => 'Waste Sale Profits', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '444'],
            ['code' => '4442', 'name' => 'Services, Material and Spare Parts Sale Profits', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '444'],
            ['code' => '4443', 'name' => 'Compensations and Penalties Revenues', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '444'],
            ['code' => '4444', 'name' => 'Commissions', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '444'],
            ['code' => '4445', 'name' => 'Credit rent', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '444'],

            ['code' => '445', 'name' => 'Exchange rate profit', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '44'],
            ['code' => '446', 'name' => 'Previous Annual Revenues', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '44'],
            ['code' => '447', 'name' => 'Capital Profits', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '44'],
            ['code' => '448', 'name' => 'Extraordinary Revenues and Profit', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'parent_code' => '44'],
        ];

        // تخزين الـ IDs بعد الإنشاء
        $accountIds = [];

        // أولاً: إنشاء الحسابات الرئيسية (بدون parent)
        foreach ($accounts as $account) {
            if ($account['parent_code'] === null) {
                $created = Account::create([
                    'code' => $account['code'],
                    'name' => $account['name'],
                    'debit' => $account['debit'],
                    'credit' => $account['credit'],
                    'balance' => $account['balance'],
                    'parent_id' => null,
                ]);
                $accountIds[$account['code']] = $created->id;
                $this->command->info("تم إنشاء: {$account['code']} - {$account['name']}");
            }
        }

        // ثانياً: إنشاء باقي الحسابات مع ربطها بالآباء
        foreach ($accounts as $account) {
            if ($account['parent_code'] !== null) {
                if (isset($accountIds[$account['parent_code']])) {
                    Account::create([
                        'code' => $account['code'],
                        'name' => $account['name'],
                        'debit' => $account['debit'],
                        'credit' => $account['credit'],
                        'balance' => $account['balance'],
                        'parent_id' => $accountIds[$account['parent_code']],
                    ]);
                    $this->command->info("تم إنشاء: {$account['code']} - {$account['name']}");
                } else {
                    $this->command->warn("تحذير: لم يتم العثور على parent للحساب {$account['code']}");
                }
            }
        }

        // التحقق من المجاميع النهائية
        $totalDebit = Account::sum('debit');
        $totalCredit = Account::sum('credit');
        $totalBalance = Account::sum('balance');

        $this->command->info('=====================================');
        $this->command->info('✅ تم إنشاء شجرة الحسابات بنجاح!');
        $this->command->info("عدد الحسابات: " . Account::count());
        $this->command->info("إجمالي المدين: " . number_format($totalDebit, 2));
        $this->command->info("إجمالي الدائن: " . number_format($totalCredit, 2));
        $this->command->info("صافي الرصيد: " . number_format($totalBalance, 2));
        $this->command->info('=====================================');
    }
}
