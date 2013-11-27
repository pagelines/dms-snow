<?php
/*
Plugin Name: DMS Snow
Plugin URI: http://www.pagelines.com
Description: !Amazing! Snow effect. Add snow to single pages by dragging the section onto the page. Add to all pages by dragging it into the header/footer.
Author: PageLines
PageLines: true
Version: 1.0
Section: true
Class Name: DMS_Snow
Demo: http://www.pagelines.com
*/

/**
 * IMPORTANT
 * This tells wordpress to not load the class as DMS will do it later when the main sections API is available.
 * If you want to include PHP earlier like a normal plugin just add it above here.
 */

if( ! class_exists( 'PageLinesSection' ) )
        return;

class DMS_Snow extends PageLinesSection {

	function section_scripts(){
		wp_enqueue_script( 'dms-snow', plugins_url( '/jquery.snow.min.1.0.js', __FILE__ ), array( 'jquery' ), '1.0', false);
	}

	function section_head() {
		$defaults = array(
			'snow_min_size'	=> '10',
			'snow_max_size'	=> '20',
			'snow_freq'		=> '500',
			'snow_color'	=> '#FFFFFF'
		);
		
		$settings = array(
			'snow_min_size'	=> $this->opt('snow_min_size'),
			'snow_max_size'	=> $this->opt('snow_max_size'),
			'snow_freq'		=> $this->opt('snow_freq'),
			'snow_color'	=> $this->opt('snow_color')
		);
		
		foreach( $settings as $k => $setting )
			if( false == $setting )
				unset( $settings[$k]);
		
		$actual = wp_parse_args( $settings, $defaults );
	
		printf( '<script>!function ($) {
		jQuery(document).ready(function() {
			$.fn.snow({ minSize: %s, maxSize: %s, newOn: %s, flakeColor: "%s",  })
		})
		}(window.jQuery);</script>',
			$actual['snow_min_size'],
			$actual['snow_max_size'],
			$actual['snow_freq'],
			pl_hashify( $actual['snow_color'] )
		);
	}

	function section_template() {
	}

		function section_opts(){
			$opts = array(
				array(
					'type'		=> 'multi',
					'key'		=> 'snow_settings',
					'title'		=> 'Snow',
					'help'		=> 'To add snow to all pages, just make sure you have added this section to a global area like the header or footer.',
					'col'		=> 1,
					'opts'		=> array(
						array(
							'type' 			=> 'text',
							'key'			=> 'snow_min_size',
							'default'		=> '10',
							'label'			=> 'Snow minimum size, default 10',
							),
						array(
							'type' 			=> 'text',
							'key'			=> 'snow_max_size',
							'default'		=> '20',
							'label'			=> 'Snow maximum size, default 20',
							),
						array(
							'type' 			=> 'text',
							'key'			=> 'snow_freq',
							'default'		=> '500',
							'label'			=> 'Flake frequency default is 500ms ( be careful here, blizzards eat cpus )',
							),
						array(
							'type' 			=> 'color',
							'key'			=> 'snow_color',
							'default'		=> 'FFFFFF',
							'label'			=> 'Snow flake color',
							)
						)
				)
			);
		
			return $opts;
		
		}
}