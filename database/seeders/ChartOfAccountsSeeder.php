<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class ChartOfAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            // ========== الأصول (Assets) - 1 ==========
            ['code' => '1', 'name' => 'Assets', 'parent_code' => null],
            ['code' => '11', 'name' => 'Long Term Assets', 'parent_code' => '1'],
            ['code' => '111', 'name' => 'Fixed Assets', 'parent_code' => '11'],
            ['code' => '1111', 'name' => 'Land', 'parent_code' => '111'],
            ['code' => '1112', 'name' => 'Buildings, Constructions, Facilities and roads', 'parent_code' => '111'],
            ['code' => '1113', 'name' => 'Machinery and equipments', 'parent_code' => '111'],
            ['code' => '1114', 'name' => 'Transportation', 'parent_code' => '111'],
            ['code' => '1115', 'name' => 'Tools & Equipments', 'parent_code' => '111'],
            ['code' => '1116', 'name' => 'Animal & Water wealth', 'parent_code' => '111'],

            ['code' => '112', 'name' => 'Ongoing Projects', 'parent_code' => '11'],
            ['code' => '1128', 'name' => 'Investment expenditure', 'parent_code' => '112'],
            ['code' => '11281', 'name' => 'Advance payments', 'parent_code' => '1128'],
            ['code' => '11282', 'name' => 'LC for Fixed assets purchasing', 'parent_code' => '1128'],

            ['code' => '113', 'name' => 'Long term investments', 'parent_code' => '11'],
            ['code' => '1131', 'name' => 'Real State Investment', 'parent_code' => '113'],
            ['code' => '1134', 'name' => 'Shares Investments in other companies', 'parent_code' => '113'],
            ['code' => '1135', 'name' => 'Bond Investments', 'parent_code' => '113'],
            ['code' => '1136', 'name' => 'Investments in Investment documents', 'parent_code' => '113'],

            ['code' => '12', 'name' => 'Current Assets', 'parent_code' => '1'],
            ['code' => '121', 'name' => 'Cash in Hand and at Bank', 'parent_code' => '12'],
            ['code' => '1211', 'name' => 'Treasury', 'parent_code' => '121'],
            ['code' => '1212', 'name' => 'Banks', 'parent_code' => '121'],
            ['code' => '1213', 'name' => 'Employees Custody', 'parent_code' => '121'],
            ['code' => '1214', 'name' => 'Bank term and Notice Deposits', 'parent_code' => '121'],
            ['code' => '1215', 'name' => 'Escrow Account Guarantee', 'parent_code' => '121'],
            ['code' => '1216', 'name' => 'Credit Cards', 'parent_code' => '121'],

            ['code' => '122', 'name' => 'Stock', 'parent_code' => '12'],
            ['code' => '1221', 'name' => 'Goods Stock', 'parent_code' => '122'],
            ['code' => '1222', 'name' => 'Stock of Unfinished Goods', 'parent_code' => '122'],
            ['code' => '1223', 'name' => 'Stock of Finished Goods', 'parent_code' => '122'],
            ['code' => '1224', 'name' => 'Stock in External Warehouses', 'parent_code' => '122'],
            ['code' => '1225', 'name' => 'LC to Purchase Goods and Services', 'parent_code' => '122'],
            ['code' => '1226', 'name' => 'Raw materials, Materials, Fuel and Spare Parts Warehouse', 'parent_code' => '122'],
            ['code' => '1227', 'name' => 'Consignment Inventory', 'parent_code' => '122'],
            ['code' => '1228', 'name' => 'Warehouse transfers', 'parent_code' => '122'],

            ['code' => '123', 'name' => 'Accounts Receivable', 'parent_code' => '12'],
            ['code' => '1231', 'name' => 'Clients', 'parent_code' => '123'],
            ['code' => '1232', 'name' => 'Notes Receivable', 'parent_code' => '123'],
            ['code' => '1233', 'name' => 'Receivables', 'parent_code' => '123'],
            ['code' => '1234', 'name' => 'Foreign Customers', 'parent_code' => '123'],
            ['code' => '1235', 'name' => 'Franchisees', 'parent_code' => '123'],
            ['code' => '1236', 'name' => 'Distributors', 'parent_code' => '123'],
            ['code' => '1237', 'name' => 'Returned Checks Portfolio', 'parent_code' => '123'],

            ['code' => '124', 'name' => 'Accounts Receivable of Authorities and Bodies', 'parent_code' => '12'],
            ['code' => '1241', 'name' => 'Customs Authority (deposits)', 'parent_code' => '124'],
            ['code' => '1242', 'name' => 'Taxes', 'parent_code' => '124'],
            ['code' => '1243', 'name' => 'General Customs Authority (third party deductions)', 'parent_code' => '124'],
            ['code' => '1244', 'name' => 'General Authority for Zakat and Income', 'parent_code' => '124'],

            ['code' => '125', 'name' => 'Debit accounts by employees', 'parent_code' => '12'],
            ['code' => '1251', 'name' => 'Advances to Employees', 'parent_code' => '125'],
            ['code' => '1252', 'name' => 'E-Services Payment entitlements', 'parent_code' => '125'],
            ['code' => '1253', 'name' => 'End of Day Deficit', 'parent_code' => '125'],

            ['code' => '126', 'name' => 'prepaid expenses', 'parent_code' => '12'],
            ['code' => '127', 'name' => 'Accrued Revenues', 'parent_code' => '12'],
            ['code' => '128', 'name' => 'Cash Transfer between Branches', 'parent_code' => '12'],

            ['code' => '129', 'name' => 'Current Investments and Securities', 'parent_code' => '12'],
            ['code' => '1291', 'name' => 'Stocks', 'parent_code' => '129'],
            ['code' => '1292', 'name' => 'investment bonds', 'parent_code' => '129'],
            ['code' => '1293', 'name' => 'Investment documents', 'parent_code' => '129'],
            ['code' => '1294', 'name' => 'Treasury bills', 'parent_code' => '129'],

            ['code' => '13', 'name' => 'Other Assets', 'parent_code' => '1'],
            ['code' => '131', 'name' => 'Intangible assets', 'parent_code' => '13'],
            ['code' => '1311', 'name' => 'Goodwill', 'parent_code' => '131'],
            ['code' => '1312', 'name' => 'Patents/Trademarks/Franchise Rights and Authorship', 'parent_code' => '131'],
            ['code' => '1313', 'name' => 'Development cost', 'parent_code' => '131'],

            ['code' => '132', 'name' => 'Capitalized Expenses', 'parent_code' => '13'],
            ['code' => '1321', 'name' => 'Business branches and showrooms modernization expenses', 'parent_code' => '132'],
            ['code' => '1322', 'name' => 'Company Contribution in Establishing Assets that it doesn\'t own but serve its purposes.', 'parent_code' => '132'],
            ['code' => '1323', 'name' => 'In exchange for the right to usufruct a place through purchase of business assets', 'parent_code' => '132'],

            ['code' => '133', 'name' => 'Deferred Expenses*', 'parent_code' => '13'],
            ['code' => '1331', 'name' => 'Incorporation Expenses', 'parent_code' => '133'],
            ['code' => '1332', 'name' => 'Pre-production/Pre-operation Expenses', 'parent_code' => '133'],
            ['code' => '1333', 'name' => 'Advertising campaign', 'parent_code' => '133'],

            // ========== الخصوم وحقوق الملكية (Liabilities and Property Rights) - 2 ==========
            ['code' => '2', 'name' => 'Liabilities and Property Rights', 'parent_code' => null],

            ['code' => '21', 'name' => 'Currents Liabilites', 'parent_code' => '2'],

            ['code' => '211', 'name' => 'Accounts Payable', 'parent_code' => '21'],
            ['code' => '2111', 'name' => 'Vendors', 'parent_code' => '211'],
            ['code' => '2112', 'name' => 'Notes Payable', 'parent_code' => '211'],
            ['code' => '2113', 'name' => 'Creditors of Dividends', 'parent_code' => '211'],
            ['code' => '2114', 'name' => 'Credit Accounts', 'parent_code' => '211'],

            ['code' => '212', 'name' => 'Due expenses', 'parent_code' => '21'],
            ['code' => '2121', 'name' => 'Due salaries', 'parent_code' => '212'],
            ['code' => '2122', 'name' => 'Revenues Collected in Advance', 'parent_code' => '212'],
            ['code' => '2123', 'name' => 'Other Accounts Payable', 'parent_code' => '212'],

            ['code' => '213', 'name' => 'Accounts Payable for Authorities and Bodies', 'parent_code' => '21'],
            ['code' => '2131', 'name' => 'Customs authority', 'parent_code' => '213'],
            ['code' => '2132', 'name' => 'VAT', 'parent_code' => '213'],
            ['code' => '2133', 'name' => 'General Taxation Authority', 'parent_code' => '213'],
            ['code' => '2134', 'name' => 'Real Estate Taxation Authority', 'parent_code' => '213'],
            ['code' => '2135', 'name' => 'Social insurance current account', 'parent_code' => '213'],
            ['code' => '2136', 'name' => 'Other Insurance Authorities', 'parent_code' => '213'],
            ['code' => '2137', 'name' => 'Withholding Tax', 'parent_code' => '213'],

            ['code' => '214', 'name' => 'Other Accounts Payable', 'parent_code' => '21'],
            ['code' => '2141', 'name' => 'Overdraft', 'parent_code' => '214'],
            ['code' => '2142', 'name' => 'Financing of LCs', 'parent_code' => '214'],
            ['code' => '2143', 'name' => 'Short term loans', 'parent_code' => '214'],
            ['code' => '2144', 'name' => 'Credit Accounts for Holding Company, Affiliated Company and Sister Company', 'parent_code' => '214'],
            ['code' => '2145', 'name' => 'Unrealized Gains', 'parent_code' => '214'],
            ['code' => '2146', 'name' => 'Discount Coupons', 'parent_code' => '214'],

            ['code' => '22', 'name' => 'Long term Liabilities', 'parent_code' => '2'],
            ['code' => '221', 'name' => 'Long term loans from Holding company, affiliated company and sister company', 'parent_code' => '22'],
            ['code' => '222', 'name' => 'Long terms loans from banks', 'parent_code' => '22'],
            ['code' => '223', 'name' => 'Long Terms Loans from Other Parties', 'parent_code' => '22'],
            ['code' => '224', 'name' => 'Bonds', 'parent_code' => '22'],

            ['code' => '23', 'name' => 'Provisions:', 'parent_code' => '2'],

            ['code' => '231', 'name' => 'Provision for Fixed Assets Depreciation', 'parent_code' => '23'],
            ['code' => '2311', 'name' => 'Provision for Destructible Perennial Produce', 'parent_code' => '231'],
            ['code' => '2312', 'name' => 'Provision for Buildings, Construction, Facilities and Roads Depreciation', 'parent_code' => '231'],
            ['code' => '2313', 'name' => 'Provision for Tools & Equipments Depreciation', 'parent_code' => '231'],
            ['code' => '2314', 'name' => 'Provision for Transportation Depreciation', 'parent_code' => '231'],
            ['code' => '2315', 'name' => 'Provision for Machines and Equipments Depreciation', 'parent_code' => '231'],
            ['code' => '2316', 'name' => 'Provision for Furniture and Office Equipments Depreciation', 'parent_code' => '231'],
            ['code' => '2317', 'name' => 'Provision for Animal & Water Wealth Depreciation', 'parent_code' => '231'],

            ['code' => '232', 'name' => 'Provision for Unfinished Products Price Decrease', 'parent_code' => '23'],
            ['code' => '233', 'name' => 'Provision for Finished Products Price Decrease', 'parent_code' => '23'],
            ['code' => '234', 'name' => 'Provision for Purchased Goods Price Decrease', 'parent_code' => '23'],
            ['code' => '235', 'name' => 'Provision for Securities Price Decrease', 'parent_code' => '23'],
            ['code' => '236', 'name' => 'provision for doubtful debts', 'parent_code' => '23'],
            ['code' => '237', 'name' => 'Provision for disputed taxes', 'parent_code' => '23'],
            ['code' => '238', 'name' => 'provision for claims and disputes', 'parent_code' => '23'],
            ['code' => '239', 'name' => 'other provisions', 'parent_code' => '23'],

            ['code' => '24', 'name' => 'Property rights', 'parent_code' => '2'],
            ['code' => '241', 'name' => 'Capital', 'parent_code' => '24'],
            ['code' => '242', 'name' => 'Shareholders current accounts', 'parent_code' => '24'],
            ['code' => '243', 'name' => 'Late installments', 'parent_code' => '24'],
            ['code' => '244', 'name' => 'Retained Earnings (losses)', 'parent_code' => '24'],
            ['code' => '245', 'name' => 'Treasury Stock', 'parent_code' => '24'],

            ['code' => '246', 'name' => 'Reserves', 'parent_code' => '24'],
            ['code' => '2461', 'name' => 'legal reserve', 'parent_code' => '246'],
            ['code' => '2462', 'name' => 'Statutory Reserve', 'parent_code' => '246'],
            ['code' => '2463', 'name' => 'Capital reserve', 'parent_code' => '246'],
            ['code' => '2464', 'name' => 'other reserves', 'parent_code' => '246'],

            ['code' => '247', 'name' => 'Opening balances', 'parent_code' => '24'],

            // ========== المصروفات (Expenses) - 3 ==========
            ['code' => '3', 'name' => 'Expenses', 'parent_code' => null],

            ['code' => '31', 'name' => 'Cost of Sold Goods', 'parent_code' => '3'],

            ['code' => '32', 'name' => 'Statement Expenses', 'parent_code' => '3'],

            ['code' => '321', 'name' => 'General & Admin expenses', 'parent_code' => '32'],

            ['code' => '3211', 'name' => 'Material, fuel and spare parts', 'parent_code' => '321'],
            ['code' => '32111', 'name' => 'Fuel and Oils', 'parent_code' => '3211'],
            ['code' => '32112', 'name' => 'Spare Parts and Gears', 'parent_code' => '3211'],
            ['code' => '32113', 'name' => 'Electricity & water', 'parent_code' => '3211'],
            ['code' => '32114', 'name' => 'Account 32114', 'parent_code' => '3211'],
            ['code' => '32115', 'name' => 'Account 32115', 'parent_code' => '3211'],
            ['code' => '32116', 'name' => 'Account 32116', 'parent_code' => '3211'],

            ['code' => '3212', 'name' => 'Petty expenses', 'parent_code' => '321'],
            ['code' => '32121', 'name' => 'Telephones, Mobiles & Internet', 'parent_code' => '3212'],
            ['code' => '32122', 'name' => 'In office and Out-of-office Expenses', 'parent_code' => '3212'],
            ['code' => '32123', 'name' => 'Administrative tips', 'parent_code' => '3212'],
            ['code' => '32124', 'name' => 'Stationary', 'parent_code' => '3212'],
            ['code' => '32125', 'name' => 'Account 32125', 'parent_code' => '3212'],
            ['code' => '32126', 'name' => 'Account 32126', 'parent_code' => '3212'],

            ['code' => '3213', 'name' => 'Wages', 'parent_code' => '321'],
            ['code' => '32131', 'name' => 'Wages in Cash', 'parent_code' => '3213'],
            ['code' => '32132', 'name' => 'Advantages In kind', 'parent_code' => '3213'],
            ['code' => '32133', 'name' => 'Social insurance', 'parent_code' => '3213'],
            ['code' => '32134', 'name' => 'transportation expenses', 'parent_code' => '3213'],
            ['code' => '32135', 'name' => 'Legal and Accounting fees', 'parent_code' => '3213'],
            ['code' => '32136', 'name' => 'Salary of Sales Rep', 'parent_code' => '3213'],
            ['code' => '32137', 'name' => 'Account 32137', 'parent_code' => '3213'],

            ['code' => '3214', 'name' => 'Other Administrative Expenses', 'parent_code' => '321'],
            ['code' => '32141', 'name' => 'Purchases Services', 'parent_code' => '3214'],
            ['code' => '32142', 'name' => 'Maintenance Expenses', 'parent_code' => '3214'],
            ['code' => '32143', 'name' => 'Advertising, Publicity, Printing, PR and Reception Expenses', 'parent_code' => '3214'],
            ['code' => '32144', 'name' => 'Transportation and communication expenses', 'parent_code' => '3214'],
            ['code' => '32145', 'name' => 'Fixed Assets Rent (real estate excluded)', 'parent_code' => '3214'],
            ['code' => '32146', 'name' => 'Government agencies & Institutions services', 'parent_code' => '3214'],

            ['code' => '3215', 'name' => 'Other Tertiary Expenses', 'parent_code' => '321'],

            ['code' => '32151', 'name' => 'Depreciation and Amortization', 'parent_code' => '3215'],
            ['code' => '321511', 'name' => 'Fixed assets depreciation', 'parent_code' => '32151'],
            ['code' => '321512', 'name' => 'Intangible Assets and Capital Expenses Amortization', 'parent_code' => '32151'],

            ['code' => '32152', 'name' => 'Interests', 'parent_code' => '3215'],
            ['code' => '32153', 'name' => 'Real Estate Rent (lands& buildings)', 'parent_code' => '3215'],
            ['code' => '32154', 'name' => 'Real Estate Taxes', 'parent_code' => '3215'],
            ['code' => '32155', 'name' => 'Indirect Tax on Statement', 'parent_code' => '3215'],

            ['code' => '322', 'name' => 'marketing expenses', 'parent_code' => '32'],
            ['code' => '3221', 'name' => 'Hotels', 'parent_code' => '322'],
            ['code' => '3222', 'name' => 'Publicity and Advertising', 'parent_code' => '322'],
            ['code' => '3223', 'name' => 'Marketing Gifts and Samples', 'parent_code' => '322'],
            ['code' => '3224', 'name' => 'Damaged Production/Purchased Goods (in sale stage)', 'parent_code' => '322'],
            ['code' => '3225', 'name' => 'Delay penalties', 'parent_code' => '322'],
            ['code' => '3226', 'name' => 'Conferences', 'parent_code' => '322'],
            ['code' => '3227', 'name' => 'Tenders Specifications', 'parent_code' => '322'],
            ['code' => '3228', 'name' => 'Marketing Tips', 'parent_code' => '322'],
            ['code' => '3229', 'name' => 'Sales reps & Marketers Commissions', 'parent_code' => '322'],

            ['code' => '323', 'name' => 'Financial expenses', 'parent_code' => '32'],
            ['code' => '3231', 'name' => 'Bank expenses', 'parent_code' => '323'],
            ['code' => '3232', 'name' => 'LG expenses', 'parent_code' => '323'],
            ['code' => '3233', 'name' => 'Bank Expenses and Commissions', 'parent_code' => '323'],
            ['code' => '3234', 'name' => 'Bank statement expenses', 'parent_code' => '323'],

            ['code' => '324', 'name' => 'Operation and production expenses', 'parent_code' => '32'],
            ['code' => '3241', 'name' => 'Operating Salaries', 'parent_code' => '324'],

            ['code' => '3242', 'name' => 'Operating Expenses', 'parent_code' => '324'],
            ['code' => '32421', 'name' => 'Operation Depreciation Expenses (tools& equipments)', 'parent_code' => '3242'],
            ['code' => '32422', 'name' => 'Maintenance and repair expenses', 'parent_code' => '3242'],
            ['code' => '32423', 'name' => 'Operating expenses with others', 'parent_code' => '3242'],
            ['code' => '32424', 'name' => 'Operating transportation expenses', 'parent_code' => '3242'],
            ['code' => '32425', 'name' => 'Rent Expenses for Operation Tools and Equipments', 'parent_code' => '3242'],

            ['code' => '33', 'name' => 'other expenses', 'parent_code' => '3'],

            ['code' => '331', 'name' => 'Provisions (other than depreciation)', 'parent_code' => '33'],
            ['code' => '3310', 'name' => 'Inventory Adjustment Differences', 'parent_code' => '331'],

            ['code' => '332', 'name' => 'Bad debts', 'parent_code' => '33'],
            ['code' => '333', 'name' => 'Securities Sale Losses', 'parent_code' => '33'],
            ['code' => '334', 'name' => 'Miscellaneous burdens and losses', 'parent_code' => '33'],
            ['code' => '3341', 'name' => 'Waste Sale Losses', 'parent_code' => '334'],
            ['code' => '3342', 'name' => 'Raw material, Material and Spare Parts Sale Losses', 'parent_code' => '334'],
            ['code' => '3343', 'name' => 'Compensations and Penalties', 'parent_code' => '334'],
            ['code' => '3344', 'name' => 'Donations and Aids', 'parent_code' => '334'],
            ['code' => '3345', 'name' => 'Fraction Approximation Differences', 'parent_code' => '334'],

            ['code' => '335', 'name' => 'Exchange rate losses', 'parent_code' => '33'],
            ['code' => '336', 'name' => 'Previous Years Expenses', 'parent_code' => '33'],
            ['code' => '337', 'name' => 'Capital losses', 'parent_code' => '33'],
            ['code' => '338', 'name' => 'Financial adjustment differences', 'parent_code' => '33'],
            ['code' => '339', 'name' => 'Income Taxes', 'parent_code' => '33'],

            // ========== الإيرادات (Revenues) - 4 ==========
            ['code' => '4', 'name' => 'Revenues', 'parent_code' => null],

            ['code' => '41', 'name' => 'Activity revenues', 'parent_code' => '4'],

            ['code' => '411', 'name' => 'sales', 'parent_code' => '41'],
            ['code' => '4111', 'name' => 'Sales of Purchased Goods', 'parent_code' => '411'],
            ['code' => '4112', 'name' => 'Sales of Finished Goods', 'parent_code' => '411'],
            ['code' => '4113', 'name' => 'Sold services', 'parent_code' => '411'],
            ['code' => '4114', 'name' => 'Consignment Goods Sale Returns (debit)', 'parent_code' => '411'],
            ['code' => '4115', 'name' => 'Sales return (debit)', 'parent_code' => '411'],
            ['code' => '4116', 'name' => 'Sales Allowances (debit)', 'parent_code' => '411'],
            ['code' => '4117', 'name' => 'Sales of Consignment goods', 'parent_code' => '411'],

            ['code' => '412', 'name' => 'Penalties', 'parent_code' => '41'],
            ['code' => '4121', 'name' => 'Discount Allowed', 'parent_code' => '412'],
            ['code' => '4122', 'name' => 'Discount Allowed (debit)', 'parent_code' => '412'],
            ['code' => '4123', 'name' => 'Quantity Discount Earned', 'parent_code' => '412'],
            ['code' => '4124', 'name' => 'Quantity Allowed Discount (debit)', 'parent_code' => '412'],

            ['code' => '413', 'name' => 'Other Statement Revenues', 'parent_code' => '41'],
            ['code' => '4131', 'name' => 'Financial lease contract revenue', 'parent_code' => '413'],
            ['code' => '4132', 'name' => 'Operation revenue for others', 'parent_code' => '413'],
            ['code' => '4133', 'name' => 'Other Operating Revenues', 'parent_code' => '413'],
            ['code' => '4134', 'name' => 'End of Day Surplus', 'parent_code' => '413'],
            ['code' => '4135', 'name' => 'Realized Gains', 'parent_code' => '413'],
            ['code' => '4136', 'name' => 'Delivery Income', 'parent_code' => '413'],

            ['code' => '42', 'name' => 'Grants & Aids', 'parent_code' => '4'],

            ['code' => '43', 'name' => 'Investment & Interest Revenues', 'parent_code' => '4'],
            ['code' => '431', 'name' => 'Financial Investments Revenues from Holding Companies', 'parent_code' => '43'],
            ['code' => '432', 'name' => 'Financial Investments Revenues from Sister Companies', 'parent_code' => '43'],
            ['code' => '433', 'name' => 'Other Financial Investments Revenue', 'parent_code' => '43'],
            ['code' => '434', 'name' => 'Loan Interests to Holding Companies, Affiliated Companies and Sister Companies', 'parent_code' => '43'],
            ['code' => '435', 'name' => 'Other credit benefits', 'parent_code' => '43'],

            ['code' => '44', 'name' => 'Other Revenues and Profits', 'parent_code' => '4'],
            ['code' => '441', 'name' => 'Provisions no longer required', 'parent_code' => '44'],
            ['code' => '442', 'name' => 'Debts Already Written-off', 'parent_code' => '44'],
            ['code' => '443', 'name' => 'Securities Sale Profits', 'parent_code' => '44'],

            ['code' => '444', 'name' => 'Diverse Revenues and Profits', 'parent_code' => '44'],
            ['code' => '4441', 'name' => 'Waste Sale Profits', 'parent_code' => '444'],
            ['code' => '4442', 'name' => 'Services, Material and Spare Parts Sale Profits', 'parent_code' => '444'],
            ['code' => '4443', 'name' => 'Compensations and Penalties Revenues', 'parent_code' => '444'],
            ['code' => '4444', 'name' => 'Commissions', 'parent_code' => '444'],
            ['code' => '4445', 'name' => 'Credit rent', 'parent_code' => '444'],

            ['code' => '445', 'name' => 'Exchange rate profit', 'parent_code' => '44'],
            ['code' => '446', 'name' => 'Previous Annual Revenues', 'parent_code' => '44'],
            ['code' => '447', 'name' => 'Capital Profits', 'parent_code' => '44'],
            ['code' => '448', 'name' => 'Extraordinary Revenues and Profit', 'parent_code' => '44'],
        ];

        // تخزين الـ IDs بعد الإنشاء
        $accountIds = [];

        // أولاً: إنشاء الحسابات الرئيسية (بدون parent)
        foreach ($accounts as $account) {
            if ($account['parent_code'] === null) {
                $created = Account::create([
                    'code' => $account['code'],
                    'name' => $account['name'],
                    'debit' => 0,
                    'credit' => 0,
                    'balance' => 0,
                    'parent_id' => null,
                ]);
                $accountIds[$account['code']] = $created->id;
            }
        }

        // ثانياً: إنشاء باقي الحسابات مع ربطها بالآباء
        foreach ($accounts as $account) {
            if ($account['parent_code'] !== null) {
                // التأكد أن الـ parent موجود
                if (isset($accountIds[$account['parent_code']])) {
                    Account::create([
                        'code' => $account['code'],
                        'name' => $account['name'],
                        'debit' => 0,
                        'credit' => 0,
                        'balance' => 0,
                        'parent_id' => $accountIds[$account['parent_code']],
                    ]);
                }
            }
        }

        $this->command->info('تم إنشاء شجرة الحسابات بنجاح!');
    }
}
