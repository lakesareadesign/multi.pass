<?php

class Dead_Blogs_Utils
{
    public static function input_select ($name, $values)
    {
        $result = sprintf('<select name="%s">', $name);

        foreach ($values as $k => $v)
        {
            if (isset($_REQUEST[$name]) && $_REQUEST[$name] == $k)
            {
                $result .= sprintf('<option selected="selected" value="%s">%s</option>', $k, $v);
            }
            else
            {
                $result .= sprintf('<option value="%s">%s</option>', $k, $v);
            }
        }

        $result .= '</select>';

        return $result;
    }

    public static function input_text ($name)
    {
        $result = sprintf('<input name="%s"', $name);

        if (isset($_REQUEST[$name]) && $_REQUEST[$name])
            $result .= sprintf(' value="%s"', $_REQUEST[$name]);

        $result .= ' />';

        return $result;
    }

    public static function input_checkbox ($name)
    {
        $result = sprintf('<input type="checkbox" name="%s"', $name);

        if (isset($_REQUEST[$name]) && $_REQUEST[$name])
            $result .= ' checked="checked"';

        $result .= ' />';

        return $result;
    }
}

?>
