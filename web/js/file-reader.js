$(function() {
  let oldContent = null;

  $(document).on('click', '.image-input button.image-reset', function(event) {
    let imgContainer = $(event.target).siblings('.image-preview');
    let fileInput = $(event.target).siblings('input[type="file"]');
    fileInput.val(null).trigger('change');

    return false;
  });

  $(document).on('change', '.image-input input[type="file"]', function(event) {
    let imgContainer = $(event.target).siblings('.image-preview');
    let clrButton = $(event.target).siblings('.image-reset');

    let file = null;
    if (event.target.files.length > 0) {
      file = event.target.files[0];
    }

    if (!(file && file.type.match(/image.*/))) {
      imgContainer.empty();
      if (oldContent) {
        imgContainer.append(oldContent);
      }
      clrButton.prop('disabled', true);

      return;
    }

    const reader = new FileReader();
    reader.onload = function(event) {
      let img = $('<img/>').attr({
        'src': event.target.result,
        'alt': file.name,
        'title': file.name
      }).css({
        'width': 200
      });

      oldContent = imgContainer.children();
      imgContainer.empty().append(img);
      clrButton.prop('disabled', false);
    }

    reader.readAsDataURL(file);
  });
});
