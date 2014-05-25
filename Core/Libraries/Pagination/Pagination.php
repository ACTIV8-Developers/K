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
    private $per_page = 12; // number of products to display per page
    private $total_rows = 0; // total number of rows
    private $cur_offset = 0; // current displaying offset
    private $links_num = 5; // number of links to display at once
    private $li_class = 'pagi'; // class to add to <li> tag
    //!!CAUTION links_num must be odd number in order to class function properly
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
    }

    /**
    * Generate the pagination links.
    * @return string
    */
    public function create_links()
    {
        $r = '';//variable to hold result
        // Calculate the total number of pages
        $num_pages = ceil($this->total_rows / $this->per_page);

        // If there is only one page make no links
        if ($num_pages == 1 || $this->total_rows==0) {
            return '';
        }
        $display_offset = (int) ($this->links_num/2);//precalculate display offset according to links_num
        $r.='<div class="" id="pagination"><ul class="pagination">';//set opening tags
        $r.='<li class="'.$this->li_class.'" id="1"><a href="#">&laquo</a></li>';//set go to first tag

        $start = 0;
        $end = $num_pages;
        if (!($num_pages<=$this->links_num)) {//if total pages is less than links_num display all pages at once
            $cur_link_number = ($this->cur_offset/$this->per_page);
            if (($cur_link_number)<=$display_offset) {//if current link in first set of links
                $start = 0;
                $end = $this->links_num;
            } elseif ($num_pages-$cur_link_number<=$display_offset) {//if current link in last set of links
                $start = $num_pages-$this->links_num;
                $end = $num_pages;
            } else {//if current link in middle set of links
                $start=$cur_link_number-$display_offset;
                $end=$cur_link_number+$display_offset+1;
            }
        }

        //create links according to parameters
        for ($i=$start;$i<$end;$i++) {//create links tags
            $offset = $i*$this->per_page;//set offset to pass to jquery function
            if($offset != $this->cur_offset) $class = ''; else $class=' active';//set current link active
            //add link to result variable
            $r.='<li class="'.$this->li_class.$class.'" id="'.($i+1).'"><a href="#">'.($i+1).'</a></li>';
        }
        $r.='<li class="'.$this->li_class.'" id="'.$num_pages.'"><a href="#">»</a></li>';//set go to last tag
        $r.='</div><ul>';//set closing tags
        return $r;//return final result
    }
}