<?php  
	/* 
	Plugin Name: WP Word&nbsp;Count
	Plugin URI: http://linksoftwarellc.com/wpwordcount
	Description: Word Count Statistics for your Posts and Pages.
	Author: Link Software LLC
	Version: 1.6.1
	Author URI: http://linksoftwarellc.com
	*/
	
	add_action('publish_post', 'bjl_word_count_calculate');
	add_action('edit_post', 'bjl_word_count_calculate');
	add_action("widgets_init", 'bjl_word_count_add_widget');
	add_action('admin_menu', 'bjl_word_count_add_menu');
	add_action('admin_head', 'bjl_word_count_style_admin');
	add_shortcode('wpwordcount', 'bjl_word_count_shortcode');
	
	function bjl_word_count_calculate()
	{
		global $wpdb, $table_prefix;
		
		$words_posts_publish = 0;
		$words_posts_draft = 0;
		$words_pages_publish = 0;
		$words_pages_draft = 0;
		
		$count_posts_publish = 0;
		$count_posts_draft = 0;
		$count_pages_publish = 0;
		$count_pages_draft = 0;
		
		$arr_bjl_content_word_count = array();
		$arr_bjl_content_post_title = array();
		$arr_bjl_content_post_type = array();
		$arr_bjl_content_post_status = array();
		$arr_bjl_content_post_author = array();
		
		$arr_bjl_author_word_count = array();
		$arr_bjl_author_posts_publish = array();
		$arr_bjl_author_posts_publish_word_count = array();
		$arr_bjl_author_posts_draft = array();
		$arr_bjl_author_posts_draft_word_count = array();
		$arr_bjl_author_pages_publish = array();
		$arr_bjl_author_pages_publish_word_count = array();
		$arr_bjl_author_pages_draft = array();
		$arr_bjl_author_pages_draft_word_count = array();
		
		$arr_bjl_month_word_count = array();
		$arr_bjl_month_posts_publish = array();
		$arr_bjl_month_posts_publish_word_count = array();
		$arr_bjl_month_posts_draft = array();
		$arr_bjl_month_posts_draft_word_count = array();
		$arr_bjl_month_pages_publish = array();
		$arr_bjl_month_pages_publish_word_count = array();
		$arr_bjl_month_pages_draft = array();
		$arr_bjl_month_pages_draft_word_count = array();
		
		// CAPTURE ALL POSTS & PAGES, PUBLISH AND UNPUBLISHED, WHILE AVOIDING AUTO-SAVES & AUTO-DRAFTS AND MENU ITEMS
		$bjl_word_count_items = $wpdb->get_results("SELECT ID, post_content, post_status, MID(post_date, 1, 7) AS post_date, post_title, post_author, post_type FROM $table_prefix"."posts WHERE post_status <> 'inherit' AND post_status <> 'auto-draft' AND (post_type = 'page' OR post_type = 'post') ORDER BY post_date DESC;");
		
		foreach ($bjl_word_count_items as $items => $item)
		{
			// CALCULATE AND STORE MAIN STATS
			$words = bjl_word_counter($item->post_content);
			$arr_bjl_author_word_count[$item->post_author] = $arr_bjl_author_word_count[$item->post_author] + $words;
			$arr_bjl_month_word_count[$item->post_date] = $arr_bjl_month_word_count[$item->post_date] + $words;
			
			if ($item->post_type == "post")
			{
				if ($item->post_status == "publish")
				{
					$words_posts_publish += $words;
					$count_posts_publish++;
					
					$arr_bjl_author_posts_publish[$item->post_author] = $arr_bjl_author_posts_publish[$item->post_author] + 1;
					$arr_bjl_author_posts_publish_word_count[$item->post_author] = $arr_bjl_author_posts_publish_word_count[$item->post_author] + $words;
					
					$arr_bjl_month_posts_publish[$item->post_date] = $arr_bjl_month_posts_publish[$item->post_date] + 1;
					$arr_bjl_month_posts_publish_word_count[$item->post_date] = $arr_bjl_month_posts_publish_word_count[$item->post_date] + $words;
				}
				elseif ($item->post_status == "draft")
				{
					$words_posts_draft += $words;
					$count_posts_draft++;
					
					$arr_bjl_author_posts_draft[$item->post_author] = $arr_bjl_author_posts_draft[$item->post_author] + 1;
					$arr_bjl_author_posts_draft_word_count[$item->post_author] = $arr_bjl_author_posts_draft_word_count[$item->post_author] + $words;
					
					$arr_bjl_month_posts_draft[$item->post_date] = $arr_bjl_month_posts_draft[$item->post_date] + 1;
					$arr_bjl_month_posts_draft_word_count[$item->post_date] = $arr_bjl_month_posts_draft_word_count[$item->post_date] + $words;
				}
			}
			elseif ($item->post_type == "page")
			{
				if ($item->post_status == "publish")
				{
					$words_pages_publish += $words;
					$count_pages_publish++;
					
					$arr_bjl_author_pages_publish[$item->post_author] = $arr_bjl_author_pages_publish[$item->post_author] + 1;
					$arr_bjl_author_pages_publish_word_count[$item->post_author] = $arr_bjl_author_pages_publish_word_count[$item->post_author] + $words;
					
					$arr_bjl_month_pages_publish[$item->post_date] = $arr_bjl_month_pages_publish[$item->post_date] + 1;
					$arr_bjl_month_pages_publish_word_count[$item->post_date] = $arr_bjl_month_pages_publish_word_count[$item->post_date] + $words;
				}
				elseif ($item->post_status == "draft")
				{
					$words_pages_draft += $words;
					$count_pages_draft++;
					
					$arr_bjl_author_pages_draft[$item->post_author] = $arr_bjl_author_pages_draft[$item->post_author] + 1;
					$arr_bjl_author_pages_draft_word_count[$item->post_author] = $arr_bjl_author_pages_draft_word_count[$item->post_author] + $words;
					
					$arr_bjl_month_pages_draft[$item->post_date] = $arr_bjl_month_pages_draft[$item->post_date] + 1;
					$arr_bjl_month_pages_draft_word_count[$item->post_date] = $arr_bjl_month_pages_draft_word_count[$item->post_date] + $words;
				}
			}
			
			// ITEM STATS
			$arr_bjl_content_word_count[$item->ID] = $words;
			$arr_bjl_content_post_title[$item->ID] = $item->post_title;
			$arr_bjl_content_post_type[$item->ID] = $item->post_type;
			$arr_bjl_content_post_status[$item->ID] = $item->post_status;
			$arr_bjl_content_post_author[$item->ID] = $item->post_author;
		}
		
		// WRITE MAIN STATS TO OPTIONS TABLE
		$arr_bjl_word_count_main = array
		(
			'words_posts_publish' => $words_posts_publish,
			'words_posts_draft' => $words_posts_draft,
			'words_pages_publish' => $words_pages_publish,
			'words_pages_draft' => $words_pages_draft,
			
			'count_posts_publish' => $count_posts_publish,
			'count_posts_draft' => $count_posts_draft,
			'count_pages_publish' => $count_pages_publish,
			'count_pages_draft' => $count_pages_draft
		);
		update_option('bjl_word_count_main', $arr_bjl_word_count_main);
		
		// WRITE CACHED ITEMS TO OPTIONS TABLE
		$arr_bjl_word_count_cache = array
		(
			'bjl_content_word_count' => $arr_bjl_content_word_count,
			'bjl_content_post_title' => $arr_bjl_content_post_title,
			'bjl_content_post_type' => $arr_bjl_content_post_type,
			'bjl_content_post_status' => $arr_bjl_content_post_status,
			'bjl_content_post_author' => $arr_bjl_content_post_author
		);
		update_option('bjl_word_count_cache', $arr_bjl_word_count_cache);
		
		// WRITE AUTHOR STATS TO OPTIONS TABLE
		$arr_bjl_word_count_author = array
		(
			'bjl_author_word_count' => $arr_bjl_author_word_count,
			'bjl_author_posts_publish' => $arr_bjl_author_posts_publish,
			'bjl_author_posts_publish_word_count' => $arr_bjl_author_posts_publish_word_count,
			'bjl_author_posts_draft' => $arr_bjl_author_posts_draft,
			'bjl_author_posts_draft_word_count' => $arr_bjl_author_posts_draft_word_count,
			'bjl_author_pages_publish' => $arr_bjl_author_pages_publish,
			'bjl_author_pages_publish_word_count' => $arr_bjl_author_pages_publish_word_count,
			'bjl_author_pages_draft' => $arr_bjl_author_pages_draft,
			'bjl_author_pages_draft_word_count' => $arr_bjl_author_pages_draft_word_count
		);
		update_option('bjl_word_count_author', $arr_bjl_word_count_author);
		
		// WRITE MONTH STATS TO OPTIONS TABLE
		$arr_bjl_word_count_month = array
		(
			'bjl_month_word_count' => $arr_bjl_month_word_count,
			'bjl_month_posts_publish' => $arr_bjl_month_posts_publish,
			'bjl_month_posts_publish_word_count' => $arr_bjl_month_posts_publish_word_count,
			'bjl_month_posts_draft' => $arr_bjl_month_posts_draft,
			'bjl_month_posts_draft_word_count' => $arr_bjl_month_posts_draft_word_count,
			'bjl_month_pages_publish' => $arr_bjl_month_pages_publish,
			'bjl_month_pages_publish_word_count' => $arr_bjl_month_pages_publish_word_count,
			'bjl_month_pages_draft' => $arr_bjl_month_pages_draft,
			'bjl_month_pages_draft_word_count' => $arr_bjl_month_pages_draft_word_count
		);
		update_option('bjl_word_count_month', $arr_bjl_word_count_month);
	}
	
	function bjl_word_counter($content)
	{
		// THIS IS THE SAME METHOD USED BY TD WORD COUNT (http://www.tdscripts.com/wp/tdwordcount/)
		return str_word_count(strip_tags($content));
	}
	
	function bjl_word_count_admin()
	{
		if (!get_option('bjl_word_count_main') || !get_option('bjl_word_count_month'))
		{
			bjl_word_count_calculate();
		}
		
		// LOAD MAIN STATS
		$arr_bjl_word_count_main = get_option('bjl_word_count_main');
		@extract($arr_bjl_word_count_main);
		
		// LOAD CACHED ITEMS
		$arr_bjl_word_count_cache = get_option('bjl_word_count_cache');
		@extract($arr_bjl_word_count_cache);
		
		// LOAD AUTHOR STATS
		$arr_bjl_word_count_author = get_option('bjl_word_count_author');
		@extract($arr_bjl_word_count_author);
		
		// LOAD MONTH STATS
		$arr_bjl_word_count_month = get_option('bjl_word_count_month');
		@extract($arr_bjl_word_count_month);
		
		// OUTPUT DATA
		echo '<div class="wrap">';
		echo '<div id="icon-edit-pages" class="icon32"></div><h2>'.__("WP Word Count").'</h2>';
		
		echo '<ul id="bjl_word_count_main_stats">';
		echo '<li><div class="top published">'.__("Published Posts").'</div>'.number_format($words_posts_publish).'<div class="bottom">'.__("Words").'</div></li>';
		echo '<li><div class="top published">'.__("Published Pages").'</div>'.number_format($words_pages_publish).'<div class="bottom">'.__("Words").'</div></li>';
		echo '<li><div class="top draft">'.__("Draft Posts").'</div>'.number_format($words_posts_draft).'<div class="bottom">'.__("Words").'</div></li>';
		echo '<li><div class="top draft">'.__("Draft Pages").'</div>'.number_format($words_pages_draft).'<div class="bottom">'.__("Words").'</div></li>';
		echo '</ul>';
		
		echo '<ul id="bjl_word_count_main_totals">';
		echo '<li><b class="published">'.number_format($words_posts_publish + $words_pages_publish).'</b> <span>'.__("Published Words").'</span></li>';
		echo '<li><b class="draft">'.number_format($words_posts_draft + $words_pages_draft).'</b> <span>'.__("Unpublished Words").'</span></li>';
		echo '</ul>';
		
		echo '<ul id="bjl_word_count_main_averages">';
		echo '<li>'.@number_format($words_posts_publish / $count_posts_publish).' <span>'.__("Words").'</span><div class="bottom">'.__("Average Per Post").'</div></li>';
		echo '<li>'.@number_format($words_pages_publish / $count_pages_publish).' <span>'.__("Words").'</span><div class="bottom">'.__("Average Per Page").'</div></li>';
		echo '<li>'.@number_format($words_posts_draft / $count_posts_draft).' <span>'.__("Words").'</span><div class="bottom">'.__("Average Per Post").'</div></li>';
		echo '<li>'.@number_format($words_pages_draft / $count_pages_draft).' <span>'.__("Words").'</span><div class="bottom">'.__("Average Per Page").'</div></li>';
		echo '</ul>';
		
		if ($_GET["largest"] == "all")
		{
			echo '<h2>'.__("All Posts &amp; Pages").'</h2>';
		}
		else
		{
			echo '<h2>'.__("Largest Posts &amp; Pages").'</h2>';
		}
		
		$bjl_wp_posts_total = count($bjl_content_word_count);
		if ($bjl_wp_posts_total > 10) { $bjl_wp_posts_top = 10; } else { $bjl_wp_posts_top = $bjl_wp_posts_total; }
		
		echo '<ul class="subsubsub bjl_word_count_subsubsub">';
		echo '<li><a href="?page=wpwordcount.php"'.($_GET["largest"] != "all" ? ' class="current"' : '').'>Top <span class="count">('.$bjl_wp_posts_top.')</span></a> |</li>';
		echo '<li><a href="?page=wpwordcount.php&largest=all"'.($_GET["largest"] == "all" ? ' class="current"' : '').'>All <span class="count">('.count($bjl_content_word_count).')</span></a></li>';
		echo '</ul>';
		
		echo '<table class="widefat post fixed" cellspacing="0">';
		echo '<thead>';
		echo '<tr>';
		echo '<th scope="col" id="wordcount" class="manage-column column-author" style="width:75px; text-align:center;">'.__("Words").'</th>';
		echo '<th scope="col" id="title" class="manage-column column-title">'.__("Title").'</th>';
		echo '<th scope="col" id="type" class="manage-column column-author">'.__("Type").'</th>';
		echo '<th scope="col" id="status" class="manage-column column-author">'.__("Status").'</th>';
		echo '<th scope="col" id="author" class="manage-column column-author">'.__("Author").'</th>';
		echo '</tr>';
		echo '</thead>';
		
		echo '<tbody>';
		arsort($bjl_content_word_count);
		$bjl_largest_counter = 0;
		$bjl_largest_limit = 10;
		foreach($bjl_content_word_count as $key => $value)
		{
			$user = get_userdata($bjl_content_post_author[$key]);
			
			echo '<tr'.($bjl_largest_counter % 2 == 1 ? "" : " class='alternate'").'>';
			echo '<td class="author column-author" style="width:75px; text-align:center;">'.number_format($value).'</td>';
			echo '<td class="post-title column-title"><a href="post.php?post='.$key.'&action=edit"><strong>'.$bjl_content_post_title[$key].'</strong></a></td>';
			echo '<td class="author column-author">'.ucwords($bjl_content_post_type[$key]).'</td>';
			echo '<td class="author column-author">'.ucwords($bjl_content_post_status[$key]).'</td>';
			echo '<td class="author column-author">'.$user->user_login.'</td>';
			echo '</tr>';
			
			$bjl_largest_counter++;
			if ($_GET["largest"] != "all" && $bjl_largest_counter == $bjl_largest_limit) break;
		}
		echo '</tbody>';
		echo '</table>';
		
		echo '<h2>'.__("Author Statistics").'</h2>';
		echo '<table class="widefat post fixed" cellspacing="0">';
		echo '<thead>';
		echo '<tr>';
		echo '<th scope="col" id="author" class="manage-column column-author">'.__("Author").'</th>';
		echo '<th scope="col" id="wordcount" class="manage-column column-author" style="width:75px; text-align:center;">'.__("Words").'</th>';
		echo '<th scope="col" id="published_posts" class="manage-column column-author">'.__("Published Posts").'</th>';
		echo '<th scope="col" id="published_ages" class="manage-column column-author">'.__("Published Pages").'</th>';
		echo '<th scope="col" id="published_total" class="manage-column column-author">'.__("Published Total").'</th>';
		echo '<th scope="col" id="draft_posts" class="manage-column column-author">'.__("Draft Posts").'</th>';
		echo '<th scope="col" id="draft_pages" class="manage-column column-author">'.__("Draft Pages").'</th>';
		echo '<th scope="col" id="draft_total" class="manage-column column-author">'.__("Draft Total").'</th>';
		echo '</tr>';
		echo '</thead>';
		
		echo '<tbody>';
		$bjl_author_counter = 0;
		foreach($bjl_author_word_count as $key => $value)
		{
			$user = get_userdata($key);
			
			echo '<tr'.($bjl_author_counter % 2 == 1 ? "" : " class='alternate'").'>';
			echo '<td class="author column-author"><strong>'.$user->user_login.'</strong></td>';
			echo '<td class="author column-author" style="width:75px; text-align:center;">'.number_format($value).'</td>';
			echo '<td class="author column-author">'.number_format($bjl_author_posts_publish_word_count[$key]).' '.__("Words").'<br />'.@number_format($bjl_author_posts_publish_word_count[$key] / $bjl_author_posts_publish[$key]).' '.__("Word Avg.").'</td>';
			echo '<td class="author column-author">'.number_format($bjl_author_pages_publish_word_count[$key]).' '.__("Words").'<br />'.@number_format($bjl_author_pages_publish_word_count[$key] / $bjl_author_pages_publish[$key]).' '.__("Word Avg.").'</td>';
			echo '<td class="author column-author">'.number_format($bjl_author_posts_publish_word_count[$key] + $bjl_author_pages_publish_word_count[$key]).' '.__("Words").'<br />'.@number_format(($bjl_author_posts_publish_word_count[$key] + $bjl_author_pages_publish_word_count[$key]) / ($bjl_author_posts_publish[$key] + $bjl_author_pages_publish[$key])).' '.__("Word Avg.").'</td>';
			echo '<td class="author column-author">'.number_format($bjl_author_posts_draft_word_count[$key]).' '.__("Words").'<br />'.@number_format($bjl_author_posts_draft_word_count[$key] / $bjl_author_posts_draft[$key]).' '.__("Word Avg.").'</td>';
			echo '<td class="author column-author">'.number_format($bjl_author_pages_draft_word_count[$key]).' '.__("Words").'<br />'.@number_format($bjl_author_pages_draft_word_count[$key] / $bjl_author_pages_draft[$key]).' '.__("Word Avg.").'</td>';
			echo '<td class="author column-author">'.number_format($bjl_author_posts_draft_word_count[$key] + $bjl_author_pages_draft_word_count[$key]).' '.__("Words").'<br />'.@number_format(($bjl_author_posts_draft_word_count[$key] + $bjl_author_pages_draft_word_count[$key]) / ($bjl_author_posts_draft[$key] + $bjl_author_pages_draft[$key])).' '.__("Word Avg.").'</td>';
			echo '</tr>';
			
			$bjl_author_counter++;
		}
		echo '</tbody>';
		echo '</table>';
		
		echo '<h2>'.__("Monthly Statistics").'</h2>';
		echo '<table class="widefat post fixed" cellspacing="0">';
		echo '<thead>';
		echo '<tr>';
		echo '<th scope="col" id="author" class="manage-column column-author">'.__("Month").'</th>';
		echo '<th scope="col" id="wordcount" class="manage-column column-author" style="width:75px; text-align:center;">'.__("Words").'</th>';
		echo '<th scope="col" id="published_posts" class="manage-column column-author">'.__("Published Posts").'</th>';
		echo '<th scope="col" id="published_ages" class="manage-column column-author">'.__("Published Pages").'</th>';
		echo '<th scope="col" id="published_total" class="manage-column column-author">'.__("Published Total").'</th>';
		echo '<th scope="col" id="draft_posts" class="manage-column column-author">'.__("Draft Posts").'</th>';
		echo '<th scope="col" id="draft_pages" class="manage-column column-author">'.__("Draft Pages").'</th>';
		echo '<th scope="col" id="draft_total" class="manage-column column-author">'.__("Draft Total").'</th>';
		echo '</tr>';
		echo '</thead>';
		
		echo '<tbody>';
		$bjl_month_counter = 0;
		foreach($bjl_month_word_count as $key => $value)
		{			
			echo '<tr'.($bjl_month_counter % 2 == 1 ? "" : " class='alternate'").'>';
			echo '<td class="author column-author"><strong>'.$key.'</strong></td>';
			echo '<td class="author column-author" style="width:75px; text-align:center;">'.number_format($value).'</td>';
			echo '<td class="author column-author">'.number_format($bjl_month_posts_publish_word_count[$key]).' '.__("Words").'<br />'.@number_format($bjl_month_posts_publish_word_count[$key] / $bjl_month_posts_publish[$key]).' '.__("Word Avg.").'</td>';
			echo '<td class="author column-author">'.number_format($bjl_month_pages_publish_word_count[$key]).' '.__("Words").'<br />'.@number_format($bjl_month_pages_publish_word_count[$key] / $bjl_month_pages_publish[$key]).' '.__("Word Avg.").'</td>';
			echo '<td class="author column-author">'.number_format($bjl_month_posts_publish_word_count[$key] + $bjl_month_pages_publish_word_count[$key]).' '.__("Words").'<br />'.@number_format(($bjl_month_posts_publish_word_count[$key] + $bjl_month_pages_publish_word_count[$key]) / ($bjl_month_posts_publish[$key] + $bjl_month_pages_publish[$key])).' '.__("Word Avg.").'</td>';
			echo '<td class="author column-author">'.number_format($bjl_month_posts_draft_word_count[$key]).' '.__("Words").'<br />'.@number_format($bjl_month_posts_draft_word_count[$key] / $bjl_month_posts_draft[$key]).' '.__("Word Avg.").'</td>';
			echo '<td class="author column-author">'.number_format($bjl_month_pages_draft_word_count[$key]).' '.__("Words").'<br />'.@number_format($bjl_month_pages_draft_word_count[$key] / $bjl_month_pages_draft[$key]).' '.__("Word Avg.").'</td>';
			echo '<td class="author column-author">'.number_format($bjl_month_posts_draft_word_count[$key] + $bjl_month_pages_draft_word_count[$key]).' '.__("Words").'<br />'.@number_format(($bjl_month_posts_draft_word_count[$key] + $bjl_month_pages_draft_word_count[$key]) / ($bjl_month_posts_draft[$key] + $bjl_month_pages_draft[$key])).' '.__("Word Avg.").'</td>';
			echo '</tr>';
			
			$bjl_month_counter++;
		}
		echo '</tbody>';
		echo '</table>';
		
		echo '<div id="bjl_word_count_linksoftware">';
		echo '<a href="http://linksoftwarellc.com">WordPress Plugin by <img src="'.plugins_url('images/linksoftware.png', __FILE__).'" alt="Link Software" /></a> <a href="http://linksoftwarellc.com">Link Software</a>';
		echo '</div>';
		
		echo '<br /><br /></div>';	// END DIV.WRAP
	}
	
	// WIDGET
	class wpwordcount extends WP_Widget
	{
		function wpwordcount()
		{
			$widget_ops = array('classname' => 'wpwordcount', 'description' => 'Word Count Statistics for your Posts and Pages.');
			$control_ops = array('id_base' => 'wpwordcount');

			$this->WP_Widget('wpwordcount', 'WP Word Count', $widget_ops, $control_ops);
		}
		
		function widget($args, $instance)
		{
			extract($args);
			
			$title = apply_filters('widget_title', $instance['title']);
			$show_total = isset( $instance['show_total'] ) ? $instance['show_total'] : false;
			$show_posts = isset( $instance['show_posts'] ) ? $instance['show_posts'] : false;
			$show_pages = isset( $instance['show_pages'] ) ? $instance['show_pages'] : false;
			$show_link = isset( $instance['show_link'] ) ? $instance['show_link'] : false;
			
			// LOAD MAIN STATS
			$arr_bjl_word_count_main = get_option('bjl_word_count_main');
			@extract($arr_bjl_word_count_main);
			
			echo $before_widget;
			echo $before_title.$title.$after_title;
			
			if ($show_total || $show_posts || $show_pages) echo '<p>';
			if ($show_total) echo '<b>'.__("Total").':</b> '.number_format($words_posts_publish + $words_pages_publish).' '.__("Words").'<br />';
			if ($show_posts) echo '<b>'.__("Posts").':</b> '.number_format($words_posts_publish).' '.__("Words").' ('.@number_format($words_posts_publish / $count_posts_publish).' '.__("Avg.").')<br />';
			if ($show_pages) echo '<b>'.__("Pages").':</b> '.number_format($words_pages_publish).' '.__("Words").' ('.@number_format($words_pages_publish / $count_pages_publish).' '.__("Avg.").')<br />';
			if ($show_total || $show_posts || $show_pages) echo '</p>';
			
			if ($show_link) echo '<p class="center">Powered by <a href="https://wordpress.org/plugins/wp-word-count">WP Word Count</p>';
			
			echo $after_widget;
		}
		
		function update($new_instance, $old_instance)
		{
			$instance = $old_instance;
	
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['show_total'] = $new_instance['show_total'];
			$instance['show_posts'] = $new_instance['show_posts'];
			$instance['show_pages'] = $new_instance['show_pages'];
			$instance['show_link'] = $new_instance['show_link'];
	
			return $instance;
		}
		
		function form($instance)
		{
			$defaults = array('title' => 'Word Count Statistics', 'show_total' => true, 'show_posts' => true, 'show_pages' => true, 'show_link' => true);
			$instance = wp_parse_args((array) $instance, $defaults);
			?>
			
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
			</p>
			
			<p>
				<input type="checkbox" class="checkbox" <?php checked($instance['show_total'], "on"); ?> id="<?php echo $this->get_field_id('show_total'); ?>" name="<?php echo $this->get_field_name('show_total'); ?>" />
				<label for="<?php echo $this->get_field_id('show_total'); ?>">Display Total Word Count</label><br />
				
				<input type="checkbox" class="checkbox" <?php checked($instance['show_posts'], "on"); ?> id="<?php echo $this->get_field_id('show_posts'); ?>" name="<?php echo $this->get_field_name('show_posts'); ?>" />
				<label for="<?php echo $this->get_field_id('show_posts'); ?>">Display Post Word Counts</label><br />
				
				<input type="checkbox" class="checkbox" <?php checked($instance['show_pages'], "on"); ?> id="<?php echo $this->get_field_id('show_pages'); ?>" name="<?php echo $this->get_field_name('show_pages'); ?>" />
				<label for="<?php echo $this->get_field_id('show_pages'); ?>">Display Page Word Counts</label><br />
				
				<input type="checkbox" class="checkbox" <?php checked($instance['show_link'], "on"); ?> id="<?php echo $this->get_field_id('show_link'); ?>" name="<?php echo $this->get_field_name('show_link'); ?>" />
				<label for="<?php echo $this->get_field_id('show_link'); ?>">Display WP Word Count Link</label><br />
			</p>
			
			<?php
		}
	}
	
	function bjl_word_count_add_widget()
	{
		register_widget('wpwordcount');
	}
	
	function bjl_word_count_add_menu()
	{
		if (function_exists('add_submenu_page'))
		{
			add_submenu_page('index.php', __("WP Word Count"), __("WP Word Count"), 1, basename(__FILE__), 'bjl_word_count_admin');
		}
	}
	
	function bjl_word_count_style_admin()
	{
		$siteurl = get_option('siteurl');
		$url = get_option('siteurl').'/wp-content/plugins/'.basename(dirname(__FILE__)).'/style_admin.css';
		
		echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
	}
	
	function bjl_word_count_shortcode($atts)
	{
		global $post;
		
		extract(shortcode_atts(array(
			'before' => '',
			'after' => 'Words',
		), $atts));
		
		// LOAD CACHED ITEMS
		$arr_bjl_word_count_cache = get_option('bjl_word_count_cache');
		@extract($arr_bjl_word_count_cache);
		
		return esc_attr($before).' '.number_format($bjl_content_word_count[$post->ID]).' '.esc_attr($after);
	}
?>