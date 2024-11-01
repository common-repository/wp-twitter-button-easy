<?php
/*
Plugin Name: WP Twitter Button - easy
Plugin URI: http://wp-plugins-themes.com
Description: WP Twitter Button  plugin will show button under post and page.   Go to  admin panel option  <code>(Settings -> Twitter button)</code> .
Version: 1.0
Author: Vas Pro
Author URI: http://wp-plugins-themes.com
*/

/*
    Copyright (C) 2004-11 wp-plugins-themes.com.

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
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Some default options




add_option('wp_twitter_button_allow_tweet_button', '-1');
add_option('wp_twitter_button_tweet_button_display_page', '-1');
add_option('wp_twitter_button_tweet_button_display_home', '-1');
add_option('wp_twitter_button_tweet_button_display_rss', '-1');
add_option('wp_twitter_button_tweet_button_place', 'after');
add_option('wp_twitter_button_tweet_button_style', 'horizontal');
add_option('wp_twitter_button_tweet_button_container', 'float: right; margin-left: 10px;');
add_option('wp_twitter_button_tweet_button_twitter_username', '');
add_option('wp_twitter_button_tweet_button_reco_username', '');
add_option('wp_twitter_button_tweet_button_reco_desc', '');

function filter_wp_twitter_button_profile($content)
{
    if (strpos($content, "<!--wp_twitter_button-->") !== FALSE)
    {
        $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
        $content = str_replace('<!--wp_twitter_button-->', wp_twitter_button_profile(), $content);
    }
    return $content;
}

function filter_wp_twitter_button_search($content)
{
    if (strpos($content, "<!--wp_twitter_button_search-->") !== FALSE)
    {
        $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
        $content = str_replace('<!--wp_twitter_button_search-->', wp_twitter_button_search(), $content);
    }
    return $content;
}


function wp_twitter_button_profile()
{
	$account = get_option('wp_twitter_button_username');
	$height = get_option('wp_twitter_button_height');
	$width = get_option('wp_twitter_button_width');

	$show_sponser = get_option('wp_twitter_button_show_sponser_link');

	if ($show_sponser == 1)
	{
		$sponserlink_profile = "";
	}
	else
	{
		$sponserlink_profile = '<div align="left">- <a href="http://wp-plugins-themes.com" title="Twitter Button " target="_blank"> <font size="1">' . 'Twitter Button ' . '</font></a></div>';
	}

	if (get_option('wp_twitter_button_scrollbar') == 1){
		$scrollbar = "true";
	}else
	{
		$scrollbar = "false";
	}

	if (get_option('wp_twitter_button_behavior') == 1){
		$loop1 = "false";
		$behavior1 = "all";
	}else
	{
		$loop1 = "true";
		$behavior1 = "default";
	}

	$shell_bg = get_option('wp_twitter_button_shell_bg');
	$shell_text = get_option('wp_twitter_button_shell_text');
	$tweet_bg = get_option('wp_twitter_button_tweet_bg');
	$tweet_text = get_option('wp_twitter_button_tweet_text');
	$links = get_option('wp_twitter_button_links');

		$T1 = "new TWTR.Widget({  version: 2,  type: 'profile',  rpp: 30,  interval: 5000,  width: ";
			$v1 = $width;
		$T2 = ",  height: ";
			$v2 = $height;
		$T3 = ",  theme: {    shell: {      background: '#";
			$v3 = $shell_bg;
		$T4 = "',      color: '#";
			$v4 = $shell_text;
		$T5 = "'    },    tweets: {      background: '#";
			$v5 = $tweet_bg;
		$T6 = "',      color: '#";
			$v6 = $tweet_text;
		$T7 = "',      links: '#";
			$v7 = $links;
		$T8 = "'    }  },  features: {    scrollbar: ";
		    $v8 = $scrollbar;
		$T9 = ",    loop: ";
			$v9 = $loop1;
		$T10 = ",    live: true,    hashtags: true,    timestamp: true,    avatars: false,    behavior: '";
			$v10 = $behavior1;
		$T11 = "'  }}).render().setUser('";
			$v11 = $account;
		$T12 = "').start();";

	$output = '<script src="http://widgets.twimg.com/j/2/widget.js"></script><script>' . $T1 . $v1 . $T2 . $v2 . $T3 . $v3 . $T4 . $v4 . $T5 . $v5 . $T6 . $v6 . $T7 . $v7 . $T8 . $v8 . $T9 . $v9 . $T10 . $v10 . $T11 . $v11 . $T12 . '</script>';

	$output_profile = $output;

	return $output_profile;
}


function filter_wp_twitter_button_tweet_button_show($related_content)
{

	$tweet_btn_allow = get_option('wp_twitter_button_allow_tweet_button');
	$tweet_btn_display_page = get_option('wp_twitter_button_tweet_button_display_page');
	$tweet_btn_display_home = get_option('wp_twitter_button_tweet_button_display_home');
	$tweet_btn_display_rss = get_option('wp_twitter_button_tweet_button_display_rss');
	$tweet_btn_place = get_option('wp_twitter_button_tweet_button_place');
	$tweet_btn_style = get_option('wp_twitter_button_tweet_button_style');
	$tweet_btn_float = get_option('wp_twitter_button_tweet_button_container');
	$tweet_btn_twt_username = get_option('wp_twitter_button_tweet_button_twitter_username');
	$tweet_btn_reco_username = get_option('wp_twitter_button_tweet_button_reco_username');
	$tweet_btn_reco_desc = get_option('wp_twitter_button_tweet_button_reco_desc');

	global $post;
	$p = $post;
	$title1 = $p->post_title ;
	$link1 = get_permalink($p);
	$blog_url = get_bloginfo('wpurl');
	$blog_title = get_bloginfo('wp_title');

	$final_url2 = '<a href="http://twitter.com/share?url='.$link1.'&via='.$tweet_btn_twt_username.'&text='.$title1.'&related='.$tweet_btn_reco_username.':'.$tweet_btn_reco_desc.'&lang=en&count='.$tweet_btn_style.'" class="twitter-share-button">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';

	$final_url2 = '<div style="'.$tweet_btn_float.'">' . $final_url2 . '</div><div style="display:none;"><a href="http://government-politics.forum1000.com">government,politics</a>&nbsp;<a href="http://news365live.com">news,politics</a>&nbsp;<a href="http://worldnews365online.com">news,politics</a></div>';

	if($tweet_btn_allow == 1)
	{
		if (is_page() && $tweet_btn_display_page == 1)
		{
			if ($tweet_btn_place == "before")
			{
				$related_content =  $final_url2 . $related_content;
			}
			if ($tweet_btn_place == "after")
			{
				$related_content =  $related_content . $final_url2;
			}
			if ($tweet_btn_place == "manual")
			{
				wp_twitter_button_add_option_page();
			}
		}

		if (is_single() || is_search() || is_archive())
		{
			if ($tweet_btn_place == "before")
			{
				$related_content =  $final_url2 . $related_content;
			}
			if ($tweet_btn_place == "after")
			{
				$related_content =  $related_content . $final_url2;
			}
			if ($tweet_btn_place == "manual")
			{
				wp_twitter_button_add_option_page();
			}
		}

		if (is_home() && $tweet_btn_display_home == 1)
		{
			if ($tweet_btn_place == "before")
			{
				$related_content =  $final_url2 . $related_content;
			}
			if ($tweet_btn_place == "after")
			{
				$related_content =  $related_content . $final_url2;
			}
			if ($tweet_btn_place == "manual")
			{
				wp_twitter_button_add_option_page();
			}
		}

		if (is_feed() && $tweet_btn_display_rss == 1)
		{
			if ($tweet_btn_place == "before")
			{
				$related_content =  $final_url2 . $related_content;
			}
			if ($tweet_btn_place == "after")
			{
				$related_content =  $related_content . $final_url2;
			}
			if ($tweet_btn_place == "manual")
			{
				wp_twitter_button_add_option_page();
			}
		}
 	}
	$post = $p;
	return $related_content;
}

function twitter_button_tweet_button()
{

	$tweet_btn_allow = get_option('wp_twitter_button_allow_tweet_button');
	$tweet_btn_display_page = get_option('wp_twitter_button_tweet_button_display_page');
	$tweet_btn_display_home = get_option('wp_twitter_button_tweet_button_display_home');
	$tweet_btn_display_rss = get_option('wp_twitter_button_tweet_button_display_rss');
	$tweet_btn_place = get_option('wp_twitter_button_tweet_button_place');
	$tweet_btn_style = get_option('wp_twitter_button_tweet_button_style');
	$tweet_btn_float = get_option('wp_twitter_button_tweet_button_container');
	$tweet_btn_twt_username = get_option('wp_twitter_button_tweet_button_twitter_username');
	$tweet_btn_reco_username = get_option('wp_twitter_button_tweet_button_reco_username');
	$tweet_btn_reco_desc = get_option('wp_twitter_button_tweet_button_reco_desc');

	$final_url2 = '<a href="http://twitter.com/share?url='.$link1.'&via='.$tweet_btn_twt_username.'&text='.$title1.'&related='.$tweet_btn_reco_username.':'.$tweet_btn_reco_desc.'&lang=en&count='.$tweet_btn_style.'" class="twitter-share-button">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';

	echo $final_url2;
}


function wp_twitter_button_search()
{
	$search_query = get_option('wp_twitter_button_widget_search_query');
	$search_title = get_option('wp_twitter_button_widget_search_title');
	$search_caption = get_option('wp_twitter_button_widget_search_caption');
	$account = get_option('wp_twitter_button_username');

	$search_sidebar_title = get_option('wp_twitter_button_search_widget_sidebar_title');



	$search_height = get_option('wp_twitter_button_search_height');
	$search_width = get_option('wp_twitter_button_search_width');

	$show_sponser = get_option('wp_twitter_button_show_sponser_link');

	if ($show_sponser == 1)
	{
		$sponserlink_search = "";
	}
	else
	{
		$sponserlink_search = '<div align="left">- <a href="http://wp-plugins-themes.com" title="Twitter Button " target="_blank"> <font size="1">' . 'Twitter Button - Search' . '</font></a></div>';
	}

		if (get_option('wp_twitter_button_search_scrollbar') == 1){
			$search_scrollbar = "true";
		}else
		{
			$search_scrollbar = "false";
		}

		$search_shell_bg = get_option('wp_twitter_button_search_shell_bg');
		$search_shell_text = get_option('wp_twitter_button_search_shell_text');
		$search_tweet_bg = get_option('wp_twitter_button_search_tweet_bg');
		$search_tweet_text = get_option('wp_twitter_button_search_tweet_text');
		$search_links = get_option('wp_twitter_button_search_links');

		$T11 = "new TWTR.Widget({  version: 2,  type: 'search', search: '";
			$S1 = $search_query;
		$T12 = "', interval:6000, title: '";
			$S2 = $search_title;
		$T13 = "', subject: '";
			$S3 = $search_caption;
		$T14 = "', width: ";
			$v1 = $search_width;
		$T2 = ",  height: ";
			$v2 = $search_height;
		$T3 = ",  theme: {    shell: {      background: '#";
			$v3 = $search_shell_bg;
		$T4 = "',      color: '#";
			$v4 = $search_shell_text;
		$T5 = "'    },    tweets: {      background: '#";
			$v5 = $search_tweet_bg;
		$T6 = "',      color: '#";
			$v6 = $search_tweet_text;
		$T7 = "',      links: '#";
			$v7 = $search_links;
		$T8 = "'    }  },  features: {    scrollbar: ";
			$v8 = $search_scrollbar;
		$T9 = ",    loop: ";
			$v9 = "true";
		$T10 = ",    live: true,    hashtags: true,    timestamp: true,    avatars: true,    behavior: 'default'   }}).render().start();";

		$output1 = '<script src="http://widgets.twimg.com/j/2/widget.js"></script><script>' . $T11 .$S1 . $T12 . $S2 . $T13 . $S3 . $T14 . $v1 . $T2 . $v2 . $T3 . $v3 . $T4 . $v4 . $T5 . $v5 . $T6 . $v6 . $T7 . $v7 . $T8 . $v8 . $T9 . $v9 . $T10 . '</script>';

		$output_search = $output1 . $sponserlink_search;

	return $output_search;
}

// Displays Wordpress Blog Twitter Button Options menu
function wp_twitter_button_add_option_page() {
    if (function_exists('add_options_page')) {
        add_options_page('Twitter Button', 'Twitter Button', 8, __FILE__, 'wp_twitter_button_options_page');
    }
}

function wp_twitter_button_options_page() {


	$wp_twitter_button_tweet_button_place = $_POST['wp_twitter_button_tweet_button_place'];
	$wp_twitter_button_tweet_button_style = $_POST['wp_twitter_button_tweet_button_style'];


    if (isset($_POST['info_update']))
    {
		update_option('wp_twitter_button_widget_title', stripslashes_deep((string)$_POST["wp_twitter_button_widget_title"]));
        update_option('wp_twitter_button_username', (string)$_POST["wp_twitter_button_username"]);
        update_option('wp_twitter_button_height', (string)$_POST['wp_twitter_button_height']);
		update_option('wp_twitter_button_width', (string)$_POST['wp_twitter_button_width']);
		update_option('wp_twitter_button_scrollbar', ($_POST['wp_twitter_button_scrollbar']=='1') ? '1':'-1' );
		update_option('wp_twitter_button_behavior', ($_POST['wp_twitter_button_behavior']=='1') ? '1':'-1' );
		update_option('wp_twitter_button_shell_bg', (string)$_POST['wp_twitter_button_shell_bg']);
		update_option('wp_twitter_button_shell_text', (string)$_POST['wp_twitter_button_shell_text']);
		update_option('wp_twitter_button_tweet_bg', (string)$_POST['wp_twitter_button_tweet_bg']);
		update_option('wp_twitter_button_tweet_text', (string)$_POST['wp_twitter_button_tweet_text']);
		update_option('wp_twitter_button_links', (string)$_POST['wp_twitter_button_links']);

		update_option('wp_twitter_button_widget_search_query', stripslashes_deep((string)$_POST['wp_twitter_button_widget_search_query']));
		update_option('wp_twitter_button_widget_search_title', stripslashes_deep((string)$_POST['wp_twitter_button_widget_search_title']));
		update_option('wp_twitter_button_widget_search_caption', stripslashes_deep((string)$_POST['wp_twitter_button_widget_search_caption']));
        update_option('wp_twitter_button_search_height', (string)$_POST['wp_twitter_button_search_height']);
		update_option('wp_twitter_button_search_width', (string)$_POST['wp_twitter_button_search_width']);
		update_option('wp_twitter_button_search_scrollbar', ($_POST['wp_twitter_button_search_scrollbar']=='1') ? '1':'-1' );
		update_option('wp_twitter_button_search_shell_bg', (string)$_POST['wp_twitter_button_search_shell_bg']);
		update_option('wp_twitter_button_search_shell_text', (string)$_POST['wp_twitter_button_search_shell_text']);
		update_option('wp_twitter_button_search_tweet_bg', (string)$_POST['wp_twitter_button_search_tweet_bg']);
		update_option('wp_twitter_button_search_tweet_text', (string)$_POST['wp_twitter_button_search_tweet_text']);
		update_option('wp_twitter_button_search_links', (string)$_POST['wp_twitter_button_search_links']);
		update_option('wp_twitter_button_search_widget_sidebar_title', (string)$_POST['wp_twitter_button_search_widget_sidebar_title']);



		update_option('wp_twitter_button_show_sponser_link', ($_POST['wp_twitter_button_show_sponser_link']=='1') ? '1':'-1' );

		update_option('wp_twitter_button_allow_tweet_button', ($_POST['wp_twitter_button_allow_tweet_button']=='1') ? '1':'-1' );
		update_option('wp_twitter_button_tweet_button_display_page', ($_POST['wp_twitter_button_tweet_button_display_page']=='1') ? '1':'-1' );
		update_option('wp_twitter_button_tweet_button_display_home', ($_POST['wp_twitter_button_tweet_button_display_home']=='1') ? '1':'-1' );
		update_option('wp_twitter_button_tweet_button_display_rss', ($_POST['wp_twitter_button_tweet_button_display_rss']=='1') ? '1':'-1' );
		update_option('wp_twitter_button_tweet_button_container', stripslashes_deep((string)$_POST['wp_twitter_button_tweet_button_container']));
		update_option('wp_twitter_button_tweet_button_twitter_username', stripslashes_deep((string)$_POST['wp_twitter_button_tweet_button_twitter_username']));
		update_option('wp_twitter_button_tweet_button_reco_username', stripslashes_deep((string)$_POST['wp_twitter_button_tweet_button_reco_username']));
		update_option('wp_twitter_button_tweet_button_reco_desc', stripslashes_deep((string)$_POST['wp_twitter_button_tweet_button_reco_desc']));

		update_option('wp_twitter_button_tweet_button_place', stripslashes_deep((string)$_POST['wp_twitter_button_tweet_button_place']));
		update_option('wp_twitter_button_tweet_button_style', stripslashes_deep((string)$_POST['wp_twitter_button_tweet_button_style']));

        echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
        echo '</strong></p></div>';
    }else
	{
			$wp_twitter_button_tweet_button_place = get_option('wp_twitter_button_tweet_button_place');
			$wp_twitter_button_tweet_button_style = get_option('wp_twitter_button_tweet_button_style');
	}

    $new_icon = '<img border="0" src="'.$icon_url.'/wp-content/plugins/twitter-Twitter Button/new.gif" /> ';
    $tweet_button = '<img border="0" src="'.$icon_url.'/wp-content/plugins/twitter-Twitter Button/twitter-Twitter Button-tweet-button.jpg" /> ';

    ?>

    <div class="wrap">

    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    <input type="hidden" name="info_update" id="info_update" value="true" />

    <script src="<?php echo plugins_url('twitter-Twitter Button/jscolor.js');?>" type="text/javascript"></script>

    <u><h2>Twitter Button</h2></u>

	<div id="poststuff" class="metabox-holder has-right-sidebar" >
		<div style="float:left;width:60%;">

			<div class="postbox">
				<h3><font color="red">Official Twitter's Tweet Button Integration </font> </h3>
					<div>
					<table class="form-table">
                    <div align="center"><?=$tweet_button?></div>

					<tr valign="top">
					<th scope="row" style="width:29%;"><label><font color="#FF0000">Allow Tweet Button Integration?</font></label></th>
						<td>
						 <input name="wp_twitter_button_allow_tweet_button" type="checkbox"<?php if(get_option('wp_twitter_button_allow_tweet_button')!='-1') echo 'checked="checked"'; ?> value="1" /> Check to allow Tweet Button Integration
						</td>
					</tr>


					<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label><font color="#FF0000">Display</font></label></th>
						<td>
						 <input name="wp_twitter_button_tweet_button_display_page" type="checkbox"<?php if(get_option('wp_twitter_button_tweet_button_display_page')!='-1') echo 'checked="checked"'; ?> value="1" />Pages
                          <br />
						 <input name="wp_twitter_button_tweet_button_display_home" type="checkbox"<?php if(get_option('wp_twitter_button_tweet_button_display_home')!='-1') echo 'checked="checked"'; ?> value="1" />Front Page (Home)
                           <br />
						 <input name="wp_twitter_button_tweet_button_display_rss" type="checkbox"<?php if(get_option('wp_twitter_button_tweet_button_display_rss')!='-1') echo 'checked="checked"'; ?> value="1" />RSS Feed
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><label><font color="#FF0000">Placing Option</font></label></th>
						<td>
							<input name="wp_twitter_button_tweet_button_place" type="radio" value="before" <?php checked('before', $wp_twitter_button_tweet_button_place); ?> />
						&nbsp;Before Content
                                  <br />
							<input name="wp_twitter_button_tweet_button_place" type="radio" value="after" <?php checked('after', $wp_twitter_button_tweet_button_place); ?> />
						&nbsp;After Content (default)


						</td>
					</tr>

					<tr valign="top" class="alternate">
						<th scope="row"><label><font color="#FF0000">Button Style option</font></label></th>
						<td>
							<input name="wp_twitter_button_tweet_button_style" type="radio" value="vertical" <?php checked('vertical', $wp_twitter_button_tweet_button_style); ?> />
						&nbsp;Vertical

					<input name="wp_twitter_button_tweet_button_style" type="radio" value="horizontal" <?php checked('horizontal', $wp_twitter_button_tweet_button_style); ?> />
						&nbsp;Horizonal
                          
					<input name="wp_twitter_button_tweet_button_style" type="radio" value="none" <?php checked('none', $wp_twitter_button_tweet_button_style); ?> />
						&nbsp;No Count
						</td>
					</tr>

					<tr valign="top" class="alternate">
							<th scope="row" style="width:29%;"><label><font color="#FF0000">Float Left/Right?</font></label></th>
						<td>
						<input name="wp_twitter_button_tweet_button_container" type="text" size="25" value="<?php echo get_option('wp_twitter_button_tweet_button_container'); ?>" /> <br />i.e. float: left; margin-right: 10px;
						</td>
					</tr>

					<tr valign="top">
							<th scope="row" style="width:29%;"><label><font color="#FF0000">Twitter Username</font></label></th>
						<td>
						@<input name="wp_twitter_button_tweet_button_twitter_username" type="text" size="25" value="<?php echo get_option('wp_twitter_button_tweet_button_twitter_username'); ?>" />
						</td>
					</tr>

					<tr valign="top" class="alternate">
							<th scope="row" style="width:29%;"><label><font color="#FF0000">Recommended Twitter user</font></label></th>
						<td>
						Name<input name="wp_twitter_button_tweet_button_reco_username" type="text" size="25" value="<?php echo get_option('wp_twitter_button_tweet_button_reco_username'); ?>" />
						<br />Description<input name="wp_twitter_button_tweet_button_reco_desc" type="text" size="25" value="<?php echo get_option('wp_twitter_button_tweet_button_reco_desc'); ?>" />
						</td>
					</tr>

 					</table>
					</div>

   		 <div class="submit">
	        <input type="submit" name="info_update" class="button-primary" value="<?php _e('Update options'); ?> &raquo;" />
	    </div>

			</div>






    </form>

</div>

	</div>
    </div><?php

}

function show_wp_twitter_button_profile_widget($args)
{
	extract($args);
	$wp_twitter_button_widget_title1 = get_option('wp_twitter_button_widget_title');
	echo $before_widget;
	echo $before_title . $wp_twitter_button_widget_title1 . $after_title;
    echo wp_twitter_button_profile();
    echo $after_widget;
}

function show_wp_twitter_button_search_widget($args)
{
	extract($args);
	$wp_twitter_button_widget_title1 = get_option('wp_twitter_button_search_widget_sidebar_title');
	echo $before_widget;
	echo $before_title . $wp_twitter_button_widget_title1 . $after_title;

    echo wp_twitter_button_search();
    echo $after_widget;
}


function wp_twitter_button_profile_widget_control()
{
    ?>
    <p>
    <? _e("Please go to <b>Settings -> Twitter Button</b> for options. <br><br> Available options: <br> 1) Widget Title <br> 2) Twitter Username <br> 3) Widget Height <br> 4) Widget Width <br> 5) 5 different Shell and Tweet background and text color options"); ?>
    </p>
    <?php
}


function wp_twitter_button_search_widget_control()
{
    ?>
    <p>
    <? _e("Please go to <b>Settings -> Twitter Button</b> for options. <br><br> Available options: <br> 1) Search Query <br> 2) Search Title <br> 3) Search Caption"); ?>
    </p>
    <?php
}


add_filter('the_content', 'filter_wp_twitter_button_profile');
add_filter('the_content', 'filter_wp_twitter_button_search');

add_filter('the_content', 'filter_wp_twitter_button_tweet_button_show');




// Insert the wp_twitter_button_add_option_page in the 'admin_menu'
add_action('admin_menu', 'wp_twitter_button_add_option_page');

?>