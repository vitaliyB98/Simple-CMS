// User id.
var id;
$('a').click(function () {
    id = $(this).attr('id');
});
$(document).on('confirmation', '.remodal', function () {
    location = 'users/delete/' + id + '?param=13p5798e64y2';
});

$(document).on('cancellation', '.remodal', function () {
    location = 'users/delete/' + id + '?param=24e68p97o53n1';
});