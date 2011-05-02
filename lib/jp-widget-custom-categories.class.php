<?php

	if (!class_exists('JpWidgetCustomCategories')) {




		/**
		 * JpWidgetCustomCategories
		 *
		 * @author jjarolim <office@jarolim.com>
		 */

		class JpWidgetCustomCategories extends WP_Widget {

			static function init() {
				add_action('widgets_init', array('JpWidgetCustomCategories', 'on_widgets_init'));
			}

			static function on_widgets_init() {
				register_widget('JpWidgetCustomCategories');
				if (is_admin()) {

					// JavaScript für Widget-Admin
					wp_register_script('jpWidgetCustomCategories', plugins_url('jp-widget-custom-categories') . '/tpl/jp-widget-custom-categories.js', false, '1.0');
					wp_enqueue_script('jpWidgetCustomCategories');

					// CSS für Widget-Admin
					wp_register_style('jpWidgetCustomCategories', plugins_url('jp-widget-custom-categories') . '/tpl/jp-widget-custom-categories.css', false, '1.0');
					wp_enqueue_style('jpWidgetCustomCategories');

				}
			}

			/**
			 * Constructor
			 *
			 * Der Name der Klasse wird benötigt, da WordPress diesen anscheinend
			 * direkt aufruft (statt __construct)
			 */
			function JpWidgetCustomCategories() {

				// Das Widget registrieren

				$this->WP_Widget(
					'jp_widget_custom_categories',
					'JP Custom Categories',
					array(
						'classname' => 'jp_widget_custom_categories',
						'description' => 'Anzeige ausgewählter Kategorien'
					)
				);
				
			}


			/**
			 * Outputs the content of the widget
			 * @param <type> $args
			 * @param <type> $instance
			 */
			function widget($args, $instance) {

				// Alle Kategorien als Liste (ohne Hierrachie) holen
				$all_categories = get_categories(array('hide_empty' => 0));

				if (array_key_exists('categories', (array)$instance)) {
					$termlist = explode(',', $instance['categories']);
				}

				// Die Kategorien der ersten Ebene auswählen

				$current_category_id = -1;
				if (is_category() || is_single()) {
					if (class_exists('FreizeitAlpin')) {

						// Das Freizeitalpin Theme hat eine nette Methode, um
						// die derzeitige Kategorie zu bekommen

						$current_category = Freizeitalpin::get_current_category();
						if (!empty($current_category) && ($current_category != -1)) {
							$current_category_id = $current_category->term_id;
						}

					} else {

						// Kein Freizeitalpin Theme - Wir nehmen,
						// was wir mit Bordmitteln bekommen können

						global $wp_query;
						$current_category_id = get_query_var('cat');

					}
				}

				$categories = array();
				if (!empty($termlist)) {
					foreach ($termlist as $term_id) {
						foreach ($all_categories as $category) {
							if ($category->term_id == $term_id) {

								$highlight = false;

								// Wir schauen jeweils, ob die Kategorie
								// noch Kinder hat

								$children = get_categories(array('hide_empty'=>0, 'parent'=>$category->term_id));
								if (!empty($children)) {

									// Wir suchen die Kinder durch:
									// Eventuell muß die Kategorie gehighlighted werden

									foreach ($children as $child) {
										if ($child->term_id == $current_category_id) {
											$child->highlight = true;
											$highlight = true;
											break;
										}
									}

									$category->children = $children;

								}

								if ($category->term_id == $current_category_id) {
									$highlight = true;
								}

								$category->highlight = $highlight;

								$categories[] = $category;
								break;

							}
						}
					}
				}

				include realpath(dirname(__FILE__) . '/../tpl/jp-widget-custom-categories.tpl.php');

			}

			/**
			 * Processes widget options to be saved
			 * param <type> $new_instance
			 * @param <type> $old_instance
			 */
			function update($new_instance, $old_instance) {
				$instance = $old_instance;
				$instance['categories'] = strip_tags($new_instance['categories']);
				return $instance;
			}

			/**
			 * outputs the options form on admin
			 * @param <type> $instance
			 */
			function form($instance) {

				// Alle Kategorien als Liste (ohne Hierrachie) holen
				$categories = get_categories(array('hide_empty' => 0));

				if (array_key_exists('categories', (array)$instance)) {
					$termlist = explode(',', $instance['categories']);
				}

				include realpath(dirname(__FILE__) . '/../tpl/jp-widget-custom-categories.form.php');

			}

		}

	}

?>
