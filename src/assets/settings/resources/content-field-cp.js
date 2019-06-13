(function($){
  contentField = typeof contentField == 'undefined' ? {} : contentField;
  contentField.SettingsTable = Garnish.Base.extend({
    init: function(id) {
      var $field = $('#' + id);

      $field.find('.tcfSchemas--cell[data-uid-controller] input').each(function(index, controller) {
        var $controller = $(controller);
        var $children;

        $controller.on('change', function() {
          if (!$children) {
            var uid = controller.parentElement.getAttribute('data-uid-controller');
            $children = $field.find(
              '.tcfSchemas--cell[data-uid-child="' + uid + '"] input'
            );
          }

          $children.toggleClass('hidden', !controller.checked);
        });
      });
    },
  });
})(jQuery);
