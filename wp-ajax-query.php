<?php
/*
Plugin Name: WP Ajax Query
Plugin URI: http://blog.aizatto.com/wp-ajax-query/
Description: Allow you to query the WordPress database and retrieve a JSON response
Author: Ezwan Aizat Bin Abdullah Faiz
Author URI: http://aizatto.com
Version: 0.1
License: LGPLv2
*/

add_action('wp_ajax_query', array('WPAjaxQuery', 'wp_ajax'));

class WPAjaxQuery {
	function wp_ajax() {
		$query = new WP_Query();
		$query->parse_query($_GET);

		$qv = $query->query_vars;
		$json = array();
	
		if ($query->is_single) {
			$query->get_posts();
		
			if ($query->have_posts()) {
				$query->the_post();
				$json = array('id' => get_the_ID(), 'title' => get_the_title(), 'type' => get_post_type(), 'permalink' => get_permalink());
			}
		} else if ($query->is_category || $query->is_admin) {
			if (empty($qv['cat']) || $qv['cat'] == 0) {
				$parent = 0;
			} else {
				$parent = $qv['cat'];
				$json = array('id' => $query->get_queried_object_id(), 'title' => $query->get_queried_object()->name, 'type' => 'category', 'permalink' => get_term_link($query->get_queried_object_id(), 'category'));
			}

			$terms = array();
			if ($parent != 0) {
				$posts = array();
				$query->get_posts();
				while($query->have_posts()) {
					$query->the_post();
					$permalink = wp_get_shortlink($post, 'post') . '&cat=' . $qv['cat'];
					$posts[] = array('id' => get_the_ID(), 'title' => get_the_title(), 'post_type' => get_post_type(), 'permalink' => $permalink);
				}
			}

			foreach(get_terms('category', array('hide_empty' => false, 'parent' => $parent)) as $term) {
				$terms[] = array('id' => $term->term_id, 'name' => $term->name, 'taxonomy' => $term->taxonomy, 'permalink' => wp_get_shortlink($term->term_id, $term->taxonomy));
			}

			$json['terms'] = $terms;
		} else { 
			$query->get_posts();

			while($query->have_posts()) {
				$query->the_post();
				$permalink = wp_get_shortlink($post, 'post') . '&cat=' . $qv['cat'];
				$posts[] = array('id' => get_the_ID(), 'title' => get_the_title(), 'post_type' => get_post_type(), 'permalink' => $permalink);
			}
		}
		
		if (isset($posts)) {
			$current_page = $query->query_vars['paged'] == 0 ? 1 : $query->query_vars['paged'];
			$json['posts'] = array('posts' => $posts, 'paged' => $current_page, 'max_num_pages' => $query->max_num_pages );
		}

		echo json_encode($json);
		exit();
	}
}
