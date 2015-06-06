<?php

class Dump
{

    public function __construct()
    {
        if(version_compare(PHP_VERSION, '5.6.0', '<'))
        {
            die('You need at least PHP version 5.6 to execute this class');
        }
    }

    protected function dumped($p1_m_var)
    {
        static $i_num_imbricated_array, $i_num_obj;

        if($p1_m_var === $GLOBALS) die('<b>WARNING :: dumping $GLOBALS will lead to infinite loop!</b><br/>');

        if(is_null($p1_m_var))
        {
            yield '<b>NULL</b>';

        }elseif(is_string($p1_m_var))
        {
            if(is_callable($p1_m_var, FALSE, $s_callable_name))
            {
                yield '<font color="#ccc">CALLABLE</font> of name ('.$s_callable_name.')';

            }else yield '<font color="blue">STRING</font> ('.strlen($p1_m_var).') "'.htmlentities($p1_m_var). '"';

        }elseif(is_bool($p1_m_var))
        {

            if($p1_m_var)
            {
                yield '<font color="green">BOOL</font> (true)';

            }else yield '<font color="green">BOOL</font> (false)';

        }elseif(is_int($p1_m_var))
        {
            yield '<font color="MediumSpringGreen" >INT</font> ('.$p1_m_var.')';

        }elseif(is_float($p1_m_var))
        {
            yield '<font color="orange">FLOAT</font> ('.$p1_m_var.')';

        }elseif(is_resource($p1_m_var))
        {
            yield '<font color="purple">RESOURCE</font> of type ('.get_resource_type($p1_m_var).')';

        }elseif(is_object($p1_m_var))
        {
            if(get_class($p1_m_var) !== 'stdClass')
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

                    yield '<span  style="color: #800000; cursor: pointer;"
        onclick="(document.getElementById(\'obj_'.$i_num_obj.'\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'\').style.display = \'block\';" >
                                OBJECT :: '.get_class($p1_m_var).'</span>';

                    yield '<ul id="obj_'.$i_num_obj.'" style="display: none; list-style-type: none; margin-top: 0px;">';

                    if($i_num_const > 0)
                    {

                        yield  '<li style="cursor: pointer; margin-left: 25px;"
                onclick="(document.getElementById(\'obj_'.$i_num_obj.'_const\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'_const\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'_const\').style.display = \'block\';" ><b><u>CONSTANTS</u></b> ('.$i_num_const.')</li>';

                        yield '<ul id="obj_'.$i_num_obj.'_const" style="display: none; list-style-type: none; margin-top: 0px;">';

                        foreach($o_ref_object->getConstants() as $s_type_const => $s_val_const):

                            yield '<li>&nbsp;["'.$s_type_const.'"] => ';

                            foreach($this->dumped($s_val_const) as $new_call) yield $new_call;

                            yield '</li>';

                        endforeach;

                        yield '</ul>';
                    }

                    if($i_num_prop > 0)
                    {
                        yield  '<li style="cursor: pointer; margin-left: 25px;"
                onclick="(document.getElementById(\'obj_'.$i_num_obj.'_prop\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'_prop\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'_prop\').style.display = \'block\';" ><b><u>PROPERTIES</u></b> ('.$i_num_prop.')</li>';

                        yield '<ul id="obj_'.$i_num_obj.'_prop" style="display: none; list-style-type: none; margin-top: 0px;">';

                        foreach($o_ref_object->getProperties() as $s_type_prop => $o_val_prop):

                            yield '<li>&nbsp;["'.$s_type_prop.'"] => ';

                            foreach($this->dumped((string)$o_val_prop) as $new_call) yield $new_call;

                            yield '</li>';

                        endforeach;

                        yield '</ul>';
                    }

                    if($i_num_interfaces > 0)
                    {
                        yield  '<li style="cursor: pointer; margin-left: 25px;"
                onclick="(document.getElementById(\'obj_'.$i_num_obj.'_interfaces\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'_interfaces\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'_interfaces\').style.display = \'block\';" ><b><u>INTERFACES</u></b> ('.$i_num_interfaces.')</li>';

                        yield '<ul id="obj_'.$i_num_obj.'_interfaces" style="display: none; list-style-type: none; margin-top: 0px;">';

                        foreach($o_ref_object->getInterfaces() as $s_type_interface => $o_val_interface):

                            yield '<li>&nbsp;["'.$s_type_interface.'"] => ';

                            foreach($this->dumped((string)$o_val_interface) as $new_call) yield $new_call;

                            yield '</li>';

                        endforeach;

                        yield '</ul>';
                    }

                    if($i_num_methods > 0)
                    {
                        yield  '<li style="cursor: pointer; margin-left: 25px;"
                onclick="(document.getElementById(\'obj_'.$i_num_obj.'_methods\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'_methods\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'_methods\').style.display = \'block\';" ><b><u>METHODS</u></b> ('.$i_num_methods.')</li>';

                        yield '<ul id="obj_'.$i_num_obj.'_methods" style="display: none; list-style-type: none; margin-top: 0px;">';

                        foreach($o_ref_object->getMethods() as $s_type_method => $o_val_method):

                            yield '<li>&nbsp;["'.$s_type_method.'"] => ';

                            foreach($this->dumped((string)$o_val_method) as $new_call) yield $new_call;

                            yield '</li>';

                        endforeach;

                        yield '</ul>';
                    }

                    if($i_num_traits > 0)
                    {
                        yield  '<li style="cursor: pointer; margin-left: 25px;"
                onclick="(document.getElementById(\'obj_'.$i_num_obj.'_traits\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'_traits\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'_traits\').style.display = \'block\';" ><b><u>TRAITS</u></b> ('.$i_num_traits.')</li>';

                        yield '<ul id="obj_'.$i_num_obj.'_traits" style="display: none; list-style-type: none; margin-top: 0px;">';

                        foreach($o_ref_object->getTraits() as $s_type_trait => $o_val_trait):

                            yield '<li>&nbsp;["'.$s_type_trait.'"] => ';

                            foreach($this->dumped((string)$o_val_trait) as $new_call) yield $new_call;

                            yield '</li>';

                        endforeach;
                    }

                    yield '</ul>';

                }else yield '<font color="red"> Attention! OBJECT "'.get_class($p1_m_var).'" appears to be empty</font>';

            }else foreach($this->dumped(get_object_vars($p1_m_var)) as $new_call) yield $new_call;

        }elseif(is_array($p1_m_var))
        {
            $i_num_imbricated_array++;

            yield '<span  style="color: #FF0000; cursor: pointer;"
                                onclick="(document.getElementById(\'level_'.$i_num_imbricated_array.'\').style.display == \'block\') ? document.getElementById(\'level_'.$i_num_imbricated_array.'\').style.display = \'none\' : document.getElementById(\'level_'.$i_num_imbricated_array.'\').style.display = \'block\';">
                                 ARRAY</span> ('.count($p1_m_var).')
                                <ul style="list-style-type: none; display: none; margin-top: 0px;" id="level_'.$i_num_imbricated_array.'"> { ';

            foreach($p1_m_var as $m_key => $m_value):

                if(is_int($m_key))
                {
                    yield '<li>&nbsp;&nbsp;['.$m_key.'] => ';

                    foreach($this->dumped($m_value) as $new_call) yield $new_call;

                    yield '</li>';

                }elseif(is_string($m_key))
                {
                    yield '<li>&nbsp;&nbsp;["'.$m_key.'"] => ';

                    foreach($this->dumped($m_value) as $new_call) yield $new_call;

                    yield '</li>';

                }else foreach($this->dumped($m_value) as $new_call) yield $new_call;

            endforeach;

            yield ' } </ul>';
        }
    }

    public function displayHTML($p1_m_var, ...$p2_additionals_params)
    {
        if(count($p2_additionals_params) > 0) die('<b>Error: You try to pass more than one var ! </b><br /> ');

        $s_html_dump = '';

        foreach($this->dumped($p1_m_var) as $v) $s_html_dump .= $v;

        return $s_html_dump;
    }

    public function writeHTML($p1_m_var, $p2_filename, ...$p3_additionals_params)
    {
        if(count($p3_additionals_params) > 0) die('<b>Error: You try to pass more than one var ! </b><br /> ');

        $s_html_nodes = '';

        foreach($this->dumped($p1_m_var) as $v) $s_html_nodes .= $v;

        $html = '<!doctype html><html lang="en"><head><meta charset="utf-8"></head><body>'.$s_html_nodes.'</body></html>';

        if(FALSE === @file_put_contents($p2_filename.'.htm', $html))
        {
            return '<b>Error: unable to write file, please check path or write permissions</b>';

        }else return TRUE;

    }

}