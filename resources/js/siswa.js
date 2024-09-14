import $ from 'jquery';
window.$ = window.jQuery = $;

$(document).ready(function() {
    let count = 0;
    // Listen event click on button with id = tambah
    $('#tambah').click(function() {
        // Append p tag to div with id = test
        count++;
        $('#test').html(`<p>${count}</p>`);
    });
});