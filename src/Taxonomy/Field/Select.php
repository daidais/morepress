<?php

namespace Morepress\Taxonomy\Field;

class Select extends \Morepress\Taxonomy\Field
{
	protected $_taxonomy;
	protected $_type = 'select';
	protected $_slug;
	protected $_params = array();

	public function callback($term = null)
	{
        if (! empty($term)) {
            $mp_term = \Morepress\Term::forge($term);
        ?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="term_meta_<?php echo $this->_slug; ?>"><?php echo $this->_params['label']; ?></label>
				</th>
				<td>
                    <select id="term_meta_<?php echo $this->_slug; ?>" name="term_meta[<?php echo $this->_slug; ?>]"  id="term_meta_<?php echo $this->_slug; ?>">
                        <?php foreach($this->_params['options'] as $key=>$value) : ?>
                            <option <?php echo ($key == $mp_term->getMeta($this->_slug, true)) ? 'selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
					<?php if(! empty($this->_params['description'])) : ?>
						<p class="description"><?php echo $this->_params['description']; ?></p>
					<?php endif; ?>
				</td>
			</tr>
			<?php
		}
	}
}
