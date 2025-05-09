<?php

namespace App\Libraries;

class Breadcrumb
{
    private $breadcrumbs = [];
    private $tags = [];

    public function __construct()
    {
        $this->tags['open'] = '<ol class="breadcrumb">';
        $this->tags['close'] = "</ol>";
        $this->tags['itemOpen'] = '<li class="breadcrumb-item">';
        $this->tags['itemClose'] = "</li>";
    }

    public function add($title, $href)
    {
        if (!$title or !$href) {
            return;
        }
        $this->breadcrumbs[] = ['title' => $title, 'href' => $href];
    }

    public function get()
    {
        return $this->breadcrumbs;
    }

    public function reset()
    {
        $this->breadcrumbs = [];
    }

    public function openTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['open'];
        } else {
            $this->tags['open'] = $tags;
        }
    }

    public function closeTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['close'];
        } else {
            $this->tags['close'] = $tags;
        }
    }

    public function itemOpenTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['itemOpen'];
        } else {
            $this->tags['itemOpen'] = $tags;
        }
    }

    public function itemCloseTage($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['itemClose'];
        } else {
            $this->tags['itemClose'] = $tags;
        }
    }

    public function render()
    {
        if (!empty($this->tags['open'])) {
            $output = $this->tags['open'];
        } else {
            $output = '<ol class="breadcrumb">';
        }

        $count = count($this->breadcrumbs) - 1;
        foreach ($this->breadcrumbs as $index => $breadcrumb) {

            if ($index == $count) {
                $output .= '<li class="breadcrumb-item active">';
                $output .= '<a class="breadcrumb-link" href="' . $breadcrumb['href'] . '">';
                $output .= $breadcrumb['title'];
                $output .= '</a>';
                $output .= '</li>';
            } else {
                $output .= ($this->tags['itemOpen']) ? $this->tags['itemOpen'] : '<li class="breadcrumb-item">';
                $output .= '<a class="breadcrumb-link" href="' . $breadcrumb['href'] . '">';
                $output .= $breadcrumb['title'];
                $output .= '</a>';
                $output .= '</li>';
            }

        }

        if (!empty($this->tags['open'])) {
            $output .= $this->tags['close'];
        } else {
            $output .= "</ol>";
        }

        return $output;
    }
}
