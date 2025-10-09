<?php
function redirect($page)
{
    header('location: ' . URLROOT . '/' . $page);
}

function segment($index)
{
    $uri = $_SERVER['REQUEST_URI'];
    $segments = explode('/', $uri);
    $segments = array_filter($segments);
    $segments = array_values($segments);

    if (isset($segments[$index])) {
        return $segments[$index];
    }

    return null;
}

function get_uri_segments()
{
    $uri = $_SERVER['REQUEST_URI'];
    $segments = explode('/', $uri);
    $segments = array_filter($segments);
    return array_values($segments);
}

function gabung_segment()
{
    $uri_segments = get_uri_segments();
    $numSegments = count($uri_segments);

    if ($numSegments >= 1) {
        return implode('/', array_slice($uri_segments, 1, 10));
    } elseif ($numSegments === 1) {
        return $uri_segments[0];
    } else {
        return '';
    }
}

function hitung_segment()
{
    $uri_segments = get_uri_segments();
    return count($uri_segments);
}

if (!function_exists('akhir_segment')) {
    function akhir_segment()
    {
        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $segments = explode('/', $url);
        $lastSegment = end($segments);
        $cleanedSegment = strtok($lastSegment, '?');
        return $cleanedSegment !== false ? $cleanedSegment : null;
    }
}



if (!function_exists('bread')) {
    function bread()
    {
        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $segments = explode('/', $url);
        $breadcrumb = array();
        foreach ($segments as $index => $segment) {
            if (!empty($segment)) {
                $cleanedSegment = strtok($segment, '?');
                // Decode bagian segment yang sudah terencode dalam URL
                $cleanedSegmentDecoded = rawurldecode($cleanedSegment);
                if ($index > 2) {
                    $parentSegments = array_slice($segments, 1, $index);
                    // Decode bagian parentSegments yang sudah terencode dalam URL
                    $parentSegmentsDecoded = array_map('rawurldecode', $parentSegments);
                    $breadcrumb[] = '<a class="bread" href="/' . implode('/', $parentSegmentsDecoded) . '">' . $cleanedSegmentDecoded . '</a>';
                }
            }
        }
        $breadcrumb_string = implode(" / ", $breadcrumb);
        return $breadcrumb_string;
    }
}


if (!function_exists('bread_arsip')) {
    function bread_arsip()
    {
        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $segments = explode('/', $url);
        $breadcrumb = array();
        foreach ($segments as $index => $segment) {
            if (!empty($segment)) {
                $cleanedSegment = strtok($segment, '?');
                $cleanedSegmentDecoded = rawurldecode($cleanedSegment);
                if ($index > 2) {
                    $parentSegments = array_slice($segments, 1, $index);
                    $parentSegmentsDecoded = array_map('rawurldecode', $parentSegments);
                    $breadcrumb[] = '<a class="bread" href="/' . implode('/', $parentSegmentsDecoded) . '">' . $cleanedSegmentDecoded . '</a>';
                }
            }
        }
        $breadcrumb_string = implode(" / ", $breadcrumb);
        return $breadcrumb_string;
    }
}
