<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartOfAccountsSeeder extends Seeder
{
    public function run(): void
    {
        // مسح الحسابات القديمة
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Account::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // مصفوفة جميع الحسابات من ملف Excel (بدون الأرصدة)
        $accounts = [
            // ========== الأصول (Assets) - 1 ==========
            ['code' => '1', 'name' => 'Assets', 'name_ar' => 'الأصول', 'parent_code' => null],
            ['code' => '11', 'name' => 'Long Term Assets', 'name_ar' => 'الأصول طويلة الأجل', 'parent_code' => '1'],
            ['code' => '111', 'name' => 'Fixed Assets', 'name_ar' => 'الأصول الثابتة', 'parent_code' => '11'],
            ['code' => '1111', 'name' => 'Land', 'name_ar' => 'الأراضي', 'parent_code' => '111'],
            ['code' => '1112', 'name' => 'Buildings, Constructions, Facilities and roads', 'name_ar' => 'المباني والمنشآت والمرافق والطرق', 'parent_code' => '111'],
            ['code' => '1113', 'name' => 'Machinery and equipments', 'name_ar' => 'الآلات والمعدات', 'parent_code' => '111'],
            ['code' => '1114', 'name' => 'Transportation', 'name_ar' => 'وسائل النقل', 'parent_code' => '111'],
            ['code' => '1115', 'name' => 'Tools & Equipments', 'name_ar' => 'الأدوات والمعدات', 'parent_code' => '111'],
            ['code' => '1116', 'name' => 'Animal & Water wealth', 'name_ar' => 'الثروة الحيوانية والسمكية', 'parent_code' => '111'],

            ['code' => '112', 'name' => 'Ongoing Projects', 'name_ar' => 'المشروعات تحت التنفيذ', 'parent_code' => '11'],
            ['code' => '1128', 'name' => 'Investment expenditure', 'name_ar' => 'مصروفات استثمارية', 'parent_code' => '112'],
            ['code' => '11281', 'name' => 'Advance payments', 'name_ar' => 'دفعات مقدمة', 'parent_code' => '1128'],
            ['code' => '11282', 'name' => 'LC for Fixed assets purchasing', 'name_ar' => 'اعتمادات مستندية لشراء أصول ثابتة', 'parent_code' => '1128'],

            ['code' => '113', 'name' => 'Long term investments', 'name_ar' => 'استثمارات طويلة الأجل', 'parent_code' => '11'],
            ['code' => '1131', 'name' => 'Real State Investment', 'name_ar' => 'استثمارات عقارية', 'parent_code' => '113'],
            ['code' => '1134', 'name' => 'Shares Investments in other companies', 'name_ar' => 'استثمارات في أسهم شركات أخرى', 'parent_code' => '113'],
            ['code' => '1135', 'name' => 'Bond Investments', 'name_ar' => 'استثمارات في سندات', 'parent_code' => '113'],
            ['code' => '1136', 'name' => 'Investments in Investment documents', 'name_ar' => 'استثمارات في أوراق استثمارية', 'parent_code' => '113'],

            ['code' => '12', 'name' => 'Current Assets', 'name_ar' => 'الأصول المتداولة', 'parent_code' => '1'],
            ['code' => '121', 'name' => 'Cash in Hand and at Bank', 'name_ar' => 'النقدية بالخزينة والبنوك', 'parent_code' => '12'],
            ['code' => '1211', 'name' => 'Treasury', 'name_ar' => 'الخزينة', 'parent_code' => '121'],
            ['code' => '1212', 'name' => 'Banks', 'name_ar' => 'البنوك', 'parent_code' => '121'],
            ['code' => '1213', 'name' => 'Employees Custody', 'name_ar' => 'عهد الموظفين', 'parent_code' => '121'],
            ['code' => '1214', 'name' => 'Bank term and Notice Deposits', 'name_ar' => 'ودائع زمنية وإخطار بنكية', 'parent_code' => '121'],
            ['code' => '1215', 'name' => 'Escrow Account Guarantee', 'name_ar' => 'حسابات ضمان', 'parent_code' => '121'],
            ['code' => '1216', 'name' => 'Credit Cards', 'name_ar' => 'بطاقات ائتمان', 'parent_code' => '121'],

            ['code' => '122', 'name' => 'Stock', 'name_ar' => 'المخزون', 'parent_code' => '12'],
            ['code' => '1221', 'name' => 'Goods Stock', 'name_ar' => 'مخزون البضائع', 'parent_code' => '122'],
            ['code' => '1222', 'name' => 'Stock of Unfinished Goods', 'name_ar' => 'مخزون إنتاج تحت التشغيل', 'parent_code' => '122'],
            ['code' => '1223', 'name' => 'Stock of Finished Goods', 'name_ar' => 'مخزون إنتاج تام', 'parent_code' => '122'],
            ['code' => '1224', 'name' => 'Stock in External Warehouses', 'name_ar' => 'مخزون بمخازن خارجية', 'parent_code' => '122'],
            ['code' => '1225', 'name' => 'LC to Purchase Goods and Services', 'name_ar' => 'اعتمادات مستندية لشراء بضائع وخدمات', 'parent_code' => '122'],
            ['code' => '1226', 'name' => 'Raw materials, Materials, Fuel and Spare Parts Warehouse', 'name_ar' => 'مخازن مواد خام ومواد ووقود وقطع غيار', 'parent_code' => '122'],
            ['code' => '1227', 'name' => 'Consignment Inventory', 'name_ar' => 'بضاعة أمانة لدى الغير', 'parent_code' => '122'],
            ['code' => '1228', 'name' => 'Warehouse transfers', 'name_ar' => 'تحويلات مخازن', 'parent_code' => '122'],

            ['code' => '123', 'name' => 'Accounts Receivable', 'name_ar' => 'حسابات مدينة', 'parent_code' => '12'],
            ['code' => '1231', 'name' => 'Clients', 'name_ar' => 'عملاء', 'parent_code' => '123'],
            ['code' => '1232', 'name' => 'Notes Receivable', 'name_ar' => 'أوراق قبض', 'parent_code' => '123'],
            ['code' => '1233', 'name' => 'Receivables', 'name_ar' => 'مدينون', 'parent_code' => '123'],
            ['code' => '1234', 'name' => 'Foreign Customers', 'name_ar' => 'عملاء خارجيون', 'parent_code' => '123'],
            ['code' => '1235', 'name' => 'Franchisees', 'name_ar' => 'وكلاء بالعمولة', 'parent_code' => '123'],
            ['code' => '1236', 'name' => 'Distributors', 'name_ar' => 'موزعون', 'parent_code' => '123'],
            ['code' => '1237', 'name' => 'Returned Checks Portfolio', 'name_ar' => 'محفظة شيكات مرتجعة', 'parent_code' => '123'],

            ['code' => '124', 'name' => 'Accounts Receivable of Authorities and Bodies', 'name_ar' => 'حسابات مدينة لهيئات ومصالح', 'parent_code' => '12'],
            ['code' => '1241', 'name' => 'Customs Authority (deposits)', 'name_ar' => 'مصلحة الجمارك (تأمينات)', 'parent_code' => '124'],
            ['code' => '1242', 'name' => 'Taxes', 'name_ar' => 'الضرائب', 'parent_code' => '124'],
            ['code' => '1243', 'name' => 'General Customs Authority (third party deductions)', 'name_ar' => 'مصلحة الجمارك (خصم طرف)', 'parent_code' => '124'],
            ['code' => '1244', 'name' => 'General Authority for Zakat and Income', 'name_ar' => 'الهيئة العامة للزكاة والدخل', 'parent_code' => '124'],

            ['code' => '125', 'name' => 'Debit accounts by employees', 'name_ar' => 'حسابات مدينة للموظفين', 'parent_code' => '12'],
            ['code' => '1251', 'name' => 'Advances to Employees', 'name_ar' => 'سلف الموظفين', 'parent_code' => '125'],
            ['code' => '1252', 'name' => 'E-Services Payment entitlements', 'name_ar' => 'مستحقات مدفوعات خدمات إلكترونية', 'parent_code' => '125'],
            ['code' => '1253', 'name' => 'End of Day Deficit', 'name_ar' => 'عجز نهاية اليوم', 'parent_code' => '125'],

            ['code' => '126', 'name' => 'prepaid expenses', 'name_ar' => 'مصروفات مدفوعة مقدماً', 'parent_code' => '12'],
            ['code' => '127', 'name' => 'Accrued Revenues', 'name_ar' => 'إيرادات مستحقة', 'parent_code' => '12'],
            ['code' => '128', 'name' => 'Cash Transfer between Branches', 'name_ar' => 'تحويلات نقدية بين الفروع', 'parent_code' => '12'],

            ['code' => '129', 'name' => 'Current Investments and Securities', 'name_ar' => 'استثمارات وأوراق مالية متداولة', 'parent_code' => '12'],
            ['code' => '1291', 'name' => 'Stocks', 'name_ar' => 'أسهم', 'parent_code' => '129'],
            ['code' => '1292', 'name' => 'investment bonds', 'name_ar' => 'سندات استثمارية', 'parent_code' => '129'],
            ['code' => '1293', 'name' => 'Investment documents', 'name_ar' => 'أوراق استثمارية', 'parent_code' => '129'],
            ['code' => '1294', 'name' => 'Treasury bills', 'name_ar' => 'أذون خزانة', 'parent_code' => '129'],

            ['code' => '13', 'name' => 'Other Assets', 'name_ar' => 'الأصول الأخرى', 'parent_code' => '1'],
            ['code' => '131', 'name' => 'Intangible assets', 'name_ar' => 'أصول غير ملموسة', 'parent_code' => '13'],
            ['code' => '1311', 'name' => 'Goodwill', 'name_ar' => 'شهرة', 'parent_code' => '131'],
            ['code' => '1312', 'name' => 'Patents/Trademarks/Franchise Rights and Authorship', 'name_ar' => 'براءات اختراع/علامات تجارية/حقوق امتياز وتأليف', 'parent_code' => '131'],
            ['code' => '1313', 'name' => 'Development cost', 'name_ar' => 'تكاليف تطوير', 'parent_code' => '131'],

            ['code' => '132', 'name' => 'Capitalized Expenses', 'name_ar' => 'مصروفات رأسمالية', 'parent_code' => '13'],
            ['code' => '1321', 'name' => 'Business branches and showrooms modernization expenses', 'name_ar' => 'مصروفات تحديث فروع الشركة وصالات العرض', 'parent_code' => '132'],
            ['code' => '1322', 'name' => 'Company Contribution in Establishing Assets that it doesn\'t own but serve its purposes.', 'name_ar' => 'إسهام الشركة في إنشاء أصول لا تملكها ولكن تخدم أغراضها', 'parent_code' => '132'],
            ['code' => '1323', 'name' => 'In exchange for the right to usufruct a place through purchase of business assets', 'name_ar' => 'مقابل حق الانتفاع بمكان عن طريق شراء أصول تجارية', 'parent_code' => '132'],

            ['code' => '133', 'name' => 'Deferred Expenses*', 'name_ar' => 'مصروفات مؤجلة', 'parent_code' => '13'],
            ['code' => '1331', 'name' => 'Incorporation Expenses', 'name_ar' => 'مصروفات التأسيس', 'parent_code' => '133'],
            ['code' => '1332', 'name' => 'Pre-production/Pre-operation Expenses', 'name_ar' => 'مصروفات قبل التشغيل/الإنتاج', 'parent_code' => '133'],
            ['code' => '1333', 'name' => 'Advertising campaign', 'name_ar' => 'حملات إعلانية', 'parent_code' => '133'],

            // ========== الخصوم وحقوق الملكية (Liabilities and Property Rights) - 2 ==========
            ['code' => '2', 'name' => 'Liabilities and Property Rights', 'name_ar' => 'الخصوم وحقوق الملكية', 'parent_code' => null],

            ['code' => '21', 'name' => 'Currents Liabilites', 'name_ar' => 'الخصوم المتداولة', 'parent_code' => '2'],

            ['code' => '211', 'name' => 'Accounts Payable', 'name_ar' => 'حسابات دائنة', 'parent_code' => '21'],
            ['code' => '2111', 'name' => 'Vendors', 'name_ar' => 'موردون', 'parent_code' => '211'],
            ['code' => '2112', 'name' => 'Notes Payable', 'name_ar' => 'أوراق دفع', 'parent_code' => '211'],
            ['code' => '2113', 'name' => 'Creditors of Dividends', 'name_ar' => 'دائنو أرباح', 'parent_code' => '211'],
            ['code' => '2114', 'name' => 'Credit Accounts', 'name_ar' => 'حسابات دائنة', 'parent_code' => '211'],

            ['code' => '212', 'name' => 'Due expenses', 'name_ar' => 'مصروفات مستحقة', 'parent_code' => '21'],
            ['code' => '2121', 'name' => 'Due salaries', 'name_ar' => 'رواتب مستحقة', 'parent_code' => '212'],
            ['code' => '2122', 'name' => 'Revenues Collected in Advance', 'name_ar' => 'إيرادات مقبوضة مقدماً', 'parent_code' => '212'],
            ['code' => '2123', 'name' => 'Other Accounts Payable', 'name_ar' => 'حسابات دائنة أخرى', 'parent_code' => '212'],

            ['code' => '213', 'name' => 'Accounts Payable for Authorities and Bodies', 'name_ar' => 'حسابات دائنة لهيئات ومصالح', 'parent_code' => '21'],
            ['code' => '2131', 'name' => 'Customs authority', 'name_ar' => 'مصلحة الجمارك', 'parent_code' => '213'],
            ['code' => '2132', 'name' => 'VAT', 'name_ar' => 'ضريبة القيمة المضافة', 'parent_code' => '213'],
            ['code' => '2133', 'name' => 'General Taxation Authority', 'name_ar' => 'الهيئة العامة للضرائب', 'parent_code' => '213'],
            ['code' => '2134', 'name' => 'Real Estate Taxation Authority', 'name_ar' => 'مصلحة الضرائب العقارية', 'parent_code' => '213'],
            ['code' => '2135', 'name' => 'Social insurance current account', 'name_ar' => 'حساب التأمينات الاجتماعية الجاري', 'parent_code' => '213'],
            ['code' => '2136', 'name' => 'Other Insurance Authorities', 'name_ar' => 'جهات تأمينية أخرى', 'parent_code' => '213'],
            ['code' => '2137', 'name' => 'Withholding Tax', 'name_ar' => 'ضريبة الخصم من المنبع', 'parent_code' => '213'],

            ['code' => '214', 'name' => 'Other Accounts Payable', 'name_ar' => 'حسابات دائنة أخرى', 'parent_code' => '21'],
            ['code' => '2141', 'name' => 'Overdraft', 'name_ar' => 'السحب على المكشوف', 'parent_code' => '214'],
            ['code' => '2142', 'name' => 'Financing of LCs', 'name_ar' => 'تمويل اعتمادات مستندية', 'parent_code' => '214'],
            ['code' => '2143', 'name' => 'Short term loans', 'name_ar' => 'قروض قصيرة الأجل', 'parent_code' => '214'],
            ['code' => '2144', 'name' => 'Credit Accounts for Holding Company, Affiliated Company and Sister Company', 'name_ar' => 'حسابات دائنة لشركة أم وشركة زميلة وشقيقة', 'parent_code' => '214'],
            ['code' => '2145', 'name' => 'Unrealized Gains', 'name_ar' => 'أرباح غير محققة', 'parent_code' => '214'],
            ['code' => '2146', 'name' => 'Discount Coupons', 'name_ar' => 'كوبونات خصم', 'parent_code' => '214'],

            ['code' => '22', 'name' => 'Long term Liabilities', 'name_ar' => 'الخصوم طويلة الأجل', 'parent_code' => '2'],
            ['code' => '221', 'name' => 'Long term loans from Holding company, affiliated company and sister company', 'name_ar' => 'قروض طويلة الأجل من شركات أم وزميلة وشقيقة', 'parent_code' => '22'],
            ['code' => '222', 'name' => 'Long terms loans from banks', 'name_ar' => 'قروض طويلة الأجل من البنوك', 'parent_code' => '22'],
            ['code' => '223', 'name' => 'Long Terms Loans from Other Parties', 'name_ar' => 'قروض طويلة الأجل من أطراف أخرى', 'parent_code' => '22'],
            ['code' => '224', 'name' => 'Bonds', 'name_ar' => 'سندات', 'parent_code' => '22'],

            ['code' => '23', 'name' => 'Provisions:', 'name_ar' => 'المخصصات', 'parent_code' => '2'],

            ['code' => '231', 'name' => 'Provision for Fixed Assets Depreciation', 'name_ar' => 'مخصص إهلاك الأصول الثابتة', 'parent_code' => '23'],
            ['code' => '2311', 'name' => 'Provision for Destructible Perennial Produce', 'name_ar' => 'مخصص إهلاك أثمار معمرة قابلة للتلف', 'parent_code' => '231'],
            ['code' => '2312', 'name' => 'Provision for Buildings, Construction, Facilities and Roads Depreciation', 'name_ar' => 'مخصص إهلاك المباني والإنشاءات والمرافق والطرق', 'parent_code' => '231'],
            ['code' => '2313', 'name' => 'Provision for Tools & Equipments Depreciation', 'name_ar' => 'مخصص إهلاك الأدوات والمعدات', 'parent_code' => '231'],
            ['code' => '2314', 'name' => 'Provision for Transportation Depreciation', 'name_ar' => 'مخصص إهلاك وسائل النقل', 'parent_code' => '231'],
            ['code' => '2315', 'name' => 'Provision for Machines and Equipments Depreciation', 'name_ar' => 'مخصص إهلاك الآلات والمعدات', 'parent_code' => '231'],
            ['code' => '2316', 'name' => 'Provision for Furniture and Office Equipments Depreciation', 'name_ar' => 'مخصص إهلاك الأثاث والتجهيزات المكتبية', 'parent_code' => '231'],
            ['code' => '2317', 'name' => 'Provision for Animal & Water Wealth Depreciation', 'name_ar' => 'مخصص إهلاك الثروة الحيوانية والسمكية', 'parent_code' => '231'],

            ['code' => '232', 'name' => 'Provision for Unfinished Products Price Decrease', 'name_ar' => 'مخصص هبوط أسعار إنتاج تحت التشغيل', 'parent_code' => '23'],
            ['code' => '233', 'name' => 'Provision for Finished Products Price Decrease', 'name_ar' => 'مخصص هبوط أسعار إنتاج تام', 'parent_code' => '23'],
            ['code' => '234', 'name' => 'Provision for Purchased Goods Price Decrease', 'name_ar' => 'مخصص هبوط أسعار بضاعة مشتراة', 'parent_code' => '23'],
            ['code' => '235', 'name' => 'Provision for Securities Price Decrease', 'name_ar' => 'مخصص هبوط أسعار أوراق مالية', 'parent_code' => '23'],
            ['code' => '236', 'name' => 'provision for doubtful debts', 'name_ar' => 'مخصص ديون مشكوك فيها', 'parent_code' => '23'],
            ['code' => '237', 'name' => 'Provision for disputed taxes', 'name_ar' => 'مخصص ضرائب تحت النزاع', 'parent_code' => '23'],
            ['code' => '238', 'name' => 'provision for claims and disputes', 'name_ar' => 'مخصص دعاوى ومنازعات', 'parent_code' => '23'],
            ['code' => '239', 'name' => 'other provisions', 'name_ar' => 'مخصصات أخرى', 'parent_code' => '23'],

            ['code' => '24', 'name' => 'Property rights', 'name_ar' => 'حقوق الملكية', 'parent_code' => '2'],
            ['code' => '241', 'name' => 'Capital', 'name_ar' => 'رأس المال', 'parent_code' => '24'],
            ['code' => '242', 'name' => 'Shareholders current accounts', 'name_ar' => 'حسابات جارية للشركاء', 'parent_code' => '24'],
            ['code' => '243', 'name' => 'Late installments', 'name_ar' => 'أقساط مستحقة', 'parent_code' => '24'],
            ['code' => '244', 'name' => 'Retained Earnings (losses)', 'name_ar' => 'أرباح (خسائر) مرحّلة', 'parent_code' => '24'],
            ['code' => '245', 'name' => 'Treasury Stock', 'name_ar' => 'أسهم خزينة', 'parent_code' => '24'],

            ['code' => '246', 'name' => 'Reserves', 'name_ar' => 'احتياطيات', 'parent_code' => '24'],
            ['code' => '2461', 'name' => 'legal reserve', 'name_ar' => 'احتياطي قانوني', 'parent_code' => '246'],
            ['code' => '2462', 'name' => 'Statutory Reserve', 'name_ar' => 'احتياطي نظامي', 'parent_code' => '246'],
            ['code' => '2463', 'name' => 'Capital reserve', 'name_ar' => 'احتياطي رأس المال', 'parent_code' => '246'],
            ['code' => '2464', 'name' => 'other reserves', 'name_ar' => 'احتياطيات أخرى', 'parent_code' => '246'],

            ['code' => '247', 'name' => 'Opening balances', 'name_ar' => 'أرصدة افتتاحية', 'parent_code' => '24'],

            // ========== المصروفات (Expenses) - 3 ==========
            ['code' => '3', 'name' => 'Expenses', 'name_ar' => 'المصروفات', 'parent_code' => null],

            ['code' => '31', 'name' => 'Cost of Sold Goods', 'name_ar' => 'تكلفة بضاعة مباعة', 'parent_code' => '3'],

            ['code' => '32', 'name' => 'Statement Expenses', 'name_ar' => 'مصروفات قائمة الدخل', 'parent_code' => '3'],

            ['code' => '321', 'name' => 'General & Admin expenses', 'name_ar' => 'مصروفات عمومية وإدارية', 'parent_code' => '32'],

            ['code' => '3211', 'name' => 'Material, fuel and spare parts', 'name_ar' => 'مواد ووقود وقطع غيار', 'parent_code' => '321'],
            ['code' => '32111', 'name' => 'Fuel and Oils', 'name_ar' => 'وقود وزيوت', 'parent_code' => '3211'],
            ['code' => '32112', 'name' => 'Spare Parts and Gears', 'name_ar' => 'قطع غيار وعدد', 'parent_code' => '3211'],
            ['code' => '32113', 'name' => 'Electricity & water', 'name_ar' => 'كهرباء ومياه', 'parent_code' => '3211'],
            ['code' => '32114', 'name' => 'Account 32114', 'name_ar' => 'حساب 32114', 'parent_code' => '3211'],
            ['code' => '32115', 'name' => 'Account 32115', 'name_ar' => 'حساب 32115', 'parent_code' => '3211'],
            ['code' => '32116', 'name' => 'Account 32116', 'name_ar' => 'حساب 32116', 'parent_code' => '3211'],

            ['code' => '3212', 'name' => 'Petty expenses', 'name_ar' => 'مصروفات نثرية', 'parent_code' => '321'],
            ['code' => '32121', 'name' => 'Telephones, Mobiles & Internet', 'name_ar' => 'تليفونات وموبايلات وانترنت', 'parent_code' => '3212'],
            ['code' => '32122', 'name' => 'In office and Out-of-office Expenses', 'name_ar' => 'مصروفات مكتبية وخارجية', 'parent_code' => '3212'],
            ['code' => '32123', 'name' => 'Administrative tips', 'name_ar' => 'إكراميات إدارية', 'parent_code' => '3212'],
            ['code' => '32124', 'name' => 'Stationary', 'name_ar' => 'قرطاسية', 'parent_code' => '3212'],
            ['code' => '32125', 'name' => 'Account 32125', 'name_ar' => 'حساب 32125', 'parent_code' => '3212'],
            ['code' => '32126', 'name' => 'Account 32126', 'name_ar' => 'حساب 32126', 'parent_code' => '3212'],

            ['code' => '3213', 'name' => 'Wages', 'name_ar' => 'أجور ومرتبات', 'parent_code' => '321'],
            ['code' => '32131', 'name' => 'Wages in Cash', 'name_ar' => 'أجور نقدية', 'parent_code' => '3213'],
            ['code' => '32132', 'name' => 'Advantages In kind', 'name_ar' => 'مزايا عينية', 'parent_code' => '3213'],
            ['code' => '32133', 'name' => 'Social insurance', 'name_ar' => 'تأمينات اجتماعية', 'parent_code' => '3213'],
            ['code' => '32134', 'name' => 'transportation expenses', 'name_ar' => 'مصروفات نقل', 'parent_code' => '3213'],
            ['code' => '32135', 'name' => 'Legal and Accounting fees', 'name_ar' => 'أتعاب محاماة ومحاسبة', 'parent_code' => '3213'],
            ['code' => '32136', 'name' => 'Salary of Sales Rep', 'name_ar' => 'رواتب مندوبي مبيعات', 'parent_code' => '3213'],
            ['code' => '32137', 'name' => 'Account 32137', 'name_ar' => 'حساب 32137', 'parent_code' => '3213'],

            ['code' => '3214', 'name' => 'Other Administrative Expenses', 'name_ar' => 'مصروفات إدارية أخرى', 'parent_code' => '321'],
            ['code' => '32141', 'name' => 'Purchases Services', 'name_ar' => 'خدمات مشتريات', 'parent_code' => '3214'],
            ['code' => '32142', 'name' => 'Maintenance Expenses', 'name_ar' => 'مصروفات صيانة', 'parent_code' => '3214'],
            ['code' => '32143', 'name' => 'Advertising, Publicity, Printing, PR and Reception Expenses', 'name_ar' => 'مصروفات دعاية واعلان وطباعة وعلاقات عامة واستقبال', 'parent_code' => '3214'],
            ['code' => '32144', 'name' => 'Transportation and communication expenses', 'name_ar' => 'مصروفات نقل واتصالات', 'parent_code' => '3214'],
            ['code' => '32145', 'name' => 'Fixed Assets Rent  (real estate excluded)', 'name_ar' => 'إيجار أصول ثابتة (عدا العقارات)', 'parent_code' => '3214'],
            ['code' => '32146', 'name' => 'Government agencies &  Institutions  services', 'name_ar' => 'خدمات جهات ومؤسسات حكومية', 'parent_code' => '3214'],

            ['code' => '3215', 'name' => 'Other Tertiary Expenses', 'name_ar' => 'مصروفات ثلاثية أخرى', 'parent_code' => '321'],

            ['code' => '32151', 'name' => 'Depreciation and Amortization', 'name_ar' => 'إهلاك واستهلاك', 'parent_code' => '3215'],
            ['code' => '321511', 'name' => 'Fixed assets depreciation', 'name_ar' => 'إهلاك أصول ثابتة', 'parent_code' => '32151'],
            ['code' => '321512', 'name' => 'Intangible Assets and Capital Expenses Amortization', 'name_ar' => 'إطفاء أصول غير ملموسة ومصروفات رأسمالية', 'parent_code' => '32151'],

            ['code' => '32152', 'name' => 'Interests', 'name_ar' => 'فوائد', 'parent_code' => '3215'],
            ['code' => '32153', 'name' => 'Real Estate Rent (lands& buildings)', 'name_ar' => 'إيجار عقارات (أراضي ومباني)', 'parent_code' => '3215'],
            ['code' => '32154', 'name' => 'Real Estate Taxes', 'name_ar' => 'ضرائب عقارية', 'parent_code' => '3215'],
            ['code' => '32155', 'name' => 'Indirect Tax on Statement', 'name_ar' => 'ضريبة غير مباشرة بقائمة الدخل', 'parent_code' => '3215'],

            ['code' => '322', 'name' => 'marketing expenses', 'name_ar' => 'مصروفات تسويقية', 'parent_code' => '32'],
            ['code' => '3221', 'name' => 'Hotels', 'name_ar' => 'فنادق', 'parent_code' => '322'],
            ['code' => '3222', 'name' => 'Publicity and Advertising', 'name_ar' => 'دعاية وإعلان', 'parent_code' => '322'],
            ['code' => '3223', 'name' => 'Marketing Gifts and Samples', 'name_ar' => 'هدايا وعينات تسويقية', 'parent_code' => '322'],
            ['code' => '3224', 'name' => 'Damaged Production/Purchased Goods (in sale stage).', 'name_ar' => 'توالف إنتاج/بضاعة مشتراة (في مرحلة البيع)', 'parent_code' => '322'],
            ['code' => '3225', 'name' => 'Delay penalties', 'name_ar' => 'غرامات تأخير', 'parent_code' => '322'],
            ['code' => '3226', 'name' => 'Conferences', 'name_ar' => 'مؤتمرات', 'parent_code' => '322'],
            ['code' => '3227', 'name' => 'Tenders Specifications', 'name_ar' => 'كراسات مناقصات', 'parent_code' => '322'],
            ['code' => '3228', 'name' => 'Marketing Tips', 'name_ar' => 'إكراميات تسويقية', 'parent_code' => '322'],
            ['code' => '3229', 'name' => 'Sales reps & Marketers Commissions', 'name_ar' => 'عمولات مندوبي مبيعات ومسوقين', 'parent_code' => '322'],

            ['code' => '323', 'name' => 'Financial expenses', 'name_ar' => 'مصروفات تمويلية', 'parent_code' => '32'],
            ['code' => '3231', 'name' => 'Bank expenses', 'name_ar' => 'مصروفات بنكية', 'parent_code' => '323'],
            ['code' => '3232', 'name' => 'LG expenses', 'name_ar' => 'مصروفات خطابات ضمان', 'parent_code' => '323'],
            ['code' => '3233', 'name' => 'Bank Expenses and Commissions', 'name_ar' => 'مصروفات وعمولات بنكية', 'parent_code' => '323'],
            ['code' => '3234', 'name' => 'Bank statement expenses', 'name_ar' => 'مصروفات كشف حساب بنكي', 'parent_code' => '323'],

            ['code' => '324', 'name' => 'Operation and production expenses', 'name_ar' => 'مصروفات تشغيلية وإنتاجية', 'parent_code' => '32'],
            ['code' => '3241', 'name' => 'Operating Salaries', 'name_ar' => 'رواتب تشغيلية', 'parent_code' => '324'],

            ['code' => '3242', 'name' => 'Operating Expenses', 'name_ar' => 'مصروفات تشغيلية', 'parent_code' => '324'],
            ['code' => '32421', 'name' => 'Operation Depreciation Expenses (tools& equipments)', 'name_ar' => 'مصروفات إهلاك تشغيل (أدوات ومعدات)', 'parent_code' => '3242'],
            ['code' => '32422', 'name' => 'Maintenance and repair expenses', 'name_ar' => 'مصروفات صيانة وإصلاح', 'parent_code' => '3242'],
            ['code' => '32423', 'name' => 'Operating expenses with others', 'name_ar' => 'مصروفات تشغيل لدى الغير', 'parent_code' => '3242'],
            ['code' => '32424', 'name' => 'Operating transportation expenses', 'name_ar' => 'مصروفات نقل تشغيلية', 'parent_code' => '3242'],
            ['code' => '32425', 'name' => 'Rent Expenses for Operation Tools and Equipments', 'name_ar' => 'إيجار أدوات ومعدات تشغيل', 'parent_code' => '3242'],

            ['code' => '33', 'name' => 'other expenses', 'name_ar' => 'مصروفات أخرى', 'parent_code' => '3'],

            ['code' => '331', 'name' => 'Provisions (other than depreciation)', 'name_ar' => 'مخصصات (عدا الإهلاك)', 'parent_code' => '33'],
            ['code' => '3310', 'name' => 'Inventory Adjustment Differences', 'name_ar' => 'فروق تسوية جرد', 'parent_code' => '331'],

            ['code' => '332', 'name' => 'Bad debts', 'name_ar' => 'ديون معدومة', 'parent_code' => '33'],
            ['code' => '333', 'name' => 'Securities Sale Losses', 'name_ar' => 'خسائر بيع أوراق مالية', 'parent_code' => '33'],
            ['code' => '334', 'name' => 'Miscellaneous burdens and losses', 'name_ar' => 'أعباء وخسائر متنوعة', 'parent_code' => '33'],
            ['code' => '3341', 'name' => 'Waste Sale Losses', 'name_ar' => 'خسائر بيع مخلفات', 'parent_code' => '334'],
            ['code' => '3342', 'name' => 'Raw material, Material and Spare Parts Sale Losses', 'name_ar' => 'خسائر بيع خامات ومواد وقطع غيار', 'parent_code' => '334'],
            ['code' => '3343', 'name' => 'Compensations and Penalties', 'name_ar' => 'تعويضات وغرامات', 'parent_code' => '334'],
            ['code' => '3344', 'name' => 'Donations and Aids', 'name_ar' => 'تبرعات وإعانات', 'parent_code' => '334'],
            ['code' => '3345', 'name' => 'Fraction Approximation Differences', 'name_ar' => 'فروق تقريب كسور', 'parent_code' => '334'],

            ['code' => '335', 'name' => 'Exchange rate losses', 'name_ar' => 'خسائر فروق عملة', 'parent_code' => '33'],
            ['code' => '336', 'name' => 'Previous Years Expenses', 'name_ar' => 'مصروفات سنوات سابقة', 'parent_code' => '33'],
            ['code' => '337', 'name' => 'Capital losses', 'name_ar' => 'خسائر رأسمالية', 'parent_code' => '33'],
            ['code' => '338', 'name' => 'Financial adjustment differences', 'name_ar' => 'فروق تسوية مالية', 'parent_code' => '33'],
            ['code' => '339', 'name' => 'Income Taxes', 'name_ar' => 'ضرائب الدخل', 'parent_code' => '33'],

            // ========== الإيرادات (Revenues) - 4 ==========
            ['code' => '4', 'name' => 'Revenues', 'name_ar' => 'الإيرادات', 'parent_code' => null],

            ['code' => '41', 'name' => 'Activity revenues', 'name_ar' => 'إيرادات النشاط', 'parent_code' => '4'],

            ['code' => '411', 'name' => 'sales', 'name_ar' => 'المبيعات', 'parent_code' => '41'],
            ['code' => '4111', 'name' => 'Sales of Purchased Goods', 'name_ar' => 'مبيعات بضاعة مشتراة', 'parent_code' => '411'],
            ['code' => '4112', 'name' => 'Sales of Finished Goods', 'name_ar' => 'مبيعات إنتاج تام', 'parent_code' => '411'],
            ['code' => '4113', 'name' => 'Sold services', 'name_ar' => 'خدمات مباعة', 'parent_code' => '411'],
            ['code' => '4114', 'name' => 'Consignment Goods Sale Returns (debit)', 'name_ar' => 'مردودات مبيعات بضاعة أمانة (مدين)', 'parent_code' => '411'],
            ['code' => '4115', 'name' => 'Sales return (debit)', 'name_ar' => 'مردودات مبيعات (مدين)', 'parent_code' => '411'],
            ['code' => '4116', 'name' => 'Sales Allowances (debit)', 'name_ar' => 'مسموحات مبيعات (مدين)', 'parent_code' => '411'],
            ['code' => '4117', 'name' => 'Sales of Consignment goods', 'name_ar' => 'مبيعات بضاعة أمانة', 'parent_code' => '411'],

            ['code' => '412', 'name' => 'Penalties', 'name_ar' => 'خصومات', 'parent_code' => '41'],
            ['code' => '4121', 'name' => 'Discount Allowed', 'name_ar' => 'خصم مسموح به', 'parent_code' => '412'],
            ['code' => '4122', 'name' => 'Discount Allowed (debit)', 'name_ar' => 'خصم مسموح به (مدين)', 'parent_code' => '412'],
            ['code' => '4123', 'name' => 'Quantity Discount Earned', 'name_ar' => 'خصم كمية مكتسب', 'parent_code' => '412'],
            ['code' => '4124', 'name' => 'Quantity Allowed Discount  (debit)', 'name_ar' => 'خصم كمية مسموح به (مدين)', 'parent_code' => '412'],

            ['code' => '413', 'name' => 'Other Statement Revenues', 'name_ar' => 'إيرادات قائمة الدخل الأخرى', 'parent_code' => '41'],
            ['code' => '4131', 'name' => 'Financial lease contract revenue', 'name_ar' => 'إيراد عقد إيجار تمويلي', 'parent_code' => '413'],
            ['code' => '4132', 'name' => 'Operation revenue for others', 'name_ar' => 'إيراد تشغيل لدى الغير', 'parent_code' => '413'],
            ['code' => '4133', 'name' => 'Other Operating Revenues', 'name_ar' => 'إيرادات تشغيلية أخرى', 'parent_code' => '413'],
            ['code' => '4134', 'name' => 'End of Day Surplus', 'name_ar' => 'فائض نهاية اليوم', 'parent_code' => '413'],
            ['code' => '4135', 'name' => 'Realized Gains', 'name_ar' => 'أرباح محققة', 'parent_code' => '413'],
            ['code' => '4136', 'name' => 'Delivery Income', 'name_ar' => 'إيراد توصيل', 'parent_code' => '413'],

            ['code' => '42', 'name' => 'Grants & Aids', 'name_ar' => 'إعانات ومعونات', 'parent_code' => '4'],

            ['code' => '43', 'name' => 'Investment & Interest Revenues', 'name_ar' => 'إيرادات استثمار وفوائد', 'parent_code' => '4'],
            ['code' => '431', 'name' => 'Financial Investments Revenues from Holding Companies', 'name_ar' => 'إيرادات استثمارات مالية من شركات أم', 'parent_code' => '43'],
            ['code' => '432', 'name' => 'Financial Investments Revenues from Sister Companies', 'name_ar' => 'إيرادات استثمارات مالية من شركات شقيقة', 'parent_code' => '43'],
            ['code' => '433', 'name' => 'Other Financial Investments Revenue', 'name_ar' => 'إيرادات استثمارات مالية أخرى', 'parent_code' => '43'],
            ['code' => '434', 'name' => 'Loan Interests to Holding Companies, Affiliated Companies and Sister Companies', 'name_ar' => 'فوائد قروح لشركات أم وزميلة وشقيقة', 'parent_code' => '43'],
            ['code' => '435', 'name' => 'Other credit benefits', 'name_ar' => 'فوائد دائنة أخرى', 'parent_code' => '43'],

            ['code' => '44', 'name' => 'Other Revenues and Profits', 'name_ar' => 'إيرادات وأرباح أخرى', 'parent_code' => '4'],
            ['code' => '441', 'name' => 'Provisions no longer required', 'name_ar' => 'مخصصات لم تعد ضرورية', 'parent_code' => '44'],
            ['code' => '442', 'name' => 'Debts Already Written-off', 'name_ar' => 'ديون سبق شطبها', 'parent_code' => '44'],
            ['code' => '443', 'name' => 'Securities Sale Profits', 'name_ar' => 'أرباح بيع أوراق مالية', 'parent_code' => '44'],

            ['code' => '444', 'name' => 'Diverse Revenues and Profits', 'name_ar' => 'إيرادات وأرباح متنوعة', 'parent_code' => '44'],
            ['code' => '4441', 'name' => 'Waste Sale Profits', 'name_ar' => 'أرباح بيع مخلفات', 'parent_code' => '444'],
            ['code' => '4442', 'name' => 'Services, Material and Spare Parts Sale Profits', 'name_ar' => 'أرباح بيع خدمات ومواد وقطع غيار', 'parent_code' => '444'],
            ['code' => '4443', 'name' => 'Compensations and Penalties Revenues', 'name_ar' => 'إيرادات تعويضات وغرامات', 'parent_code' => '444'],
            ['code' => '4444', 'name' => 'Commissions', 'name_ar' => 'عمولات', 'parent_code' => '444'],
            ['code' => '4445', 'name' => 'Credit rent', 'name_ar' => 'إيجار دائن', 'parent_code' => '444'],

            ['code' => '445', 'name' => 'Exchange rate profit', 'name_ar' => 'أرباح فروق عملة', 'parent_code' => '44'],
            ['code' => '446', 'name' => 'Previous Annual Revenues', 'name_ar' => 'إيرادات سنوات سابقة', 'parent_code' => '44'],
            ['code' => '447', 'name' => 'Capital Profits', 'name_ar' => 'أرباح رأسمالية', 'parent_code' => '44'],
            ['code' => '448', 'name' => 'Extraordinary Revenues and Profit', 'name_ar' => 'إيرادات وأرباح غير عادية', 'parent_code' => '44'],
        ];

        // تخزين الـ IDs بعد الإنشاء
        $accountIds = [];

        // إنشاء جميع الحسابات
        foreach ($accounts as $accountData) {
            try {
                // البحث عن الـ parent_id
                $parentId = null;
                if ($accountData['parent_code'] !== null) {
                    if (isset($accountIds[$accountData['parent_code']])) {
                        $parentId = $accountIds[$accountData['parent_code']];
                    } else {
                        $parent = Account::where('code', $accountData['parent_code'])->first();
                        if ($parent) {
                            $parentId = $parent->id;
                            $accountIds[$accountData['parent_code']] = $parent->id;
                        } else {
                            $this->command->warn("⚠️ لم يتم العثور على parent بكود: {$accountData['parent_code']} للحساب {$accountData['code']}");
                            continue;
                        }
                    }
                }

                // إنشاء الحساب بكل الأرصدة = 0
                $account = Account::create([
                    'code' => $accountData['code'],
                    'name' => $accountData['name'],
                    'name_ar' => $accountData['name_ar'],
                    'debit' => 0,
                    'credit' => 0,
                    'balance' => 0,
                    'parent_id' => $parentId,
                ]);

                $accountIds[$accountData['code']] = $account->id;
                $this->command->info("✅ تم إنشاء: {$accountData['code']} - {$accountData['name_ar']}");

            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $this->command->error("❌ كود مكرر: {$accountData['code']} - {$accountData['name']}");

                    $existingAccount = Account::where('code', $accountData['code'])->first();
                    if ($existingAccount) {
                        $accountIds[$accountData['code']] = $existingAccount->id;
                        $this->command->info("🔄 تم استخدام الحساب الموجود: {$accountData['code']}");
                    }
                } else {
                    $this->command->error("❌ خطأ في إنشاء {$accountData['code']}: " . $e->getMessage());
                }
            }
        }

        // إحصائيات
        $totalAccounts = Account::count();
        $accountsWithChildren = Account::has('children')->count();

        $this->command->info('=====================================');
        $this->command->info('✅ تم إنشاء شجرة الحسابات بنجاح!');
        $this->command->info("📊 عدد الحسابات: " . $totalAccounts);
        $this->command->info("📌 حسابات رئيسية (لها أطفال): " . $accountsWithChildren);
        $this->command->info("📌 حسابات فرعية (ليس لها أطفال): " . ($totalAccounts - $accountsWithChildren));
        $this->command->info('=====================================');
        $this->command->info('💰 جميع الأرصدة = 0');
        $this->command->info('=====================================');
    }
}
