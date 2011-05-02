<?php echo $before_widget ?>

<?php if (!empty($title)): ?>
	<?php echo $before_title . $title . $after_title ?>
<?php endif ?>

<?php if (!empty($categories)): ?>

	<ul class="categories <?php if (!is_home()): ?>categories-dark <?php endif ?> clearfix">

		<!-- The actual selected categories -->

		<?php foreach ($categories as $category): ?>
			<?php

				$css = array();
				if (!empty($category->highlight)) { $css[] = 'active'; }
				if (!empty($category->children)) { $css[] = 'submenu'; }

			?>
			
				<li class="<?php echo implode(' ', $css) ?>">
					<a href="<?php echo get_category_link($category->term_id) ?>"><?php echo $category->name ?></a>
					<?php if (!empty($category->children)): ?>
						<ul>
							<?php foreach ($category->children as $child): ?>
								<?php

									$child_css = array();
									if (!empty($child->highlight)) $child_css[] = 'active';

								?>
								<li class="<?php echo implode(' ', $child_css) ?>"><a href="<?php echo get_category_link($child->term_id) ?>"><?php echo $child->name ?></a></li>
							<?php endforeach ?>
						</ul>
					<?php endif ?>
				</li>

		<?php endforeach ?>
				
	</ul>

<?php else: ?>

	<i>No categories selected</i>

<?php endif ?>

<?php echo $after_widget ?>