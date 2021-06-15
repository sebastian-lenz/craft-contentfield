<?php

namespace lenz\contentfield\helpers;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use Throwable;

/**
 * Class DefaultGeoLocations
 *
 * see http://techslides.com/list-of-countries-and-capitals
 */
class DefaultGeoLocations
{
  /**
   * @var array
   */
  static $DEFAULT_LOCATION = ['latitude' => 40.712776, 'longitude' => -74.005974];

  /**
   * @var array
   */
  static $LOCATIONS = [
    'AF' => ['latitude' =>  34.51666667,  'longitude' =>   69.183333], // Kabul, Afghanistan
    'AX' => ['latitude' =>  60.116667,    'longitude' =>   19.9],      // Mariehamn, Aland Islands
    'AL' => ['latitude' =>  41.31666667,  'longitude' =>   19.816667], // Tirana, Albania
    'DZ' => ['latitude' =>  36.75,        'longitude' =>    3.05],     // Algiers, Algeria
    'AS' => ['latitude' => -14.26666667,  'longitude' => -170.7],      // Pago Pago, American Samoa
    'AD' => ['latitude' =>  42.5,         'longitude' =>    1.516667], // Andorra la Vella, Andorra
    'AO' => ['latitude' =>  -8.833333333, 'longitude' =>   13.216667], // Luanda, Angola
    'AI' => ['latitude' =>  18.21666667,  'longitude' =>  -63.05],     // The Valley, Anguilla
    'AG' => ['latitude' =>  17.11666667,  'longitude' =>  -61.85],     // Saint John’s, Antigua and Barbuda
    'AR' => ['latitude' => -34.58333333,  'longitude' =>  -58.666667], // Buenos Aires, Argentina
    'AM' => ['latitude' =>  40.16666667,  'longitude' =>   44.5],      // Yerevan, Armenia
    'AW' => ['latitude' =>  12.51666667,  'longitude' =>  -70.033333], // Oranjestad, Aruba
    'AU' => ['latitude' => -35.26666667,  'longitude' =>  149.133333], // Canberra, Australia
    'AT' => ['latitude' =>  48.2,         'longitude' =>   16.366667], // Vienna, Austria
    'AZ' => ['latitude' =>  40.38333333,  'longitude' =>   49.866667], // Baku, Azerbaijan
    'BS' => ['latitude' =>  25.08333333,  'longitude' =>  -77.35],     // Nassau, Bahamas
    'BH' => ['latitude' =>  26.23333333,  'longitude' =>   50.566667], // Manama, Bahrain
    'BD' => ['latitude' =>  23.71666667,  'longitude' =>   90.4],      // Dhaka, Bangladesh
    'BB' => ['latitude' =>  13.1,         'longitude' =>  -59.616667], // Bridgetown, Barbados
    'BY' => ['latitude' =>  53.9,         'longitude' =>   27.566667], // Minsk, Belarus
    'BE' => ['latitude' =>  50.83333333,  'longitude' =>    4.333333], // Brussels, Belgium
    'BZ' => ['latitude' =>  17.25,        'longitude' =>  -88.766667], // Belmopan, Belize
    'BJ' => ['latitude' =>   6.483333333, 'longitude' =>    2.616667], // Porto-Novo, Benin
    'BM' => ['latitude' =>  32.28333333,  'longitude' =>  -64.783333], // Hamilton, Bermuda
    'BT' => ['latitude' =>  27.46666667,  'longitude' =>   89.633333], // Thimphu, Bhutan
    'BO' => ['latitude' => -16.5,         'longitude' =>  -68.15],     // La Paz, Bolivia
    'BA' => ['latitude' =>  43.86666667,  'longitude' =>   18.416667], // Sarajevo, Bosnia and Herzegovina
    'BW' => ['latitude' => -24.63333333,  'longitude' =>   25.9],      // Gaborone, Botswana
    'BR' => ['latitude' => -15.78333333,  'longitude' =>  -47.916667], // Brasilia, Brazil
    'IO' => ['latitude' =>  -7.3,         'longitude' =>   72.4],      // Diego Garcia, British Indian Ocean Territory
    'VG' => ['latitude' =>  18.41666667,  'longitude' =>  -64.616667], // Road Town, British Virgin Islands
    'BN' => ['latitude' =>   4.883333333, 'longitude' =>  114.933333], // Bandar Seri Begawan, Brunei Darussalam
    'BG' => ['latitude' =>  42.68333333,  'longitude' =>   23.316667], // Sofia, Bulgaria
    'BF' => ['latitude' =>  12.36666667,  'longitude' =>   -1.516667], // Ouagadougou, Burkina Faso
    'BI' => ['latitude' =>  -3.366666667, 'longitude' =>   29.35],     // Bujumbura, Burundi
    'KH' => ['latitude' =>  11.55,        'longitude' =>  104.916667], // Phnom Penh, Cambodia
    'CM' => ['latitude' =>   3.866666667, 'longitude' =>   11.516667], // Yaounde, Cameroon
    'CA' => ['latitude' =>  45.41666667,  'longitude' =>  -75.7],      // Ottawa, Canada
    'CV' => ['latitude' =>  14.91666667,  'longitude' =>  -23.516667], // Praia, Cape Verde
    'KY' => ['latitude' =>  19.3,         'longitude' =>  -81.383333], // George Town, Cayman Islands
    'CF' => ['latitude' =>   4.366666667, 'longitude' =>   18.583333], // Bangui, Central African Republic
    'TD' => ['latitude' =>  12.1,         'longitude' =>   15.033333], // N’Djamena, Chad
    'CL' => ['latitude' => -33.45,        'longitude' =>  -70.666667], // Santiago, Chile
    'CN' => ['latitude' =>  39.91666667,  'longitude' =>  116.383333], // Beijing, China
    'CX' => ['latitude' => -10.41666667,  'longitude' =>  105.716667], // The Settlement, Christmas Island
    'CC' => ['latitude' => -12.16666667,  'longitude' =>   96.833333], // West Island, Cocos Islands
    'CO' => ['latitude' =>   4.6,         'longitude' =>  -74.083333], // Bogota, Colombia
    'KM' => ['latitude' => -11.7,         'longitude' =>   43.233333], // Moroni, Comoros
    'CK' => ['latitude' => -21.2,         'longitude' => -159.766667], // Avarua, Cook Islands
    'CR' => ['latitude' =>   9.933333333, 'longitude' =>  -84.083333], // San Jose, Costa Rica
    'CI' => ['latitude' =>   6.816666667, 'longitude' =>   -5.266667], // Yamoussoukro, Cote d’Ivoire
    'HR' => ['latitude' =>  45.8,         'longitude' =>   16.0],      // Zagreb, Croatia
    'CU' => ['latitude' =>  23.11666667,  'longitude' =>  -82.35],     // Havana, Cuba
    'CW' => ['latitude' =>  12.1,         'longitude' =>  -68.916667], // Willemstad, CuraÃ§ao
    'CY' => ['latitude' =>  35.16666667,  'longitude' =>   33.366667], // Nicosia, Cyprus
    'CZ' => ['latitude' =>  50.08333333,  'longitude' =>   14.466667], // Prague, Czech Republic
    'CD' => ['latitude' =>  -4.316666667, 'longitude' =>   15.3],      // Kinshasa, Democratic Republic of the Congo
    'DK' => ['latitude' =>  55.66666667,  'longitude' =>   12.583333], // Copenhagen, Denmark
    'DJ' => ['latitude' =>  11.58333333,  'longitude' =>   43.15],     // Djibouti, Djibouti
    'DM' => ['latitude' =>  15.3,         'longitude' =>  -61.4],      // Roseau, Dominica
    'DO' => ['latitude' =>  18.46666667,  'longitude' =>  -69.9],      // Santo Domingo, Dominican Republic
    'EC' => ['latitude' =>  -0.216666667, 'longitude' =>  -78.5],      // Quito, Ecuador
    'EG' => ['latitude' =>  30.05,        'longitude' =>   31.25],     // Cairo, Egypt
    'SV' => ['latitude' =>  13.7,         'longitude' =>  -89.2],      // San Salvador, El Salvador
    'GQ' => ['latitude' =>   3.75,        'longitude' =>    8.783333], // Malabo, Equatorial Guinea
    'ER' => ['latitude' =>  15.33333333,  'longitude' =>   38.933333], // Asmara, Eritrea
    'EE' => ['latitude' =>  59.43333333,  'longitude' =>   24.716667], // Tallinn, Estonia
    'ET' => ['latitude' =>   9.033333333, 'longitude' =>   38.7],      // Addis Ababa, Ethiopia
    'FK' => ['latitude' => -51.7,         'longitude' =>  -57.85],     // Stanley, Falkland Islands
    'FO' => ['latitude' =>  62.0,         'longitude' =>   -6.766667], // Torshavn, Faroe Islands
    'FM' => ['latitude' =>   6.916666667, 'longitude' =>  158.15],     // Palikir, Federated States of Micronesia
    'FJ' => ['latitude' => -18.13333333,  'longitude' =>  178.416667], // Suva, Fiji
    'FI' => ['latitude' =>  60.16666667,  'longitude' =>   24.933333], // Helsinki, Finland
    'FR' => ['latitude' =>  48.86666667,  'longitude' =>    2.333333], // Paris, France
    'PF' => ['latitude' => -17.53333333,  'longitude' => -149.566667], // Papeete, French Polynesia
    'TF' => ['latitude' => -49.35,        'longitude' =>   70.216667], // Port-aux-FranÃ§ais, French Southern and Antarctic Lands
    'GA' => ['latitude' =>   0.383333333, 'longitude' =>    9.45],     // Libreville, Gabon
    'GE' => ['latitude' =>  41.68333333,  'longitude' =>   44.833333], // Tbilisi, Georgia
    'DE' => ['latitude' =>  52.51666667,  'longitude' =>   13.4],      // Berlin, Germany
    'GH' => ['latitude' =>   5.55,        'longitude' =>   -0.216667], // Accra, Ghana
    'GI' => ['latitude' =>  36.13333333,  'longitude' =>   -5.35],     // Gibraltar, Gibraltar
    'GR' => ['latitude' =>  37.98333333,  'longitude' =>   23.733333], // Athens, Greece
    'GL' => ['latitude' =>  64.18333333,  'longitude' =>  -51.75],     // Nuuk, Greenland
    'GD' => ['latitude' =>  12.05,        'longitude' =>  -61.75],     // Saint George’s, Grenada
    'GU' => ['latitude' =>  13.46666667,  'longitude' =>  144.733333], // Hagatna, Guam
    'GT' => ['latitude' =>  14.61666667,  'longitude' =>  -90.516667], // Guatemala City, Guatemala
    'GG' => ['latitude' =>  49.45,        'longitude' =>   -2.533333], // Saint Peter Port, Guernsey
    'GN' => ['latitude' =>   9.5,         'longitude' =>  -13.7],      // Conakry, Guinea
    'GW' => ['latitude' =>  11.85,        'longitude' =>  -15.583333], // Bissau, Guinea-Bissau
    'GY' => ['latitude' =>   6.8,         'longitude' =>  -58.15],     // Georgetown, Guyana
    'HT' => ['latitude' =>  18.53333333,  'longitude' =>  -72.333333], // Port-au-Prince, Haiti
    'HN' => ['latitude' =>  14.1,         'longitude' =>  -87.216667], // Tegucigalpa, Honduras
    'HK' => ['latitude' =>  22.396427,    'longitude' =>  114.109497], // N/A, Hong Kong
    'HU' => ['latitude' =>  47.5,         'longitude' =>   19.083333], // Budapest, Hungary
    'IS' => ['latitude' =>  64.15,        'longitude' =>  -21.95],     // Reykjavik, Iceland
    'IN' => ['latitude' =>  28.6,         'longitude' =>   77.2],      // New Delhi, India
    'ID' => ['latitude' =>  -6.166666667, 'longitude' =>  106.816667], // Jakarta, Indonesia
    'IR' => ['latitude' =>  35.7,         'longitude' =>   51.416667], // Tehran, Iran
    'IQ' => ['latitude' =>  33.33333333,  'longitude' =>   44.4],      // Baghdad, Iraq
    'IE' => ['latitude' =>  53.31666667,  'longitude' =>   -6.233333], // Dublin, Ireland
    'IM' => ['latitude' =>  54.15,        'longitude' =>   -4.483333], // Douglas, Isle of Man
    'IL' => ['latitude' =>  31.76666667,  'longitude' =>   35.233333], // Jerusalem, Israel
    'IT' => ['latitude' =>  41.9,         'longitude' =>   12.483333], // Rome, Italy
    'JM' => ['latitude' =>  18.0,         'longitude' =>  -76.8],      // Kingston, Jamaica
    'JP' => ['latitude' =>  35.68333333,  'longitude' =>  139.75],     // Tokyo, Japan
    'JE' => ['latitude' =>  49.18333333,  'longitude' =>   -2.1],      // Saint Helier, Jersey
    'JO' => ['latitude' =>  31.95,        'longitude' =>   35.933333], // Amman, Jordan
    'KZ' => ['latitude' =>  51.16666667,  'longitude' =>   71.416667], // Astana, Kazakhstan
    'KE' => ['latitude' =>  -1.283333333, 'longitude' =>   36.816667], // Nairobi, Kenya
    'KI' => ['latitude' =>  -0.883333333, 'longitude' =>  169.533333], // Tarawa, Kiribati
    'KO' => ['latitude' =>  42.66666667,  'longitude' =>   21.166667], // Pristina, Kosovo
    'KW' => ['latitude' =>  29.36666667,  'longitude' =>   47.966667], // Kuwait City, Kuwait
    'KG' => ['latitude' =>  42.86666667,  'longitude' =>   74.6],      // Bishkek, Kyrgyzstan
    'LA' => ['latitude' =>  17.96666667,  'longitude' =>  102.6],      // Vientiane, Laos
    'LV' => ['latitude' =>  56.95,        'longitude' =>   24.1],      // Riga, Latvia
    'LB' => ['latitude' =>  33.86666667,  'longitude' =>   35.5],      // Beirut, Lebanon
    'LS' => ['latitude' => -29.31666667,  'longitude' =>   27.483333], // Maseru, Lesotho
    'LR' => ['latitude' =>   6.3,         'longitude' =>  -10.8],      // Monrovia, Liberia
    'LY' => ['latitude' =>  32.88333333,  'longitude' =>   13.166667], // Tripoli, Libya
    'LI' => ['latitude' =>  47.13333333,  'longitude' =>    9.516667], // Vaduz, Liechtenstein
    'LT' => ['latitude' =>  54.68333333,  'longitude' =>   25.316667], // Vilnius, Lithuania
    'LU' => ['latitude' =>  49.6,         'longitude' =>    6.116667], // Luxembourg, Luxembourg
    'MK' => ['latitude' =>  42.0,         'longitude' =>   21.433333], // Skopje, Macedonia
    'MG' => ['latitude' => -18.91666667,  'longitude' =>   47.516667], // Antananarivo, Madagascar
    'MW' => ['latitude' => -13.96666667,  'longitude' =>   33.783333], // Lilongwe, Malawi
    'MY' => ['latitude' =>   3.166666667, 'longitude' =>  101.7],      // Kuala Lumpur, Malaysia
    'MV' => ['latitude' =>   4.166666667, 'longitude' =>   73.5],      // Male, Maldives
    'ML' => ['latitude' =>  12.65,        'longitude' =>   -8.0],      // Bamako, Mali
    'MT' => ['latitude' =>  35.88333333,  'longitude' =>   14.5],      // Valletta, Malta
    'MH' => ['latitude' =>   7.1,         'longitude' =>  171.383333], // Majuro, Marshall Islands
    'MR' => ['latitude' =>  18.06666667,  'longitude' =>  -15.966667], // Nouakchott, Mauritania
    'MU' => ['latitude' => -20.15,        'longitude' =>   57.483333], // Port Louis, Mauritius
    'MX' => ['latitude' =>  19.43333333,  'longitude' =>  -99.133333], // Mexico City, Mexico
    'MD' => ['latitude' =>  47.0,         'longitude' =>   28.85],     // Chisinau, Moldova
    'MC' => ['latitude' =>  43.73333333,  'longitude' =>    7.416667], // Monaco, Monaco
    'MN' => ['latitude' =>  47.91666667,  'longitude' =>  106.916667], // Ulaanbaatar, Mongolia
    'ME' => ['latitude' =>  42.43333333,  'longitude' =>   19.266667], // Podgorica, Montenegro
    'MS' => ['latitude' =>  16.7,         'longitude' =>  -62.216667], // Plymouth, Montserrat
    'MA' => ['latitude' =>  34.01666667,  'longitude' =>   -6.816667], // Rabat, Morocco
    'MZ' => ['latitude' => -25.95,        'longitude' =>   32.583333], // Maputo, Mozambique
    'MM' => ['latitude' =>  16.8,         'longitude' =>   96.15],     // Rangoon, Myanmar
    'NA' => ['latitude' => -22.56666667,  'longitude' =>   17.083333], // Windhoek, Namibia
    'NR' => ['latitude' =>  -0.5477,      'longitude' =>  166.920867], // Yaren, Nauru
    'NP' => ['latitude' =>  27.71666667,  'longitude' =>   85.316667], // Kathmandu, Nepal
    'NL' => ['latitude' =>  52.35,        'longitude' =>    4.916667], // Amsterdam, Netherlands
    'NC' => ['latitude' => -22.26666667,  'longitude' =>  166.45],     // Noumea, New Caledonia
    'NZ' => ['latitude' => -41.3,         'longitude' =>  174.783333], // Wellington, New Zealand
    'NI' => ['latitude' =>  12.13333333,  'longitude' =>  -86.25],     // Managua, Nicaragua
    'NE' => ['latitude' =>  13.51666667,  'longitude' =>    2.116667], // Niamey, Niger
    'NG' => ['latitude' =>   9.083333333, 'longitude' =>    7.533333], // Abuja, Nigeria
    'NU' => ['latitude' => -19.01666667,  'longitude' => -169.916667], // Alofi, Niue
    'NF' => ['latitude' => -29.05,        'longitude' =>  167.966667], // Kingston, Norfolk Island
    'KP' => ['latitude' =>  39.01666667,  'longitude' =>  125.75],     // Pyongyang, North Korea
    'MP' => ['latitude' =>  15.2,         'longitude' =>  145.75],     // Saipan, Northern Mariana Islands
    'NO' => ['latitude' =>  59.91666667,  'longitude' =>   10.75],     // Oslo, Norway
    'OM' => ['latitude' =>  23.61666667,  'longitude' =>   58.583333], // Muscat, Oman
    'PK' => ['latitude' =>  33.68333333,  'longitude' =>   73.05],     // Islamabad, Pakistan
    'PW' => ['latitude' =>   7.483333333, 'longitude' =>  134.633333], // Melekeok, Palau
    'PS' => ['latitude' =>  31.76666667,  'longitude' =>   35.233333], // Jerusalem, Palestine
    'PA' => ['latitude' =>   8.966666667, 'longitude' =>  -79.533333], // Panama City, Panama
    'PG' => ['latitude' =>  -9.45,        'longitude' =>  147.183333], // Port Moresby, Papua New Guinea
    'PY' => ['latitude' => -25.26666667,  'longitude' =>  -57.666667], // Asuncion, Paraguay
    'PE' => ['latitude' => -12.05,        'longitude' =>  -77.05],     // Lima, Peru
    'PH' => ['latitude' =>  14.6,         'longitude' =>  120.966667], // Manila, Philippines
    'PN' => ['latitude' => -25.06666667,  'longitude' => -130.083333], // Adamstown, Pitcairn Islands
    'PL' => ['latitude' =>  52.25,        'longitude' =>   21.0],      // Warsaw, Poland
    'PT' => ['latitude' =>  38.71666667,  'longitude' =>   -9.133333], // Lisbon, Portugal
    'PR' => ['latitude' =>  18.46666667,  'longitude' =>  -66.116667], // San Juan, Puerto Rico
    'QA' => ['latitude' =>  25.28333333,  'longitude' =>   51.533333], // Doha, Qatar
    'CG' => ['latitude' =>  -4.25,        'longitude' =>   15.283333], // Brazzaville, Republic of Congo
    'RO' => ['latitude' =>  44.43333333,  'longitude' =>   26.1],      // Bucharest, Romania
    'RU' => ['latitude' =>  55.75,        'longitude' =>   37.6],      // Moscow, Russia
    'RW' => ['latitude' =>  -1.95,        'longitude' =>   30.05],     // Kigali, Rwanda
    'BL' => ['latitude' =>  17.88333333,  'longitude' =>  -62.85],     // Gustavia, Saint Barthelemy
    'SH' => ['latitude' => -15.93333333,  'longitude' =>   -5.716667], // Jamestown, Saint Helena
    'KN' => ['latitude' =>  17.3,         'longitude' =>  -62.716667], // Basseterre, Saint Kitts and Nevis
    'LC' => ['latitude' =>  14.0,         'longitude' =>  -61.0],      // Castries, Saint Lucia
    'MF' => ['latitude' =>  18.0731,      'longitude' =>  -63.0822],   // Marigot, Saint Martin
    'PM' => ['latitude' =>  46.76666667,  'longitude' =>  -56.183333], // Saint-Pierre, Saint Pierre and Miquelon
    'VC' => ['latitude' =>  13.13333333,  'longitude' =>  -61.216667], // Kingstown, Saint Vincent and the Grenadines
    'WS' => ['latitude' => -13.81666667,  'longitude' => -171.766667], // Apia, Samoa
    'SM' => ['latitude' =>  43.93333333,  'longitude' =>   12.416667], // San Marino, San Marino
    'ST' => ['latitude' =>   0.333333333, 'longitude' =>    6.733333], // Sao Tome, Sao Tome and Principe
    'SA' => ['latitude' =>  24.65,        'longitude' =>   46.7],      // Riyadh, Saudi Arabia
    'SN' => ['latitude' =>  14.73333333,  'longitude' =>  -17.633333], // Dakar, Senegal
    'RS' => ['latitude' =>  44.83333333,  'longitude' =>   20.5],      // Belgrade, Serbia
    'SC' => ['latitude' =>  -4.616666667, 'longitude' =>   55.45],     // Victoria, Seychelles
    'SL' => ['latitude' =>   8.483333333, 'longitude' =>  -13.233333], // Freetown, Sierra Leone
    'SG' => ['latitude' =>   1.283333333, 'longitude' =>  103.85],     // Singapore, Singapore
    'SX' => ['latitude' =>  18.01666667,  'longitude' =>  -63.033333], // Philipsburg, Sint Maarten
    'SK' => ['latitude' =>  48.15,        'longitude' =>   17.116667], // Bratislava, Slovakia
    'SI' => ['latitude' =>  46.05,        'longitude' =>   14.516667], // Ljubljana, Slovenia
    'SB' => ['latitude' =>  -9.433333333, 'longitude' =>  159.95],     // Honiara, Solomon Islands
    'SO' => ['latitude' =>   2.066666667, 'longitude' =>   45.333333], // Mogadishu, Somalia
    'ZA' => ['latitude' => -25.7,         'longitude' =>   28.216667], // Pretoria, South Africa
    'GS' => ['latitude' => -54.283333,    'longitude' =>  -36.5],      // King Edward Point, South Georgia and South Sandwich Islands
    'KR' => ['latitude' =>  37.55,        'longitude' =>  126.983333], // Seoul, South Korea
    'SS' => ['latitude' =>   4.85,        'longitude' =>   31.616667], // Juba, South Sudan
    'ES' => ['latitude' =>  40.4,         'longitude' =>   -3.683333], // Madrid, Spain
    'LK' => ['latitude' =>   6.916666667, 'longitude' =>   79.833333], // Colombo, Sri Lanka
    'SD' => ['latitude' =>  15.6,         'longitude' =>   32.533333], // Khartoum, Sudan
    'SR' => ['latitude' =>   5.833333333, 'longitude' =>  -55.166667], // Paramaribo, Suriname
    'SJ' => ['latitude' =>  78.21666667,  'longitude' =>   15.633333], // Longyearbyen, Svalbard
    'SZ' => ['latitude' => -26.31666667,  'longitude' =>   31.133333], // Mbabane, Swaziland
    'SE' => ['latitude' =>  59.33333333,  'longitude' =>   18.05],     // Stockholm, Sweden
    'CH' => ['latitude' =>  46.91666667,  'longitude' =>    7.466667], // Bern, Switzerland
    'SY' => ['latitude' =>  33.5,         'longitude' =>   36.3],      // Damascus, Syria
    'TW' => ['latitude' =>  25.03333333,  'longitude' =>  121.516667], // Taipei, Taiwan
    'TJ' => ['latitude' =>  38.55,        'longitude' =>   68.766667], // Dushanbe, Tajikistan
    'TZ' => ['latitude' =>  -6.8,         'longitude' =>   39.283333], // Dar es Salaam, Tanzania
    'TH' => ['latitude' =>  13.75,        'longitude' =>  100.516667], // Bangkok, Thailand
    'GM' => ['latitude' =>  13.45,        'longitude' =>  -16.566667], // Banjul, The Gambia
    'TL' => ['latitude' =>  -8.583333333, 'longitude' =>  125.6],      // Dili, Timor-Leste
    'TG' => ['latitude' =>   6.116666667, 'longitude' =>    1.216667], // Lome, Togo
    'TK' => ['latitude' =>  -9.166667,    'longitude' => -171.833333], // Atafu, Tokelau
    'TO' => ['latitude' => -21.13333333,  'longitude' => -175.2],      // Nuku’alofa, Tonga
    'TT' => ['latitude' =>  10.65,        'longitude' =>  -61.516667], // Port of Spain, Trinidad and Tobago
    'TN' => ['latitude' =>  36.8,         'longitude' =>   10.183333], // Tunis, Tunisia
    'TR' => ['latitude' =>  39.93333333,  'longitude' =>   32.866667], // Ankara, Turkey
    'TM' => ['latitude' =>  37.95,        'longitude' =>   58.383333], // Ashgabat, Turkmenistan
    'TC' => ['latitude' =>  21.46666667,  'longitude' =>  -71.133333], // Grand Turk, Turks and Caicos Islands
    'TV' => ['latitude' =>  -8.516666667, 'longitude' =>  179.216667], // Funafuti, Tuvalu
    'UG' => ['latitude' =>   0.316666667, 'longitude' =>   32.55],     // Kampala, Uganda
    'UA' => ['latitude' =>  50.43333333,  'longitude' =>   30.516667], // Kyiv, Ukraine
    'AE' => ['latitude' =>  24.46666667,  'longitude' =>   54.366667], // Abu Dhabi, United Arab Emirates
    'GB' => ['latitude' =>  51.5,         'longitude' =>   -0.083333], // London, United Kingdom
    'US' => ['latitude' =>  38.883333,    'longitude' =>  -77.0],      // Washington, D.C., United States
    'UY' => ['latitude' => -34.85,        'longitude' =>  -56.166667], // Montevideo, Uruguay
    'UM' => ['latitude' =>  38.883333,    'longitude' =>  -77],        // Washington, D.C., US Minor Outlying Islands
    'VI' => ['latitude' =>  18.35,        'longitude' =>  -64.933333], // Charlotte Amalie, US Virgin Islands
    'UZ' => ['latitude' =>  41.31666667,  'longitude' =>   69.25],     // Tashkent, Uzbekistan
    'VU' => ['latitude' => -17.73333333,  'longitude' =>  168.316667], // Port-Vila, Vanuatu
    'VA' => ['latitude' =>  41.9,         'longitude' =>   12.45],     // Vatican City, Vatican City
    'VE' => ['latitude' =>  10.48333333,  'longitude' =>  -66.866667], // Caracas, Venezuela
    'VN' => ['latitude' =>  21.03333333,  'longitude' =>  105.85],     // Hanoi, Vietnam
    'WF' => ['latitude' => -13.95,        'longitude' => -171.933333], // Mata-Utu, Wallis and Futuna
    'EH' => ['latitude' =>  27.153611,    'longitude' =>  -13.203333], // El-AaiÃºn, Western Sahara
    'YE' => ['latitude' =>  15.35,        'longitude' =>   44.2],      // Sanaa, Yemen
    'ZM' => ['latitude' => -15.41666667,  'longitude' =>   28.283333], // Lusaka, Zambia
    'ZW' => ['latitude' => -17.81666667,  'longitude' =>   31.033333], // Harare, Zimbabwe
  ];


  /**
   * @param ElementInterface|null $element
   * @return array
   */
  static public function get(ElementInterface $element = null): array {
    $language = null;

    try {
      $language = is_null($element) || !($element instanceof Element)
        ? Craft::$app->sites->currentSite->language
        : $element->getSite()->language;
    } catch (Throwable $error) {
      // Ignore errors right here
    }

    if (is_string($language)) {
      $language = strtoupper(
        substr($language, strlen($language) - 2, 2)
      );
    }

    return array_key_exists($language, self::$LOCATIONS)
      ? self::$LOCATIONS[$language]
      : self::$DEFAULT_LOCATION;
  }
}
