<div class="blogDate">
	<i class="far fa-calendar-alt"></i>
	<?php echo utf8_encode(strftime('%d %B %Y', $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'publishedOn']))); ?>
		à <?php echo utf8_encode(strftime('%H:%M', $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'publishedOn']))); ?>		
</div>

	<?php if ($this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'hidePicture']) == false) {
		echo '<div class="blogArticlePicture"><img class="blogArticlePicture" src="' . helper::baseUrl(false) . self::FILE_DIR.'source/' . $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'picture']) . '" alt="' . $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'picture']) . '"></div>';
	} ?>

<?php echo $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'content']); ?>
<!-- <h4 class="textAlignRight"> -->
<p class="signature">
    <?php echo $this->getData(['user', $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'userId']), 'firstname']); ?>
	<?php echo $this->getData(['user', $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'userId']), 'lastname']); ?>
<!-- </h4> -->
</p>

<div class="clearBoth"></div>
<h3 id="comment">
	<?php $commentsNb = count($this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'comment'])); ?>
	<?php echo $commentsNb . ' ' . ($commentsNb > 1 ? 'commentaires' : 'commentaire'); ?>
</h3>
<?php if($this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'closeComment'])): ?>
	<p>Les commentaires sont fermés pour cet article.</p>
<?php else: ?>
	<?php echo template::formOpen('blogArticleForm'); ?>
		<?php echo template::text('blogArticleCommentShow', [
			'placeholder' => 'Rédiger un commentaire...',
			'readonly' => true
		]); ?>
		<div id="blogArticleCommentWrapper" class="displayNone">
			<?php if($this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')): ?>
				<?php echo template::text('blogArticleUserName', [
					'label' => 'Nom',
					'readonly' => true,
					'value' => $this->getUser('firstname') . ' ' . $this->getUser('lastname')
				]); ?>
				<?php echo template::hidden('blogArticleUserId', [
					'value' => $this->getUser('id')
				]); ?>
			<?php else: ?>
				<div class="row">
					<div class="col9">
						<?php echo template::text('blogArticleAuthor', [
							'label' => 'Nom'
						]); ?>
					</div>
					<div class="col1 textAlignCenter verticalAlignBottom">
						<div id="blogArticleOr">Ou</div>
					</div>
					<div class="col2 verticalAlignBottom">
						<?php echo template::button('blogArticleLogin', [
							'href' => helper::baseUrl() . 'user/login/' . str_replace('/', '_', $this->getUrl()) . '__comment',
							'value' => 'Connexion'
						]); ?>
					</div>
				</div>
			<?php endif; ?>
			<?php echo template::textarea('blogArticleContent', [
				'label' => 'Commentaire',
				'maxlength' => '500'
			]); ?>
			<?php if($this->getUser('password') !== $this->getInput('ZWII_USER_PASSWORD')): ?>
				<div class="row">
					<div class="col4">
						<?php echo template::capcha('blogArticleCapcha'); ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="row">
				<div class="col2 offset8">
					<?php echo template::button('blogArticleCommentHide', [
						'class' => 'buttonGrey',
						'value' => 'Annuler'
					]); ?>
				</div>
				<div class="col2">
					<?php echo template::submit('blogArticleSubmit', [
						'value' => 'Envoyer',
						'ico' => ''
					]); ?>
				</div>
			</div>
		</div>
	<?php echo template::formClose(); ?>
<?php endif;?>
<div class="row">
	<div class="col12">
		<?php foreach($module::$comments as $commentId => $comment): ?>
			<div class="block">
				<h4>
					<?php if($comment['userId']): ?>
						<?php echo $this->getData(['user', $comment['userId'], 'firstname']) . ' ' . $this->getData(['user', $comment['userId'], 'lastname']); ?>
					<?php else: ?>
						<?php echo $comment['author']; ?>
					<?php endif; ?>
					le <?php echo utf8_encode(strftime('%d %B %Y - %H:%M', $comment['createdOn'])); ?>
				</h4>
				<?php echo $comment['content']; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?php  if($this->getUser('group') >= self::GROUP_ADMIN): ?>
<div class="row">
    <div class="col3">
		<?php echo template::button('blogBack', [
					'class' => 'buttonGrey',
					'href' => helper::baseUrl() . $this->getUrl(0),
					'ico' => 'left',
					'value' => 'Retour'
		]); ?>
    </div>
    <div class="col3 offset6">
 		<?php echo template::button('blogEdit', [
					'class' => 'buttonBlue',
					'href' => helper::baseUrl() . $this->getUrl(0) . '/edit/' . $this->getUrl(1) . '/' . $_SESSION['csrf'],
					'value' => 'Editer'
		]); ?>
    </div>
</div>
<?php else: ?>
<div class="row">
	<div class="col2">
		<?php echo template::button('blogBack', [
					'class' => 'buttonGrey',
					'href' => helper::baseUrl() . $this->getUrl(0),
					'ico' => 'left',
					'value' => 'Retour'
		]); ?>
	</div>
	<div class="col10">
	</div>
</div>
<?php endif; ?>
<?php echo $module::$pages; ?>
