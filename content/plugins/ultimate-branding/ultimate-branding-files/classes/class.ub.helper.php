<?php
/*
Copyright 2017 Incsub (email: admin@incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if ( ! class_exists( 'ub_helper' ) ) {

	class ub_helper{
		protected $options;
		protected $data = null;
        protected $option_name;

        public function __construct() {
            add_filter( 'ultimate_branding_options_names', array( $this, 'add_option_name' ) );
        }

        public function add_option_name( $options ) {
            if ( ! in_array( $this->option_name, $options ) ) {
                $options[] = $this->option_name;
            }
            return $options;
        }

		protected function get_value( $section, $name = null ) {
			$this->set_data();
			$value = $this->data;
			if ( empty( $value ) ) {
				return null;
			}
			if ( isset( $value[ $section ] ) ) {
				if ( empty( $name ) ) {
					return $value[ $section ];
				} else if ( isset( $value[ $section ][ $name ] )
				) {
					return $value[ $section ][ $name ];
				}
			}
			return null;
		}

		public function admin_options_page() {
			$this->set_options();
			$this->set_data();
			$simple_options = new simple_options();
			echo $simple_options->build_options( $this->options, $this->data );
		}

		protected function set_data() {
			if ( null === $this->data ) {
				$value = ub_get_option( $this->option_name );
				if ( 'empty' !== $value ) {
					$this->data = $value;
				}
			}
		}
	}
}
