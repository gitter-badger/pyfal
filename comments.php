<?php
/**
 * The template for displaying comments
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
}

//Lets modify comment fields to use mdl stylesheet
//https://codex.wordpress.org/Function_Reference/comment_form
?>
<div class="mdl-grid mdl-grid--no-spacing mdl-cell mdl-cell--12-col">
<?php
 $comment_args = array( 
	'title_reply'=>'',
	'class_submit'=> 'mdl-cell mdl-cell--4-col mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect',
	'comment_notes_after' => '',

	'fields' => apply_filters( 
		'comment_form_default_fields', array(

			//Author custom Field
			'author' => '<div class="mdl-cell mdl-cell--8-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">' . 
					'<label class="mdl-textfield__label" for="author">' . __( 'Your Good Name' ). ( $req ? '<span>*</span>' . '</label> '  : '' ) . 
					'<input class="mdl-textfield__input" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',

			//Author Email custom Field
			'email'  => '<div class="mdl-cell mdl-cell--8-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">' . 
					'<label class="mdl-textfield__label" for="email">' . __( 'Your Email Please' ) . ( $req ? '<span>*</span>' . '</label> ' : '' ) . '<input class="mdl-textfield__input" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />'.'</div>',

			//Author Url custom Field
    			'url' =>'<div class="mdl-cell mdl-cell--8-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="mdl-textfield__label" for="url">' . __( 'Website', 'domainreference' ) . '</label>' .
    '<input class="mdl-textfield__input" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
    '" size="30" /></div>',) ),

			//Comment Field
    			'comment_field' => '<div class="form-textfield mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">' .
                '<label class="mdl-textfield__label" for="comment">' . __( 'Let us know what you have to say:' ) . '</label>' .
                '<textarea class="mdl-textfield__input" id="comment" name="comment" cols="45" rows="1" aria-required="true"></textarea>' .
                '</div>',

		'must_log_in' => '<p class="must-log-in">' .
			sprintf(__( 'You must be <a href="%s">logged in</a> to post a comment.' ),
			wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )) . '</p>',

  		'logged_in_as' => '<p class="logged-in-as">' .
			sprintf(__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
			admin_url( 'profile.php' ),
			$user_identity,
			wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )) . '</p>',

);

comment_form($comment_args); ?>

<div id="comments" class="comments-area mdl-cell mdl-cell--12-col">

	<?php if ( have_comments() ) : ?>
		<?php pyfal_comment_nav(); ?>

		<div class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'div',
					'short_ping'  => true,
					'avatar_size' => 56,
				) );
			?>
		</div><!-- .comment-list -->

		<?php pyfal_comment_nav(); ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>
	<?php endif; ?>

</div><!-- .comments-area -->
</div>