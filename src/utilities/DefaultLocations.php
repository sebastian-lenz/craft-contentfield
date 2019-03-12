<?php

namespace sebastianlenz\contentfield\utilities;

use craft\base\ElementInterface;

/**
 * Class DefaultLocations
 *
 * see http://techslides.com/list-of-countries-and-capitals
 */
class DefaultLocations {
  /**
   * @param ElementInterface|null $element
   * @return array
   */
  static public function get(ElementInterface $element = null) {
    $language = null;

    try {
      $language = is_null($element)
        ? \Craft::$app->sites->currentSite->language
        : $element->getSite()->language;
    } catch (\Throwable $error) { }

    if (is_string($language)) {
      $language = strtoupper(
        substr($language, strlen($language) - 2, 2)
      );
    }

    switch ($language) {
      case 'AF': return ['latitude' => 34.51666667, 'longitude' => 69.183333]; // Kabul, Afghanistan
      case 'AX': return ['latitude' => 60.116667, 'longitude' => 19.9]; // Mariehamn, Aland Islands
      case 'AL': return ['latitude' => 41.31666667, 'longitude' => 19.816667]; // Tirana, Albania
      case 'DZ': return ['latitude' => 36.75, 'longitude' => 3.05]; // Algiers, Algeria
      case 'AS': return ['latitude' => -14.26666667, 'longitude' => -170.7]; // Pago Pago, American Samoa
      case 'AD': return ['latitude' => 42.5, 'longitude' => 1.516667]; // Andorra la Vella, Andorra
      case 'AO': return ['latitude' => -8.833333333, 'longitude' => 13.216667]; // Luanda, Angola
      case 'AI': return ['latitude' => 18.21666667, 'longitude' => -63.05]; // The Valley, Anguilla
      case 'AQ': return ['latitude' => 0, 'longitude' => 0]; // N/A, Antarctica
      case 'AG': return ['latitude' => 17.11666667, 'longitude' => -61.85]; // Saint John’s, Antigua and Barbuda
      case 'AR': return ['latitude' => -34.58333333, 'longitude' => -58.666667]; // Buenos Aires, Argentina
      case 'AM': return ['latitude' => 40.16666667, 'longitude' => 44.5]; // Yerevan, Armenia
      case 'AW': return ['latitude' => 12.51666667, 'longitude' => -70.033333]; // Oranjestad, Aruba
      case 'AU': return ['latitude' => -35.26666667, 'longitude' => 149.133333]; // Canberra, Australia
      case 'AT': return ['latitude' => 48.2, 'longitude' => 16.366667]; // Vienna, Austria
      case 'AZ': return ['latitude' => 40.38333333, 'longitude' => 49.866667]; // Baku, Azerbaijan
      case 'BS': return ['latitude' => 25.08333333, 'longitude' => -77.35]; // Nassau, Bahamas
      case 'BH': return ['latitude' => 26.23333333, 'longitude' => 50.566667]; // Manama, Bahrain
      case 'BD': return ['latitude' => 23.71666667, 'longitude' => 90.4]; // Dhaka, Bangladesh
      case 'BB': return ['latitude' => 13.1, 'longitude' => -59.616667]; // Bridgetown, Barbados
      case 'BY': return ['latitude' => 53.9, 'longitude' => 27.566667]; // Minsk, Belarus
      case 'BE': return ['latitude' => 50.83333333, 'longitude' => 4.333333]; // Brussels, Belgium
      case 'BZ': return ['latitude' => 17.25, 'longitude' => -88.766667]; // Belmopan, Belize
      case 'BJ': return ['latitude' => 6.483333333, 'longitude' => 2.616667]; // Porto-Novo, Benin
      case 'BM': return ['latitude' => 32.28333333, 'longitude' => -64.783333]; // Hamilton, Bermuda
      case 'BT': return ['latitude' => 27.46666667, 'longitude' => 89.633333]; // Thimphu, Bhutan
      case 'BO': return ['latitude' => -16.5, 'longitude' => -68.15]; // La Paz, Bolivia
      case 'BA': return ['latitude' => 43.86666667, 'longitude' => 18.416667]; // Sarajevo, Bosnia and Herzegovina
      case 'BW': return ['latitude' => -24.63333333, 'longitude' => 25.9]; // Gaborone, Botswana
      case 'BR': return ['latitude' => -15.78333333, 'longitude' => -47.916667]; // Brasilia, Brazil
      case 'IO': return ['latitude' => -7.3, 'longitude' => 72.4]; // Diego Garcia, British Indian Ocean Territory
      case 'VG': return ['latitude' => 18.41666667, 'longitude' => -64.616667]; // Road Town, British Virgin Islands
      case 'BN': return ['latitude' => 4.883333333, 'longitude' => 114.933333]; // Bandar Seri Begawan, Brunei Darussalam
      case 'BG': return ['latitude' => 42.68333333, 'longitude' => 23.316667]; // Sofia, Bulgaria
      case 'BF': return ['latitude' => 12.36666667, 'longitude' => -1.516667]; // Ouagadougou, Burkina Faso
      case 'BI': return ['latitude' => -3.366666667, 'longitude' => 29.35]; // Bujumbura, Burundi
      case 'KH': return ['latitude' => 11.55, 'longitude' => 104.916667]; // Phnom Penh, Cambodia
      case 'CM': return ['latitude' => 3.866666667, 'longitude' => 11.516667]; // Yaounde, Cameroon
      case 'CA': return ['latitude' => 45.41666667, 'longitude' => -75.7]; // Ottawa, Canada
      case 'CV': return ['latitude' => 14.91666667, 'longitude' => -23.516667]; // Praia, Cape Verde
      case 'KY': return ['latitude' => 19.3, 'longitude' => -81.383333]; // George Town, Cayman Islands
      case 'CF': return ['latitude' => 4.366666667, 'longitude' => 18.583333]; // Bangui, Central African Republic
      case 'TD': return ['latitude' => 12.1, 'longitude' => 15.033333]; // N’Djamena, Chad
      case 'CL': return ['latitude' => -33.45, 'longitude' => -70.666667]; // Santiago, Chile
      case 'CN': return ['latitude' => 39.91666667, 'longitude' => 116.383333]; // Beijing, China
      case 'CX': return ['latitude' => -10.41666667, 'longitude' => 105.716667]; // The Settlement, Christmas Island
      case 'CC': return ['latitude' => -12.16666667, 'longitude' => 96.833333]; // West Island, Cocos Islands
      case 'CO': return ['latitude' => 4.6, 'longitude' => -74.083333]; // Bogota, Colombia
      case 'KM': return ['latitude' => -11.7, 'longitude' => 43.233333]; // Moroni, Comoros
      case 'CK': return ['latitude' => -21.2, 'longitude' => -159.766667]; // Avarua, Cook Islands
      case 'CR': return ['latitude' => 9.933333333, 'longitude' => -84.083333]; // San Jose, Costa Rica
      case 'CI': return ['latitude' => 6.816666667, 'longitude' => -5.266667]; // Yamoussoukro, Cote d’Ivoire
      case 'HR': return ['latitude' => 45.8, 'longitude' => 16]; // Zagreb, Croatia
      case 'CU': return ['latitude' => 23.11666667, 'longitude' => -82.35]; // Havana, Cuba
      case 'CW': return ['latitude' => 12.1, 'longitude' => -68.916667]; // Willemstad, CuraÃ§ao
      case 'CY': return ['latitude' => 35.16666667, 'longitude' => 33.366667]; // Nicosia, Cyprus
      case 'CZ': return ['latitude' => 50.08333333, 'longitude' => 14.466667]; // Prague, Czech Republic
      case 'CD': return ['latitude' => -4.316666667, 'longitude' => 15.3]; // Kinshasa, Democratic Republic of the Congo
      case 'DK': return ['latitude' => 55.66666667, 'longitude' => 12.583333]; // Copenhagen, Denmark
      case 'DJ': return ['latitude' => 11.58333333, 'longitude' => 43.15]; // Djibouti, Djibouti
      case 'DM': return ['latitude' => 15.3, 'longitude' => -61.4]; // Roseau, Dominica
      case 'DO': return ['latitude' => 18.46666667, 'longitude' => -69.9]; // Santo Domingo, Dominican Republic
      case 'EC': return ['latitude' => -0.216666667, 'longitude' => -78.5]; // Quito, Ecuador
      case 'EG': return ['latitude' => 30.05, 'longitude' => 31.25]; // Cairo, Egypt
      case 'SV': return ['latitude' => 13.7, 'longitude' => -89.2]; // San Salvador, El Salvador
      case 'GQ': return ['latitude' => 3.75, 'longitude' => 8.783333]; // Malabo, Equatorial Guinea
      case 'ER': return ['latitude' => 15.33333333, 'longitude' => 38.933333]; // Asmara, Eritrea
      case 'EE': return ['latitude' => 59.43333333, 'longitude' => 24.716667]; // Tallinn, Estonia
      case 'ET': return ['latitude' => 9.033333333, 'longitude' => 38.7]; // Addis Ababa, Ethiopia
      case 'FK': return ['latitude' => -51.7, 'longitude' => -57.85]; // Stanley, Falkland Islands
      case 'FO': return ['latitude' => 62, 'longitude' => -6.766667]; // Torshavn, Faroe Islands
      case 'FM': return ['latitude' => 6.916666667, 'longitude' => 158.15]; // Palikir, Federated States of Micronesia
      case 'FJ': return ['latitude' => -18.13333333, 'longitude' => 178.416667]; // Suva, Fiji
      case 'FI': return ['latitude' => 60.16666667, 'longitude' => 24.933333]; // Helsinki, Finland
      case 'FR': return ['latitude' => 48.86666667, 'longitude' => 2.333333]; // Paris, France
      case 'PF': return ['latitude' => -17.53333333, 'longitude' => -149.566667]; // Papeete, French Polynesia
      case 'TF': return ['latitude' => -49.35, 'longitude' => 70.216667]; // Port-aux-FranÃ§ais, French Southern and Antarctic Lands
      case 'GA': return ['latitude' => 0.383333333, 'longitude' => 9.45]; // Libreville, Gabon
      case 'GE': return ['latitude' => 41.68333333, 'longitude' => 44.833333]; // Tbilisi, Georgia
      case 'DE': return ['latitude' => 52.51666667, 'longitude' => 13.4]; // Berlin, Germany
      case 'GH': return ['latitude' => 5.55, 'longitude' => -0.216667]; // Accra, Ghana
      case 'GI': return ['latitude' => 36.13333333, 'longitude' => -5.35]; // Gibraltar, Gibraltar
      case 'GR': return ['latitude' => 37.98333333, 'longitude' => 23.733333]; // Athens, Greece
      case 'GL': return ['latitude' => 64.18333333, 'longitude' => -51.75]; // Nuuk, Greenland
      case 'GD': return ['latitude' => 12.05, 'longitude' => -61.75]; // Saint George’s, Grenada
      case 'GU': return ['latitude' => 13.46666667, 'longitude' => 144.733333]; // Hagatna, Guam
      case 'GT': return ['latitude' => 14.61666667, 'longitude' => -90.516667]; // Guatemala City, Guatemala
      case 'GG': return ['latitude' => 49.45, 'longitude' => -2.533333]; // Saint Peter Port, Guernsey
      case 'GN': return ['latitude' => 9.5, 'longitude' => -13.7]; // Conakry, Guinea
      case 'GW': return ['latitude' => 11.85, 'longitude' => -15.583333]; // Bissau, Guinea-Bissau
      case 'GY': return ['latitude' => 6.8, 'longitude' => -58.15]; // Georgetown, Guyana
      case 'HT': return ['latitude' => 18.53333333, 'longitude' => -72.333333]; // Port-au-Prince, Haiti
      case 'HM': return ['latitude' => 0, 'longitude' => 0]; // N/A, Heard Island and McDonald Islands
      case 'HN': return ['latitude' => 14.1, 'longitude' => -87.216667]; // Tegucigalpa, Honduras
      case 'HK': return ['latitude' => 0, 'longitude' => 0]; // N/A, Hong Kong
      case 'HU': return ['latitude' => 47.5, 'longitude' => 19.083333]; // Budapest, Hungary
      case 'IS': return ['latitude' => 64.15, 'longitude' => -21.95]; // Reykjavik, Iceland
      case 'IN': return ['latitude' => 28.6, 'longitude' => 77.2]; // New Delhi, India
      case 'ID': return ['latitude' => -6.166666667, 'longitude' => 106.816667]; // Jakarta, Indonesia
      case 'IR': return ['latitude' => 35.7, 'longitude' => 51.416667]; // Tehran, Iran
      case 'IQ': return ['latitude' => 33.33333333, 'longitude' => 44.4]; // Baghdad, Iraq
      case 'IE': return ['latitude' => 53.31666667, 'longitude' => -6.233333]; // Dublin, Ireland
      case 'IM': return ['latitude' => 54.15, 'longitude' => -4.483333]; // Douglas, Isle of Man
      case 'IL': return ['latitude' => 31.76666667, 'longitude' => 35.233333]; // Jerusalem, Israel
      case 'IT': return ['latitude' => 41.9, 'longitude' => 12.483333]; // Rome, Italy
      case 'JM': return ['latitude' => 18, 'longitude' => -76.8]; // Kingston, Jamaica
      case 'JP': return ['latitude' => 35.68333333, 'longitude' => 139.75]; // Tokyo, Japan
      case 'JE': return ['latitude' => 49.18333333, 'longitude' => -2.1]; // Saint Helier, Jersey
      case 'JO': return ['latitude' => 31.95, 'longitude' => 35.933333]; // Amman, Jordan
      case 'KZ': return ['latitude' => 51.16666667, 'longitude' => 71.416667]; // Astana, Kazakhstan
      case 'KE': return ['latitude' => -1.283333333, 'longitude' => 36.816667]; // Nairobi, Kenya
      case 'KI': return ['latitude' => -0.883333333, 'longitude' => 169.533333]; // Tarawa, Kiribati
      case 'KO': return ['latitude' => 42.66666667, 'longitude' => 21.166667]; // Pristina, Kosovo
      case 'KW': return ['latitude' => 29.36666667, 'longitude' => 47.966667]; // Kuwait City, Kuwait
      case 'KG': return ['latitude' => 42.86666667, 'longitude' => 74.6]; // Bishkek, Kyrgyzstan
      case 'LA': return ['latitude' => 17.96666667, 'longitude' => 102.6]; // Vientiane, Laos
      case 'LV': return ['latitude' => 56.95, 'longitude' => 24.1]; // Riga, Latvia
      case 'LB': return ['latitude' => 33.86666667, 'longitude' => 35.5]; // Beirut, Lebanon
      case 'LS': return ['latitude' => -29.31666667, 'longitude' => 27.483333]; // Maseru, Lesotho
      case 'LR': return ['latitude' => 6.3, 'longitude' => -10.8]; // Monrovia, Liberia
      case 'LY': return ['latitude' => 32.88333333, 'longitude' => 13.166667]; // Tripoli, Libya
      case 'LI': return ['latitude' => 47.13333333, 'longitude' => 9.516667]; // Vaduz, Liechtenstein
      case 'LT': return ['latitude' => 54.68333333, 'longitude' => 25.316667]; // Vilnius, Lithuania
      case 'LU': return ['latitude' => 49.6, 'longitude' => 6.116667]; // Luxembourg, Luxembourg
      case 'MO': return ['latitude' => 0, 'longitude' => 0]; // N/A, Macau
      case 'MK': return ['latitude' => 42, 'longitude' => 21.433333]; // Skopje, Macedonia
      case 'MG': return ['latitude' => -18.91666667, 'longitude' => 47.516667]; // Antananarivo, Madagascar
      case 'MW': return ['latitude' => -13.96666667, 'longitude' => 33.783333]; // Lilongwe, Malawi
      case 'MY': return ['latitude' => 3.166666667, 'longitude' => 101.7]; // Kuala Lumpur, Malaysia
      case 'MV': return ['latitude' => 4.166666667, 'longitude' => 73.5]; // Male, Maldives
      case 'ML': return ['latitude' => 12.65, 'longitude' => -8]; // Bamako, Mali
      case 'MT': return ['latitude' => 35.88333333, 'longitude' => 14.5]; // Valletta, Malta
      case 'MH': return ['latitude' => 7.1, 'longitude' => 171.383333]; // Majuro, Marshall Islands
      case 'MR': return ['latitude' => 18.06666667, 'longitude' => -15.966667]; // Nouakchott, Mauritania
      case 'MU': return ['latitude' => -20.15, 'longitude' => 57.483333]; // Port Louis, Mauritius
      case 'MX': return ['latitude' => 19.43333333, 'longitude' => -99.133333]; // Mexico City, Mexico
      case 'MD': return ['latitude' => 47, 'longitude' => 28.85]; // Chisinau, Moldova
      case 'MC': return ['latitude' => 43.73333333, 'longitude' => 7.416667]; // Monaco, Monaco
      case 'MN': return ['latitude' => 47.91666667, 'longitude' => 106.916667]; // Ulaanbaatar, Mongolia
      case 'ME': return ['latitude' => 42.43333333, 'longitude' => 19.266667]; // Podgorica, Montenegro
      case 'MS': return ['latitude' => 16.7, 'longitude' => -62.216667]; // Plymouth, Montserrat
      case 'MA': return ['latitude' => 34.01666667, 'longitude' => -6.816667]; // Rabat, Morocco
      case 'MZ': return ['latitude' => -25.95, 'longitude' => 32.583333]; // Maputo, Mozambique
      case 'MM': return ['latitude' => 16.8, 'longitude' => 96.15]; // Rangoon, Myanmar
      case 'NA': return ['latitude' => -22.56666667, 'longitude' => 17.083333]; // Windhoek, Namibia
      case 'NR': return ['latitude' => -0.5477, 'longitude' => 166.920867]; // Yaren, Nauru
      case 'NP': return ['latitude' => 27.71666667, 'longitude' => 85.316667]; // Kathmandu, Nepal
      case 'NL': return ['latitude' => 52.35, 'longitude' => 4.916667]; // Amsterdam, Netherlands
      case 'NC': return ['latitude' => -22.26666667, 'longitude' => 166.45]; // Noumea, New Caledonia
      case 'NZ': return ['latitude' => -41.3, 'longitude' => 174.783333]; // Wellington, New Zealand
      case 'NI': return ['latitude' => 12.13333333, 'longitude' => -86.25]; // Managua, Nicaragua
      case 'NE': return ['latitude' => 13.51666667, 'longitude' => 2.116667]; // Niamey, Niger
      case 'NG': return ['latitude' => 9.083333333, 'longitude' => 7.533333]; // Abuja, Nigeria
      case 'NU': return ['latitude' => -19.01666667, 'longitude' => -169.916667]; // Alofi, Niue
      case 'NF': return ['latitude' => -29.05, 'longitude' => 167.966667]; // Kingston, Norfolk Island
      case 'KP': return ['latitude' => 39.01666667, 'longitude' => 125.75]; // Pyongyang, North Korea
      case 'MP': return ['latitude' => 15.2, 'longitude' => 145.75]; // Saipan, Northern Mariana Islands
      case 'NO': return ['latitude' => 59.91666667, 'longitude' => 10.75]; // Oslo, Norway
      case 'OM': return ['latitude' => 23.61666667, 'longitude' => 58.583333]; // Muscat, Oman
      case 'PK': return ['latitude' => 33.68333333, 'longitude' => 73.05]; // Islamabad, Pakistan
      case 'PW': return ['latitude' => 7.483333333, 'longitude' => 134.633333]; // Melekeok, Palau
      case 'PS': return ['latitude' => 31.76666667, 'longitude' => 35.233333]; // Jerusalem, Palestine
      case 'PA': return ['latitude' => 8.966666667, 'longitude' => -79.533333]; // Panama City, Panama
      case 'PG': return ['latitude' => -9.45, 'longitude' => 147.183333]; // Port Moresby, Papua New Guinea
      case 'PY': return ['latitude' => -25.26666667, 'longitude' => -57.666667]; // Asuncion, Paraguay
      case 'PE': return ['latitude' => -12.05, 'longitude' => -77.05]; // Lima, Peru
      case 'PH': return ['latitude' => 14.6, 'longitude' => 120.966667]; // Manila, Philippines
      case 'PN': return ['latitude' => -25.06666667, 'longitude' => -130.083333]; // Adamstown, Pitcairn Islands
      case 'PL': return ['latitude' => 52.25, 'longitude' => 21]; // Warsaw, Poland
      case 'PT': return ['latitude' => 38.71666667, 'longitude' => -9.133333]; // Lisbon, Portugal
      case 'PR': return ['latitude' => 18.46666667, 'longitude' => -66.116667]; // San Juan, Puerto Rico
      case 'QA': return ['latitude' => 25.28333333, 'longitude' => 51.533333]; // Doha, Qatar
      case 'CG': return ['latitude' => -4.25, 'longitude' => 15.283333]; // Brazzaville, Republic of Congo
      case 'RO': return ['latitude' => 44.43333333, 'longitude' => 26.1]; // Bucharest, Romania
      case 'RU': return ['latitude' => 55.75, 'longitude' => 37.6]; // Moscow, Russia
      case 'RW': return ['latitude' => -1.95, 'longitude' => 30.05]; // Kigali, Rwanda
      case 'BL': return ['latitude' => 17.88333333, 'longitude' => -62.85]; // Gustavia, Saint Barthelemy
      case 'SH': return ['latitude' => -15.93333333, 'longitude' => -5.716667]; // Jamestown, Saint Helena
      case 'KN': return ['latitude' => 17.3, 'longitude' => -62.716667]; // Basseterre, Saint Kitts and Nevis
      case 'LC': return ['latitude' => 14, 'longitude' => -61]; // Castries, Saint Lucia
      case 'MF': return ['latitude' => 18.0731, 'longitude' => -63.0822]; // Marigot, Saint Martin
      case 'PM': return ['latitude' => 46.76666667, 'longitude' => -56.183333]; // Saint-Pierre, Saint Pierre and Miquelon
      case 'VC': return ['latitude' => 13.13333333, 'longitude' => -61.216667]; // Kingstown, Saint Vincent and the Grenadines
      case 'WS': return ['latitude' => -13.81666667, 'longitude' => -171.766667]; // Apia, Samoa
      case 'SM': return ['latitude' => 43.93333333, 'longitude' => 12.416667]; // San Marino, San Marino
      case 'ST': return ['latitude' => 0.333333333, 'longitude' => 6.733333]; // Sao Tome, Sao Tome and Principe
      case 'SA': return ['latitude' => 24.65, 'longitude' => 46.7]; // Riyadh, Saudi Arabia
      case 'SN': return ['latitude' => 14.73333333, 'longitude' => -17.633333]; // Dakar, Senegal
      case 'RS': return ['latitude' => 44.83333333, 'longitude' => 20.5]; // Belgrade, Serbia
      case 'SC': return ['latitude' => -4.616666667, 'longitude' => 55.45]; // Victoria, Seychelles
      case 'SL': return ['latitude' => 8.483333333, 'longitude' => -13.233333]; // Freetown, Sierra Leone
      case 'SG': return ['latitude' => 1.283333333, 'longitude' => 103.85]; // Singapore, Singapore
      case 'SX': return ['latitude' => 18.01666667, 'longitude' => -63.033333]; // Philipsburg, Sint Maarten
      case 'SK': return ['latitude' => 48.15, 'longitude' => 17.116667]; // Bratislava, Slovakia
      case 'SI': return ['latitude' => 46.05, 'longitude' => 14.516667]; // Ljubljana, Slovenia
      case 'SB': return ['latitude' => -9.433333333, 'longitude' => 159.95]; // Honiara, Solomon Islands
      case 'SO': return ['latitude' => 2.066666667, 'longitude' => 45.333333]; // Mogadishu, Somalia
      case 'ZA': return ['latitude' => -25.7, 'longitude' => 28.216667]; // Pretoria, South Africa
      case 'GS': return ['latitude' => -54.283333, 'longitude' => -36.5]; // King Edward Point, South Georgia and South Sandwich Islands
      case 'KR': return ['latitude' => 37.55, 'longitude' => 126.983333]; // Seoul, South Korea
      case 'SS': return ['latitude' => 4.85, 'longitude' => 31.616667]; // Juba, South Sudan
      case 'ES': return ['latitude' => 40.4, 'longitude' => -3.683333]; // Madrid, Spain
      case 'LK': return ['latitude' => 6.916666667, 'longitude' => 79.833333]; // Colombo, Sri Lanka
      case 'SD': return ['latitude' => 15.6, 'longitude' => 32.533333]; // Khartoum, Sudan
      case 'SR': return ['latitude' => 5.833333333, 'longitude' => -55.166667]; // Paramaribo, Suriname
      case 'SJ': return ['latitude' => 78.21666667, 'longitude' => 15.633333]; // Longyearbyen, Svalbard
      case 'SZ': return ['latitude' => -26.31666667, 'longitude' => 31.133333]; // Mbabane, Swaziland
      case 'SE': return ['latitude' => 59.33333333, 'longitude' => 18.05]; // Stockholm, Sweden
      case 'CH': return ['latitude' => 46.91666667, 'longitude' => 7.466667]; // Bern, Switzerland
      case 'SY': return ['latitude' => 33.5, 'longitude' => 36.3]; // Damascus, Syria
      case 'TW': return ['latitude' => 25.03333333, 'longitude' => 121.516667]; // Taipei, Taiwan
      case 'TJ': return ['latitude' => 38.55, 'longitude' => 68.766667]; // Dushanbe, Tajikistan
      case 'TZ': return ['latitude' => -6.8, 'longitude' => 39.283333]; // Dar es Salaam, Tanzania
      case 'TH': return ['latitude' => 13.75, 'longitude' => 100.516667]; // Bangkok, Thailand
      case 'GM': return ['latitude' => 13.45, 'longitude' => -16.566667]; // Banjul, The Gambia
      case 'TL': return ['latitude' => -8.583333333, 'longitude' => 125.6]; // Dili, Timor-Leste
      case 'TG': return ['latitude' => 6.116666667, 'longitude' => 1.216667]; // Lome, Togo
      case 'TK': return ['latitude' => -9.166667, 'longitude' => -171.833333]; // Atafu, Tokelau
      case 'TO': return ['latitude' => -21.13333333, 'longitude' => -175.2]; // Nuku’alofa, Tonga
      case 'TT': return ['latitude' => 10.65, 'longitude' => -61.516667]; // Port of Spain, Trinidad and Tobago
      case 'TN': return ['latitude' => 36.8, 'longitude' => 10.183333]; // Tunis, Tunisia
      case 'TR': return ['latitude' => 39.93333333, 'longitude' => 32.866667]; // Ankara, Turkey
      case 'TM': return ['latitude' => 37.95, 'longitude' => 58.383333]; // Ashgabat, Turkmenistan
      case 'TC': return ['latitude' => 21.46666667, 'longitude' => -71.133333]; // Grand Turk, Turks and Caicos Islands
      case 'TV': return ['latitude' => -8.516666667, 'longitude' => 179.216667]; // Funafuti, Tuvalu
      case 'UG': return ['latitude' => 0.316666667, 'longitude' => 32.55]; // Kampala, Uganda
      case 'UA': return ['latitude' => 50.43333333, 'longitude' => 30.516667]; // Kyiv, Ukraine
      case 'AE': return ['latitude' => 24.46666667, 'longitude' => 54.366667]; // Abu Dhabi, United Arab Emirates
      case 'GB': return ['latitude' => 51.5, 'longitude' => -0.083333]; // London, United Kingdom
      case 'US': return ['latitude' => 38.883333, 'longitude' => -77]; // Washington, D.C., United States
      case 'UY': return ['latitude' => -34.85, 'longitude' => -56.166667]; // Montevideo, Uruguay
      case 'UM': return ['latitude' => 38.883333, 'longitude' => -77]; // Washington, D.C., US Minor Outlying Islands
      case 'VI': return ['latitude' => 18.35, 'longitude' => -64.933333]; // Charlotte Amalie, US Virgin Islands
      case 'UZ': return ['latitude' => 41.31666667, 'longitude' => 69.25]; // Tashkent, Uzbekistan
      case 'VU': return ['latitude' => -17.73333333, 'longitude' => 168.316667]; // Port-Vila, Vanuatu
      case 'VA': return ['latitude' => 41.9, 'longitude' => 12.45]; // Vatican City, Vatican City
      case 'VE': return ['latitude' => 10.48333333, 'longitude' => -66.866667]; // Caracas, Venezuela
      case 'VN': return ['latitude' => 21.03333333, 'longitude' => 105.85]; // Hanoi, Vietnam
      case 'WF': return ['latitude' => -13.95, 'longitude' => -171.933333]; // Mata-Utu, Wallis and Futuna
      case 'EH': return ['latitude' => 27.153611, 'longitude' => -13.203333]; // El-AaiÃºn, Western Sahara
      case 'YE': return ['latitude' => 15.35, 'longitude' => 44.2]; // Sanaa, Yemen
      case 'ZM': return ['latitude' => -15.41666667, 'longitude' => 28.283333]; // Lusaka, Zambia
      case 'ZW': return ['latitude' => -17.81666667, 'longitude' => 31.033333]; // Harare, Zimbabwe
    }

    return ['latitude' => 0, 'longitude' => 0];
  }
}
