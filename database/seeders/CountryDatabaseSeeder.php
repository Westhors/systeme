<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Country;
use App\Models\Media;

class CountryDatabaseSeeder extends Seeder
{


        /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        Model::unguard();
        {
            $bar = $this->command->getOutput()->createProgressBar(
                count($this->countriesWithFlag())
            );
            $bar->start();

            $countries_path = resource_path('countries');
            $files = collect(File::files($countries_path));

            $files = collect(File::files($countries_path));
            foreach ($this->countriesWithFlag() as $country) {
                $countryModel = Country::factory()->create($country);
                $code = strtolower($country['code']);
                if (File::exists($countries_path . '/' . $code . '.svg')) {
                    foreach ($files as $file) {
                        if ($file->getBasename('.svg') == $code) {
                            $media = Media::create([
                                'name' => $file->getBasename(),
                                'file_name' => $file->getBasename(),
                                'mime_type' => 'image/svg+xml',
                                'size' => $file->getSize(),
                            ]);
                            $contents = file_get_contents($file);
                            $directory = "media/flags";
                            Storage::disk('public')->put( $directory.'/'.$media->file_name, $contents);
                            $media->file_path = $directory.'/'.$media->file_name;
                            $media->save();
                            $countryModel->media()->attach([$media->id =>  ['collection' => 'default']]);
                        }
                    }
                }
                $bar->advance();
            }
            $bar->finish();
        }
    }

    /**
     * Run the database seeds.
     * @return array
     */
    public function countries(): array
    {
        return [
            ['name' => 'AFGHANISTAN' ,'key' => '93'],
            ['name' => 'ALASKA (USA)' ,'key' => '1-907'],
            ['name' => 'ALBANIA' ,'key' => '355'],
            ['name' => 'ALGERIA' ,'key' => '213'],
            ['name' => 'AMERICAN SAMOA' ,'key' => '1-684'],
            ['name' => 'ORRA' ,'key' => '376'],
            ['name' => 'ANGOLA' ,'key' => '244'],
            ['name' => 'ANGUILLA' ,'key' => '1-264'],
            ['name' => 'ANTIGUA & BARBUDA' ,'key' => '1-268'],
            ['name' => 'ARGENTINA' ,'key' => '54'],
            ['name' => 'ARMENIA' ,'key' => '374'],
            ['name' => 'ARUBA' ,'key' => '297'],
            ['name' => 'ASCENSION' ,'key' => '247'],
            ['name' => 'AUSTRALIA' ,'key' => '61'],
            ['name' => 'AUSTRIA' ,'key' => '43'],
            ['name' => 'AZERBAIJAN' ,'key' => '994'],
            ['name' => 'BAHAMAS' ,'key' => '1-242'],
            ['name' => 'BAHRAIN' ,'key' => '973'],
            ['name' => 'BANGLADESH' ,'key' => '880'],
            ['name' => 'BARBADOS' ,'key' => '1-246'],
            ['name' => 'BELARUS' ,'key' => '375'],
            ['name' => 'BELGIUM' ,'key' => '32'],
            ['name' => 'BELIZE' ,'key' => '501'],
            ['name' => 'BENIN' ,'key' => '229'],
            ['name' => 'BERMUDA' ,'key' => '1-441'],
            ['name' => 'BHUTAN' ,'key' => '975'],
            ['name' => 'BOLIVIA' ,'key' => '591'],
            ['name' => 'BOSNIA / HERZEGOVINA' ,'key' => '387'],
            ['name' => 'BOTSWANA' ,'key' => '267'],
            ['name' => 'BRAZIL' ,'key' => '55'],
            ['name' => 'BRITISH VIRGINISLS' ,'key' => '1-284'],
            ['name' => 'BRUNEI' ,'key' => '673'],
            ['name' => 'BULGARIA' ,'key' => '359'],
            ['name' => 'BURKINA FASO' ,'key' => '226'],
            ['name' => 'BURUNDI' ,'key' => '257'],
            ['name' => 'CAMBODIA' ,'key' => '855'],
            ['name' => 'CAMEROON' ,'key' => '237'],
            ['name' => 'CANADA' ,'key' => '1'],
            ['name' => 'CAPE VERDE' ,'key' => '238'],
            ['name' => 'CAYMAN ISLS' ,'key' => '1-345'],
            ['name' => 'CENTRAL AFRICANREPUBLIC' ,'key' => '236'],
            ['name' => 'CHAD' ,'key' => '235'],
            ['name' => 'CHILE' ,'key' => '56'],
            ['name' => 'CHINA' ,'key' => '86'],
            ['name' => 'COLOMBIA' ,'key' => '57'],
            ['name' => 'COMOROS' ,'key' => '269'],
            ['name' => 'CONGO' ,'key' => '242'],
            ['name' => 'CONGO DEM. REP.(ZAIRE)' ,'key' => '243'],
            ['name' => 'COOK ISL' ,'key' => '682'],
            ['name' => 'COSTA RICA' ,'key' => '506'],
            ['name' => 'CROATIA' ,'key' => '385'],
            ['name' => 'CUBA' ,'key' => '53'],
            ['name' => 'CYPRUS' ,'key' => '357'],
            ['name' => 'CZECH REPUBLIC' ,'key' => '420'],
            ['name' => 'DENMARK' ,'key' => '45'],
            ['name' => 'DIEGO GARCIA' ,'key' => '246'],
            ['name' => 'DJIBOUTI' ,'key' => '253'],
            ['name' => 'DOMINICA' ,'key' => '1-767'],
            ['name' => 'DOMINICAN REPUBLIC' ,'key' => '1-809'],
            ['name' => 'EAST TIMOR' ,'key' => '670'],
            ['name' => 'ECUADOR' ,'key' => '593'],
            ['name' => 'EGYPT' ,'key' => '20'],
            ['name' => 'EL SALVADOR' ,'key' => '503'],
            ['name' => 'EQUATORIAL GUINEA' ,'key' => '240'],
            ['name' => 'ERITREA' ,'key' => '291'],
            ['name' => 'ESTONIA' ,'key' => '372'],
            ['name' => 'ETHIOPIA' ,'key' => '251'],
            ['name' => 'FALKL ISLS' ,'key' => '500'],
            ['name' => 'FAROE ISLS' ,'key' => '298'],
            ['name' => 'FIJI' ,'key' => '679'],
            ['name' => 'FINL' ,'key' => '358'],
            ['name' => 'FRANCE' ,'key' => '33'],
            ['name' => 'FRENCH GUIANA' ,'key' => '594'],
            ['name' => 'FRENCH POLYNESIA' ,'key' => '689'],
            ['name' => 'GABON' ,'key' => '241'],
            ['name' => 'GAMBIA' ,'key' => '220'],
            ['name' => 'GEORGIA' ,'key' => '995'],
            ['name' => 'GERMANY' ,'key' => '49'],
            ['name' => 'GHANA' ,'key' => '233'],
            ['name' => 'GIBRALTAR' ,'key' => '350'],
            ['name' => 'GREECE' ,'key' => '30'],
            ['name' => 'GREENL' ,'key' => '299'],
            ['name' => 'GRENADA' ,'key' => '1-473'],
            ['name' => 'GUADALOUPE' ,'key' => '590'],
            ['name' => 'GUAM' ,'key' => '1-671'],
            ['name' => 'GUATEMALA' ,'key' => '502'],
            ['name' => 'GUINEA' ,'key' => '224'],
            ['name' => 'GUINEA BISSAU' ,'key' => '245'],
            ['name' => 'GUYANA' ,'key' => '592'],
            ['name' => 'HAITI' ,'key' => '509'],
            ['name' => 'HAWAII (USA)' ,'key' => '1-808'],
            ['name' => 'HONDURAS' ,'key' => '504'],
            ['name' => 'HONG KONG' ,'key' => '852'],
            ['name' => 'HUNGARY' ,'key' => '36'],
            ['name' => 'ICEL' ,'key' => '354'],
            ['name' => 'INDIA' ,'key' => '91'],
            ['name' => 'INDONESIA' ,'key' => '62'],
            ['name' => 'IRAN' ,'key' => '98'],
            ['name' => 'IRAQ' ,'key' => '964'],
            ['name' => 'IREL' ,'key' => '353'],
            ['name' => 'ISRAEL' ,'key' => '972'],
            ['name' => 'ITALY' ,'key' => '39'],
            ['name' => 'IVORY COAST' ,'key' => '225'],
            ['name' => 'JAMAICA' ,'key' => '1-876'],
            ['name' => 'JAPAN' ,'key' => '81'],
            ['name' => 'JORDAN' ,'key' => '962'],
            ['name' => 'KAZAKHSTAN' ,'key' => '7'],
            ['name' => 'KENYA' ,'key' => '254'],
            ['name' => 'KIRIBATI' ,'key' => '686'],
            ['name' => 'KOREA (NORTH)' ,'key' => '850'],
            ['name' => 'KOREA SOUTH' ,'key' => '82'],
            ['name' => 'KUWAIT' ,'key' => '965'],
            ['name' => 'KYRGHYZSTAN' ,'key' => '996'],
            ['name' => 'LAOS' ,'key' => '856'],
            ['name' => 'LATVIA' ,'key' => '371'],
            ['name' => 'LEBANON' ,'key' => '961'],
            ['name' => 'LESOTHO' ,'key' => '266'],
            ['name' => 'LIBERIA' , 'key' => '231'],
            ['name' => 'LIBYA' , 'key' => '218'],
            ['name' => 'LIECHTENSTEIN' , 'key' => '423'],
            ['name' => 'LITHUANIA' , 'key' => '370'],
            ['name' => 'LUXEMBOURG' , 'key' => '352'],
            ['name' => 'MACAU' , 'key' => '853'],
            ['name' => 'MACEDONIA' , 'key' => '389'],
            ['name' => 'MADAGASCAR' , 'key' => '261'],
            ['name' => 'MALAWI' , 'key' => '265'],
            ['name' => 'MALAYSIA' , 'key' => '60'],
            ['name' => 'MALDIVES' , 'key' => '960'],
            ['name' => 'MALI' , 'key' => '223'],
            ['name' => 'MALTA' , 'key' => '356'],
            ['name' => 'MARIANA IS.(SAIPAN)' , 'key' => '1-670'],
            ['name' => 'MARSHALL ISLS' , 'key' => '692'],
            ['name' => 'MARTINIQUE(FRENCHANTILLES)' , 'key' => '596'],
            ['name' => 'MAURITANIA' , 'key' => '222'],
            ['name' => 'MAURITIUS' , 'key' => '230'],
            ['name' => 'MAYOTTE' , 'key' => '269'],
            ['name' => 'MEXICO' , 'key' => '52'],
            ['name' => 'MICRONESIA' , 'key' => '691'],
            ['name' => 'MOLDOVA' , 'key' => '373'],
            ['name' => 'MONACO' , 'key' => '377'],
            ['name' => 'MONGOLIA' , 'key' => '976'],
            ['name' => 'MONTSERRAT' , 'key' => '1-664 '],
            ['name' => 'MOROCCO' , 'key' => '212'],
            ['name' => 'MOZAMBIQUE' , 'key' => '258'],
            ['name' => 'MYANMAR' , 'key' => '95'],
            ['name' => 'NAMIBIA' , 'key' => '264'],
            ['name' => 'NAURU' , 'key' => '674'],
            ['name' => 'NEPAL' , 'key' => '977'],
            ['name' => 'NETHERLS' , 'key' => '31'],
            ['name' => 'NETHERLS ANTILLES' , 'key' => '599'],
            ['name' => 'NEW CALEDONIA' , 'key' => '687'],
            ['name' => 'NEW ZEAL' , 'key' => '64'],
            ['name' => 'NICARAGUA' , 'key' => '505'],
            ['name' => 'NIGER' , 'key' => '227'],
            ['name' => 'NIGERIA' , 'key' => '234'],
            ['name' => 'NIUE ISL' , 'key' => '683'],
            ['name' => 'NORWAY' , 'key' => '47'],
            ['name' => 'OMAN' , 'key' => '968'],
            ['name' => 'PAKISTAN' , 'key' => '92'],
            ['name' => 'PALAU' , 'key' => '680'],
            ['name' => 'PALESTINE' , 'key' => '970'],
            ['name' => 'PANAMA' , 'key' => '507'],
            ['name' => 'PAPUA NEW GUINEA' , 'key' => '675'],
            ['name' => 'PARAGUAY' , 'key' => '595'],
            ['name' => 'PERU' , 'key' => '51'],
            ['name' => 'PHILIPPINES' , 'key' => '63'],
            ['name' => 'POLAND' , 'key' => '48'],
            ['name' => 'PORTUGAL' , 'key' => '351'],
            ['name' => 'PUERTO RICO (USA)' , 'key' => '1-787'],
            ['name' => 'PUERTO RICO (II)(USA)' , 'key' => '1-939'],
            ['name' => 'QATAR' , 'key' => '974'],
            ['name' => 'REUNION' , 'key' => '262'],
            ['name' => 'ROMANIA' , 'key' => '40'],
            ['name' => 'RUSSIA' , 'key' => '7'],
            ['name' => 'RWANDA' , 'key' => '250'],
            ['name' => 'SAMOA WESTERN' , 'key' => '685'],
            ['name' => 'SAN MARINO' , 'key' => '378'],
            ['name' => 'SAO TOME &PRINCIPE' , 'key' => '239'],
            ['name' => 'SAUDI ARABIA' , 'key' => '966'],
            ['name' => 'SENEGAL' , 'key' => '221'],
            ['name' => 'SEYCHELLES' , 'key' => '248'],
            ['name' => 'SIERRA LEONE' , 'key' => '232'],
            ['name' => 'SINGAPORE' , 'key' => '65'],
            ['name' => 'SLOVAKIA' , 'key' => '421'],
            ['name' => 'SLOVENIA' , 'key' => '386'],
            ['name' => 'SOLOMON ISLANDS' , 'key' => '677'],
            ['name' => 'SOMALIA' , 'key' => '252'],
            ['name' => 'SOUTH AFRICA' , 'key' => '27'],
            ['name' => 'SPAIN' , 'key' => '34'],
            ['name' => 'SRI LANKA' , 'key' => '94'],
            ['name' => 'ST HELENA' , 'key' => '290'],
            ['name' => 'ST KITTS & NEVIS' , 'key' => '1-869 '],
            ['name' => 'ST LUCIA' , 'key' => '1-758 '],
            ['name' => 'ST VINCENT &GRENADINES' , 'key' => '1-784 '],
            ['name' => 'ST. PIERRE &MIQUELON' , 'key' => '508'],
            ['name' => 'SUDAN' , 'key' => '249'],
            ['name' => 'SURINAM' , 'key' => '597'],
            ['name' => 'SWAZILAND' , 'key' => '268'],
            ['name' => 'SWEDEN' , 'key' => '46'],
            ['name' => 'SWITZERLAND' , 'key' => '41'],
            ['name' => 'SYRIA' , 'key' => '963'],
            ['name' => 'TAIWAN' , 'key' => '886'],
            ['name' => 'TAJIKISTAN' , 'key' => '992'],
            ['name' => 'TANZANIA' , 'key' => '255'],
            ['name' => 'THAILAND' , 'key' => '66'],
            ['name' => 'TOGO' , 'key' => '228'],
            ['name' => 'TOKELAU' , 'key' => '690'],
            ['name' => 'TONGA' , 'key' => '676'],
            ['name' => 'TRINIDAD & TOBAGO' , 'key' => '1-868'],
            ['name' => 'TUNISIA' , 'key' => '216'],
            ['name' => 'TURKEY' , 'key' => '90'],
            ['name' => 'TURKMENISTAN' , 'key' => '993'],
            ['name' => 'TURKS & CAICOSISLANDS' , 'key' => '1-649 '],
            ['name' => 'TUVALU' , 'key' => '688'],
            ['name' => 'UGANDA' , 'key' => '256'],
            ['name' => 'UKRAINE' , 'key' => '380'],
            ['name' => 'UNITED ARAB EMIRATES' , 'key' => '971'],
            ['name' => 'UNITED KINGDOM' , 'key' => '44'],
            ['name' => 'URUGUAY' , 'key' => '598'],
            ['name' => 'UZBEKISTAN' , 'key' => '998'],
            ['name' => 'VANUATU' , 'key' => '678'],
            ['name' => 'VATICAN CITY' , 'key' => '39'],
            ['name' => 'VENEZUELA' , 'key' => '58'],
            ['name' => 'VIETNAM' , 'key' => '84'],
            ['name' => 'VIRGIN ISLAND (USA)' , 'key' => '1-340'],
            ['name' => 'WALLIS & FUTUNA' , 'key' => '681'],
            ['name' => 'YEMEN' , 'key' => '967'],
            ['name' => 'YUGOSLAVIA (SERBIA)' , 'key' => '381'],
            ['name' => 'ZAMBIA' , 'key' => '260'],
            ['name' => 'ZANZIBAR' , 'key' => '255'],
            ['name' => 'ZIMBABWE' , 'key' => '263'],
        ];
    }

    /**
     * Run the database seeds.
     * @return array
     */
    public function countriesWithFlag(): array
    {
        return [
            [
                'name' => 'Afghanistan' ,
                'key' => '93' ,
                'code' => 'AF',
                'icon' => 'AF'
                // , 'simple_code' => 'AFG'
            ],
            [
                'name' => 'Albania' ,
                'key' => '355' ,
                'code' => 'AL',
                'icon' => 'AL'
                // , 'simple_code' => 'ALB'
            ],
            [
                'name' => 'Algeria' ,
                'key' => '213' ,
                'code' => 'DZ',
                'icon' => 'DZ'
                // , 'simple_code' => 'DZA'
            ],
            [
                'name' => 'American Samoa' ,
                'key' => '1-684' ,
                'code' => 'AS',
                'icon' => 'AS'
                // , 'simple_code' => 'ASM'
            ],
            [
                'name' => 'Andorra' ,
                'key' => '376' ,
                'code' => 'AD',
                'icon' => 'AD'
                // , 'simple_code' => 'AND'
            ],
            [
                'name' => 'Angola' ,
                'key' => '244' ,
                'code' => 'AO',
                'icon' => 'AO'
                // , 'simple_code' => 'AGO'
            ],
            [
                'name' => 'Anguilla' ,
                'key' => '1-264' ,
                'code' => 'AI',
                'icon' => 'AI'
                // , 'simple_code' => 'AIA'
            ],
            [
                'name' => 'Antarctica' ,
                'key' => '672' ,
                'code' => 'AQ',
                'icon' => 'AQ'
                // , 'simple_code' => 'ATA'
            ],
            [
                'name' => 'Antigua and Barbuda' ,
                'key' => '1-268' ,
                'code' => 'AG',
                'icon' => 'AG'
                // , 'simple_code' => 'ATG'
            ],
            [
                'name' => 'Argentina' ,
                'key' => '54' ,
                'code' => 'AR',
                'icon' => 'AR'
                // , 'simple_code' => 'ARG'
            ],
            [
                'name' => 'Armenia' ,
                'key' => '374' ,
                'code' => 'AM',
                'icon' => 'AM'
                // , 'simple_code' => 'ARM'
            ],
            [
                'name' => 'Aruba' ,
                'key' => '297' ,
                'code' => 'AW',
                'icon' => 'AW'
                // , 'simple_code' => 'ABW'
            ],
            [
                'name' => 'Australia' ,
                'key' => '61' ,
                'code' => 'AU',
                'icon' => 'AU'
                // , 'simple_code' => 'AUS'
            ],
            [
                'name' => 'Austria' ,
                'key' => '43' ,
                'code' => 'AT',
                'icon' => 'AT'
                // , 'simple_code' => 'AUT'
            ],
            [
                'name' => 'Azerbaijan' ,
                'key' => '994' ,
                'code' => 'AZ',
                'icon' => 'AZ'
                // , 'simple_code' => 'AZE'
            ],
            [
                'name' => 'Bahamas' ,
                'key' => '1-242' ,
                'code' => 'BS',
                'icon' => 'BS'
                // , 'simple_code' => 'BHS'
            ],
            [
                'name' => 'Bahrain' ,
                'key' => '973' ,
                'code' => 'BH',
                'icon' => 'BH'
                // , 'simple_code' => 'BHR'
            ],
            [
                'name' => 'Bangladesh' ,
                'key' => '880' ,
                'code' => 'BD',
                'icon' => 'BD'
                // , 'simple_code' => 'BGD'
            ],
            [
                'name' => 'Barbados' ,
                'key' => '1-246' ,
                'code' => 'BB',
                'icon' => 'BB'
                // , 'simple_code' => 'BRB'
            ],
            [
                'name' => 'Belarus' ,
                'key' => '375' ,
                'code' => 'BY',
                'icon' => 'BY'
                // , 'simple_code' => 'BLR'
            ],
            [
                'name' => 'Belgium' ,
                'key' => '32' ,
                'code' => 'BE',
                'icon' => 'BE'
                // , 'simple_code' => 'BEL'
            ],
            [
                'name' => 'Belize' ,
                'key' => '501' ,
                'code' => 'BZ',
                'icon' => 'BZ'
                // , 'simple_code' => 'BLZ'
            ],
            [
                'name' => 'Benin' ,
                'key' => '229' ,
                'code' => 'BJ',
                'icon' => 'BJ'
                // , 'simple_code' => 'BEN'
            ],
            [
                'name' => 'Bermuda' ,
                'key' => '1-441' ,
                'code' => 'BM',
                'icon' => 'BM'
                // , 'simple_code' => 'BMU'
            ],
            [
                'name' => 'Bhutan' ,
                'key' => '975' ,
                'code' => 'BT',
                'icon' => 'BT'
                // , 'simple_code' => 'BTN'
            ],
            [
                'name' => 'Bolivia' ,
                'key' => '591' ,
                'code' => 'BO',
                'icon' => 'BO'
                // , 'simple_code' => 'BOL'
            ],
            [
                'name' => 'Bosnia and Herzegovina' ,
                'key' => '387' ,
                'code' => 'BA',
                'icon' => 'BA'
                // , 'simple_code' => 'BIH'
            ],
            [
                'name' => 'Botswana' ,
                'key' => '267' ,
                'code' => 'BW',
                'icon' => 'BW'
                // , 'simple_code' => 'BWA'
            ],
            [
                'name' => 'Brazil' ,
                'key' => '55' ,
                'code' => 'BR',
                'icon' => 'BR'
                // , 'simple_code' => 'BRA'
            ],
            [
                'name' => 'British Indian Ocean Territory' ,
                'key' => '246' ,
                'code' => 'IO',
                'icon' => 'IO'
                // , 'simple_code' => 'IOT'
            ],
            [
                'name' => 'British Virgin Islands' ,
                'key' => '1-284' ,
                'code' => 'VG',
                'icon' => 'VG'
                // , 'simple_code' => 'VGB'
            ],
            [
                'name' => 'Brunei' ,
                'key' => '673' ,
                'code' => 'BN',
                'icon' => 'BN'
                // , 'simple_code' => 'BRN'
            ],
            [
                'name' => 'Bulgaria' ,
                'key' => '359' ,
                'code' => 'BG',
                'icon' => 'BG'
                // , 'simple_code' => 'BGR'
            ],
            [
                'name' => 'Burkina Faso' ,
                'key' => '226' ,
                'code' => 'BF',
                'icon' => 'BF'
                // , 'simple_code' => 'BFA'
            ],
            [
                'name' => 'Burundi' ,
                'key' => '257' ,
                'code' => 'BI',
                'icon' => 'BI'
                // , 'simple_code' => 'BDI'
            ],
            [
                'name' => 'Cambodia' ,
                'key' => '855' ,
                'code' => 'KH',
                'icon' => 'KH'
                // , 'simple_code' => 'KHM'
            ],
            [
                'name' => 'Cameroon' ,
                'key' => '237' ,
                'code' => 'CM',
                'icon' => 'CM'
                // , 'simple_code' => 'CMR'
            ],
            [
                'name' => 'Canada' ,
                'key' => '1' ,
                'code' => 'CA',
                'icon' => 'CA'
                // , 'simple_code' => 'CAN'
            ],
            [
                'name' => 'Cape Verde' ,
                'key' => '238' ,
                'code' => 'CV',
                'icon' => 'CV'
                // , 'simple_code' => 'CPV'
            ],
            [
                'name' => 'Cayman Islands' ,
                'key' => '1-345' ,
                'code' => 'KY',
                'icon' => 'KY'
                // , 'simple_code' => 'CYM'
            ],
            [
                'name' => 'Central African Republic' ,
                'key' => '236' ,
                'code' => 'CF',
                'icon' => 'CF'
                // , 'simple_code' => 'CAF'
            ],
            [
                'name' => 'Chad' ,
                'key' => '235' ,
                'code' => 'TD',
                'icon' => 'TD'
                // , 'simple_code' => 'TCD'
            ],
            [
                'name' => 'Chile' ,
                'key' => '56' ,
                'code' => 'CL',
                'icon' => 'CL'
                // , 'simple_code' => 'CHL'
            ],
            [
                'name' => 'China' ,
                'key' => '86' ,
                'code' => 'CN',
                'icon' => 'CN'
                // , 'simple_code' => 'CHN'
            ],
            [
                'name' => 'Christmas Island' ,
                'key' => '61' ,
                'code' => 'CX',
                'icon' => 'CX'
                // , 'simple_code' => 'CXR'
            ],
            [
                'name' => 'Cocos Islands' ,
                'key' => '61' ,
                'code' => 'CC',
                'icon' => 'CC'
                // , 'simple_code' => 'CCK'
            ],
            [
                'name' => 'Colombia' ,
                'key' => '57' ,
                'code' => 'CO',
                'icon' => 'CO'
                // , 'simple_code' => 'COL'
            ],
            [
                'name' => 'Comoros' ,
                'key' => '269' ,
                'code' => 'KM',
                'icon' => 'KM'
                // , 'simple_code' => 'COM'
            ],
            [
                'name' => 'Cook Islands' ,
                'key' => '682' ,
                'code' => 'CK',
                'icon' => 'CK'
                // , 'simple_code' => 'COK'
            ],
            [
                'name' => 'Costa Rica' ,
                'key' => '506' ,
                'code' => 'CR',
                'icon' => 'CR'
                // , 'simple_code' => 'CRI'
            ],
            [
                'name' => 'Croatia' ,
                'key' => '385' ,
                'code' => 'HR',
                'icon' => 'HR'
                // , 'simple_code' => 'HRV'
            ],
            [
                'name' => 'Cuba' ,
                'key' => '53' ,
                'code' => 'CU',
                'icon' => 'CU'
                // , 'simple_code' => 'CUB'
            ],
            [
                'name' => 'Curacao' ,
                'key' => '599' ,
                'code' => 'CW',
                'icon' => 'CW'
                // , 'simple_code' => 'CUW'
            ],
            [
                'name' => 'Cyprus' ,
                'key' => '357' ,
                'code' => 'CY',
                'icon' => 'CY'
                // , 'simple_code' => 'CYP'
            ],
            [
                'name' => 'Czech Republic' ,
                'key' => '420' ,
                'code' => 'CZ',
                'icon' => 'CZ'
                // , 'simple_code' => 'CZE'
            ],
            [
                'name' => 'Democratic Republic of the Congo' ,
                'key' => '243' ,
                'code' => 'CD',
                'icon' => 'CD'
                // , 'simple_code' => 'COD'
            ],
            [
                'name' => 'Denmark' ,
                'key' => '45' ,
                'code' => 'DK',
                'icon' => 'DK'
                // , 'simple_code' => 'DNK'
            ],
            [
                'name' => 'Djibouti' ,
                'key' => '253' ,
                'code' => 'DJ',
                'icon' => 'DJ'
                // , 'simple_code' => 'DJI'
            ],
            [
                'name' => 'Dominica' ,
                'key' => '1-767' ,
                'code' => 'DM',
                'icon' => 'DM'
                // , 'simple_code' => 'DMA'
            ],
            [
                'name' => 'Dominican Republic	1-809, 1-829' ,
                'key' => '1-849' ,
                'code' => 'DO',
                'icon' => 'DO'
                // , 'simple_code' => 'DOM'
            ],
            [
                'name' => 'East Timor' ,
                'key' => '670' ,
                'code' => 'TL',
                'icon' => 'TL'
                // , 'simple_code' => 'TLS'
            ],
            [
                'name' => 'Ecuador' ,
                'key' => '593' ,
                'code' => 'EC',
                'icon' => 'EC'
                // , 'simple_code' => 'ECU'
            ],
            [
                'name' => 'Egypt' ,
                'key' => '20' ,
                'code' => 'EG',
                'icon' => 'EG'
                // , 'simple_code' => 'EGY'
            ],
            [
                'name' => 'El Salvador' ,
                'key' => '503' ,
                'code' => 'SV',
                'icon' => 'SV'
                // , 'simple_code' => 'SLV'
            ],
            [
                'name' => 'Equatorial Guinea' ,
                'key' => '240' ,
                'code' => 'GQ',
                'icon' => 'GQ'
                // , 'simple_code' => 'GNQ'
            ],
            [
                'name' => 'Eritrea' ,
                'key' => '291' ,
                'code' => 'ER',
                'icon' => 'ER'
                // , 'simple_code' => 'ERI'
            ],
            [
                'name' => 'Estonia' ,
                'key' => '372' ,
                'code' => 'EE',
                'icon' => 'EE'
                // , 'simple_code' => 'EST'
            ],
            [
                'name' => 'Ethiopia' ,
                'key' => '251' ,
                'code' => 'ET',
                'icon' => 'ET'
                // , 'simple_code' => 'ETH'
            ],
            [
                'name' => 'Falkland Islands' ,
                'key' => '500' ,
                'code' => 'FK',
                'icon' => 'FK'
                // , 'simple_code' => 'FLK'
            ],
            [
                'name' => 'Faroe Islands' ,
                'key' => '298' ,
                'code' => 'FO',
                'icon' => 'FO'
                // , 'simple_code' => 'FRO'
            ],
            [
                'name' => 'Fiji' ,
                'key' => '679' ,
                'code' => 'FJ',
                'icon' => 'FJ'
                // , 'simple_code' => 'FJI'
            ],
            [
                'name' => 'Finland' ,
                'key' => '358' ,
                'code' => 'FI',
                'icon' => 'FI'
                // , 'simple_code' => 'FIN'
            ],
            [
                'name' => 'France' ,
                'key' => '33' ,
                'code' => 'FR',
                'icon' => 'FR'
                // , 'simple_code' => 'FRA'
            ],
            [
                'name' => 'French Polynesia' ,
                'key' => '689' ,
                'code' => 'PF',
                'icon' => 'PF'
                // , 'simple_code' => 'PYF'
            ],
            [
                'name' => 'Gabon' ,
                'key' => '241' ,
                'code' => 'GA',
                'icon' => 'GA'
                // , 'simple_code' => 'GAB'
            ],
            [
                'name' => 'Gambia' ,
                'key' => '220' ,
                'code' => 'GM',
                'icon' => 'GM'
                // , 'simple_code' => 'GMB'
            ],
            [
                'name' => 'Georgia' ,
                'key' => '995' ,
                'code' => 'GE',
                'icon' => 'GE'
                // , 'simple_code' => 'GEO'
            ],
            [
                'name' => 'Germany' ,
                'key' => '49' ,
                'code' => 'DE',
                'icon' => 'DE'
                // , 'simple_code' => 'DEU'
            ],
            [
                'name' => 'Ghana' ,
                'key' => '233' ,
                'code' => 'GH',
                'icon' => 'GH'
                // , 'simple_code' => 'GHA'
            ],
            [
                'name' => 'Gibraltar' ,
                'key' => '350' ,
                'code' => 'GI',
                'icon' => 'GI'
                // , 'simple_code' => 'GIB'
            ],
            [
                'name' => 'Greece' ,
                'key' => '30' ,
                'code' => 'GR',
                'icon' => 'GR'
                // , 'simple_code' => 'GRC'
            ],
            [
                'name' => 'Greenland' ,
                'key' => '299' ,
                'code' => 'GL',
                'icon' => 'GL'
                // , 'simple_code' => 'GRL'
            ],
            [
                'name' => 'Grenada' ,
                'key' => '1-473' ,
                'code' => 'GD',
                'icon' => 'GD'
                // , 'simple_code' => 'GRD'
            ],
            [
                'name' => 'Guam' ,
                'key' => '1-671' ,
                'code' => 'GU',
                'icon' => 'GU'
                // , 'simple_code' => 'GUM'
            ],
            [
                'name' => 'Guatemala' ,
                'key' => '502' ,
                'code' => 'GT',
                'icon' => 'GT'
                // , 'simple_code' => 'GTM'
            ],
            [
                'name' => 'Guernsey' ,
                'key' => '44-1481' ,
                'code' => 'GG',
                'icon' => 'GG'
                // , 'simple_code' => 'GGY'
            ],
            [
                'name' => 'Guinea' ,
                'key' => '224' ,
                'code' => 'GN',
                'icon' => 'GN'
                // , 'simple_code' => 'GIN'
            ],
            [
                'name' => 'Guinea-Bissau' ,
                'key' => '245' ,
                'code' => 'GW',
                'icon' => 'GW'
                // , 'simple_code' => 'GNB'
            ],
            [
                'name' => 'Guyana' ,
                'key' => '592' ,
                'code' => 'GY',
                'icon' => 'GY'
                // , 'simple_code' => 'GUY'
            ],
            [
                'name' => 'Haiti' ,
                'key' => '509' ,
                'code' => 'HT',
                'icon' => 'HT'
                // , 'simple_code' => 'HTI'
            ],
            [
                'name' => 'Honduras' ,
                'key' => '504' ,
                'code' => 'HN',
                'icon' => 'HN'
                // , 'simple_code' => 'HND'
            ],
            [
                'name' => 'Hong Kong' ,
                'key' => '852' ,
                'code' => 'HK',
                'icon' => 'HK'
                // , 'simple_code' => 'HKG'
            ],
            [
                'name' => 'Hungary' ,
                'key' => '36' ,
                'code' => 'HU',
                'icon' => 'HU'
                // , 'simple_code' => 'HUN'
            ],
            [
                'name' => 'Iceland' ,
                'key' => '354' ,
                'code' => 'IS',
                'icon' => 'IS'
                // , 'simple_code' => 'ISL'
            ],
            [
                'name' => 'India' ,
                'key' => '91' ,
                'code' => 'IN',
                'icon' => 'IN'
                // , 'simple_code' => 'IND'
            ],
            [
                'name' => 'Indonesia' ,
                'key' => '62' ,
                'code' => 'ID',
                'icon' => 'ID'
                // , 'simple_code' => 'IDN'
            ],
            [
                'name' => 'Iran' ,
                'key' => '98' ,
                'code' => 'IR',
                'icon' => 'IR'
                // , 'simple_code' => 'IRN'
            ],
            [
                'name' => 'Iraq' ,
                'key' => '964' ,
                'code' => 'IQ',
                'icon' => 'IQ'
                // , 'simple_code' => 'IRQ'
            ],
            [
                'name' => 'Ireland' ,
                'key' => '353' ,
                'code' => 'IE',
                'icon' => 'IE'
                // , 'simple_code' => 'IRL'
            ],
            [
                'name' => 'Isle of Man	44' ,
                'key' => '1624' ,
                'code' => 'IM',
                'icon' => 'IM'
                // , 'simple_code' => 'IMN'
            ],
            [
                'name' => 'Israel' ,
                'key' => '972' ,
                'code' => 'IL',
                'icon' => 'IL'
                // , 'simple_code' => 'ISR'
            ],
            [
                'name' => 'Italy' ,
                'key' => '39' ,
                'code' => 'IT',
                'icon' => 'IT'
                // , 'simple_code' => 'ITA'
            ],
            [
                'name' => 'Ivory Coast' ,
                'key' => '225' ,
                'code' => 'CI',
                'icon' => 'CI'
                // , 'simple_code' => 'CIV'
            ],
            [
                'name' => 'Jamaica' ,
                'key' => '1-876' ,
                'code' => 'JM',
                'icon' => 'JM'
                // , 'simple_code' => 'JAM'
            ],
            [
                'name' => 'Japan' ,
                'key' => '81' ,
                'code' => 'JP',
                'icon' => 'JP'
                // , 'simple_code' => 'JPN'
            ],
            [
                'name' => 'Jersey' ,
                'key' => '44-1534' ,
                'code' => 'JE',
                'icon' => 'JE'
                // , 'simple_code' => 'JEY'
            ],
            [
                'name' => 'Jordan' ,
                'key' => '962' ,
                'code' => 'JO',
                'icon' => 'JO'
                // , 'simple_code' => 'JOR'
            ],
            [
                'name' => 'Kazakhstan' ,
                'key' => '7' ,
                'code' => 'KZ',
                'icon' => 'KZ'
                // , 'simple_code' => 'KAZ'
            ],
            [
                'name' => 'Kenya' ,
                'key' => '254' ,
                'code' => 'KE',
                'icon' => 'KE'
                // , 'simple_code' => 'KEN'
            ],
            [
                'name' => 'Kiribati' ,
                'key' => '686' ,
                'code' => 'KI',
                'icon' => 'KI'
                // , 'simple_code' => 'KIR'
            ],
            [
                'name' => 'Kosovo' ,
                'key' => '383' ,
                'code' => 'XK',
                'icon' => 'XK'
                // , 'simple_code' => 'XKX'
            ],
            [
                'name' => 'Kuwait' ,
                'key' => '965' ,
                'code' => 'KW',
                'icon' => 'KW'
                // , 'simple_code' => 'KWT'
            ],
            [
                'name' => 'Kyrgyzstan' ,
                'key' => '996' ,
                'code' => 'KG',
                'icon' => 'KG'
                // , 'simple_code' => 'KGZ'
            ],
            [
                'name' => 'Laos' ,
                'key' => '856' ,
                'code' => 'LA',
                'icon' => 'LA'
                // , 'simple_code' => 'LAO'
            ],
            [
                'name' => 'Latvia' ,
                'key' => '371' ,
                'code' => 'LV',
                'icon' => 'LV'
                // , 'simple_code' => 'LVA'
            ],
            [
                'name' => 'Lebanon' ,
                'key' => '961' ,
                'code' => 'LB',
                'icon' => 'LB'
                // , 'simple_code' => 'LBN'
            ],
            [
                'name' => 'Lesotho' ,
                'key' => '266' ,
                'code' => 'LS',
                'icon' => 'LS'
                // , 'simple_code' => 'LSO'
            ],
            [
                'name' => 'Liberia' ,
                'key' => '231' ,
                'code' => 'LR',
                'icon' => 'LR'
                // , 'simple_code' => 'LBR'
            ],
            [
                'name' => 'Libya' ,
                'key' => '218' ,
                'code' => 'LY',
                'icon' => 'LY'
                // , 'simple_code' => 'LBY'
            ],
            [
                'name' => 'Liechtenstein' ,
                'key' => '423' ,
                'code' => 'LI',
                'icon' => 'LI'
                // , 'simple_code' => 'LIE'
            ],
            [
                'name' => 'Lithuania' ,
                'key' => '370' ,
                'code' => 'LT',
                'icon' => 'LT'
                // , 'simple_code' => 'LTU'
            ],
            [
                'name' => 'Luxembourg' ,
                'key' => '352' ,
                'code' => 'LU',
                'icon' => 'LU'
                // , 'simple_code' => 'LUX'
            ],
            [
                'name' => 'Macau' ,
                'key' => '853' ,
                'code' => 'MO',
                'icon' => 'MO'
                // , 'simple_code' => 'MAC'
            ],
            [
                'name' => 'Macedonia' ,
                'key' => '389' ,
                'code' => 'MK',
                'icon' => 'MK'
                // , 'simple_code' => 'MKD'
            ],
            [
                'name' => 'Madagascar' ,
                'key' => '261' ,
                'code' => 'MG',
                'icon' => 'MG'
                // , 'simple_code' => 'MDG'
            ],
            [
                'name' => 'Malawi' ,
                'key' => '265' ,
                'code' => 'MW',
                'icon' => 'MW'
                // , 'simple_code' => 'MWI'
            ],
            [
                'name' => 'Malaysia' ,
                'key' => '60' ,
                'code' => 'MY',
                'icon' => 'MY'
                // , 'simple_code' => 'MYS'
            ],
            [
                'name' => 'Maldives' ,
                'key' => '960' ,
                'code' => 'MV',
                'icon' => 'MV'
                // , 'simple_code' => 'MDV'
            ],
            [
                'name' => 'Mali' ,
                'key' => '223' ,
                'code' => 'ML',
                'icon' => 'ML'
                // , 'simple_code' => 'MLI'
            ],
            [
                'name' => 'Malta' ,
                'key' => '356' ,
                'code' => 'MT',
                'icon' => 'MT'
                // , 'simple_code' => 'MLT'
            ],
            [
                'name' => 'Marshall Islands' ,
                'key' => '692' ,
                'code' => 'MH',
                'icon' => 'MH'
                // , 'simple_code' => 'MHL'
            ],
            [
                'name' => 'Mauritania' ,
                'key' => '222' ,
                'code' => 'MR',
                'icon' => 'MR'
                // , 'simple_code' => 'MRT'
            ],
            [
                'name' => 'Mauritius' ,
                'key' => '230' ,
                'code' => 'MU',
                'icon' => 'MU'
                // , 'simple_code' => 'MUS'
            ],
            [
                'name' => 'Mayotte' ,
                'key' => '262' ,
                'code' => 'YT',
                'icon' => 'YT'
                // , 'simple_code' => 'MYT'
            ],
            [
                'name' => 'Mexico' ,
                'key' => '52' ,
                'code' => 'MX',
                'icon' => 'MX'
                // , 'simple_code' => 'MEX'
            ],
            [
                'name' => 'Micronesia' ,
                'key' => '691' ,
                'code' => 'FM',
                'icon' => 'FM'
                // , 'simple_code' => 'FSM'
            ],
            [
                'name' => 'Moldova' ,
                'key' => '373' ,
                'code' => 'MD',
                'icon' => 'MD'
                // , 'simple_code' => 'MDA'
            ],
            [
                'name' => 'Monaco' ,
                'key' => '377' ,
                'code' => 'MC',
                'icon' => 'MC'
                // , 'simple_code' => 'MCO'
            ],
            [
                'name' => 'Mongolia' ,
                'key' => '976' ,
                'code' => 'MN',
                'icon' => 'MN'
                // , 'simple_code' => 'MNG'
            ],
            [
                'name' => 'Montenegro' ,
                'key' => '382' ,
                'code' => 'ME',
                'icon' => 'ME'
                // , 'simple_code' => 'MNE'
            ],
            [
                'name' => 'Montserrat' ,
                'key' => '1-664' ,
                'code' => 'MS',
                'icon' => 'MS'
                // , 'simple_code' => 'MSR'
            ],
            [
                'name' => 'Morocco' ,
                'key' => '212' ,
                'code' => 'MA',
                'icon' => 'MA'
                // , 'simple_code' => 'MAR'
            ],
            [
                'name' => 'Mozambique' ,
                'key' => '258' ,
                'code' => 'MZ',
                'icon' => 'MZ'
                // , 'simple_code' => 'MOZ'
            ],
            [
                'name' => 'Myanmar' ,
                'key' => '95' ,
                'code' => 'MM',
                'icon' => 'MM'
                // , 'simple_code' => 'MMR'
            ],
            [
                'name' => 'Namibia' ,
                'key' => '264' ,
                'code' => 'NA',
                'icon' => 'NA'
                // , 'simple_code' => 'NAM'
            ],
            [
                'name' => 'Nauru' ,
                'key' => '674' ,
                'code' => 'NR',
                'icon' => 'NR'
                // , 'simple_code' => 'NRU'
            ],
            [
                'name' => 'Nepal' ,
                'key' => '977' ,
                'code' => 'NP',
                'icon' => 'NP'
                // , 'simple_code' => 'NPL'
            ],
            [
                'name' => 'Netherlands' ,
                'key' => '31' ,
                'code' => 'NL',
                'icon' => 'NL'
                // , 'simple_code' => 'NLD'
            ],
            [
                'name' => 'Netherlands Antilles' ,
                'key' => '599' ,
                'code' => 'AN',
                'icon' => 'AN'
                // , 'simple_code' => 'ANT'
            ],
            [
                'name' => 'New Caledonia' ,
                'key' => '687' ,
                'code' => 'NC',
                'icon' => 'NC'
                // , 'simple_code' => 'NCL'
            ],
            [
                'name' => 'New Zealand' ,
                'key' => '64' ,
                'code' => 'NZ',
                'icon' => 'NZ'
                // , 'simple_code' => 'NZL'
            ],
            [
                'name' => 'Nicaragua' ,
                'key' => '505' ,
                'code' => 'NI',
                'icon' => 'NI'
                // , 'simple_code' => 'NIC'
            ],
            [
                'name' => 'Niger' ,
                'key' => '227' ,
                'code' => 'NE',
                'icon' => 'NE'
                // , 'simple_code' => 'NER'
            ],
            [
                'name' => 'Nigeria' ,
                'key' => '234' ,
                'code' => 'NG',
                'icon' => 'NG'
                // , 'simple_code' => 'NGA'
            ],
            [
                'name' => 'Niue' ,
                'key' => '683' ,
                'code' => 'NU',
                'icon' => 'NU'
                // , 'simple_code' => 'NIU'
            ],
            [
                'name' => 'North Korea' ,
                'key' => '850' ,
                'code' => 'KP',
                'icon' => 'KP'
                // , 'simple_code' => 'PRK'
            ],
            [
                'name' => 'Northern Mariana Islands' ,
                'key' => '1-670' ,
                'code' => 'MP',
                'icon' => 'MP'
                // , 'simple_code' => 'MNP'
            ],
            [
                'name' => 'Norway' ,
                'key' => '47' ,
                'code' => 'NO',
                'icon' => 'NO'
                // , 'simple_code' => 'NOR'
            ],
            [
                'name' => 'Oman' ,
                'key' => '968' ,
                'code' => 'OM',
                'icon' => 'OM'
                // , 'simple_code' => 'OMN'
            ],
            [
                'name' => 'Pakistan' ,
                'key' => '92' ,
                'code' => 'PK',
                'icon' => 'PK'
                // , 'simple_code' => 'PAK'
            ],
            [
                'name' => 'Palau' ,
                'key' => '680' ,
                'code' => 'PW',
                'icon' => 'PW'
                // , 'simple_code' => 'PLW'
            ],
            [
                'name' => 'Palestine' ,
                'key' => '970' ,
                'code' => 'PS',
                'icon' => 'PS'
                // , 'simple_code' => 'PSE'
            ],
            [
                'name' => 'Panama' ,
                'key' => '507' ,
                'code' => 'PA',
                'icon' => 'PA'
                // , 'simple_code' => 'PAN'
            ],
            [
                'name' => 'Papua New Guinea' ,
                'key' => '675' ,
                'code' => 'PG',
                'icon' => 'PG'
                // , 'simple_code' => 'PNG'
            ],
            [
                'name' => 'Paraguay' ,
                'key' => '595' ,
                'code' => 'PY',
                'icon' => 'PY'
                // , 'simple_code' => 'PRY'
            ],
            [
                'name' => 'Peru' ,
                'key' => '51' ,
                'code' => 'PE',
                'icon' => 'PE'
                // , 'simple_code' => 'PER'
            ],
            [
                'name' => 'Philippines' ,
                'key' => '63' ,
                'code' => 'PH',
                'icon' => 'PH'
                // , 'simple_code' => 'PHL'
            ],
            [
                'name' => 'Pitcairn' ,
                'key' => '64' ,
                'code' => 'PN',
                'icon' => 'PN'
                // , 'simple_code' => 'PCN'
            ],
            [
                'name' => 'Poland' ,
                'key' => '48' ,
                'code' => 'PL',
                'icon' => 'PL'
                // , 'simple_code' => 'POL'
            ],
            [
                'name' => 'Portugal' ,
                'key' => '351' ,
                'code' => 'PT',
                'icon' => 'PT'
                // , 'simple_code' => 'PRT'
            ],
            [
                'name' => 'Puerto Rico' ,
                'key' => '1-787' ,
                'code' => 'PR',
                'icon' => 'PR'
                // , 'simple_code' => 'PRI'
            ],
            [
                'name' => 'Qatar' ,
                'key' => '974' ,
                'code' => 'QA',
                'icon' => 'QA'
                // , 'simple_code' => 'QAT'
            ],
            [
                'name' => 'Republic of the Congo' ,
                'key' => '242' ,
                'code' => 'CG',
                'icon' => 'CG'
                // , 'simple_code' => 'COG'
            ],
            [
                'name' => 'Reunion' ,
                'key' => '262' ,
                'code' => 'RE',
                'icon' => 'RE'
                // , 'simple_code' => 'REU'
            ],
            [
                'name' => 'Romania' ,
                'key' => '40' ,
                'code' => 'RO',
                'icon' => 'RO'
                // , 'simple_code' => 'ROU'
            ],
            [
                'name' => 'Russia' ,
                'key' => '7' ,
                'code' => 'RU',
                'icon' => 'RU'
                // , 'simple_code' => 'RUS'
            ],
            [
                'name' => 'Rwanda' ,
                'key' => '250' ,
                'code' => 'RW',
                'icon' => 'RW'
                // , 'simple_code' => 'RWA'
            ],
            [
                'name' => 'Saint Barthelemy' ,
                'key' => '590' ,
                'code' => 'BL',
                'icon' => 'BL'
                // , 'simple_code' => 'BLM'
            ],
            [
                'name' => 'Saint Helena' ,
                'key' => '290' ,
                'code' => 'SH',
                'icon' => 'SH'
                // , 'simple_code' => 'SHN'
            ],
            [
                'name' => 'Saint Kitts and Nevis' ,
                'key' => '1-869' ,
                'code' => 'KN',
                'icon' => 'KN'
                // , 'simple_code' => 'KNA'
            ],
            [
                'name' => 'Saint Lucia' ,
                'key' => '1-758' ,
                'code' => 'LC',
                'icon' => 'LC'
                // , 'simple_code' => 'LCA'
            ],
            [
                'name' => 'Saint Martin' ,
                'key' => '590' ,
                'code' => 'MF',
                'icon' => 'MF'
                // , 'simple_code' => 'MAF'
            ],
            [
                'name' => 'Saint Pierre and Miquelon' ,
                'key' => '508' ,
                'code' => 'PM',
                'icon' => 'PM'
                // , 'simple_code' => 'SPM'
            ],
            [
                'name' => 'Saint Vincent and the Grenadines' ,
                'key' => '1-784' ,
                'code' => 'VC',
                'icon' => 'VC'
                // , 'simple_code' => 'VCT'
            ],
            [
                'name' => 'Samoa' ,
                'key' => '685' ,
                'code' => 'WS',
                'icon' => 'WS'
                // , 'simple_code' => 'WSM'
            ],
            [
                'name' => 'San Marino' ,
                'key' => '378' ,
                'code' => 'SM',
                'icon' => 'SM'
                // , 'simple_code' => 'SMR'
            ],
            [
                'name' => 'Sao Tome and Principe' ,
                'key' => '239' ,
                'code' => 'ST',
                'icon' => 'ST'
                // , 'simple_code' => 'STP'
            ],
            [
                'name' => 'Saudi Arabia' ,
                'key' => '966' ,
                'code' => 'SA',
                'icon' => 'SA'
                // , 'simple_code' => 'SAU'
            ],
            [
                'name' => 'Senegal' ,
                'key' => '221' ,
                'code' => 'SN',
                'icon' => 'SN'
                // , 'simple_code' => 'SEN'
            ],
            [
                'name' => 'Serbia' ,
                'key' => '381' ,
                'code' => 'RS',
                'icon' => 'RS'
                // , 'simple_code' => 'SRB'
            ],
            [
                'name' => 'Seychelles' ,
                'key' => '248' ,
                'code' => 'SC',
                'icon' => 'SC'
                // , 'simple_code' => 'SYC'
            ],
            [
                'name' => 'Sierra Leone' ,
                'key' => '232' ,
                'code' => 'SL',
                'icon' => 'SL'
                // , 'simple_code' => 'SLE'
            ],
            [
                'name' => 'Singapore' ,
                'key' => '65' ,
                'code' => 'SG',
                'icon' => 'SG'
                // , 'simple_code' => 'SGP'
            ],
            [
                'name' => 'Sint Maarten' ,
                'key' => '1-721' ,
                'code' => 'SX',
                'icon' => 'SX'
                // , 'simple_code' => 'SXM'
            ],
            [
                'name' => 'Slovakia' ,
                'key' => '421' ,
                'code' => 'SK',
                'icon' => 'SK'
                // , 'simple_code' => 'SVK'
            ],
            [
                'name' => 'Slovenia' ,
                'key' => '386' ,
                'code' => 'SI',
                'icon' => 'SI'
                // , 'simple_code' => 'SVN'
            ],
            [
                'name' => 'Solomon Islands' ,
                'key' => '677' ,
                'code' => 'SB',
                'icon' => 'SB'
                // , 'simple_code' => 'SLB'
            ],
            [
                'name' => 'Somalia' ,
                'key' => '252' ,
                'code' => 'SO',
                'icon' => 'SO'
                // , 'simple_code' => 'SOM'
            ],
            [
                'name' => 'South Africa' ,
                'key' => '27' ,
                'code' => 'ZA',
                'icon' => 'ZA'
                // , 'simple_code' => 'ZAF'
            ],
            [
                'name' => 'South Korea' ,
                'key' => '82' ,
                'code' => 'KR',
                'icon' => 'KR'
                // , 'simple_code' => 'KOR'
            ],
            [
                'name' => 'South Sudan' ,
                'key' => '211' ,
                'code' => 'SS',
                'icon' => 'SS'
                // , 'simple_code' => 'SSD'
            ],
            [
                'name' => 'Spain' ,
                'key' => '34' ,
                'code' => 'ES',
                'icon' => 'ES'
                // , 'simple_code' => 'ESP'
            ],
            [
                'name' => 'Sri Lanka' ,
                'key' => '94' ,
                'code' => 'LK',
                'icon' => 'LK'
                // , 'simple_code' => 'LKA'
            ],
            [
                'name' => 'Sudan' ,
                'key' => '249' ,
                'code' => 'SD',
                'icon' => 'SD'
                // , 'simple_code' => 'SDN'
            ],
            [
                'name' => 'Suriname' ,
                'key' => '597' ,
                'code' => 'SR',
                'icon' => 'SR'
                // , 'simple_code' => 'SUR'
            ],
            [
                'name' => 'Svalbard and Jan Mayen' ,
                'key' => '47' ,
                'code' => 'SJ',
                'icon' => 'SJ'
                // , 'simple_code' => 'SJM'
            ],
            [
                'name' => 'Swaziland' ,
                'key' => '268' ,
                'code' => 'SZ',
                'icon' => 'SZ'
                // , 'simple_code' => 'SWZ'
            ],
            [
                'name' => 'Sweden' ,
                'key' => '46' ,
                'code' => 'SE',
                'icon' => 'SE'
                // , 'simple_code' => 'SWE'
            ],
            [
                'name' => 'Switzerland' ,
                'key' => '41' ,
                'code' => 'CH',
                'icon' => 'CH'
                // , 'simple_code' => 'CHE'
            ],
            [
                'name' => 'Syria' ,
                'key' => '963' ,
                'code' => 'SY',
                'icon' => 'SY'
                // , 'simple_code' => 'SYR'
            ],
            [
                'name' => 'Taiwan' ,
                'key' => '886' ,
                'code' => 'TW',
                'icon' => 'TW'
                // , 'simple_code' => 'TWN'
            ],
            [
                'name' => 'Tajikistan' ,
                'key' => '992' ,
                'code' => 'TJ',
                'icon' => 'TJ'
                // , 'simple_code' => 'TJK'
            ],
            [
                'name' => 'Tanzania' ,
                'key' => '255' ,
                'code' => 'TZ',
                'icon' => 'TZ'
                // , 'simple_code' => 'TZA'
            ],
            [
                'name' => 'Thailand' ,
                'key' => '66' ,
                'code' => 'TH',
                'icon' => 'TH'
                // , 'simple_code' => 'THA'
            ],
            [
                'name' => 'Togo' ,
                'key' => '228' ,
                'code' => 'TG',
                'icon' => 'TG'
                // , 'simple_code' => 'TGO'
            ],
            [
                'name' => 'Tokelau' ,
                'key' => '690' ,
                'code' => 'TK',
                'icon' => 'TK'
                // , 'simple_code' => 'TKL'
            ],
            [
                'name' => 'Tonga' ,
                'key' => '676' ,
                'code' => 'TO',
                'icon' => 'TO'
                // , 'simple_code' => 'TON'
            ],
            [
                'name' => 'Trinidad and Tobago' ,
                'key' => '1-868' ,
                'code' => 'TT',
                'icon' => 'TT'
                // , 'simple_code' => 'TTO'
            ],
            [
                'name' => 'Tunisia' ,
                'key' => '216' ,
                'code' => 'TN',
                'icon' => 'TN'
                // , 'simple_code' => 'TUN'
            ],
            [
                'name' => 'Turkey' ,
                'key' => '90' ,
                'code' => 'TR',
                'icon' => 'TR'
                // , 'simple_code' => 'TUR'
            ],
            [
                'name' => 'Turkmenistan' ,
                'key' => '993' ,
                'code' => 'TM',
                'icon' => 'TM'
                // , 'simple_code' => 'TKM'
            ],
            [
                'name' => 'Turks and Caicos Islands' ,
                'key' => '1-649' ,
                'code' => 'TC',
                'icon' => 'TC'
                // , 'simple_code' => 'TCA'
            ],
            [
                'name' => 'Tuvalu' ,
                'key' => '688' ,
                'code' => 'TV',
                'icon' => 'TV'
                // , 'simple_code' => 'TUV'
            ],
            [
                'name' => 'U.S. Virgin Islands' ,
                'key' => '1-340' ,
                'code' => 'VI',
                'icon' => 'VI'
                // , 'simple_code' => 'VIR'
            ],
            [
                'name' => 'Uganda' ,
                'key' => '256' ,
                'code' => 'UG',
                'icon' => 'UG'
                // , 'simple_code' => 'UGA'
            ],
            [
                'name' => 'Ukraine' ,
                'key' => '380' ,
                'code' => 'UA',
                'icon' => 'UA'
                // , 'simple_code' => 'UKR'
            ],
            [
                'name' => 'United Arab Emirates' ,
                'key' => '971' ,
                'code' => 'AE',
                'icon' => 'AE'
                // , 'simple_code' => 'ARE'
            ],
            [
                'name' => 'United Kingdom' ,
                'key' => '44' ,
                'code' => 'GB',
                'icon' => 'GB'
                // , 'simple_code' => 'GBR'
            ],
            [
                'name' => 'United States' ,
                'key' => '1' ,
                'code' => 'US',
                'icon' => 'US'
                // , 'simple_code' => 'USA'
            ],
            [
                'name' => 'Uruguay' ,
                'key' => '598' ,
                'code' => 'UY',
                'icon' => 'UY'
                // , 'simple_code' => 'URY'
            ],
            [
                'name' => 'Uzbekistan' ,
                'key' => '998' ,
                'code' => 'UZ',
                'icon' => 'UZ'
                // , 'simple_code' => 'UZB'
            ],
            [
                'name' => 'Vanuatu' ,
                'key' => '678' ,
                'code' => 'VU',
                'icon' => 'VU'
                // , 'simple_code' => 'VUT'
            ],
            [
                'name' => 'Vatican' ,
                'key' => '379' ,
                'code' => 'VA',
                'icon' => 'VA'
                // , 'simple_code' => 'VAT'
            ],
            [
                'name' => 'Venezuela' ,
                'key' => '58' ,
                'code' => 'VE',
                'icon' => 'VE'
                // , 'simple_code' => 'VEN'
            ],
            [
                'name' => 'Vietnam' ,
                'key' => '84' ,
                'code' => 'VN',
                'icon' => 'VN'
                // , 'simple_code' => 'VNM'
            ],
            [
                'name' => 'Wallis and Futuna' ,
                'key' => '681' ,
                'code' => 'WF',
                'icon' => 'WF'
                // , 'simple_code' => 'WLF'
            ],
            [
                'name' => 'Western Sahara' ,
                'key' => '212' ,
                'code' => 'EH',
                'icon' => 'EH'
                // , 'simple_code' => 'ESH'
            ],
            [
                'name' => 'Yemen' ,
                'key' => '967' ,
                'code' => 'YE',
                'icon' => 'YE'
                // , 'simple_code' => 'YEM'
            ],
            [
                'name' => 'Zambia' ,
                'key' => '260' ,
                'code' => 'ZM',
                'icon' => 'ZM'
                // , 'simple_code' => 'ZMB'
            ],
            [
                'name' => 'Zimbabwe' ,
                'key' => '263' ,
                'code' => 'ZW',
                'icon' => 'ZW'
                // , 'simple_code' => 'ZWE'
            ],
        ];
    }
}
