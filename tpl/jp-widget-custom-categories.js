var jp_widget_categorynav = {

	process: function(uniqueWidgetId) {

		var $widget = jQuery('#'+uniqueWidgetId);
		var length = jQuery('.cat', $widget).length;
		var termlist = new Array();

		jQuery('.cat', $widget).each(
			function(index) {

				// Up & Down Links anzeigen bzw. verstecken

				jQuery('.up a', this).show();
				jQuery('.down a', this).show();

				if (index == 0) {
					jQuery('.up a', this).hide();
				}

				if (index == (length-1)) {
					jQuery('.down a', this).hide();
				}

				// termlist befüttern:
				// Falls die aktuelle checkbox angehakelt ist:
				// Die ID der Kategorie zur Liste hinzufügen

				var input_element = jQuery('.show input', this).get(0);
				if (input_element.checked) {
					termlist.push(input_element.value);
				}

			}
		);

		jQuery('.data', $widget).get(0).value = termlist.join(',');

	},

	toggle: function(element) {
		var uniqueWidgetId = jp_widget_categorynav.getId(element);
		jp_widget_categorynav.process(uniqueWidgetId);
	},

	moveUp: function(element) {
		var uniqueWidgetId = jp_widget_categorynav.getId(element);

		var $tr = jp_widget_categorynav.getTR(element);
		var $copy = $tr.clone();
		$tr.prev().before($copy);
		$tr.remove();

		jp_widget_categorynav.process(uniqueWidgetId);
	},

	moveDown: function(element) {
		var uniqueWidgetId = jp_widget_categorynav.getId(element);

		var $tr = jp_widget_categorynav.getTR(element);
		var $copy = $tr.clone();
		$tr.next().after($copy);
		$tr.remove();

		jp_widget_categorynav.process(uniqueWidgetId);
	},

	getId: function(element) {
		return jQuery(element).closest('.jp_widget_categorynav').attr('id');
	},

	getTR: function(element) {
		return jQuery(element).closest('tr');
	}

}