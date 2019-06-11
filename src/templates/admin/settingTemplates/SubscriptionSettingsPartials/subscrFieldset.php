<?php
$mailjetSyncActivated = get_query_var('mailjetSyncActivated');
$mailjetContactLists = get_query_var('mailjetContactLists');
$mailjetCommentAuthorsList = get_query_var('mailjetCommentAuthorsList');
$mailjetInitialSyncActivated = get_query_var('mailjetInitialSyncActivated');
$mailjetCommentAuthorsSyncActivated = get_query_var('mailjetCommentAuthorsSyncActivated');
?>

<fieldset class="settingsSubscrFldset">
	<label class="checkboxLabel">
		<input name="activate_mailjet_sync" type="checkbox" id="activate_mailjet_sync" value="1" <?php echo ($mailjetSyncActivated == 1 ? ' checked="checked"' : '') ?>  autocomplete="off">
		<span><?php _e('Automatically add Wordpress users to a Mailjet list. Each user’s email address and role (subscriber, administrator, author, …) is synchronized to the list and available for use inside Mailjet.', 'mailjet-for-wordpress'); ?></span>
	</label>

	<div id="activate_mailjet_sync_form" class="<?=($mailjetSyncActivated == 1 ? ' mj-show' : 'mj-hide') ?>">
		<div class="mailjet_sync_options_div">
			<div id="contact_list" class="mailjet_sync_woo_div">
				<!--                        <label class="mj-contact-list">--><?php //_e( 'Contact List', 'mailjet-for-wordpress' ); ?><!--</label>-->
				<div class="mj-woocommerce-contacts">
					<?= $mailjetContactLists ?>  <span>&nbsp&nbsp<a href="#" onclick="ajaxResync()">Resync</a>&nbsp&nbsp<a href="#">Change list</a></span>
				</div>
			</div>
		</div>
	</div>

	<label >
		<span class="mj-opt-in-inside-leav">Opt-in inside « Leave a reply » form</span>
	</label>
	<label class="checkboxLabel">
		<input name="activate_mailjet_comment_authors_sync" type="checkbox" id="activate_mailjet_comment_authors_sync" value="1" <?php echo ($mailjetCommentAuthorsSyncActivated == 1 ? ' checked="checked"' : '') ?> autocomplete="off">
		<span><?php _e('Display "Subscribe to our mailjet list" checkbox in the "Leave a reply" form to allow comment authors to join a specific contact list', 'mailjet-for-wordpress'); ?></span>
	</label>


	<div id="comment_authors_contact_list" class="<?php echo ($mailjetCommentAuthorsSyncActivated == 1 ? ' mj-show' : 'mj-hide') ?> mailjet_sync_comment_authors_div">
		<select class="mj-select" name="mailjet_comment_authors_list" id="mailjet_comment_authors_list" type="select">
			<?php
			foreach ($mailjetContactLists as $mailjetContactList) {
				if ($mailjetContactList["IsDeleted"] == true) {
					continue;
				}
				?>
				<option value="<?=$mailjetContactList['ID'] ?>" <?=($mailjetCommentAuthorsList == $mailjetContactList['ID'] ? 'selected="selected"' : '') ?> > <?=$mailjetContactList['Name'] ?> (<?=$mailjetContactList['SubscriberCount'] ?>) </option>
				<?php
			} ?>
		</select>
	</div>

</fieldset>

<input name="settings_step" type="hidden" id="settings_step" value="subscription_options_step">