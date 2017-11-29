<?php

/* implement villenoir_get_tweets */
function villenoir_get_tweets($count = 20, $username = false, $options = false) {
    $config['key'] = get_option('gg_consumer_key');
    $config['secret'] = get_option('gg_consumer_secret');
    $config['token'] = get_option('gg_access_token');
    $config['token_secret'] = get_option('gg_access_token_secret');
    $config['screenname'] = get_option('gg_user_timeline');
    $config['cache_expire'] = intval(get_option('gg_cache_expire'));
    if ($config['cache_expire'] < 1) $config['cache_expire'] = 3600;
    $config['directory'] = plugin_dir_path(__FILE__);

    $obj = new villenoir_StormTwitter($config);
    $res = $obj->villenoir_get_tweets($count, $username, $options);
    update_option('gg_last_error',$obj->st_last_error);
    return $res;
}

function villenoir_process_tweets($tweet, $username='', $link='#') {

    if( is_array( $tweet ) ) {
    
        $the_tweet = $tweet['text'];
        $the_tweet_text = $tweet['text'];
        $the_error = isset($tweet['error']);

        if ($the_error != '') {
           $the_tweet = '';
          __return_false();
        }
        else {

            $time = strtotime($tweet['created_at']);
            if ( ( abs( time() - $time) ) < 86400 )
                $h_time = sprintf( esc_html__('%s ago', 'villenoir'), human_time_diff( $time ) );
            else
                $h_time = date(esc_html__('Y/m/d', 'villenoir'), $time);

            $the_tweet = sprintf( esc_html__('%s', 'villenoir'),' <span class="post-date"><a href="'.esc_url($link).'" target="blank"><i class="fa fa-twitter-square"></i>'.esc_html($username).'</a></span>' );

            //use the display url
            if(is_array($tweet['entities']['urls'])){
                foreach($tweet['entities']['urls'] as $key => $link){
                      $the_tweet_text = preg_replace('`'.$link['url'].'`','<a href="'.esc_url($link['url']).'" target="_blank">'.$link['url'].'</a>', $the_tweet_text);
                }
            }
            //  Hashtags must link to a twitter.com search with the hashtag as the query.
            if(is_array($tweet['entities']['hashtags'])){
                foreach($tweet['entities']['hashtags'] as $key => $hashtag){
                      $the_tweet_text = preg_replace('/#'.$hashtag['text'].'/i','<a href="https://twitter.com/search?q=%23'.$hashtag['text'].'&src=hash" target="_blank">#'.$hashtag['text'].'</a>',
                    $the_tweet_text);
                }
            }
            // User_mentions must link to the mentioned user's profile.
            if(is_array($tweet['entities']['user_mentions'])){
                foreach($tweet['entities']['user_mentions'] as $key => $user_mention){
                      $the_tweet_text = preg_replace('/@'.$user_mention['screen_name'].'/i','<a href="http://www.twitter.com/'.esc_html($user_mention['screen_name']).'" target="_blank">@'.esc_html($user_mention['screen_name']).'</a>',
                    $the_tweet_text);
                }
            }

        $the_tweet .= '<span class="twitter-text">'.$the_tweet_text.'</span>';
        $the_tweet .= '<abbr title="' . date(esc_html__('Y/m/d H:i:s', 'villenoir'), $time) . '">' . $h_time . '</abbr>';
          
        } //else
    } //if

    else {
        $the_tweet = $tweet;
    }
    return $the_tweet;
}