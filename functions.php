<?php
/**
 * Part of the theme update from InteractiveMechanics
 * @return string
 */
function public_nav_main_bootstrap() {
    $partial = array('common/menu-partial.phtml', 'default');
    $nav = public_nav_main();  // this looks like $this->navigation()->menu() from Zend
    $nav->setPartial($partial);
    return $nav->render();
}

class NewRootsBilingual {
    /**
     * Are we viewing the page in English or Spanish? Get cookie to find out.
     * @return mixed
     */
    public function cookieData() {
        $request = new Zend_Controller_Request_Http();

        return $request->getCookie('multi-loc');
    }

    /**
     * Get details about the item type metadata fields - order and description.
     * Description contains Spanish label for fields with same value in both languages
     * (no translation). Order ensures we display English and Spanish fields in same order.
     * @return mixed
     */
    protected function getAllElements() {
        // Get the metadata values for this item for "SOHP Interview - Bilingual" content type fields
        $data_elements = item_type_elements();

        $db = get_db();
        $sql = 'select omeka_elements.id, omeka_item_types_elements.order as item_type_order,
    omeka_elements.name, omeka_elements.description
    from omeka_elements, omeka_item_types_elements, omeka_item_types
    where
    omeka_elements.id = omeka_item_types_elements.element_id
    and omeka_item_types_elements.item_type_id = omeka_item_types.id
    and omeka_item_types.name = "SOHP Interview - Bilingual"';

        $statement = $db->query($sql);
        $sohp_elements = $statement->fetchAll();

        // Combine the metadata values with order and description into one array
        foreach($sohp_elements as $key => &$element) {
            foreach($data_elements as $name => $value) {
                if ($element["name"] == $name) {
                    $element["value"] = $value;
                }
            }
        }
        unset($element);

        return $sohp_elements;
    }

    /**
     * Sort fields into English & Spanish fields
     * @param $cookieData
     * @return array
     */
    public function displayElements($cookieData) {
        $es_elements = array(); // Espanol elements
        $en_elements = array(); // English elements
        $display_elements = array();
        $sohp_elements = $this->getAllElements();
        $nodata = array(
            'en' => 'Data not provided.',
            'es' => 'Los datos no provistos.'
        );

        foreach($sohp_elements as $key => $element) {
            $en_value = $element['value'];
            $es_value = $element['value'];
            if (strlen($element['value']) < 1 ) {
                $en_value = $nodata['en'];
                $es_value = $nodata['es'];
            }

            // If the field name starts with "En: ", put data in $en_elements
            if (strpos($element['name'], "En:") === 0)  {
                $en_name = substr($element['name'], 4);

                $en_elements[$en_name] = array(
                    "name" => $en_name,
                    "value" => $en_value,
                    "order" => $element["item_type_order"]
                );
                // If field name starts with "Es: ", put data in $es_elements
            } elseif (strpos($element['name'], "Es:") === 0)  {
                $es_name = substr($element['name'], 4);
                $es_elements[$es_name] = array(
                    "name" => $es_name,
                    "value" => $es_value,
                    "order" => $element["item_type_order"]
                );
                // If field name has no preface, this is a 'bilingual' element.
                // (Instead of having a translation, this field has the same value in
                //  English or Spanish. It has different labels in the two languages.)
            }  else {
                // For most of these fields, the value in English or Spanish will be the same

                // Is this a date? If so we need to translate it.
                if (stripos(strtolower($element['description']), 'fecha') !== FALSE ) {
                    $isDate = $this->checkIsAValidDate($element['value']);

                    // Lots of interviewee birth dates are just the year which breaks the Zend Date class
                    if(preg_match('/^\d{4}$/', $element['value'])) {
                        $en_value = $element['value'];
                        $es_value = $element['value'];
                    } elseif($isDate) {
                        $zdate = new Zend_Date($element["value"], 'dd.MM.yyyy', 'en');
                        $en_value = $zdate->get(Zend_Date::DATE_LONG);
                        $esdate = new Zend_Date ($zdate, "es");
                        $es_value = $esdate->get(Zend_Date::DATE_LONG);
                    }
                }

                // The 'description' in omeka_elements table is the Spanish label
                $es_elements[$element['description']] = array(
                    "name" => $element['description'],
                    "value" => $es_value,
                    "order" => $element["item_type_order"]
                );

                // The 'name' in omeka_elements table is the English label
                $en_elements[$element["name"]] = array(
                    "name" => $element["name"],
                    "value" => $en_value,
                    "order" => $element["item_type_order"]
                );
            }

        }

        // Loop through Spanish elements and assign them the same order as their
        // English counterparts.
        foreach($es_elements as $es_element) {
            foreach($sohp_elements as $sohp_element) {
                if ($es_element['name'] == $sohp_element['description'] ||
                    'Es: ' . $es_element['name'] == $sohp_element['description']) {
                    $es_element['order'] = $sohp_element['item_type_order'];
                }
            }
        }

        if (strtolower($cookieData) == "es") {
            $display_elements = $es_elements;
        } else {
            $display_elements = $en_elements;
        }

        usort($display_elements, $this->sortByOrder('order'));

        return $display_elements;
    }

