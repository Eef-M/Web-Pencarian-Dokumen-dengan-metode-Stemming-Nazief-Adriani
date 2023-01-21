<?php

    $data = [
        [
            "id" => 1,
            "judul" => "penerapan dengan metode naive bayes",
        ],
        [
            "id" => 2,
            "judul" => "media ini dibuat dengan ilmiah dan penerapan media baku",
        ],
        [
            "id" => 3,
            "judul" => "desain ini adalah media rekayasa penerapan",
        ],
    ];
    
    $key = "penerapan media";
    $exp_key = explode(" ", $key);
    $newArray = array();
    
    function substr_count_array($haystack, $needle){
        $initial = 0;
        $bits_of_haystack = explode(' ', $haystack);
        foreach ($needle as $substring) {
            if(!in_array($substring, $bits_of_haystack))
                continue;
    
            $initial += substr_count($haystack, $substring);
        }
        return $initial;
    }
    
    foreach($data as $item) {
        $repArr = array(
            "id" => $item["id"],
            "judul" => $item["judul"],
            "count" => substr_count_array($item["judul"], $exp_key),
        );
        
        $newArray[] = $repArr;
    }
    
    // $myArr = array_column($newArray, 'judul', 'count');
    
    function array_column_multi ($array, $column) {
        $types = array_unique(array_column($array, $column));
    
        $return = [];
        foreach ($types as $type) {
            foreach ($array as $key => $value) {
                if ($type === $value[$column]) {
                    unset($value[$column]);
                    $return[$type] = $value;
                    unset($array[$key]);
                }
            }
        }
        return $return;
    }
    
    $forSort = array_column_multi($newArray, "count");
    
    ksort($forSort);
    
    $rev = $forSort;
    
    print_r(array_reverse($rev, TRUE));

?>