<?php

namespace Morepress\Post;

class Column {

	protected $_name;
	protected $_title;
	protected $_post_types;

	protected static $_to_remove = array();

	public function __construct($name, $title, $post_types = array())
	{
		$this->_name = $name;
		$this->_title = $title;
		is_string($post_types) and $post_types = array($post_types);
		$this->_post_types = $post_types;
		add_filter('manage_posts_columns', array($this, 'wpManage'));
        add_filter('manage_media_columns', array($this, 'wpManage'));
	}

	public function wpManage($columns)
	{
		if(! empty($this->_post_types))
		{
			$current_post_type = get_query_var('post_type');
			if(in_array($current_post_type, $this->_post_types ))
			{
				return array_merge($columns, array($this->_name => $this->_title));
			}
			return $columns;
		}

		return array_merge($columns, array($this->_name => $this->_title));
	}

	public function content($callback)
	{
		add_action('manage_posts_custom_column', $callback, 10, 2);
		add_action('manage_media_custom_column', $callback, 10, 2);
	}

	public static function remove($columns, $post_types = array())
	{
		static::$_to_remove[] = array(
			'columns' => $columns,
			'post_types' => $post_types,
		);
		add_filter('manage_posts_columns', array(__CLASS__, 'wpRemove'), 10, 1);
		add_filter('manage_media_columns', array(__CLASS__, 'wpRemove'), 10, 1);
	}

	public static function wpRemove($columns)
	{
		foreach(static::$_to_remove as $to_remove)
		{
			if(! empty($to_remove['post_types']))
			{
				$current_post_type = get_query_var('post_type');
				if(in_array($current_post_type, $to_remove['post_types'] ))
				{
					foreach($to_remove['columns'] as $column)
					{
						unset($columns[$column]);
					}
				}
			}
		}

		return $columns;
	}
}
