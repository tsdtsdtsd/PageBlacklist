<?php

/**
 * PageBlacklist module
 *
 * A starting point skeleton from which to build your own Process module. 
 * Process modules are used primarily for building admin applications and tools.
 * This module also creates a page in the ProcessWire admin to run itself from.
 * 
 * Copyright 2015 by Orkan Alat
 * Licensed under Creative Commons CC0, see LICENSE.CC0
 * 
 * ProcessWire 2.5.5+
 * Copyright (C) 2014 by Ryan Cramer 
 * Licensed under GNU/GPL v2, see LICENSE.GPL
 * 
 * http://processwire.com
 *
 */
class PageBlacklist extends WireData implements Module 
{

    /**
     * Collection of blacklisted page IDs
     * @var array
     */
    protected $_blacklistedPages = array();

    /**
     * Adds $pageBlacklist to template scope
     */
    public function init() 
    {
        wire("fuel")->set("pageBlacklist", $this);
        parent::init();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getAsString();
    }

    public function add($value)
    {
        if($value instanceof Page) {
            $this->addPage($value);
        }

        if($value instanceof PageArray) {
            $this->addPages($value);
        }

        if(is_integer($value)) {
            $this->addPageById($value);
        }

        if(is_array($value)) {
            $firstEntry = resert($value);

            if(is_integer($firstEntry)) {
                $this->addPagesById($value);
            }
        }

        return $this;
    }

    /**
     * Adds a single page to blacklist
     * 
     * @param Page 
     */
    public function addPage(Page $page)
    {
        if(!empty($page)) {
            $this->_blacklistedPages[$page->id] = true;
            
            return true;
        }

        return false;
    }

    /**
     * Removes a single page from blacklist
     * 
     * @param  Page
     */
    public function removePage(Page $page)
    {
        if(!empty($page)) {
            $this->_blacklistedPages[$page->id] = false;
            
            return true;
        }

        return false;
    }

    /**
     * Adds all pages of an PageArray to the blacklist
     * 
     * @param PageArray
     */
    public function addPages(PageArray $pages) 
    {
        foreach($pages as $page) {
            $this->addPage($page);
        }
    }

    /**
     * Tries to add a page to blacklist by given ID
     * 
     * @param int
     */
    public function addPageById($id) 
    {
        if(!is_integer($id)) {
            return false;
        }

        $article = wire()->pages->get($id);

        if(!$article || $article instanceof NullPage) {
            return false;
        }

        return $this->addPage($article);
    }

    /**
     * Tries to add pages to blacklist by given array of IDs
     * 
     * @param array
     */
    public function addPagesById($ids)
    {
        foreach($ids as $id) {
            $this->addPageById($id);
        }
    }

    /**
     * Clears the blacklist
     */
    public function reset()
    {
        $this->_blacklistedPages = array();
    }

    /**
     * Returns the current blacklisted page IDs
     * 
     * @param  boolean  If false, will prepend "id!=" to string. Default: false
     * @param  string   Prefix. Default: empty string
     * @param  string   Suffix. Default: empty string
     * @return string
     */
    public function getAsString($idListOnly = false, $prefix = '', $suffix = '')
    {
        $this->_blacklistedPages = array_filter($this->_blacklistedPages);

        if(empty($this->_blacklistedPages)) {
            return '';
        }

        $string = $idListOnly ? $prefix : $prefix . 'id!=';
        $string .= implode('|', array_keys($this->_blacklistedPages));

        return $string . $suffix;
    }
}