<?php  
	/* 
	Plugin Name: WP Word Count
	Plugin URI: http://www.brianjlink.com/wpwordcount
	Description: Word Count Statistics for your Posts and Pages.
	Author: Brian J. Link 
	Version: 1.1 
	Author URI: http://www.brianjlink.com
	*/
	
	add_action('publish_post', 'bjl_word_count_calculate');
	add_action('edit_post', 'bjl_word_count_calculate');
	add_action('admin_menu', 'bjl_word_count_add_menu');
	add_action('admin_head', 'bjl_word_count_style_admin');
	
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
		
		echo '<h2>'.__("Largest Posts &amp; Pages").'</h2>';
		echo '<table class="widefat post fixed" cellspacing="0">';
		echo '<thead>';
		echo '<tr>';
		echo '<th scope="col" id="wordcount" class="manage-column column-author" style="width:75px; text-align:center;">'.__("Words").'</th>';
		echo '<th scope="col" id="title" class="manage-column column-title">'.__("Title").'</th>';
		echo '<th scope="col" id="type" class="manage-column column-author">'.__("Type").'</th>';
		echo '<th scope="col" id="status" class="manage-column column-author">'.__("Status").'</th>';
		// echo '<th scope="col" id="author" class="manage-column column-author">'.__("Author").'</th>';
		echo '</tr>';
		echo '</thead>';
		
		echo '<tbody>';
		arsort($bjl_content_word_count);
		$bjl_largest_counter = 0;
		$bjl_largest_limit = 10;
		foreach($bjl_content_word_count as $key => $value)
		{
			echo '<tr'.($bjl_largest_counter % 2 == 1 ? "" : " class='alternate'").'>';
			echo '<td class="author column-author" style="width:75px; text-align:center;">'.number_format($value).'</td>';
			echo '<td class="post-title column-title"><a href="post.php?post='.$key.'&action=edit"><strong>'.$bjl_content_post_title[$key].'</strong></a></td>';
			echo '<td class="author column-author">'.ucwords($bjl_content_post_type[$key]).'</td>';
			echo '<td class="author column-author">'.ucwords($bjl_content_post_status[$key]).'</td>';
			// echo '<td class="author column-author">'.$bjl_content_post_author[$key].'</td>';
			echo '</tr>';
			
			$bjl_largest_counter++;
			if ($bjl_largest_counter == $bjl_largest_limit) break;
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
		
		echo '<br /><br /></div>';	// END DIV.WRAP
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
?>