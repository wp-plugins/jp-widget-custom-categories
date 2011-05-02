<div class="jp_widget_categorynav" id="<?php echo $this->get_field_id('jp_widget_categorynav-table') ?>">
	
	<input class="data" type="hidden" id="<?php echo $this->get_field_id('categories') ?>" name="<?php echo $this->get_field_name('categories') ?>" value="" />

	<p>
		<label>
			Title:
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" value="<?php echo $title ?>" />
		</label>
	</p>

	<p>
	<label>
		Choose categories:
	</label>
	</p>

	<?php if (!empty($categories)): ?>
		<table>
			<tbody>

				<!-- Alle zuvor markierten Kategorien in der richtigen Reihenfolge ausgeben -->

				<?php if (!empty($termlist)): ?>
					<?php foreach ($termlist as $term_id): ?>
						<?php
							$category = null;
							for ($i=0, $ilen=count($categories); $i<$ilen; $i++) {
								if ($categories[$i]->term_id == $term_id) {
									$categories[$i]->jp_widget_categorynav_marked = true;
									$category = $categories[$i];
									break;
								}
							}
						?>
						<?php if (!empty($category)): ?>
							<tr class="cat">
								<td class="show"><input type="checkbox" checked name="term_id[<?php echo $category->term_id ?>]" value="<?php echo $category->term_id ?>" onClick="jp_widget_categorynav.toggle(this);" /></td>
								<td class="name"><?php echo $category->name ?></td>
								<td class="down"><a href="javascript:void(0);" onClick="jp_widget_categorynav.moveDown(this);">down</a></td>
								<td class="up"><a href="javascript:void(0);" onClick="jp_widget_categorynav.moveUp(this);">up</a></td>
							</tr>
						<?php endif ?>
					<?php endforeach ?>
				<?php endif ?>

				<!-- Die restlichen Kategorien ausgeben -->

				<?php foreach ($categories as $category): ?>
					<?php if (!property_exists($category, 'jp_widget_categorynav_marked')): ?>
						<tr class="cat">
							<td class="show"><input type="checkbox" name="term_id[<?php echo $category->term_id ?>]" value="<?php echo $category->term_id ?>" onClick="jp_widget_categorynav.toggle(this);" /></td>
							<td class="name"><?php echo $category->name ?></td>
							<td class="down"><a href="javascript:void(0);" onClick="jp_widget_categorynav.moveDown(this);">down</a></td>
							<td class="up"><a href="javascript:void(0);" onClick="jp_widget_categorynav.moveUp(this);">up</a></td>
						</tr>
					<?php endif ?>
				<?php endforeach ?>

			</tbody>
		</table>
	<?php else: ?>
		<i>no categories to choose</i>
	<?php endif ?>

</div>
<script type="text/javascript" language="javascript">
	jp_widget_categorynav.process('<?php echo $this->get_field_id('jp_widget_categorynav-table') ?>');
</script>