<?php

class Utils_Html
{

    public static function ul($data) ## code for new dropdown menu.##
    {  
      //  echo "<pre>";        var_dump($data); exit;
        $output = "<ul " . array_to_attr($data['attr']) . ">";
        foreach ($data['links'] as $link) {
            $output .= "<li " . array_to_attr($link['attr']) . ">";
            if (array_key_exists('href', $link)) {              
                
            $output .= Html::anchor($link['href'], $link['text']);
            } else {
                $output .= "<span>" . $link['text'] . "</span>";
            }
            if (array_key_exists('children', $link)) {
               // if ($link['attr']['class'] == 'leaf last') {
                    $output .= "<ul>";
                    foreach ($link['children'] as $ch => $child) {
                        if (array_key_exists('href', $child)) {
                            $output.="<li>";
                            $output .= Html::anchor($child['href'], $child['text']);
                            $output .= "</li>";
                        } else {
                            $output.="<li" . array_to_attr($link['attr']) . ">";
                            $output .= "<span>" . $child['text'] . "</span>";
                            $output .= "</li>";
                        }
                    }
                    $output .= "</ul>";
               // }
            }
            $output .= "</li>";
        }
        //$output .= "</ul>"; //closed in navigation.php

        return $output;
    }

    public static function columns($data)
    {
        $columns = array(
            1 => false,
            2 => false,
            3 => false,
        );

        $count = count((array) $data);
        if ($count <= 6) {
            $columns[1] = $data;
            return $columns;
        } elseif ($count <= 12) {
            $division = floor($count / 2);
            $loop_count = 1;
            foreach ($data as $key => $item) {
                if ($loop_count <= $division) {
                    $columns[1][$key] = $item;
                } else {
                    $columns[2][$key] = $item;
                }
                $loop_count++;
            }
            return $columns;
        } else {
            $division = floor($count / 3);
            $loop_count = 1;
            foreach ($data as $key => $item) {
                if ($loop_count <= $division) {
                    $columns[1][$key] = $item;
                } elseif ($loop_count <= 2 * $division) {
                    $columns[2][$key] = $item;
                } else {
                    $columns[3][$key] = $item;
                }
                $loop_count++;
            }
            return $columns;
        }
    }

    public static function addhttp($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }

}
