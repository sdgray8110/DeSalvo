<div class="info" id="post-<?php the_ID(); ?>">
    <h3 class="entry-title"><?php the_title(); ?></h3>
    <?php the_content(); ?>

    <?php edit_post_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
</div><!-- .entry-content -->