<?php

namespace Morepress\Post\Field;

class Checkbox extends \Morepress\Post\Field
{

	protected $_prefix_id = '';
	public function html($meta, $repeatable = null){
		is_array($meta) and $meta = null;
		$name = is_null($repeatable) ? $this->_name : $this->_name.'['.$repeatable.']';
		$id = is_null($repeatable) ? $this->_id : $this->_id.'_'.$repeatable;
        $classes = array();
        if(! empty($this->_params['context']) and $this->_params['context'] != 'side')
        {
            $classes[] = 'form-field';
        }
        $classes = implode(' ', $classes);
        empty($classes) or $classes = ' class="'.$classes.'"';
		echo '<tr'.$classes.'>';
		echo '
			<th></th>
			<td>
				<label for="'.$id . '">
					<input type="hidden" value="0" name="'.$name.'">
					<input type="checkbox" value="1" name="'.$name.'" id="'.$id . '" '. ($meta ? ' checked="checked"' : '') .' '.$this->_inputAttr().'>
					'.$this->_label.'
				</label>';
		if(!empty($this->_description))
		{
			echo '<p class="description">' . $this->_description . '</p>';
		}
		echo '</td>';
		echo '</tr>';
	}
}