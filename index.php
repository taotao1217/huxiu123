<?php

include './package/simple_html_dom.php';

// database info
$servername = "localhost";
$username = "root";
$password = "AE75674b90e6";

// error handling 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


// create connection
$dbname = "scraper";
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo 'Database connection succeeded.<br>';
}

// find the relevant div for article list
$html = file_get_html('https://www.huxiu.com/article/');
$huxiu_information_flow = $html->find('div[data-v-7009b653]', 0);
#$huxiu_loading_more = $kr_information_flow->find('div[class="kr-loading-more"]', 0);
#$information_flow_list = $kr_loading_more->find('div[class="information-flow-list"]', 0);

// loop counter
#$article_counter = 1;

// loop through each item in the html
foreach ($information_flow_list->find('div[class="data-v-7009b653"]') as $item) {

    // error count
    $error = array();


    $huxiu_flow_article_item = $item->find('div[class="article-item  article-item--normal"]', 0);
    #$kr_shadow_wrapper = $kr_flow_article_item->find('div[class="kr-shadow-wrapper"]', 0);
    #$kr_shadow_content = $kr_shadow_wrapper->find('div[class="kr-shadow-content"]', 0);

    // image
    $cover_image = " ";

    // category
    $category = "uncategorized";

    // author
    #$article_item_info_clearfloat = $kr_shadow_content->find('div[class="article-item-info clearfloat"]', 0);
    #$huxiu_flow_bar = $article_item_info_clearfloat->find('span[class="single-line-overflow"]', 0);
    $huxiu_flow_bar_author = $huxiu_flow_bar->find('span[class="single-line-overflow"]', 0);
    $author = $huxiu_flow_bar_author->plaintext;

    // title
    #$title_wrapper_ellipsis_2 = $article_item_info_clearfloat->find('p[class="title-wrapper ellipsis-2"]', 0);
    $article_item_title_weight_bold = $title_wrapper_ellipsis_2->find('h5[class="article-item__content__title multi-line-overflow"]', 0);
    $title = $article_item_title_weight_bold->plaintext;

    // description
    #$article_item_description_ellipsis_2 = $article_item_info_clearfloat->find('a[class="article-item-description ellipsis-2"]', 0);
    #$description = $article_item_description_ellipsis_2->plaintext;

    // source
    $source = '虎嗅';

    // article_url
    $article_url_html = $title_wrapper_ellipsis_2->find('a', 0);
    $article_url_partial = $article_url_html->href;
    $article_url = 'https://huxiu.com' . $article_url_partial;

    // content (will be scraped through another web application)
    $content = " ";

    // created_at
    $created_at = date("Y/m/d");

    // is_selected: 0
    $is_selected = 0;

    // is_archived: 0
    $is_archived = 0;

    // other_notes
    $article_item_pic_wrapper = $kr_shadow_content->find('div[class="article-item-pic-wrapper"]', 0);
    $article_item_pic = $article_item_pic_wrapper->find('a[class="article-item-pic"]', 0);
    $tag = $article_item_pic_wrapper->find('a', 0);
    $other_notes = $tag->plaintext;
    
    echo 'article ' . $article_counter . ' scraping finished.<br>';
/*
    // check db for existing news
    $news_check_query = "SELECT * FROM raw_article_list WHERE title = '$title' LIMIT 1";
    $news_check_query_result = $conn->query($news_check_query);
    $result_news = mysqli_fetch_assoc($news_check_query_result);

    if ($result_news) {
        $news_exists_error = 'article ' . $article_counter . ' already exits.';
        array_push($error, $news_exists_error);
        echo $news_exists_error . '<br>';
    }

    // insert values into table
    if (count($error) == 0) {
        $sql = "INSERT INTO raw_article_list (category, title, author, source, cover_image, description, article_url, content, created_at, is_selected, is_archived, other_notes) 
                                VALUES ('$category','$title', '$author', '$source', '$cover_image', '$description','$article_url', '$content','$created_at', $is_selected, $is_archived, '$other_notes')";

        if ($conn->query($sql) === TRUE) {
            echo 'article ' . $article_counter . ' record created successfully.<br>';
        } else {
            echo 'article ' . $article_counter . "error: " . $sql . "<br>";
        }
    } else {
        echo 'article ' . $article_counter . ' record creation failed.<br>';
    }

    // add counter by 1
    $article_counter += 1;

*/
// close the connection 
$conn->close();