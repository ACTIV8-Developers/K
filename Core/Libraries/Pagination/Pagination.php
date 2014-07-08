<?php
namespace Core\Libraries\Pagination;

/**
* Pagination class.
*
* @author <miloskajnaco@gmail.com>
* @author <ndelevic@ymail.com>
*/
class Pagination
{
    // ------------------------------------------------------------------------
    private $perPage = 12; // number of products to display per page
    private $totalRows = 0; // total number of rows
    private $curOffset = 0; // current displaying offset
    private $numLinks = 9; // number of links to display at once
    private $liClass = 'pagi'; // class to add to <li> tag
    private $baseUrl = '';   // Base added to all links
    private $extraParams = '';  // Added at end of every link
    //!!CAUTION numLinks must be odd number in order to class function properly
    // ------------------------------------------------------------------------
    
    /**
    * Class constructor
    * @param array
    */
    public function __construct($params = [])
    {
        foreach ($params as $key => $val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }

        if($this->extraParams!='') {
            $this->extraParams = '/'.$this->extraParams;
        }
    }

    /**
    * Generate the pagination links.
    * @return string (HTML of pagination menu)
    */
    public function createLinks()
    {
        $r = '';//variable to hold result
        // Calculate the total number of pages
        $num_pages = ceil($this->totalRows / $this->perPage);

        // If there is only one page make no links
        if ($num_pages == 1 || $this->totalRows==0) {
            return '';
        }
        $display_offset = (int) ($this->numLinks/2);//precalculate display offset according to numLinks
        $r.='<div class="" id="pagination"><ul class="pagination">';//set opening tags
        $r.='<li class="'.$this->liClass.'" id="1"><a href="'.$this->baseUrl.'/0/'.$this->perPage.$this->extraParams.'">&laquo</a></li>';//set go to first tag

        $start = 0;
        $end = $num_pages;
        if (!($num_pages<=$this->numLinks)) {//if total pages is less than numLinks display all pages at once
            $cur_link_number = ($this->curOffset/$this->perPage);
            if (($cur_link_number)<=$display_offset) {//if current link in first set of links
                $start = 0;
                $end = $this->numLinks;
            } elseif ($num_pages-$cur_link_number<=$display_offset) {//if current link in last set of links
                $start = $num_pages-$this->numLinks;
                $end = $num_pages;
            } else {//if current link in middle set of links
                $start=$cur_link_number-$display_offset;
                $end=$cur_link_number+$display_offset+1;
            }
        }

        //create links according to parameters
        for ($i=$start;$i<$end;$i++) {//create links tags
            $offset = $i*$this->perPage;//set offset to pass to jquery function
            if($offset != $this->curOffset) $class = ''; else $class=' active';//set current link active
            //add link to result variable
            $r.='<li class="'.$this->liClass.$class.'" id="'.($i+1).'">
            <a href="'.$this->baseUrl.'/'.($i*$this->perPage).'/'.$this->perPage.$this->extraParams.'">'.($i+1).'</a></li>';
        }

        $r.='<li class="'.$this->liClass.'" id="'.$num_pages.'"><a href="'.$this->baseUrl.'/'.(($num_pages-1)*$this->perPage).'/'.$this->perPage.$this->extraParams.'">»</a></li>';//set go to last tag
        $r.='</div><ul>';//set closing tags

        return $r;//return final result
    }
}