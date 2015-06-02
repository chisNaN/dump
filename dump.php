<?php

class Dump
{
    function dumped($p1_m_var = NULL, $s_output_dumped)
    {
        static $i_num_imbricated_array, $i_num_obj;

        if(is_null($p1_m_var))
        {
            $s_output_dumped .= '<b>NULL</b>';

        }elseif(is_string($p1_m_var))
        {
            if(is_callable($p1_m_var, FALSE, $s_callable_name))
            {
                $s_output_dumped .= '<font color="#ccc">CALLABLE</font> of name ('.$s_callable_name.')';

            }else $s_output_dumped .= '<font color="blue">STRING</font> ('.strlen($p1_m_var).') "'.htmlentities($p1_m_var).'"';

        }elseif(is_bool($p1_m_var))
        {
            if($p1_m_var)
            {
                $s_output_dumped .= '<font color="green">BOOL</font> (true)';

            }else $s_output_dumped .= '<font color="green">BOOL</font> (false)';

        }elseif(is_int($p1_m_var))
        {
            $s_output_dumped .= '<font color="MediumSpringGreen" >INT</font> ('.$p1_m_var.')';

        }elseif(is_float($p1_m_var))
        {
            $s_output_dumped .= '<font color="orange">FLOAT</font> ('.$p1_m_var.')';

        }elseif(is_resource($p1_m_var))
        {

            $s_output_dumped .= '<font color="purple">RESOURCE</font> of type ('.get_resource_type($p1_m_var).')';

        }elseif(is_object($p1_m_var))
        {
            if(get_class($p1_m_var) !== 'stdClass')
            {
                $i_num_obj++;

                $s_output_dumped .= '<span  style="color: #800000; cursor: pointer;"
            onclick="(document.getElementById(\'obj_' . $i_num_obj . '\').style.display == \'block\') ? document.getElementById(\'obj_' . $i_num_obj . '\').style.display = \'none\' : document.getElementById(\'obj_' . $i_num_obj . '\').style.display = \'block\';" >
                                    OBJECT :: ' . get_class($p1_m_var) . '</span>';

                $s_output_dumped .= '<ul id="obj_' . $i_num_obj . '" style="display: none; list-style-type: none; margin-top: 0px;">';

                $s_output_dumped .= preg_replace('#(^Class )|(\s{1}Constants \[\d+\])|(Static properties \[\d+\])|(\s{1}Properties \[\d+\])|(Static methods \[\d+\])|(\s{1}Methods \[\d+\])#',
                    '<ul><font color=red>${2}${3}${4}${5}${6}</font></ul>',
                    \ReflectionClass::export($p1_m_var, TRUE));

                $s_output_dumped .= '</ul>';

            }else foreach(get_object_vars($p1_m_var) as $m_value) $this->dumped($m_value);

        }elseif(is_array($p1_m_var))
        {
            $i_num_imbricated_array++;

            $s_output_dumped .= '<span  style="color: #FF0000; cursor: pointer;"
			 					onclick="(document.getElementById(\'level_'.$i_num_imbricated_array.'\').style.display == \'block\') ? document.getElementById(\'level_'.$i_num_imbricated_array.'\').style.display = \'none\' : document.getElementById(\'level_'.$i_num_imbricated_array.'\').style.display = \'block\';">
								 ARRAY</span> ('.count($p1_m_var).')
								<ul style="list-style-type: none; display: none; margin-top: 0px;" id="level_'.$i_num_imbricated_array.'"> { ';

            foreach($p1_m_var as $m_key => $m_value):

                if(is_int($m_key))
                {
                    $s_output_dumped .=  '<li>&nbsp;&nbsp;['.$m_key.'] => '.$this->dumped($m_value).'</li>';

                }elseif(is_string($m_key))
                {
                    $s_output_dumped .=  '<li>&nbsp;&nbsp;["'.$m_key.'"] => '.$this->dumped($m_value).'</li>';


                }else $this->dumped($m_key);

            endforeach;

            $s_output_dumped .= ' } </ul>';
        }

        return '<!doctype html><html lang="en"><head><meta charset="utf-8"></head><body>'.$s_output_dumped.'</body></html>';
    }

    public function displayHTML($p1_var)
    {
        if(func_num_args() > 1) die('<b>WARNING :: You try to pass more than one var ! </b><br /> ');

        if($p1_var === $GLOBALS) die('<b>WARNING :: dumping $GLOBALS will lead to infinite loop!</b><br/>');

        echo $this->dumped($p1_var);
    }

    public function writeHTML($p1_var, $p2_filename)
    {
        if(func_num_args() > 2) die('<b>WARNING :: You try to pass more than 2 vars ! </b><br /> ');

        if($p1_var === $GLOBALS) die('<b>WARNING :: dumping $GLOBALS will lead to infinite loop!</b><br/>');

        if(FALSE === @file_put_contents($p2_filename.'.htm', $this->dumped($p1_var)))
        {
            return '<b>Error: unable to write file, please check path or write permissions</b>';

        }else return TRUE;
    }
}