    /**
     * Sort the elements by the "order" field, as set on Item Type admin screen
     * Use closure to get this to work in OOP context
     * @param $a
     * @param $b
     * @return mixed
     */
    private function sortByOrder($key) {
        return function($a, $b) use ($key) {
            return $a[$key] - $b[$key];
        };
    }

    /**
     * @param $myDateString
     * @return bool
     */
    private function checkIsAValidDate($myDateString){
        return (bool)strtotime($myDateString);
    }

    /**
     * @param $fieldname
     * @return string
     */
    public function makeLabel($fieldname) {
        $fieldname = strtolower(str_replace(" ", "-", $fieldname));
        $fieldname = $this->stripAccents($fieldname);

        return $fieldname;
    }

    /**
     * @param $spanish
     * @return string
     */
    private function stripAccents($spanish){
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        $label = strtr( $spanish, $unwanted_array );

        return $label;
    }

    /**
     * Sometimes have leading whitespace & need to format for Omeka searching
     * @param $themes
     * @return array
     */
    public function displayThemes($themes) {
        $clean_themes = array();

        /* Replace any semi-colons not preceded by "&quot" or "&#039", e.g. double and single quotes
        *  Otherwise themes in quotes won't split correctly
        *  List comes in semi-colon delimited from ContentDM. */
        $theme_regx = preg_replace('/(?<!&quot|&#039);/', '-', $themes);
       // $theme_regx = preg_replace('/(?<!&#39);/', '-', $theme_regx);

        $theme_list = explode('-', $theme_regx);

        foreach($theme_list as $theme) {
            $theme_words = trim($theme);
            $theme_words_search = preg_replace('/\s+/', '+', strtolower($theme_words));
            $clean_themes[$theme_words_search] = $theme_words;
        }

        return $clean_themes;
    }

    /**
     * Get correct field to get metadata for where the same field can be in multiple languages
     * @param $cookieData
     * @param $spanish_value
     * @param $english_value
     * @return mixed
     */
    public function getField($cookieData, $spanish_value, $english_value) {
        return (strtolower($cookieData) == "es") ? $spanish_value : $english_value;
    }

    /**
     * Transpose interviewee name
     * @param $name
     * @return string
     */
    public function invertName($name) {
        $pieces = explode(',', $name); //print_r($pieces);

        $last_name = preg_split('/--/', trim($pieces[0]));
        $last_name = end($last_name);
        $regx = '/;/';

        if(preg_match('/(pseud|\d+)/', end($pieces))) { // Interviewees with pseudonyms
            $first_name = $this->cleanName($pieces[1]);
            $pseudo = end($pieces);

            $full_name = "$first_name $last_name, $pseudo";
        } else if(array_key_exists(1, $pieces) && preg_match($regx, $pieces[1])) { // Multiple Interviewees
            $names = preg_split($regx, $pieces[1]);

            $full_name = $this->cleanName($names[0]) . ' ' .$pieces[0] . ', ';
            $full_name .= $this->cleanName(end($pieces)) . ' ' . $names[1];
        } else {
            $first_name = $this->cleanName(trim(end($pieces)));
            $full_name = "$first_name $last_name";
        }

        return $full_name;
    }

    /**
     * @param $name
     * @return mixed
     */
    private function cleanName($name) {
        return preg_replace('/\.$/', '', trim($name));
    }

    /**
     * Get PDF or MP3 file link
     * @param $files
     * @return mixed
     */
    public function getDownloadFiles($files, $pdf = true) {
        $regx = ($pdf) ? '/pdf$/' : '/mp3$/';
        foreach($files as $file) {
            if(preg_match($regx, $file->original_filename)) {
                return $file->original_filename;
                break;
            }
        }
    }
}