<?php

/**
 * @author: Hoang Ngo
 */
class WD_Post_Model extends WD_Model {
	/**
	 * post type name
	 * @var string
	 * @since 1.0
	 */
	public $table;

	/**
	 * @var bool
	 * @since 1.0
	 */
	public $exist;

	/**
	 * $relations contains the rules how this class data mapped with WordPress custom post type
	 * array(
	 *      array(
	 *          'type' => 'native',
	 *          'prop' => 'class_property',
	 *          'wp' => 'WP_POST property'
	 *      ),
	 *      array(
	 *          'type' => 'wp_meta',
	 *          'prop' => 'class_property',
	 *          'wp' => 'meta key'
	 *      )
	 *  );
	 * @var array
	 * @since 1.0
	 */
	protected $relations = array();

	/**
	 * @var WP_Post
	 */
	protected $_raw;

	protected $virtual_data = array();

	private static $_models = array();


	/**
	 * @return array
	 * @since 1.0
	 */
	public function get_relations() {
		return $this->relations;
	}

	/**
	 * @param array $fields
	 * @param bool $refresh
	 */
	public function save( $fields = array(), $refresh = true ) {
		if ( $this->exist ) {
			$id = $this->update( $fields );
		} else {
			$id = $this->insert( $fields );
		}
		if ( $refresh == true ) {
			$this->switch_to_main();
			$model = $this->find( $id );
			$this->restore_blog();
			$this->import( $model->export() );
		}
	}

	/**
	 * Insert model to _post table
	 * @since 1.0
	 * @return int
	 */
	protected function insert( $fields = array() ) {
		$this->before_insert();
		list( $post_data, $post_meta ) = $this->prepare_data( $fields );
		//insert to post data
		$this->switch_to_main();
		$id = wp_insert_post( $post_data, true );
		//add post meta
		foreach ( $post_meta as $key => $meta ) {
			update_post_meta( $id, $key, $meta );
		}
		$this->restore_blog();
		$this->after_insert();

		return $id;
	}

	/**
	 * Prepare post native & meta data
	 * @return array
	 */
	private function prepare_data( $fields = array() ) {
		$rels      = $this->get_relations();
		$post_data = array(
			'post_type'   => $this->table,
			'post_status' => 'publish'
		);
		$post_meta = array();
		foreach ( $rels as $rel ) {
			$prop    = $rel['prop'];
			$wp_prop = $rel['wp'];
			if ( $rel['type'] == 'native' ) {
				$post_data[ $wp_prop ] = $this->$prop;
			} else {
				if ( ! empty( $fields ) && ! in_array( $prop, $fields ) ) {
					//default all post field will get update, only meta can exclude
					continue;
				}
				$post_meta[ $wp_prop ] = $this->$prop;
			}
		}

		return array(
			$post_data,
			$post_meta
		);
	}

	protected function update( $fields = array() ) {
		$this->before_update();
		list( $post_data, $post_meta ) = $this->prepare_data( $fields );
		$this->switch_to_main();
		wp_update_post( $post_data );
		//add post meta
		foreach ( $post_meta as $key => $meta ) {
			update_post_meta( $post_data['ID'], $key, $meta );
		}
		$this->restore_blog();
		$this->after_update();

		return $post_data['ID'];
	}

	/**
	 * Find single record
	 *
	 * @param $id
	 *
	 * @return null
	 * @since 1.0
	 */
	public function find( $id ) {
		$this->switch_to_main();
		$post = get_post( $id );
		if ( ! is_object( $post ) || ! $post instanceof WP_Post ) {
			return null;
		}

		$class = get_class( $this );
		//instance it
		$model = new $class;

		//start binding
		$model = self::bind( $post, $model );
		$this->restore_blog();

		return $model;
	}

