/* $(document).ready(function() {
  $('.group').click(function() {
    $(this).nextUntil('.group').toggle();
  });
}) */

$(document).ready(function() {
  $('.data-row').click(function() {
    var value = $(this).find('th:first-child').text();
    console.log(value);
    $('.data-row').each(function() {
      if ($(this).find('td:first-child').text() === 'Value 1') {
        $(this).toggleClass('hidden');
      }
    });
  });
});