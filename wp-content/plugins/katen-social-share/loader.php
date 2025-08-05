<?php

if(!function_exists('katen_social_share')){
  function katen_social_share(){ ?>

    <div class="social-share me-auto">
        <button class="toggle-button icon-share"></button>
        <ul class="icons list-unstyled list-inline mb-0">
            <li class="list-inline-item"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
            <li class="list-inline-item"><a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
            <li class="list-inline-item"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
            <li class="list-inline-item"><a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=&description=<?php the_title(); ?>" target="_blank"><i class="fab fa-pinterest"></i></a></li>
            <li class="list-inline-item"><a href="https://t.me/share/url?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><i class="fab fa-telegram-plane"></i></a></li>
            <li class="list-inline-item"><a href="mailto:info@example.com?&subject=&cc=&bcc=&body=<?php the_permalink(); ?>"><i class="far fa-envelope"></i></a></li>
        </ul>
    </div>

<?php } }

if(!function_exists('katen_post_social_share')){
  function katen_post_social_share(){ ?>
    <div class="single-post-share">
      <span class="share-text"><?php echo esc_attr('Share this:', 'katen') ?></span>
      <ul class="social-icons list-unstyled list-inline mt-2 float-md-start">
          <li class="list-inline-item"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
          <li class="list-inline-item"><a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
          <li class="list-inline-item"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
          <li class="list-inline-item"><a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=&description=<?php the_title(); ?>" target="_blank"><i class="fab fa-pinterest"></i></a></li>
          <li class="list-inline-item"><a href="https://t.me/share/url?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><i class="fab fa-telegram-plane"></i></a></li>
          <li class="list-inline-item"><a href="mailto:info@example.com?&subject=&cc=&bcc=&body=<?php the_permalink(); ?>"><i class="far fa-envelope"></i></a></li>
      </ul>
    </div>

<?php } } ?>