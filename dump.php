<?php

/**
	 * @name    	dump
	 * @param 		mixed any type of var
	 * @return  	string of results on a type and value of a variable
	 * @example  	does not work like var_dump(); you need to echo the results : echo $o->dump(array('test', true, 0.2));
	 */

function dump($p1_m_var = NULL, $s_output_dumped = '')
{
		static $i_num_imbricated_array, $i_num_obj;

		if(func_num_args() > 1) die('<b>WARNING :: You try to pass more than one var ! </b><br /> ');

		if($p1_m_var === $GLOBALS) die('<b>WARNING :: dumping $GLOBALS will lead to infinite loop!</b><br/>');

		if(is_null($p1_m_var))
		{
			$s_output_dumped .= '<b>NULL</b>';

		}elseif(is_string($p1_m_var))
		{

			$s_output_dumped .= '<font color="blue">STRING</font> ('.strlen($p1_m_var).') "'.$p1_m_var.'"';

		}elseif(is_bool($p1_m_var))
		{

			if($p1_m_var)
			{
				$s_output_dumped .= '<font color="green">BOOL</font> (true)';

			}else $s_output_dumped .= '<font color="green">BOOL</font> (false)';

		}elseif(is_int($p1_m_var))
		{
			$s_output_dumped .= '<font color="teal" >INT</font> ('.$p1_m_var.')';

		}elseif(is_float($p1_m_var))
		{
			$s_output_dumped .= '<font color="orange">FLOAT</font> ('.$p1_m_var.')';

		}elseif(is_resource($p1_m_var))
		{

			$s_output_dumped .= '<font color="purple">RESOURCE</font> of type ('.get_resource_type($p1_m_var).')';

		}elseif(is_object($p1_m_var))
		{
			$i_num_obj++;

			$s_output_dumped .= '<span  style="color: #800000; cursor: pointer;"
			 		onclick="(document.getElementById(\'obj_'.$i_num_obj.'\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'\').style.display = \'block\';" >
					 OBJECT :: '.get_class($p1_m_var).'</span>';

			$m_public_props = get_class_vars(get_class($p1_m_var));

			$s_output_dumped .= '<ul id="obj_'.$i_num_obj.'" style="display: none; list-style-type: none; margin-top: 0px;">
			 					<li> PUBLIC PROP ('.count($m_public_props).'):: </li>';

			if(is_array($m_public_props) && count($m_public_props) > 0)
			{
				foreach($m_public_props as $m_key => $m_value):

					$s_output_dumped .= '<li>&nbsp;'.$m_key.' => '.dump($m_value).'</li>';

				endforeach;
			}

			$m_public_methods = get_class_methods($p1_m_var);

			$s_output_dumped .= '<li>PUBLIC METHODS ('.count($m_public_methods).') :: </li>';

			if(is_array($m_public_methods) && count($m_public_methods) > 0)
			{
				foreach($m_public_methods as $m_value) $s_output_dumped .= '<li>&nbsp;'.$m_value.'</li>';

			}

			$s_output_dumped .= '</ul>';

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


				}else dump($m_key, $s_output_dumped);

			endforeach;

			$s_output_dumped .= ' } </ul>';
		}

	return $s_output_dumped;
}