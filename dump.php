<?php

/**
 * @name        dump
 * @param 		mixed any type of var
 * @return      string of results on a type and value of a variable
 * @example     does not work like var_dump(); you need to echo the results of the function : echo dump(array('test', true, 0.2));
 */


function dump($p1_m_var = NULL, $s_output_dumped = NULL)
{
    static $i_num_imbricated_array, $i_num_obj;

    if(func_num_args() > 1) die('<b>WARNING :: You try to pass more than one var ! </b><br /> ');

    if($p1_m_var === $GLOBALS) die('<b>WARNING :: dumping $GLOBALS will lead to infinite loop!</b><br/>');

    if(is_null($p1_m_var))
    {
        $s_output_dumped .= '<b>NULL</b>';

    }elseif(is_string($p1_m_var))
    {
    	if(is_callable($p1_m_var, FALSE, $s_callable_name))
    	{
        
        	$s_output_dumped .= '<font color="#ccc">CALLABLE</font> of name ('.$s_callable_name.')';

    	}else $s_output_dumped .= '<font color="blue">STRING</font> ('.strlen($p1_m_var).') "'.$p1_m_var.'"';

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
        $o_ref_object = new ReflectionClass($p1_m_var);

        $i_num_obj++;

        $i_num_const = count($o_ref_object->getConstants());
        $i_num_prop = count($o_ref_object->getDefaultProperties());
        $i_num_interfaces = count($o_ref_object->getInterfaces());
        $i_num_methods = count($o_ref_object->getMethods());
        $i_num_traits = count($o_ref_object->getTraits());

        if($i_num_const > 0 || $i_num_prop > 0 || $i_num_interfaces > 0 || $i_num_methods > 0 || $i_num_traits > 0)
        {

            $s_output_dumped .= '<span  style="color: #800000; cursor: pointer;"
		onclick="(document.getElementById(\'obj_'.$i_num_obj.'\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'\').style.display = \'block\';" >
					            OBJECT :: '.get_class($p1_m_var).'</span>';

            $s_output_dumped .= '<ul id="obj_'.$i_num_obj.'" style="display: none; list-style-type: none; margin-top: 0px;">';

            if($i_num_const > 0)
            {

                $s_output_dumped .=  '<li style="cursor: pointer; margin-left: 25px;"
                onclick="(document.getElementById(\'obj_'.$i_num_obj.'_const\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'_const\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'_const\').style.display = \'block\';" ><b><u>CONSTANTS</u></b> ('.$i_num_const.')</li>';

                $s_output_dumped .= '<ul id="obj_'.$i_num_obj.'_const" style="display: none; list-style-type: none; margin-top: 0px;">';

                foreach($o_ref_object->getConstants() as $s_type_const => $s_val_const):

                    $s_output_dumped .= '<li>&nbsp;["'.$s_type_const.'"] => '.dump($s_val_const).'</li>';

                endforeach;

                $s_output_dumped .= '</ul>';
            }

            if($i_num_prop > 0)
            {
                $s_output_dumped .=  '<li style="cursor: pointer; margin-left: 25px;"
                onclick="(document.getElementById(\'obj_'.$i_num_obj.'_prop\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'_prop\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'_prop\').style.display = \'block\';" ><b><u>PROPERTIES</u></b> ('.$i_num_prop.')</li>';

                $s_output_dumped .= '<ul id="obj_'.$i_num_obj.'_prop" style="display: none; list-style-type: none; margin-top: 0px;">';

                foreach($o_ref_object->getProperties() as $s_type_prop => $o_val_prop):

                    $s_output_dumped .= '<li>&nbsp;["'.$s_type_prop.'"] => '.dump((string)$o_val_prop).'</li>';

                endforeach;

                $s_output_dumped .= '</ul>';
            }

            if($i_num_interfaces > 0)
            {
                $s_output_dumped .=  '<li style="cursor: pointer; margin-left: 25px;"
                onclick="(document.getElementById(\'obj_'.$i_num_obj.'_interfaces\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'_interfaces\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'_interfaces\').style.display = \'block\';" ><b><u>INTERFACES</u></b> ('.$i_num_interfaces.')</li>';

                $s_output_dumped .= '<ul id="obj_'.$i_num_obj.'_interfaces" style="display: none; list-style-type: none; margin-top: 0px;">';

                foreach($o_ref_object->getInterfaces() as $s_type_interface => $o_val_interface):

                    $s_output_dumped .= '<li>&nbsp;["'.$s_type_interface.'"] => '.dump((string)$o_val_interface).'</li>';

                endforeach;

                $s_output_dumped .= '</ul>';
            }

            if($i_num_methods > 0)
            {
                $s_output_dumped .=  '<li style="cursor: pointer; margin-left: 25px;"
                onclick="(document.getElementById(\'obj_'.$i_num_obj.'_methods\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'_methods\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'_methods\').style.display = \'block\';" ><b><u>METHODS</u></b> ('.$i_num_methods.')</li>';

                $s_output_dumped .= '<ul id="obj_'.$i_num_obj.'_methods" style="display: none; list-style-type: none; margin-top: 0px;">';

                foreach($o_ref_object->getMethods() as $s_type_method => $o_val_method):

                    $s_output_dumped .= '<li>&nbsp;["'.$s_type_method.'"] => '.dump((string)$o_val_method).'</li>';

                endforeach;

                $s_output_dumped .= '</ul>';
            }

            if($i_num_traits > 0)
            {
                $s_output_dumped .=  '<li style="cursor: pointer; margin-left: 25px;"
                onclick="(document.getElementById(\'obj_'.$i_num_obj.'_traits\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'_traits\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'_traits\').style.display = \'block\';" ><b><u>TRAITS</u></b> ('.$i_num_traits.')</li>';

                $s_output_dumped .= '<ul id="obj_'.$i_num_obj.'_traits" style="display: none; list-style-type: none; margin-top: 0px;">';

                foreach($o_ref_object->getTraits() as $s_type_trait => $o_val_trait):

                    $s_output_dumped .= '<li>&nbsp;["'.$s_type_trait.'"] => '.dump((string)$o_val_trait).'</li>';

                endforeach;
            }

            $s_output_dumped .= '</ul>';

        }else $s_output_dumped .= '<font color="red"> Attention! OBJECT "'.get_class($p1_m_var).'" appears to be empty</font>';

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
                $s_output_dumped .=  '<li>&nbsp;&nbsp;['.$m_key.'] => '.dump($m_value).'</li>';

            }elseif(is_string($m_key))
            {
                $s_output_dumped .=  '<li>&nbsp;&nbsp;["'.$m_key.'"] => '.dump($m_value).'</li>';


            }else dump($m_key);

        endforeach;

        $s_output_dumped .= ' } </ul>';
    }

    return '<!doctype html><html lang="en"><head><meta charset="utf-8"></head><body>'.$s_output_dumped.'</body></html>';
}
