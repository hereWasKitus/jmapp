<?php
/**
 * Template Name: Verification
 */

global $current_user;

$user_hash = get_user_meta( $current_user -> ID, 'hash', true );

if ( !isset($_GET['hash']) || $user_hash !== $_GET['hash'] ) {
  wp_safe_redirect( home_url(), 301 );
  exit();
};

update_user_meta( $current_user -> ID, 'hash', '' );
update_user_meta( $current_user -> ID, 'hash_verified', true );
update_user_meta( $current_user -> ID, 'user_signature', '' );

wp_safe_redirect( home_url('/account'), 301 );
exit();
?>

<?php get_footer(); ?>