	/**
	 * @param $slug
	 *
	 * @return mixed|null
	 * @since 1.0
	 */
	public function find_by_slug( $slug ) {
		$this->switch_to_main();
		$args    = array(
			'name'        => $slug,
			'post_type'   => self::get_table(),
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$results = get_posts( $args );
		if ( $results ) {
			$model = self::make( get_class( $this ) );
			$post  = array_shift( $results );
			$model = self::bind( $post, $model );

			return $model;
		}
		$this->restore_blog();

		return null;
	}

	/**
	 * @param array $params
	 *
	 * @return self|null
	 * @since 1.0
	 */
	public function find_by_attributes( $params = array(), $addition_params = array() ) {
		$this->switch_to_main();
		$model      = self::make( get_class( $this ) );
		$rels       = $model->get_relations();
		$args       = array(
			'post_type'   => self::get_table(),
			'numberposts' => 1,
			'post_status' => 'publish'
		);
		$meta_query = array();
		/**
		 * loop through input parameters, $key is referrer as class property
		 */
		foreach ( $params as $key => $val ) {
			$relation = '';
			foreach ( $rels as $rel ) {
				if ( $rel['prop'] == $key ) {
					$relation = $rel;
					break;
				}
			}
			if ( is_array( $relation ) ) {
				if ( $relation['type'] == 'native' ) {
					$wp_prop          = $relation['wp'];
					$wp_prop          = str_replace( 'post_author', 'author', $wp_prop );
					$args[ $wp_prop ] = $val;
				} elseif ( $relation['type'] == 'wp_meta' ) {
					$meta         = array(
						'key'     => $relation['wp'],
						'value'   => $val,
						'compare' => is_array( $val ) ? 'IN' : '='
					);
					$meta_query[] = $meta;
				}
			}
		}
		if ( count( ( $meta_query ) ) ) {
			$args['meta_query'] = $meta_query;
		}
		$args = array_merge( $args, $addition_params );

		$results = get_posts( $args );
		if ( count( $results ) ) {
			$post = array_shift( $results );

			$ret = self::bind( $post, $model );
			$this->restore_blog();

			return $ret;
		}
		$this->restore_blog();

		return null;
	}

	/**
	 * @param array $params class attributes
	 * @param bool $limit set this if you want to benefit from paging
	 * @param int $paged
	 *
	 * @return array
	 */
	public function find_all( $params = array(), $limit = false, $paged = 1, $addition_params = array(), &$wp_query = null ) {
		$model = self::make( get_class( $this ) );
		$rels  = $model->get_relations();
		$args  = array(
			'post_type' => self::get_table()
		);
		if ( $limit == false ) {
			$args['nopaging'] = true;
		} else {
			$args['posts_per_page'] = $limit;
			$args['paged']          = $paged;
		}
		$meta_query = array();
		/**
		 * loop through input parameters, $key is referrer as class property
		 */
		foreach ( $params as $key => $val ) {
			$relation = '';
			foreach ( $rels as $rel ) {
				if ( $rel['prop'] == $key ) {
					$relation = $rel;
					break;
				}
			}
			if ( is_array( $relation ) ) {
				if ( $relation['type'] == 'native' ) {
					$wp_prop          = $relation['wp'];
					$wp_prop          = str_replace( 'post_author', 'author', $wp_prop );
					$args[ $wp_prop ] = $val;
				} elseif ( $relation['type'] == 'wp_meta' ) {
					$meta = array(
						'key'   => $relation['wp'],
						'value' => $val
					);
					if ( is_array( $val ) ) {
						$meta['compare'] = 'in';
					}
					$meta_query[] = $meta;
				}
			}
		}

		if ( count( ( $meta_query ) ) ) {
			$args['meta_query'] = $meta_query;
		}

		$args = array_merge( $args, $addition_params );
		$this->switch_to_main();
		$query = new WP_Query( $args );

		$wp_query = $query;
		$data     = array();
		if ( $query->post_count > 0 ) {
			foreach ( $query->posts as $post ) {
				$data[] = self::bind( $post, self::make( get_class( $this ) ) );
			}
		}
		$this->restore_blog();

		return $data;
	}

	/**
	 * @return mixed
	 */
	public static function count() {
		$counts = wp_count_posts( self::get_table() );

		return $counts->publish + $counts->draft;
	}

	/**
	 * delete
	 */
	public function delete() {
		$this->switch_to_main();
		wp_delete_post( $this->id, true );
		$this->restore_blog();
	}

	/**
	 * @param $post
	 * @param $model
	 *
	 * @return mixed
	 * @since 1.0
	 */
	private static function bind( $post, $model ) {
		//get relations
		$rels  = $model->get_relations();
		$metas = get_post_meta( $post->ID );
		foreach ( $rels as $rel ) {
			$prop    = $rel['prop'];
			$wp_prop = $rel['wp'];
			switch ( $rel['type'] ) {
				case 'native':
					//$model->__set( $prop, $post->$wp_prop );
					$model->$prop = $post->$wp_prop;
					break;
				case 'wp_meta':
					$v            = array_values( (array) @$metas[ $wp_prop ] );
					$model->$prop = isset( $metas[ $wp_prop ] ) ? @array_shift( $v ) : null;	  	 	   	 		 		 				
					break;
			}
		}
		$model->exist = true;
		$model->after_load();

		return $model;
	}

	/**
	 * @param $post
	 */
	public function set_raw_post( $post ) {
		$this->_raw = $post;
	}

	/**
	 * @return array|null|WP_Post
	 */
	public function get_raw_post() {
		if ( ! is_object( $this->_raw ) && $this->exist ) {
			$this->switch_to_main();
			$this->_raw = get_post( $this->id );
			$this->restore_blog();
		}

		return $this->_raw;
	}

	protected function after_load() {

	}

	public function export() {
		$data = array();

		foreach ( $this->relations as $rel ) {
			$prop          = $rel['prop'];
			$data[ $prop ] = $this->$prop;
		}

		//virtual attribute
		foreach ( $this->virtual_attributes as $key => $val ) {
			$data[ $key ] = $val;
		}

		return $data;
	}

	/**
	 * @return mixed
	 * @since 1.0
	 */
	private static function make( $class ) {
		$model = new $class();

		return $model;
	}

	/**
	 * @return mixed
	 * @since 1.0
	 */
	public function get_table() {
		return self::make( get_class( $this ) )->table;
	}

	/**
	 * Magic method __get
	 *
	 * @param string $property
	 *
	 * @access public
	 * @since 1.0
	 * @return mixed|null
	 */
	public function &__get( $property ) {
		$attributes = array_keys( $this->export() );
		if ( in_array( $property, $attributes ) ) {
			//all good
			return $this->$property;
		}

		if ( isset( $this->virtual_attributes[ $property ] ) ) {
			//check in the virtual property
			return $this->virtual_attributes[ $property ];
		}
		$ret = null;

		return $ret;
	}

	/**
	 * Magic method __set
	 *
	 * @param string $property
	 * @param mixed $value
	 *
	 * @access public
	 * @since 1.0
	 */
	public function __set( $property, $value ) {
		$attributes = array_keys( $this->export() );
		if ( in_array( $property, $attributes ) ) {
			//all good
			$this->$property = $value;
		} else {
			//jsut throw it into virtual attribute
			$this->virtual_attributes[ $property ] = $value;
		}
	}

	public static function model( $class_name = __CLASS__ ) {
		//cache
		if ( ! isset( self::$_models[ $class_name ] ) ) {
			self::$_models[ $class_name ] = new $class_name();
		}

		return self::$_models[ $class_name ];
	}

	private function switch_to_main() {
		if ( WD_Utils::is_plugin_network_activated() ) {
			switch_to_blog( 1 );
		}
	}

	private function restore_blog() {
		if ( WD_Utils::is_plugin_network_activated() ) {
			restore_current_blog();
		}
	}
}