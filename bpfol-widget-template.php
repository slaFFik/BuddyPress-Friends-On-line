	<?php // do_action( 'bp_before_directory_members_list' ); ?>
	<ul id="members-list" class="item-list" role="main">
	<?php while ( bp_members() ) : bp_the_member(); ?>
		<li>
			<?php if($instance['display_avatar']):?>
				<div class="item-avatar">
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
				</div>
			<?php endif;?>
			<div class="item">
				<div class="item-title">
				<?php if($instance['display_name']):?>
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
				<?php endif;?>
				</div>
				<?php if($instance['display_last_activity']):?>
					<div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>
				<?php endif;?>
			</div>
			<div class="clear"></div>
		</li>
	<?php endwhile; ?>
	</ul>
	
	<?php //bp_member_hidden_fields(); ?>
	<!--
	<div id="pag-bottom" class="pagination">
		<div class="pag-count" id="member-dir-count-bottom">
			<?php //bp_members_pagination_count(); ?>
		</div>
		<div class="pagination-links" id="member-dir-pag-bottom">
			<?php //bp_members_pagination_links(); ?>
		</div>
	</div>
	-->
