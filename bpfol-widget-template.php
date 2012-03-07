<?php if($instance['view_mode'] == 'standart'):?>
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
<?php elseif($instance['view_mode'] == 'only_avatar'):?>
	<div class="avatar-block">
		<?php while ( bp_members() ) : bp_the_member(); ?>
			<div class="item-avatar">
				<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name() ?>"><?php bp_member_avatar() ?></a>
			</div>
		<?php endwhile; ?>
	</div>
<?php endif;?>