<?php

if (!defined('BASEPATH')) {
    exit('Direct script access not allowed');
}

function form_months_dropdown($data, $selected = NULL, $extra = NULL, $is_short = FALSE, $default = NULL) {
    $months = array(0 => $default, 1 => 'January', 'February', 'March', 'April',
        'May', 'June', 'July', 'August',
        'September', 'October', 'November',
        'December'
    );

    $short_months = array(0 => $default, 1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');

    if ($is_short == TRUE) {
        return form_dropdown($data, $short_months, $selected, $extra);
    } else {
        return form_dropdown($data, $months, $selected, $extra);
    }
}

function form_custom_date_dropdown($data, $rmin, $rmax, $selected = NULL, $extra = NULL, $default = NULL) {
    $numbers = range($rmin, $rmax);
    $options[0] = $default;
    foreach ($numbers as $index => $value) {
        $options[$value] = $value;
    }
    return form_dropdown($data, $options, $selected, $extra);
}

function form_custom_range_dropdown($data, $rmin, $rmax, $step = 1, $selected = NULL, $extra = NULL, $default = NULL) {
    $numbers = range($rmin, $rmax, $step);
    $options[0] = $default;
    foreach ($numbers as $index => $value) {
        $options[$value] = $value;
    }
    return form_dropdown($data, $options, $selected, $extra);
}

function form_custom_gender_dropdown($data, $selected = NULL, $extra = NULL) {
    $options = ['' => 'Select Gender', 'Male' => 'Male', 'Female' => 'Female'];
    return form_dropdown($data, $options, $selected, $extra);
}

function format_days($days, $shorten = false, $future = false) {

    if ($days == 0) {
        $when = $future == true ? 'today' : 'less than a day';
        return $when;
    } else if ($days >= 7 && $days < 31) {
        $newDay = floor($days / 7);
        $rem = $days % 7;
        if ($shorten == true):
            return $newDay . ' ' . ($newDay > 1 ? 'weeks' : 'week');
        else:
            return $newDay . ' ' . ($newDay > 1 ? 'weeks' : 'week') . ( $rem > 1 ? ' and ' . $rem . ' days' : (($rem == 0) ? '' : ' and ' . $rem . ' day'));
        endif;
    } else if ($days >= 31) {
        $newMonth = floor($days / 31);
        $remDays = floor(( $days % 31 ) / 7);
        $rem = floor($days % 31) % 7;
        if ($shorten == true):
            return $newMonth . ' ' . ($newMonth > 1 ? 'Months' : 'Month');
        else:
            return $newMonth . ' ' . ($newMonth > 1 ? 'Months' : 'Month')
                    . ( $remDays > 1 ? ' and ' . $remDays . ' Weeks' : (($remDays == 0) ? '' : ' and ' . $remDays . ' Week'))
                    . ( $rem > 1 ? ' and ' . $rem . ' days' : (($rem == 0) ? '' : ' and ' . $rem . ' day'));
        endif;
    } else {
        return ( $days > 1 ? $days . ' days' : (($days == 0) ? '' : $days . ' day'));
    }
}

function get_rating_stars($num_of_stars) {
    $stars = '';
    if (is_numeric($num_of_stars) && $num_of_stars > 0) {
        for ($i = 0; $i < 5; $i++) {
            if ($num_of_stars > $i) {
                $stars .= '<i class="fa fa-star w3-text-yellow"></i>';
            } else {
                $stars .= '<i class="fa fa-star-o w3-text-yellow"></i>';
            }
        }
    } else {
        $stars = '<i class="fa fa-star-o w3-text-yellow"></i>';
    }

    return $stars;
}

function time_elapsed_A($secs) {
    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
        's' => $secs % 60
    );

    foreach ($bit as $k => $v) {
        if ($v > 0)
            $ret[] = $v . $k;
    }

    return join(' ', $ret);
}

function time_elapsed_B($secs) {
    $bit = array(
        ' year' => $secs / 31556926 % 12,
        ' week' => $secs / 604800 % 52,
        ' day' => $secs / 86400 % 7,
        ' hour' => $secs / 3600 % 24,
        ' minute' => $secs / 60 % 60,
        ' second' => $secs % 60
    );

    foreach ($bit as $k => $v) {
        if ($v > 1) {
            $ret[] = $v . $k . 's';
        }
        if ($v == 1) {
            $ret[] = $v . $k;
        }
    }
    array_splice($ret, count($ret) - 1, 0, 'and');

    $ret[] = 'ago.';

    return join(' ', $ret);
}

function time_elapsed_C($secs) {
    $bit = array(
        ' year' => $secs / 31556926 % 12,
        ' week' => $secs / 604800 % 52,
        ' day' => $secs / 86400 % 7,
        ' hour' => $secs / 3600 % 24,
        ' min' => $secs / 60 % 60,
        ' sec' => $secs % 60
    );

    foreach ($bit as $k => $v) {
        if ($v > 1)
            $ret[] = $v . $k . 's';
        if ($v == 1)
            $ret[] = $v . $k;
    }
    array_splice($ret, count($ret) - 1, 0, 'and');
    $ret[] = 'ago.';

    return join(' ', $ret);
}

function parse_time($tm, $rcs = 0) {
    $cur_tm = time();
    $dif = $cur_tm - $tm;
    $pds = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade');
    $lngh = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);
    for ($v = sizeof($lngh) - 1; ($v >= 0) && (($no = $dif / $lngh[$v]) <= 1); $v--)
        ; if ($v < 0)
        $v = 0;
    $_tm = $cur_tm - ($dif % $lngh[$v]);

    $no = floor($no);
    if ($no <> 1)
        $pds[$v] .= 's';
    $x = sprintf("%d %s ", $no, $pds[$v]);
    if (($rcs == 1) && ($v >= 1) && (($cur_tm - $_tm) > 0))
        $x .= time_ago($_tm);
    return $x;
}

function format_timestamp($start) {
    $string = NULL;
    $t = array(//suffixes
        'mo' => 2419200,
        'd' => 86400,
        'h' => 3600,
        'm' => 60,
    );
    $s = abs(time() - $start);
    foreach ($t as $key => &$val) {
        $$key = floor($s / $val);
        $s -= ($$key * $val);
        $string .= ($$key == 0) ? '' : $$key . "$key ";
    }
    return $string . $s . 's';
}
