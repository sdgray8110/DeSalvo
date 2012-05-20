<?php get_header(); ?>
<?php get_html_header(); ?>
<?php $randomImage = homepage_random_image(); ?>

<img src="<?=$randomImage->guid;?>" alt="<?=$randomImage->post_title;?>" />

<?php get_footer(); ?>